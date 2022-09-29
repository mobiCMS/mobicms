<?php

declare(strict_types=1);

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
use Mobicms\Container\Container;
use Mobicms\Render\Engine;
use Mobicms\App\ApplicationFactory;
use Mobicms\Config\ConfigContainer;
use Mobicms\Db\PdoFactory;
use Mobicms\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Mobicms\Config\ConfigInterface;
use Mobicms\Log\LoggerFactory;
use Mobicms\Session\SessionMiddleware;
use Mobicms\Session\SessionMiddlewareFactory;
use Mobicms\View\EngineFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;

$config = require_once __DIR__ . '/config.php';

if (is_file(__DIR__ . '/config.local.php')) {
    $config = array_merge($config, require_once __DIR__ . '/config.local.php');
}

$container = new Container(
    [
        'services'    =>
            [
                ConfigInterface::class => new ConfigContainer($config),
            ],
        'factories'   =>
            [
                Application::class            => ApplicationFactory::class,
                Engine::class                 => EngineFactory::class,
                LoggerInterface::class        => LoggerFactory::class,
                PDO::class                    => PdoFactory::class,
                ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,
                SessionMiddleware::class      => SessionMiddlewareFactory::class,
            ],
        'definitions' =>
            [
                CookieManagerInterface::class      => fn() => new CookieManager(),
                EmitterInterface::class            => fn() => new SapiEmitter(),
                MiddlewarePipelineInterface::class => fn() => new MiddlewarePipeline(),
                RouteCollector::class              => fn() => new RouteCollector(),
                MiddlewareResolverInterface::class => fn(ContainerInterface $c) => new MiddlewareResolver($c),
                ResponseFactoryInterface::class    => fn() => new CustomResponseFactory(),
            ],
    ]
);

return $container;
