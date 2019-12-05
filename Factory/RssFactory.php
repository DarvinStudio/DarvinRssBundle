<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory;

use Darvin\RssBundle\Model\Rss;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * RSS factory
 */
class RssFactory implements RssFactoryInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack Request stack
     * @param string|null                                    $title        Title
     */
    public function __construct(RequestStack $requestStack, ?string $title)
    {
        $this->requestStack = $requestStack;
        $this->title = $title;
    }

    /**
     * {@inheritDoc}
     */
    public function createRss(): Rss
    {
        $rss = new Rss();
        $rss->setTitle($this->title);

        $request = $this->requestStack->getCurrentRequest();

        if (!empty($request)) {
            $this->populateFromRequest($rss, $request);
        }

        return $rss;
    }

    /**
     * @param \Darvin\RssBundle\Model\Rss               $rss     RSS
     * @param \Symfony\Component\HttpFoundation\Request $request Request
     */
    private function populateFromRequest(Rss $rss, Request $request): void
    {
        $rss
            ->setLink($request->getSchemeAndHttpHost())
            ->setLanguage($request->getLocale());
    }
}
