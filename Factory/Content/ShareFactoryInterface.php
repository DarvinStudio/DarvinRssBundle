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

use Darvin\RssBundle\Config\Content\ShareConfig;
use Darvin\RssBundle\Model\Content\Share;

/**
 * RSS content share factory
 */
interface ShareFactoryInterface
{
    /**
     * @param \Darvin\RssBundle\Config\Content\ShareConfig $config Configuration
     *
     * @return \Darvin\RssBundle\Model\Content\Share
     */
    public function createShare(ShareConfig $config): Share;
}
