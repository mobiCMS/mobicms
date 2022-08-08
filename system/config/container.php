<?php

declare(strict_types=1);

use Devanych\Di\Container;
use HttpSoft\Basis\Application;
use HttpSoft\Basis\Response\CustomResponseFactory;
use HttpSoft\Cookie\CookieManager;
use HttpSoft\Cookie\CookieManagerInterface;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use HttpSoft\Router\RouteCollector;
use HttpSoft\Runner\MiddlewarePipeline;
use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewareResolver;
use HttpSoft\Runner\MiddlewareResolverInterface;
use Mobicms\Render\Engine;
use Mobicms\System\Db\PdoFactory;
use Mobicms\System\App\ApplicationFactory;
use Mobicms\System\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Mobicms\System\Log\LoggerFactory;
use Mobicms\System\View\EngineFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;

return new Container(
    [
        'config'                           => function (): array {
            $config = require_once __DIR__ . '/config.php';

            if (is_file(__DIR__ . '/config.local.php')) {
                $config = array_merge($config, require_once __DIR__ . '/config.local.php');
            }

            return $config;
        },
        Application::class                 => fn() => new ApplicationFactory(),
        CookieManagerInterface::class      => fn() => new CookieManager(),
        EmitterInterface::class            => fn() => new SapiEmitter(),
        Engine::class                      => fn() => new EngineFactory(),
        ErrorHandlerMiddleware::class      => fn() => new ErrorHandlerMiddlewareFactory(),
        LoggerInterface::class             => fn() => new LoggerFactory(),
        MiddlewarePipelineInterface::class => fn() => new MiddlewarePipeline(),
        MiddlewareResolverInterface::class => fn(ContainerInterface $c) => new MiddlewareResolver($c),
        PDO::class                         => fn() => new PdoFactory(),
        ResponseFactoryInterface::class    => fn() => new CustomResponseFactory(),
        RouteCollector::class              => fn() => new RouteCollector(),
    ]
);
