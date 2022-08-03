<?php

declare(strict_types=1);

namespace Mobicms\System\Db;

use Devanych\Di\FactoryInterface;
use Mobicms\System\Db\Exception\CommonException;
use Mobicms\System\Db\Exception\InvalidDatabaseException;
use Mobicms\System\Db\Exception\InvalidCredentialsException;
use PDO;
use PDOException;
use Psr\Container\ContainerInterface;

class PdoFactory implements FactoryInterface
{
    public function create(ContainerInterface $container): PDO
    {
        $config = (array) $container->get('config');

        try {
            return new PDO(
                sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                    (string) ($config['database']['host'] ?? 'localhost'),
                    (int) ($config['database']['port'] ?? 3306),
                    (string) ($config['database']['dbname'] ?? '')
                ),
                (string) ($config['database']['user'] ?? ''),
                (string) ($config['database']['pass'] ?? ''),
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $exception) {
            $code = (int) $exception->getCode();

            throw match ($code) {
                1045 => new InvalidCredentialsException('Invalid database credentials (user, password)', $code),
                1049 => new InvalidDatabaseException('Unknown database', $code),
                default => new CommonException($exception->getMessage(), $code)
            };
        }
    }
}
