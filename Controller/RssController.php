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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * RSS controller
 */
class RssController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        return new StreamedResponse([$this->getRssStreamer(), 'streamRss'], 200, [
            'Content-Type'      => sprintf('application/rss+xml; charset=%s', $this->container->getParameter('kernel.charset')),
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * @return \Darvin\RssBundle\Streamer\RssStreamerInterface
     */
    private function getRssStreamer(): RssStreamerInterface
    {
        return $this->get('darvin_rss.streamer');
    }
}
