<?php

declare(strict_types=1);

namespace MobicmsTest\System\Log;

use Mobicms\System\Log\LoggerFactory;
use Devanych\Di\Container;
use Devanych\Di\Exception\NotFoundException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    private LoggerFactory $factory;

    public function setUp(): void
    {
        $this->factory = new LoggerFactory();
    }

    /**
     * @dataProvider debugDataProvider
     */
    public function testCreate(?bool $debug): void
    {
        $container = new Container(['config' => ['debug' => $debug, 'log_file' => 'test.log']]);

        /** @var Logger $logger */
        $logger = $this->factory->create($container);
        $this->assertInstanceOf(LoggerInterface::class, $logger);
        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertTrue($logger->isHandling($debug ? Logger::DEBUG : Logger::WARNING));

        foreach ($logger->getHandlers() as $handler) {
            $this->assertInstanceOf(StreamHandler::class, $handler);
        }
    }

    public function testCreateThrowNotFoundExceptionIfConfigIsNotSet(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container());
    }

    /**
     * @return iterable<array-key, array<array-key, bool|null>>
     */
    public function debugDataProvider(): iterable
    {
        return [
            'debug-true'  => [true],
            'debug-false' => [false],
            'debug-null'  => [null],
        ];
    }
}
