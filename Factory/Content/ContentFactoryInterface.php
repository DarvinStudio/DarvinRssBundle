<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory\Content;

use Darvin\RssBundle\Config\Content\ContentConfig;
use Darvin\RssBundle\Model\Content\Content;

/**
 * RSS content factory
 */
interface ContentFactoryInterface
{
    /**
     * @param object                                         $entity  Entity
     * @param \Darvin\RssBundle\Config\Content\ContentConfig $config  Configuration
     * @param array                                          $mapping Mapping
     *
     * @return \Darvin\RssBundle\Model\Content\Content
     */
    public function createContent(object $entity, ContentConfig $config, array $mapping): Content;
}
