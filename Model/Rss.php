<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Model;

/**
 * RSS
 */
class Rss
{
    public const TITLE_MAX_LENGTH = 240;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $link;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $language;

    /**
     * @return array
     */
    public function getSimpleElements(): array
    {
        $elements = [
            'title'       => $this->title,
            'link'        => $this->link,
            'description' => $this->description,
            'language'    => $this->language,
        ];

        foreach ($elements as $key => $value) {
            $value = null !== $value ? trim($value) : '';

            if ('' === $value) {
                unset($elements[$key]);

                continue;
            }

            $elements[$key] = $value;
        }

        return $elements;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title Title
     *
     * @return Rss
     */
    public function setTitle(?string $title): Rss
    {
        if (null !== $title && mb_strlen($title) > self::TITLE_MAX_LENGTH) {
            $title = mb_substr($title, 0, self::TITLE_MAX_LENGTH - 3).'...';
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link Link
     *
     * @return Rss
     */
    public function setLink(?string $link): Rss
    {
        $this->link = $link;

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
     * @param string|null $description Description
     *
     * @return Rss
     */
    public function setDescription(?string $description): Rss
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language Language
     *
     * @return Rss
     */
    public function setLanguage(?string $language): Rss
    {
        $this->language = $language;

        return $this;
    }
}
