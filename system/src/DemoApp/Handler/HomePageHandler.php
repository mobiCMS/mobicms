<?php

declare(strict_types=1);

namespace Mobicms\DemoApp\Handler;

use HttpSoft\Response\HtmlResponse;
use Mobicms\System\Http\IpAndUserAgentMiddleware;
use Mobicms\System\View\Renderer;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HomePageHandler implements RequestHandlerInterface
{
    private PDO $pdo;
    private Renderer $renderer;

    public function __construct(Renderer $renderer, PDO $pdo)
    {
        $this->renderer = $renderer;
        $this->pdo = $pdo;
    }

    /**
     * @throws \Throwable
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $sever = $request->getServerParams();
        $data = [];
        $data['pageTitle'] = 'Home Page';
        $data['webServer'] = (string) $sever['SERVER_SOFTWARE'];
        $data['ip'] = (string) $request->getAttribute(IpAndUserAgentMiddleware::IP_ADDR, 'Empty');
        $data['ipViaProxy'] = (string) $request->getAttribute(IpAndUserAgentMiddleware::IP_VIA_PROXY_ADDR);
        $data['userAgent'] = (string) $request->getAttribute(IpAndUserAgentMiddleware::USER_AGENT, 'Empty');
        $data['pdoDemo'] = $this->pdoDemo();

        $data['psrattributes'] = [];

        /**
         * @var string $key
         * @var mixed $val
         */
        foreach ($request->getAttributes() as $key => $val) {
            if (is_string($val) || is_int($val)) {
                $data['psrattributes'][$key] = $val;
            } elseif (is_array($val)) {
                $data['psrattributes'][$key] = 'array';
            } elseif (is_object($val)) {
                $data['psrattributes'][$key] = 'object';
            } else {
                $data['psrattributes'][$key] = 'other';
            }
        }

        return new HtmlResponse(
            $this->renderer->render('app::home', $data)
        );
    }

    private function pdoDemo(): array
    {
        $data = [];
        $req = $this->pdo->query('SELECT * FROM `test`');

        while ($res = $req->fetch(PDO::FETCH_ASSOC)) {
            $data[] = (string) $res['name'];
        }

        return $data;
    }
}
