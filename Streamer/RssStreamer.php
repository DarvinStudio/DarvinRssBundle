<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Streamer;

use Darvin\ContentBundle\Disableable\DisableableInterface;
use Darvin\ContentBundle\Hideable\HideableInterface;
use Darvin\RssBundle\Config\RssConfig;
use Darvin\RssBundle\Factory\Exception\CantCreateItemException;
use Darvin\RssBundle\Factory\ItemFactoryInterface;
use Darvin\RssBundle\Factory\RssFactoryInterface;
use Darvin\Utils\Locale\LocaleProviderInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Templating\EngineInterface;

/**
 * RSS streamer
 */
class RssStreamer implements RssStreamerInterface
{
    public const ITEMS_MAX = 1000;

    /**
     * @var \Darvin\RssBundle\Config\RssConfig
     */
    private $config;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Darvin\RssBundle\Factory\ItemFactoryInterface
     */
    private $itemFactory;

    /**
     * @var \Darvin\Utils\Locale\LocaleProviderInterface
     */
    private $localeProvider;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var \Darvin\RssBundle\Factory\RssFactoryInterface
     */
    private $rssFactory;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $templating;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param \Darvin\RssBundle\Config\RssConfig             $config         Configuration
     * @param \Doctrine\ORM\EntityManager                    $em             Entity manager
     * @param \Darvin\RssBundle\Factory\ItemFactoryInterface $itemFactory    RSS item factory
     * @param \Darvin\Utils\Locale\LocaleProviderInterface   $localeProvider Locale provider
     * @param \Psr\Log\LoggerInterface                       $logger         Logger
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack   Request stack
     * @param \Darvin\RssBundle\Factory\RssFactoryInterface  $rssFactory     RSS factory
     * @param \Symfony\Component\Templating\EngineInterface  $templating     Templating
     * @param bool                                           $debug          Is debug enabled
     */
    public function __construct(
        RssConfig $config,
        EntityManager $em,
        ItemFactoryInterface $itemFactory,
        LocaleProviderInterface $localeProvider,
        LoggerInterface $logger,
        RequestStack $requestStack,
        RssFactoryInterface $rssFactory,
        EngineInterface $templating,
        bool $debug
    ) {
        $this->config = $config;
        $this->em = $em;
        $this->itemFactory = $itemFactory;
        $this->localeProvider = $localeProvider;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
        $this->rssFactory = $rssFactory;
        $this->templating = $templating;
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function streamRss(): void
    {
        if (null === $this->requestStack->getCurrentRequest()) {
            $this->requestStack->push(new Request());
        }

        $rss = $this->rssFactory->createRss();

        $this->render(':rss:header.xml.twig', [
            'rss' => $rss,
        ]);

        $items  = 0;
        $locale = $this->localeProvider->getCurrentLocale();

        foreach ($this->config->getEntities() as $config) {
            $qb         = null;
            $repository = $this->em->getRepository($config->getEntity());

            if (null !== $config->getRepositoryMethod()) {
                if (!method_exists($repository, $config->getRepositoryMethod())) {
                    throw new \RuntimeException(
                        sprintf('Entity repository class "%s" does not have method "%s()".', get_class($repository), $config->getRepositoryMethod())
                    );
                }

                $qb = $repository->{$config->getRepositoryMethod()}($locale);

                if (!$qb instanceof QueryBuilder) {
                    throw new \RuntimeException(
                        sprintf('Method "%s::%s()" must return instance of "%s".', get_class($repository), $config->getRepositoryMethod(), QueryBuilder::class)
                    );
                }
            }
            if (empty($qb)) {
                $qb = $repository->createQueryBuilder('o');
            }

            $iterator = $qb->getQuery()->iterate();

            while ($iterator->next()) {
                $row = $iterator->current();

                $entity = reset($row);

                if (($entity instanceof DisableableInterface && !$entity->isEnabled())
                    || ($entity instanceof HideableInterface && $entity->isHidden())
                ) {
                    continue;
                }
                try {
                    $item = $this->itemFactory->createItem($entity, $config->getContent(), $config->getMapping());

                    $this->render(':rss:item.xml.twig', [
                        'rss'  => $rss,
                        'item' => $item,
                    ]);

                    $items++;

                    if ($items >= self::ITEMS_MAX) {
                        break 2;
                    }
                } catch (CantCreateItemException $ex) {
                    if ($this->debug) {
                        $this->logger->error(implode(' ', [__METHOD__, $ex->getMessage()]));
                    }
                }

                $this->em->clear();
            }

            $this->em->clear();
        }

        $this->render(':rss:footer.xml.twig', [
            'rss' => $rss,
        ]);
    }

    /**
     * @param string $template Template
     * @param array  $params   Parameters
     */
    private function render(string $template, array $params): void
    {
        $content = $this->templating->render($template, $params);

        if (!$this->debug) {
            $content = preg_replace('/\s+/', ' ', $content);
        }

        echo $content;

        flush();
    }
}
