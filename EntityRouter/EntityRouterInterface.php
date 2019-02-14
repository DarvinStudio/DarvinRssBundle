<?php
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\EntityRouter;

/**
 * Entity router
 */
interface EntityRouterInterface
{
    /**
     * @param object $entity Entity
     *
     * @return string|null
     */
    public function generateUrl($entity);
}
