<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018-2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory\Content\Feed;

use Darvin\ContentBundle\Router\EntityRouterInterface;
use Darvin\RssBundle\Config\Content\FeedConfig;
use Darvin\RssBundle\Factory\Content\Feed\Exception\CantCreateItemException;
use Darvin\RssBundle\Mapper\MapperInterface;
use Darvin\RssBundle\Model\Content\Feed\Feed;
use Darvin\RssBundle\Model\Content\Feed\Item;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * RSS content feed item factory
 */
class ItemFactory implements ItemFactoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Darvin\ContentBundle\Router\EntityRouterInterface
     */
    private $entityRouter;

    /**
     * @var \Darvin\RssBundle\Mapper\MapperInterface
     */
    private $mapper;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * @param \Doctrine\ORM\EntityManager                               $em           Entity manager
     * @param \Darvin\ContentBundle\Router\EntityRouterInterface        $entityRouter Entity router
     * @param \Darvin\RssBundle\Mapper\MapperInterface                  $mapper       Mapper
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator    Validator
     */
    public function __construct(
        EntityManager $em,
        EntityRouterInterface $entityRouter,
        MapperInterface $mapper,
        ValidatorInterface $validator
    ) {
        $this->em = $em;
        $this->entityRouter = $entityRouter;
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function createItem($entity, FeedConfig $config, array $mapping, Feed $feed): Item
    {
        $item = new Item($feed, $this->entityRouter->generateUrl($entity, UrlGeneratorInterface::ABSOLUTE_URL), $config->getThumbPosition(), $config->getThumbRatio());

        $this->mapper->map($entity, $item, $mapping);

        $violations = $this->validator->validate($item);

        if ($violations->count() > 0) {
            $parts = [];

            /** @var \Symfony\Component\Validator\ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $parts[] = implode(' - ', [$violation->getPropertyPath(), rtrim($violation->getMessage(), '.')]);
            }

            $class = ClassUtils::getClass($entity);

            $id = array_values($this->em->getClassMetadata($class)->getIdentifierValues($entity))[0];

            throw new CantCreateItemException($class, $id, implode(', ', $parts));
        }

        return $item;
    }
}
