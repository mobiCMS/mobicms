<?php

declare(strict_types=1);

namespace MobicmsTest\DemoApp\Handler;

use HttpSoft\Response\HtmlResponse;
use Mobicms\DemoApp\Handler\HomePageHandler;
use Mobicms\{
    Render\Engine,
    Middleware\IpAndUserAgentMiddleware,
    Interface\SessionInterface,
    Testutils\MysqlTestCase,
    Testutils\SqlDumpLoader
};
use Psr\Http\Message\ServerRequestInterface;

class HomePageHandlerTest extends MysqlTestCase
{
    public function setUp(): void
    {
        $loader = new SqlDumpLoader(self::getPdo());
        $loader->loadFile('install/sql/mobicms.sql');

        if ($loader->hasErrors()) {
            $this->fail(implode("\n", $loader->getErrors()));
        }
    }

    public function testReturnsHtmlResponse(): void
    {
        $homePage = new HomePageHandler($this->mockRenderer(), self::getPdo());
        $response = $homePage->handle($this->mockRequest());

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }

    private function mockRequest(): ServerRequestInterface
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(
            [
                'session' => 'test-session',
                'reset'   => '',
            ]
        );
        $request
            ->method('getAttribute')
            ->withConsecutive(
                [SessionInterface::class],
                [IpAndUserAgentMiddleware::IP_ADDR],
                [IpAndUserAgentMiddleware::IP_VIA_PROXY_ADDR],
                [IpAndUserAgentMiddleware::USER_AGENT]
            )
            ->willReturn($this->mockSession(), '192.168.0.1', '', 'UA');
        $request
            ->method('getServerParams')
            ->willReturn(['SERVER_SOFTWARE' => 'test']);
        $request
            ->expects($this->once())
            ->method('getAttributes')
            ->willReturn(
                [
                    'int' => 123,
                    'string' => 'string',
                    'array' => [],
                    'object' => new \stdClass(),
                    'other' => null,
                ]
            );

        return $request;
    }

    private function mockSession(): SessionInterface
    {
        return $this->createMock(SessionInterface::class);
    }

    private function mockRenderer(): Engine
    {
        $renderer = $this->createMock(Engine::class);
        $renderer
            ->expects($this->once())
            ->method('render')
            ->willReturn('');

        return $renderer;
    }
}
