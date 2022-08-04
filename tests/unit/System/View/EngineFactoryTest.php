<?php

declare(strict_types=1);

namespace MobicmsTest\System\View;

use Mobicms\Render\Engine;
use Mobicms\System\View\RendererFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class EngineFactoryTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'templates' => [
                        'paths' => [
                            'test' => ['path1'],
                            'p2' => ['path2'],
                        ],
                    ],
                ]
            );
        $this->container = $container;
    }

    public function testFactoryReturnsInstanceOfEngine(): Engine
    {
        $engine = (new RendererFactory())->create($this->container);
        $this->assertInstanceOf(Engine::class, $engine);
        return $engine;
    }

    /**
     * @depends testFactoryReturnsInstanceOfEngine
     */
    public function testEngineHasConfiguredFolder(Engine $engine): void
    {
        $result = $engine->getPath('test');
        $this->assertEquals('path1', $result[0]);
    }
}
