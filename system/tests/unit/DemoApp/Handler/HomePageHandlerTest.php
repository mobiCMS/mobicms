<?php

declare(strict_types=1);

namespace MobicmsTest\DemoApp\Handler;

use HttpSoft\Response\HtmlResponse;
use Mobicms\DemoApp\Handler\HomePageHandler;
use Mobicms\Render\Engine;
use Mobicms\Testutils\MysqlTestCase;
use Mobicms\Testutils\SqlDumpLoader;
use Psr\Http\Message\ServerRequestInterface;

class HomePageHandlerTest extends MysqlTestCase
{
    public function setUp(): void
    {
        $loader = new SqlDumpLoader(self::getPdo());
        $loader->loadFile('install/sql/demodata.sql');

        if ($loader->hasErrors()) {
            $this->fail(implode("\n", $loader->getErrors()));
        }
    }

    public function testReturnsHtmlResponse(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->expects($this->once())
            ->method('getServerParams')
            ->willReturn(['SERVER_SOFTWARE' => 'test']);
        $request
            ->expects($this->once())
            ->method('getAttributes')
            ->willReturn(
                [
                    'int'    => 123,
                    'string' => 'string',
                    'array'  => [],
                    'object' => new \stdClass(),
                    'other'  => null,
                ]
            );

        $renderer = $this->createMock(Engine::class);
        $renderer
            ->expects($this->once())
            ->method('render')
            ->willReturn('');

        $homePage = new HomePageHandler($renderer, self::getPdo());
        $response = $homePage->handle($request);

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }
}
