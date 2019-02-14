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

use Darvin\RssBundle\Model\Content\Content;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RSS item
 */
class Item
{
    /**
     * @var \Darvin\RssBundle\Model\Content\Content
     *
     * @Assert\Valid
     */
    private $content;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     * @Assert\Length(max=243, charset="ASCII")
     */
    private $link;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $turboSource;

    /**
     * @var string|null
     */
    private $turboTopic;

    /**
     * @var \DateTime|null
     */
    private $pubDate;

    /**
     * @var string|null
     *
     * @Assert\Length(max=240)
     */
    private $author;

    /**
     * @param \Darvin\RssBundle\Model\Content\Content $content Content
     * @param string|null                          $link    Link
     */
    public function __construct(Content $content, $link)
    {
        $this->content = $content;
        $this->link = $this->turboSource = $link;
    }

    /**
     * @return array
     */
    public function getSimpleElements()
    {
        $elements = [
            'link'         => $this->link,
            'title'        => $this->title,
            'description'  => $this->description,
            'turbo:source' => $this->turboSource,
            'turbo:topic'  => $this->turboTopic,
            'pubDate'      => !empty($this->pubDate) ? $this->pubDate->format(\DateTime::RFC822) : '',
            'author'       => $this->author,
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
     * @return \Darvin\RssBundle\Model\Content\Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Content $content content
     *
     * @return Item
     */
    public function setContent(Content $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string|null $link link
     *
     * @return Item
     */
    public function setLink($link)
    {
        $this->link = $link;

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
     * @param string|null $title title
     *
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description description
     *
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = strip_tags($description);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTurboSource()
    {
        return $this->turboSource;
    }

    /**
     * @param string|null $turboSource turboSource
     *
     * @return Item
     */
    public function setTurboSource($turboSource)
    {
        $this->turboSource = $turboSource;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTurboTopic()
    {
        return $this->turboTopic;
    }

    /**
     * @param string|null $turboTopic turboTopic
     *
     * @return Item
     */
    public function setTurboTopic($turboTopic)
    {
        $this->turboTopic = $turboTopic;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @param \DateTime|null $pubDate pubDate
     *
     * @return Item
     */
    public function setPubDate(\DateTime $pubDate = null)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string|null $author author
     *
     * @return Item
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }
}
