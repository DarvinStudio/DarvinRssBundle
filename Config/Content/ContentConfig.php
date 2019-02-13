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
 * RSS content configuration
 */
class ContentConfig
{
    /**
     * @var \Darvin\RssBundle\Config\Content\FeedConfig|null
     */
    private $feedConfig;

    /**
     * @var \Darvin\RssBundle\Config\Content\ShareConfig|null
     */
    private $shareConfig;

    /**
     * ShareConfig constructor.
     *
     * @param \Darvin\RssBundle\Config\Content\FeedConfig|null  $feedConfig  Feed configuration
     * @param \Darvin\RssBundle\Config\Content\ShareConfig|null $shareConfig Share configuration
     */
    public function __construct(?FeedConfig $feedConfig = null, ?ShareConfig $shareConfig = null)
    {
        $this->feedConfig  = $feedConfig;
        $this->shareConfig = $shareConfig;
    }

    /**
     * @return \Darvin\RssBundle\Config\Content\FeedConfig|null
     */
    public function getFeedConfig(): ?FeedConfig
    {
        return $this->feedConfig;
    }

    /**
     * @return \Darvin\RssBundle\Config\Content\ShareConfig|null
     */
    public function getShareConfig(): ?ShareConfig
    {
        return $this->shareConfig;
    }
}
