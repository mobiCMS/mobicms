<?php

declare(strict_types=1);

namespace Mobicms\System\View;

use Devanych\Di\FactoryInterface;
use Psr\Container\ContainerInterface;

class RendererFactory implements FactoryInterface
{
    public function create(ContainerInterface $container): Renderer
    {
        /** @var array $config */
        $config = $container->get('config');

        /** @var array $paths */
        $paths = $config['templates']['paths'] ?? [];

        $engine = new Renderer();

        /**
         * @var string $namespace
         * @var array $pathArray
         */
        foreach ($paths as $namespace => $pathArray) {
            /** @var string $path */
            foreach ($pathArray as $path) {
                $engine->addPath($path, $namespace);
            }
        }

        return $engine;
    }
}
