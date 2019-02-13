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

/**
 * RSS entity configuration
 */
class EntityConfig
{
    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $repositoryMethod;

    /**
     * @var array
     */
    private $mapping;

    /**
     * @var \Darvin\RssBundle\Config\Content\ContentConfig
     */
    private $contentConfig;

    /**
     * @param string                                         $entity           Entity class or interface
     * @param string                                         $repositoryMethod Repository method
     * @param array                                          $mapping          Mapping
     * @param \Darvin\RssBundle\Config\Content\ContentConfig $contentConfig    Content configuration
     */
    public function __construct(string $entity, string $repositoryMethod, array $mapping, ContentConfig $contentConfig)
    {
        $this->entity = $entity;
        $this->repositoryMethod = $repositoryMethod;
        $this->mapping = $mapping;
        $this->contentConfig = $contentConfig;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getRepositoryMethod(): string
    {
        return $this->repositoryMethod;
    }

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }

    /**
     * @return \Darvin\RssBundle\Config\Content\ContentConfig
     */
    public function getContentConfig(): ContentConfig
    {
        return $this->contentConfig;
    }
}
