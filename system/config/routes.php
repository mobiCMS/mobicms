<?php

declare(strict_types=1);

use HttpSoft\Basis\Application;
use Mobicms\DemoApp\Handler\HomePageHandler;

return function (Application $app): void {
    $app->get('home', '/', HomePageHandler::class);
};
