<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory;

use Darvin\RssBundle\Model\Rss;

/**
 * RSS factory
 */
interface RssFactoryInterface
{
    /**
     * @return \Darvin\RssBundle\Model\Rss
     */
    public function createRss(): Rss;
}
