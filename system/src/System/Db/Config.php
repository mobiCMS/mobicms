<?php

declare(strict_types=1);

namespace Mobicms\System\Db;

/**
 * @property string $host
 * @property int $port
 * @property string $dbname
 * @property string $user
 * @property string $pass
 */
class Config
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __get(string $name)
    {
        return $this->config['database'][$name] ?? '';
    }
}
