<?php declare(strict_types=1);
/**
 * @author    Alexey Gorshkov <moonhorn33@gmail.com>
 * @copyright Copyright (c) 2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Config;

use Darvin\RssBundle\Config\Content\ContentConfig;
use Darvin\RssBundle\Config\Content\FeedConfig;
use Darvin\RssBundle\Config\Content\ShareConfig;

/**
 * RSS configuration
 */
class RssConfig
{
    /**
     * @var \Darvin\RssBundle\Config\EntityConfig[]
     */
    private $entities;

    /**
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        $this->entities = [];

        foreach ($config['entities'] as $entity => $config) {
            if (!$config['enabled']) {
                continue;
            }

            $this->entities[] = new EntityConfig(
                $entity,
                $config['repository_method'],
                $config['mapping'],
                new ContentConfig(
                    $this->createContentFeedConfig($config['content']['feed']),
                    $this->createContentShareConfig($config['content']['share'])
                )
            );
        }
    }

    /**
     * @return \Darvin\RssBundle\Config\EntityConfig[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param array $config Content feed configuration
     *
     * @return \Darvin\RssBundle\Config\Content\FeedConfig|null
     */
    private function createContentFeedConfig(array $config): ?FeedConfig
    {
        if (!$config['enabled']) {
            return null;
        }

        return new FeedConfig(
            $config['repository_method'],
            $config['length'],
            $config['layout'],
            $config['title'],
            $config['thumb_position'],
            $config['thumb_ratio']
        );
    }

    /**
     * @param array $config Content share configuration
     *
     * @return \Darvin\RssBundle\Config\Content\ShareConfig|null
     */
    private function createContentShareConfig(array $config): ?ShareConfig
    {
        if (!$config['enabled']) {
            return null;
        }

        return new ShareConfig($config['network']);
    }
}
