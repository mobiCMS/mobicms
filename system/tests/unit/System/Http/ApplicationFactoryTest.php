<?php

declare(strict_types=1);

namespace MobicmsTest\System\Http;

use HttpSoft\Basis\Response\CustomResponseFactory;
use Mobicms\System\Http\ApplicationFactory;
use Devanych\Di\Container;
use Devanych\Di\Exception\NotFoundException;
use HttpSoft\Basis\Application;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\Router\RouteCollector;
use HttpSoft\Runner\MiddlewarePipeline;
use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewareResolver;
use HttpSoft\Runner\MiddlewareResolverInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;

class ApplicationFactoryTest extends TestCase
{
    private ApplicationFactory $factory;

    public function setUp(): void
    {
        $this->factory = new ApplicationFactory();
    }

    public function debugDataProvider(): array
    {
        return [
            'debug-true'  => [true],
            'debug-false' => [false],
        ];
    }

    /**
     * @dataProvider debugDataProvider
     */
    public function testCreate(bool $debug): void
    {
        $app = $this->factory->create(
            new Container(
                [
                    'config'                           => ['debug' => $debug],
                    EmitterInterface::class            => SapiEmitter::class,
                    MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
                    MiddlewareResolverInterface::class => MiddlewareResolver::class,
                    ResponseFactoryInterface::class    => CustomResponseFactory::class,
                ]
            )
        );
        $this->assertInstanceOf(Application::class, $app);
    }

    public function testCreateThrowNotFoundExceptionIfConfigIsNotSet(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(
            new Container(
                [
                    RouteCollector::class              => RouteCollector::class,
                    EmitterInterface::class            => SapiEmitter::class,
                    MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
                    MiddlewareResolverInterface::class => MiddlewareResolver::class,
                ]
            )
        );
    }

    public function invalidDependenciesDataProvider(): array
    {
        return [
            'EmitterInterface-is-not-set'            => [
                [
                    MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
                    MiddlewareResolverInterface::class => MiddlewareResolver::class,
                ],
            ],
            'MiddlewarePipelineInterface-is-not-set' => [
                [
                    EmitterInterface::class            => SapiEmitter::class,
                    MiddlewareResolverInterface::class => MiddlewareResolver::class,
                ],
            ],
            'MiddlewareResolverInterface-is-not-set' => [
                [
                    EmitterInterface::class            => SapiEmitter::class,
                    MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidDependenciesDataProvider
     */
    public function testCreateThrowNotFoundExceptionIfOneOfDependenciesIsNotSet(array $dependencies): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container(['debug' => true, 'log_file' => 'test.log'] + $dependencies));
    }
}
