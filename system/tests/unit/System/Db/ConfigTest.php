<?php

declare(strict_types=1);

namespace MobicmsTest\System\Db;

use Mobicms\System\Db\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private Config $config;

    public function setUp(): void
    {
        $array = [
            'database' => [
                'host'   => 'test.host',
                'port'   => '9999',
                'dbname' => 'test_db',
                'user'   => 'test_user',
                'pass'   => 'test_pass',
            ],
        ];

        $this->config = new Config($array);
    }

    public function testConfigHasValidProperties(): void
    {
        $this->assertEquals('test.host', $this->config->host);
        $this->assertEquals(9999, $this->config->port);
        $this->assertEquals('test_db', $this->config->dbname);
        $this->assertEquals('test_user', $this->config->user);
        $this->assertEquals('test_pass', $this->config->pass);
    }
}
