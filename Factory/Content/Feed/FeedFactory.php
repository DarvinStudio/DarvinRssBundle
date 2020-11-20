<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2020, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory\Content\Feed;

use Darvin\RssBundle\Config\Content\FeedConfig;
use Darvin\RssBundle\Factory\Content\Feed\Exception\CantCreateItemException;
use Darvin\RssBundle\Model\Content\Feed\Feed;
use Darvin\Utils\Locale\LocaleProviderInterface;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RSS content feed factory
 */
class FeedFactory implements FeedFactoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Darvin\RssBundle\Factory\Content\Feed\ItemFactoryInterface
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
     * @var \Symfony\Contracts\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param \Doctrine\ORM\EntityManager                                 $em             Entity manager
     * @param \Darvin\RssBundle\Factory\Content\Feed\ItemFactoryInterface $itemFactory    Item factory
     * @param \Darvin\Utils\Locale\LocaleProviderInterface                $localeProvider Locale provider
     * @param \Psr\Log\LoggerInterface                                    $logger         Logger
     * @param \Symfony\Contracts\Translation\TranslatorInterface          $translator     Translator
     * @param bool                                                        $debug          Is debug enabled
     */
    public function __construct(
        EntityManager $em,
        ItemFactoryInterface $itemFactory,
        LocaleProviderInterface $localeProvider,
        LoggerInterface $logger,
        TranslatorInterface $translator,
        bool $debug
    ) {
        $this->em = $em;
        $this->itemFactory = $itemFactory;
        $this->localeProvider = $localeProvider;
        $this->logger = $logger;
        $this->translator = $translator;
        $this->debug = $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function createFeed($entity, FeedConfig $config, array $mapping): Feed
    {
        $feed = new Feed($config->getLayout(), $this->translator->trans($config->getTitle()));

        $class = ClassUtils::getClass($entity);

        $repository = $this->em->getRepository($class);

        if (!method_exists($repository, $config->getRepositoryMethod())) {
            throw new \RuntimeException(
                sprintf('Entity repository class "%s" does not have method "%s()".', get_class($repository), $config->getRepositoryMethod())
            );
        }

        $itemEntities = $repository->{$config->getRepositoryMethod()}($this->localeProvider->getCurrentLocale(), $entity, $config->getLength());

        if (!is_array($itemEntities) && !$itemEntities instanceof \Traversable) {
            throw new \RuntimeException(
                sprintf('Method "%s::%s()" must return iterable result.', get_class($repository), $config->getRepositoryMethod())
            );
        }
        foreach ($itemEntities as $itemEntity) {
            try {
                $feed->addItem($this->itemFactory->createItem($itemEntity, $config, $mapping, $feed));
            } catch (CantCreateItemException $ex) {
                if ($this->debug) {
                    $this->logger->error(implode(' ', [__METHOD__, $ex->getMessage()]));
                }
            }
        }

        return $feed;
    }
}
