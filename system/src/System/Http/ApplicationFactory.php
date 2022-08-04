<?php

declare(strict_types=1);

namespace Mobicms\System\Http;

use Devanych\Di\FactoryInterface;
use HttpSoft\Basis\Application;
use HttpSoft\Basis\Handler\NotFoundHandler;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\Router\RouteCollector;
use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewareResolverInterface;
use Psr\Container\{
    ContainerExceptionInterface,
    ContainerInterface,
    NotFoundExceptionInterface
};
use Mobicms\System\View\Renderer;
use Psr\Http\Message\ResponseFactoryInterface;

final class ApplicationFactory implements FactoryInterface
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function create(ContainerInterface $container): Application
    {
        /**
         * @psalm-suppress MixedArgument
         * @psalm-suppress MixedArrayAccess
         */
        return new Application(
            $container->get(RouteCollector::class),
            $container->get(EmitterInterface::class),
            $container->get(MiddlewarePipelineInterface::class),
            $container->get(MiddlewareResolverInterface::class),
            new NotFoundHandler(
                $container->get(ResponseFactoryInterface::class),
                $container->get(Renderer::class),
                'error::404',
                $container->get('config')['debug']
            )
        );
    }
}
