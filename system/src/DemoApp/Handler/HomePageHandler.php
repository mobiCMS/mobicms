<?php

declare(strict_types=1);

namespace Mobicms\DemoApp\Handler;

use HttpSoft\Response\HtmlResponse;
use Mobicms\Render\Engine;
use Mobicms\Middleware\IpAndUserAgentMiddleware;
use Mobicms\Session\SessionInterface;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function is_string;
use function is_object;
use function is_array;
use function is_int;

final class HomePageHandler implements RequestHandlerInterface
{
    private PDO $pdo;
    private Engine $renderer;

    public function __construct(Engine $renderer, PDO $pdo)
    {
        $this->renderer = $renderer;
        $this->pdo = $pdo;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionInterface::class);
        $sever = $request->getServerParams();
        $query = $request->getQueryParams();
        $data = [];

        if (isset($query['session'])) {
            $session->set('foo', htmlentities(trim((string) $query['session'])));
        }

        if (isset($query['reset'])) {
            $session->clear();
        }

        $data['session'] = (string) $session->get('foo', 'no session');
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
            $data['psrattributes'][$key] = $this->checkType($val);
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

    private function checkType(mixed $var): array
    {
        return match (true) {
            is_object($var) => ['<span class="badge text-bg-primary">object</span>', $var::class],
            is_string($var) => ['<span class="badge text-bg-secondary">string</span>', $var],
            is_array($var) => ['<span class="badge text-bg-info">array</span>', ''],
            is_int($var) => ['<span class="badge text-bg-dark">&nbsp;int&nbsp;</span>', $var],
            default => ['<span class="badge text-bg-warning">unknown type</span>', '']
        };
    }
}
