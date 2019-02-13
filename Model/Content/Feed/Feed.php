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

/**
 * RSS content feed
 */
class Feed
{
    /**
     * @var \Darvin\RssBundle\Model\Content\Feed\Item[]
     */
    private $items;

    /**
     * @var string|null
     */
    private $layout;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @param string|null $layout Layout
     * @param string|null $title  Title
     */
    public function __construct(?string $layout, ?string $title)
    {
        $this->layout = $layout;
        $this->title = $title;

        $this->items = [];
    }

    /**
     * @return array
     */
    public function getSimpleAttributes(): array
    {
        $attributes = [
            'data-block'  => 'feed',
            'data-layout' => $this->layout,
            'data-title'  => $this->title,
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
     * @return \Darvin\RssBundle\Model\Content\Feed\Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Feed\Item[] $items Items
     *
     * @return Feed
     */
    public function setItems(array $items): Feed
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Feed\Item $item Items
     *
     * @return Feed
     */
    public function addItem(Item $item): Feed
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLayout(): ?string
    {
        return $this->layout;
    }

    /**
     * @param string|null $layout Layout
     *
     * @return Feed
     */
    public function setLayout(?string $layout): Feed
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $title Title
     *
     * @return Feed
     */
    public function setTitle(?string $title): Feed
    {
        $this->title = $title;

        return $this;
    }
}
