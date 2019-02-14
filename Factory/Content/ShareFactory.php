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

use Darvin\RssBundle\Config\Content\ShareConfig;
use Darvin\RssBundle\Model\Content\Share;

/**
 * RSS content share factory
 */
class ShareFactory implements ShareFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createShare(ShareConfig $config): Share
    {
        return new Share($config->getNetwork());
    }
}
