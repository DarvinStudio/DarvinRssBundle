<?php
/**
 * @author    Alexey Gorshkov <moonhorn33@gmail.com>
 * @copyright Copyright (c) 2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * RSS configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('darvin_rss');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('entities')->useAttributeAsKey('entity')
                    ->validate()
                        ->ifTrue(function (array $entities) {
                            foreach (array_keys($entities) as $entity) {
                                if (!class_exists($entity) && !interface_exists($entity)) {
                                    throw new \RuntimeException(sprintf('Entity class or interface "%s" does not exist.', $entity));
                                }
                            }

                            return false;
                        })
                        ->thenInvalid('')
                    ->end()
                    ->prototype('array')->canBeDisabled()
                        ->children()
                            ->scalarNode('repository_method')->defaultNull()->end()
                            ->arrayNode('mapping')->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('title')->defaultFalse()->end()
                                    ->scalarNode('description')->defaultFalse()->end()
                                    ->scalarNode('turbo_topic')->defaultFalse()->end()
                                    ->scalarNode('pub_date')->defaultFalse()->end()
                                    ->scalarNode('author')->defaultFalse()->end()
                                    ->scalarNode('image')->defaultFalse()->end()
                                    ->scalarNode('heading')->defaultFalse()->end()
                                    ->scalarNode('text')->defaultFalse()->end()
                                ->end()
                            ->end()
                            ->arrayNode('content')->addDefaultsIfNotSet()
                                ->children()
                                    ->arrayNode('feed')->canBeEnabled()
                                        ->children()
                                            ->scalarNode('repository_method')->isRequired()->cannotBeEmpty()->end()
                                            ->integerNode('length')->defaultValue(3)->min(1)->end()
                                            ->enumNode('layout')->values(['horizontal', 'vertical'])->defaultNull()->end()
                                            ->scalarNode('title')->defaultNull()->end()
                                            ->enumNode('thumb_position')->values(['left', 'right', 'top'])->defaultNull()->end()
                                            ->enumNode('thumb_ratio')->values(['1x1', '2x3', '3x2', '3x4', '4x3', '16x9', '16x10'])->defaultNull()->end()
                                        ->end()
                                    ->end()
                                    ->arrayNode('share')->canBeEnabled()
                                        ->children()
                                            ->arrayNode('network')->isRequired()
                                                ->prototype('enum')->values(['facebook', 'google', 'odnoklassniki', 'telegram', 'twitter', 'vkontakte'])->end()
                                                ->beforeNormalization()->ifArray()->then(function (array $network) {
                                                    return array_unique($network);
                                                });

        return $treeBuilder;
    }
}
