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
use Mobicms\Interface\ConfigInterface;
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

return new Container(
    [
        Application::class                 => fn() => new ApplicationFactory(),
        ConfigInterface::class             => fn() => new ConfigContainer($config),
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
        SessionMiddleware::class           => fn() => new SessionMiddlewareFactory(),
    ]
);
