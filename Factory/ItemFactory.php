<?php declare(strict_types=1);
/**
 * @author    Igor Nikolaev <igor.sv.n@gmail.com>
 * @copyright Copyright (c) 2018, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\Factory;

use Darvin\RssBundle\Config\Content\ContentConfig;
use Darvin\RssBundle\EntityRouter\EntityRouterInterface;
use Darvin\RssBundle\Factory\Content\ContentFactoryInterface;
use Darvin\RssBundle\Factory\Exception\CantCreateItemException;
use Darvin\RssBundle\Mapper\MapperInterface;
use Darvin\RssBundle\Model\Item;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * RSS item factory
 */
class ItemFactory implements ItemFactoryInterface
{
    /**
     * @var \Darvin\RssBundle\Factory\Content\ContentFactoryInterface
     */
    private $contentFactory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Darvin\RssBundle\EntityRouter\EntityRouterInterface
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
     * @param \Darvin\RssBundle\Factory\Content\ContentFactoryInterface $contentFactory RSS content factory
     * @param \Doctrine\ORM\EntityManager                               $em             Entity manager
     * @param \Darvin\RssBundle\EntityRouter\EntityRouterInterface      $entityRouter   Entity router
     * @param \Darvin\RssBundle\Mapper\MapperInterface                  $mapper         Mapper
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator      Validator
     */
    public function __construct(
        ContentFactoryInterface $contentFactory,
        EntityManager $em,
        EntityRouterInterface $entityRouter,
        MapperInterface $mapper,
        ValidatorInterface $validator
    ) {
        $this->contentFactory = $contentFactory;
        $this->em = $em;
        $this->entityRouter = $entityRouter;
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function createItem($entity, ContentConfig $config, array $mapping): Item
    {
        $item = new Item($this->contentFactory->createContent($entity, $config, $mapping), $this->entityRouter->generateUrl($entity));

        $this->mapper->map($entity, $item, $mapping);

        $violations = $this->validator->validate($item);

        if ($violations->count() > 0) {
            $parts = [];

            /** @var \Symfony\Component\Validator\ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $parts[] = implode(' - ', [$violation->getPropertyPath(), rtrim($violation->getMessage(), '.')]);
            }

            $class = get_class($entity);

            $id = array_values($this->em->getClassMetadata($class)->getIdentifierValues($entity))[0];

            throw new CantCreateItemException($class, $id, implode(', ', $parts));
        }

        return $item;
    }
}
