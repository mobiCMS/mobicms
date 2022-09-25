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

$container = new Container();

$container->setFactory(Application::class, ApplicationFactory::class);
$container->setFactory(Engine::class, EngineFactory::class);
$container->setFactory(LoggerInterface::class, LoggerFactory::class);
$container->setFactory(PDO::class, PdoFactory::class);
$container->setFactory(ErrorHandlerMiddleware::class, ErrorHandlerMiddlewareFactory::class);
$container->setFactory(SessionMiddleware::class, SessionMiddlewareFactory::class);

$container->set(ConfigInterface::class, fn() => new ConfigContainer($config));
$container->set(CookieManagerInterface::class, fn() => new CookieManager());
$container->set(EmitterInterface::class, fn() => new SapiEmitter());
$container->set(MiddlewarePipelineInterface::class, fn() => new MiddlewarePipeline());
$container->set(RouteCollector::class, fn() => new RouteCollector());
$container->set(MiddlewareResolverInterface::class, fn(ContainerInterface $c) => new MiddlewareResolver($c));
$container->set(ResponseFactoryInterface::class, fn() => new CustomResponseFactory());

return $container;
