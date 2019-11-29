<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Controller;

use Darvin\RssBundle\Streamer\RssStreamerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * RSS controller
 */
class RssController
{
    /**
     * @var \Darvin\RssBundle\Streamer\RssStreamerInterface
     */
    private $streamer;

    /**
     * @var array
     */
    private $headers;

    /**
     * @param \Darvin\RssBundle\Streamer\RssStreamerInterface $streamer RSS streamer
     * @param array                                           $headers  Response headers
     */
    public function __construct(RssStreamerInterface $streamer, array $headers)
    {
        $this->streamer = $streamer;
        $this->headers = $headers;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(): Response
    {
        return new StreamedResponse([$this->streamer, 'streamRss'], 200, $this->headers);
    }
}
