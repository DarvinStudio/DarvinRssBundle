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

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @param \Symfony\Component\PropertyAccess\PropertyAccessorInterface $propertyAccessor Property accessor
     */
    public function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * {@inheritDoc}
     */
    public function map($source, $target, array $mapping): void
    {
        foreach ($mapping as $targetPath => $sourcePath) {
            if (false === $sourcePath) {
                continue;
            }
            if (null === $sourcePath) {
                $sourcePath = $targetPath;
            }
            if ($this->propertyAccessor->isWritable($target, $targetPath)) {
                $this->propertyAccessor->setValue($target, $targetPath, $this->propertyAccessor->getValue($source, $sourcePath));
            }
        }
    }
}
