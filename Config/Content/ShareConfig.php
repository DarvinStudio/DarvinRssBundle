<?php declare(strict_types=1);
/**
 * @author    Alexey Gorshkov <moonhorn33@gmail.com>
 * @copyright Copyright (c) 2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Config\Content;

/**
 * RSS content share configuration
 */
class ShareConfig
{
    /**
     * @var string[]
     */
    private $network;

    /**
     * @param string[] $network Network
     */
    public function __construct(array $network)
    {
        $this->network = $network;
    }

    /**
     * @return string[]
     */
    public function getNetwork(): array
    {
        return $this->network;
    }
}
