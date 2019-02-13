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

/**
 * RSS content share
 */
class Share
{
    /**
     * @var string[]
     */
    private $network;

    /**
     * @param string[] $network Network
     */
    public function __construct(array $network)
    {
        $this->network = $network;
    }

    /**
     * @return array
     */
    public function getSimpleAttributes(): array
    {
        $attributes = [
            'data-block'   => 'share',
            'data-network' => implode(', ', array_unique($this->network)),
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
     * @return string[]
     */
    public function getNetwork(): array
    {
        return $this->network;
    }

    /**
     * @param string[] $network network
     *
     * @return Share
     */
    public function setNetwork(array $network): Share
    {
        $this->network = $network;

        return $this;
    }
}
