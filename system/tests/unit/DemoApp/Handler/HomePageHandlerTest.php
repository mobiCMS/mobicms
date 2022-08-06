<?php

declare(strict_types=1);

namespace MobicmsTest\DemoApp\Handler;

use HttpSoft\Response\HtmlResponse;
use Mobicms\DemoApp\Handler\HomePageHandler;
use Mobicms\System\View\Renderer;
use Mobicms\Testutils\MysqlTestCase;
use Psr\Http\Message\ServerRequestInterface;

class HomePageHandlerTest extends MysqlTestCase
{
    public function setUp(): void
    {
        self::loadSqlDump('install/sql/demodata.sql');
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

        $renderer = $this->createMock(Renderer::class);
        $renderer
            ->expects($this->once())
            ->method('render')
            ->willReturn('');

        $homePage = new HomePageHandler($renderer, self::$pdo);
        $response = $homePage->handle($request);

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }
}
