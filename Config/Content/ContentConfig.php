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
    private $feed;

    /**
     * @var \Darvin\RssBundle\Config\Content\ShareConfig|null
     */
    private $share;

    /**
     * ShareConfig constructor.
     *
     * @param \Darvin\RssBundle\Config\Content\FeedConfig|null  $feed  Feed configuration
     * @param \Darvin\RssBundle\Config\Content\ShareConfig|null $share Share configuration
     */
    public function __construct(?FeedConfig $feed = null, ?ShareConfig $share = null)
    {
        $this->feed  = $feed;
        $this->share = $share;
    }

    /**
     * @return \Darvin\RssBundle\Config\Content\FeedConfig|null
     */
    public function getFeed(): ?FeedConfig
    {
        return $this->feed;
    }

    /**
     * @return \Darvin\RssBundle\Config\Content\ShareConfig|null
     */
    public function getShare(): ?ShareConfig
    {
        return $this->share;
    }
}
