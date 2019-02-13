<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Model\Content\Feed;

use Darvin\ImageBundle\Entity\Image\AbstractImage;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RSS content feed item
 */
class Item
{
    /**
     * @var \Darvin\RssBundle\Model\Content\Feed\Feed
     */
    private $feed;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     */
    private $href;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var \Darvin\ImageBundle\Entity\Image\AbstractImage|null
     *
     * @Assert\Type("Darvin\ImageBundle\Entity\Image\AbstractImage")
     * @Assert\Expression("null !== value or null === this.getFeed() or 'horizontal' !== this.getFeed().getLayout()")
     */
    private $image;

    /**
     * @var string|null
     */
    private $thumbPosition;

    /**
     * @var string|null
     */
    private $thumbRatio;

    /**
     * @param \Darvin\RssBundle\Model\Content\Feed\Feed $feed          Feed
     * @param string|null                            $href          Reference
     * @param string|null                            $thumbPosition Thumbnail position
     * @param string|null                            $thumbRatio    Thumbnail ratio
     */
    public function __construct(Feed $feed, ?string $href, ?string $thumbPosition, ?string $thumbRatio)
    {
        $this->feed = $feed;
        $this->href = $href;
        $this->thumbPosition = $thumbPosition;
        $this->thumbRatio = $thumbRatio;
    }

    /**
     * @return array
     */
    public function getSimpleAttributes(): array
    {
        $attributes = [
            'data-block'          => 'feed-item',
            'data-href'           => $this->href,
            'data-title'          => $this->title,
            'data-description'    => $this->description,
            'data-thumb-position' => $this->thumbPosition,
            'data-thumb-ratio'    => $this->thumbRatio,
        ];

        foreach ($attributes as $key => $value) {
            $value = trim($value);

            if ('' === $value) {
                unset($attributes[$key]);

                continue;
            }

            $attributes[$key] = $value;
        }

        return $attributes;
    }

    /**
     * @return \Darvin\RssBundle\Model\Content\Feed\Feed
     */
    public function getFeed(): Feed
    {
        return $this->feed;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Feed\Feed $feed Feed
     *
     * @return Item
     */
    public function setFeed(Feed $feed): Item
    {
        $this->feed = $feed;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * @param string|null $href Href
     *
     * @return Item
     */
    public function setHref(?string $href): Item
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title title
     *
     * @return Item
     */
    public function setTitle(?string $title): Item
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description description
     *
     * @return Item
     */
    public function setDescription(?string $description): Item
    {
        $this->description = strip_tags($description);

        return $this;
    }

    /**
     * @return \Darvin\ImageBundle\Entity\Image\AbstractImage|null
     */
    public function getImage(): ?AbstractImage
    {
        return $this->image;
    }

    /**
     * @param \Darvin\ImageBundle\Entity\Image\AbstractImage|null $image image
     *
     * @return Item
     */
    public function setImage(?AbstractImage $image): Item
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbPosition(): ?string
    {
        return $this->thumbPosition;
    }

    /**
     * @param string|null $thumbPosition thumbPosition
     *
     * @return Item
     */
    public function setThumbPosition(?string $thumbPosition): Item
    {
        $this->thumbPosition = $thumbPosition;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbRatio(): ?string
    {
        return $this->thumbRatio;
    }

    /**
     * @param string|null $thumbRatio thumbRatio
     *
     * @return Item
     */
    public function setThumbRatio(?string $thumbRatio): Item
    {
        $this->thumbRatio = $thumbRatio;

        return $this;
    }
}
