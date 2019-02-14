<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory\Content;

use Darvin\ContentBundle\Widget\WidgetInterface;
use Darvin\ContentBundle\Widget\WidgetPoolInterface;
use Darvin\RssBundle\Config\Content\ContentConfig;
use Darvin\RssBundle\Factory\Content\Feed\FeedFactoryInterface;
use Darvin\RssBundle\Mapper\MapperInterface;
use Darvin\RssBundle\Model\Content\Content;

/**
 * RSS content factory
 */
class ContentFactory implements ContentFactoryInterface
{
    /**
     * @var \Darvin\RssBundle\Factory\Content\Feed\FeedFactoryInterface
     */
    private $feedFactory;

    /**
     * @var \Darvin\RssBundle\Mapper\MapperInterface
     */
    private $mapper;

    /**
     * @var \Darvin\RssBundle\Factory\Content\ShareFactoryInterface
     */
    private $shareFactory;

    /**
     * @var \Darvin\ContentBundle\Widget\WidgetPoolInterface
     */
    private $widgetPool;

    /**
     * @param \Darvin\RssBundle\Factory\Content\Feed\FeedFactoryInterface $feedFactory  Feed factory
     * @param \Darvin\RssBundle\Mapper\MapperInterface                    $mapper       Mapper
     * @param \Darvin\RssBundle\Factory\Content\ShareFactoryInterface     $shareFactory Share factory
     * @param \Darvin\ContentBundle\Widget\WidgetPoolInterface            $widgetPool   Widget pool
     */
    public function __construct(
        FeedFactoryInterface $feedFactory,
        MapperInterface $mapper,
        ShareFactoryInterface $shareFactory,
        WidgetPoolInterface $widgetPool
    ) {
        $this->feedFactory = $feedFactory;
        $this->mapper = $mapper;
        $this->shareFactory = $shareFactory;
        $this->widgetPool = $widgetPool;
    }

    /**
     * {@inheritdoc}
     */
    public function createContent($entity, ContentConfig $config, array $mapping): Content
    {
        $content = new Content();

        if (null !== $config->getFeed()) {
            $content->setFeed($this->feedFactory->createFeed($entity, $config->getFeed(), $mapping));
        }
        if (null !== $config->getShare()) {
            $content->setShare($this->shareFactory->createShare($config->getShare()));
        }

        $this->mapper->map($entity, $content, $mapping);

        $this->prepareText($content);

        return $content;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Content $content Content
     */
    private function prepareText(Content $content): void
    {
        $text = $content->getText();

        $replacements = array_fill_keys(array_map(function (WidgetInterface $widget) {
            return '%'.$widget->getName().'%';
        }, $this->widgetPool->getAllWidgets()), '');

        if (!empty($replacements)) {
            $text = strtr($text, $replacements);
        }
        if ('' === trim(str_replace("\xc2\xa0", ' ', strip_tags($text, '<img></img>')))) {
            $text = null;
        }

        $content->setText($text);
    }
}
