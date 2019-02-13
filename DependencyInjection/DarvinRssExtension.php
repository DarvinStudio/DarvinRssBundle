<?php declare(strict_types=1);
/**
 * @author    Alexey Gorshkov <moonhorn33@gmail.com>
 * @copyright Copyright (c) 2019, Darvin Studio
 * @link      https://www.darvin-studio.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Darvin\RssBundle\DependencyInjection;

use Darvin\Utils\DependencyInjection\ConfigInjector;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * RSS extension
 */
class DarvinRssExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        (new ConfigInjector($container))->inject($this->processConfiguration(new Configuration(), $configs), $this->getAlias());
    }
}
