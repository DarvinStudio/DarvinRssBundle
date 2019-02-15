<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Config\Content;

/**
 * RSS content feed configuration
 */
class FeedConfig
{
    /**
     * @var string
     */
    private $repositoryMethod;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string|null
     */
    private $layout;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $thumbPosition;

    /**
     * @var string|null
     */
    private $thumbRatio;

    /**
     * @param string      $repositoryMethod Repository method
     * @param int         $length           Length
     * @param string|null $layout           Layout
     * @param string|null $title            Title
     * @param string|null $thumbPosition    Thumbnail position
     * @param string|null $thumbRatio       Thumbnail ratio
     */
    public function __construct(
        string $repositoryMethod,
        int $length,
        ?string $layout,
        ?string $title,
        ?string $thumbPosition,
        ?string $thumbRatio
    ) {
        $this->repositoryMethod = $repositoryMethod;
        $this->length = $length;
        $this->layout = $layout;
        $this->title = $title;
        $this->thumbPosition = $thumbPosition;
        $this->thumbRatio = $thumbRatio;
    }

    /**
     * @return string
     */
    public function getRepositoryMethod(): string
    {
        return $this->repositoryMethod;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return string|null
     */
    public function getLayout(): ?string
    {
        return $this->layout;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getThumbPosition(): ?string
    {
        return $this->thumbPosition;
    }

    /**
     * @return string|null
     */
    public function getThumbRatio(): ?string
    {
        return $this->thumbRatio;
    }
}
