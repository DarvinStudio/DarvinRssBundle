<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory\Content\Feed\Exception;

/**
 * Can't create RSS content feed item exception
 */
class CantCreateItemException extends \Exception
{
    /**
     * @param string $class   Entity class
     * @param mixed  $id      Entity ID
     * @param string $message Message
     */
    public function __construct(string $class, $id, string $message)
    {
        parent::__construct(sprintf('Unable to create RSS content feed item from entity "%s" with ID "%s": %s.', $class, $id, $message));
    }
}
