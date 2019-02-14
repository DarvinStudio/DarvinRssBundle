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

use Darvin\ContentBundle\Entity\SlugMapItem;
use Darvin\Utils\Homepage\HomepageRouterInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Entity router
 */
class EntityRouter implements EntityRouterInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $genericRouter;

    /**
     * @var \Darvin\Utils\Homepage\HomepageRouterInterface
     */
    private $homepageRouter;

    /**
     * @param \Doctrine\ORM\EntityManager                    $em             Entity manager
     * @param \Symfony\Component\Routing\RouterInterface     $genericRouter  Generic router
     * @param \Darvin\Utils\Homepage\HomepageRouterInterface $homepageRouter Homepage router
     */
    public function __construct(EntityManager $em, RouterInterface $genericRouter, HomepageRouterInterface $homepageRouter)
    {
        $this->em = $em;
        $this->genericRouter = $genericRouter;
        $this->homepageRouter = $homepageRouter;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUrl($entity)
    {
        $class = get_class($entity);

        $id = array_values($this->em->getClassMetadata($class)->getIdentifierValues($entity))[0];

        /** @var \Darvin\ContentBundle\Entity\SlugMapItem[] $slugs */
        $slugs = $this->em->getRepository(SlugMapItem::class)->findBy(['objectClass' => $class, 'objectId' => $id], null, 1);

        if (empty($slugs)) {
            return null;
        }
        if ($this->homepageRouter->isHomepage($entity)) {
            return $this->homepageRouter->generate(UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return $this->genericRouter->generate('darvin_content_show', [
            'slug' => $slugs[0]->getSlug(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
