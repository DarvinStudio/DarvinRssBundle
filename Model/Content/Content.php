<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Model\Content;

use Darvin\ImageBundle\Entity\Image\AbstractImage;
use Darvin\RssBundle\Model\Content\Feed\Feed;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RSS content
 */
class Content
{
    public const HEADING_MAX_LENGTH = 240;

    /**
     * @var \Darvin\RssBundle\Model\Content\Feed\Feed|null
     */
    private $feed;

    /**
     * @var \Darvin\RssBundle\Model\Content\Share|null
     */
    private $share;

    /**
     * @var \Darvin\ImageBundle\Entity\Image\AbstractImage|null
     *
     * @Assert\Type("Darvin\ImageBundle\Entity\Image\AbstractImage")
     */
    private $image;

    /**
     * @var string|null
     *
     * @Assert\Length(max=240)
     */
    private $heading;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     */
    private $text;

    /**
     * @return \Darvin\RssBundle\Model\Content\Feed\Feed|null
     */
    public function getFeed(): ?Feed
    {
        return $this->feed;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Feed\Feed|null $feed Feed
     *
     * @return Content
     */
    public function setFeed(Feed $feed = null): Content
    {
        $this->feed = $feed;

        return $this;
    }

    /**
     * @return \Darvin\RssBundle\Model\Content\Share|null
     */
    public function getShare(): ?Share
    {
        return $this->share;
    }

    /**
     * @param \Darvin\RssBundle\Model\Content\Share|null $share Share
     *
     * @return Content
     */
    public function setShare(Share $share = null): Content
    {
        $this->share = $share;

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
     * @param \Darvin\ImageBundle\Entity\Image\AbstractImage|null $image Image
     *
     * @return Content
     */
    public function setImage(?AbstractImage $image): Content
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeading(): ?string
    {
        return $this->heading;
    }

    /**
     * @param string|null $heading Heading
     *
     * @return Content
     */
    public function setHeading(?string $heading)
    {
        if (null !== $heading && mb_strlen($heading) > self::HEADING_MAX_LENGTH) {
            $heading = mb_substr($heading, 0, self::HEADING_MAX_LENGTH - 3).'...';
        }

        $this->heading = $heading;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text Text
     *
     * @return Content
     */
    public function setText(?string $text): Content
    {
        $this->text = $text;

        return $this;
    }
}
