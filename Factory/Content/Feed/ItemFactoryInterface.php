<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory\Content\Feed;

use Darvin\RssBundle\Config\Content\FeedConfig;
use Darvin\RssBundle\Model\Content\Feed\Feed;
use Darvin\RssBundle\Model\Content\Feed\Item;

/**
 * RSS content feed item factory
 */
interface ItemFactoryInterface
{
    /**
     * @param object                                      $entity  Entity
     * @param \Darvin\RssBundle\Config\Content\FeedConfig $config  Configuration
     * @param array                                       $mapping Mapping
     * @param \Darvin\RssBundle\Model\Content\Feed\Feed   $feed    Feed
     *
     * @return \Darvin\RssBundle\Model\Content\Feed\Item
     * @throws \Darvin\RssBundle\Factory\Content\Feed\Exception\CantCreateItemException
     */
    public function createItem($entity, FeedConfig $config, array $mapping, Feed $feed): Item;
}
