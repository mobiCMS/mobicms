<?php

declare(strict_types=1);

namespace MobicmsTest\System\Db;

use Mobicms\System\Db\Exception\CommonException;
use Mobicms\System\Db\Exception\InvalidCredentialsException;
use Mobicms\System\Db\Exception\InvalidDatabaseException;
use Mobicms\System\Db\PdoFactory;
use Mobicms\Testutils\MysqlTestCase;
use PDO;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

class PdoFactoryTest extends MysqlTestCase
{
    private MockObject $container;

    public function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->container
            ->method('has')
            ->with('config')
            ->willReturn(true);
    }

    public function testFactoryReturnsInstanceOfPdo(): void
    {
        $this->container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'database' => [
                        'host'   => self::$dbHost,
                        'port'   => self::$dbPort,
                        'dbname' => self::$dbName,
                        'user'   => self::$dbUser,
                        'pass'   => self::$dbPass,
                    ],
                ]
            );

        $factory = new PdoFactory();
        $this->assertInstanceOf(PDO::class, $factory->create($this->container));
    }

    public function testInvalidPasswordThrowInvalidCredentialsException(): void
    {
        $this->container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'database' => [
                        'host'   => self::$dbHost,
                        'port'   => self::$dbPort,
                        'dbname' => self::$dbName,
                        'user'   => self::$dbUser,
                        'pass'   => 'invalid_password',
                    ],
                ]
            );

        $this->expectException(InvalidCredentialsException::class);
        (new PdoFactory())->create($this->container);
    }

    public function testInvalidUserThrowInvalidCredentialsException(): void
    {
        $this->container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'database' => [
                        'host'   => self::$dbHost,
                        'port'   => self::$dbPort,
                        'dbname' => self::$dbName,
                        'user'   => 'invalid_user',
                        'pass'   => self::$dbPass,
                    ],
                ]
            );

        $this->expectException(InvalidCredentialsException::class);
        (new PdoFactory())->create($this->container);
    }

    public function testInvalidDatabaseNameThrowInvalidDatabaseException(): void
    {
        $this->container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'database' => [
                        'host'   => self::$dbHost,
                        'port'   => self::$dbPort,
                        'dbname' => 'invalid_database',
                        'user'   => self::$dbUser,
                        'pass'   => self::$dbPass,
                    ],
                ]
            );

        $this->expectException(InvalidDatabaseException::class);
        (new PdoFactory())->create($this->container);
    }

    public function testInvalidHostThrowUnableToConnectException(): void
    {
        $this->container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'database' => [
                        'host'   => 'invalid_host',
                        'port'   => self::$dbPort,
                        'dbname' => self::$dbName,
                        'user'   => self::$dbUser,
                        'pass'   => self::$dbPass,
                    ],
                ]
            );

        $this->expectException(CommonException::class);
        (new PdoFactory())->create($this->container);
    }

    public function testInvalidPortThrowUnableToConnectException(): void
    {
        $this->container
            ->method('get')
            ->with('config')
            ->willReturn(
                [
                    'database' => [
                        'host'   => self::$dbHost,
                        'port'   => 999999999,
                        'dbname' => self::$dbName,
                        'user'   => self::$dbUser,
                        'pass'   => self::$dbPass,
                    ],
                ]
            );

        $this->expectException(CommonException::class);
        (new PdoFactory())->create($this->container);
    }
}
