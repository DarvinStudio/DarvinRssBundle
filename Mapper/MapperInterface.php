<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Mapper;

/**
 * Mapper
 */
interface MapperInterface
{
    /**
     * @param mixed $source  Source
     * @param mixed $target  Target
     * @param array $mapping Mapping
     */
    public function map($source, $target, array $mapping): void;
}
