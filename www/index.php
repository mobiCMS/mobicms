<?php

declare(strict_types=1);

use HttpSoft\Basis\Application;
use HttpSoft\ServerRequest\ServerRequestCreator;

define('START_MEMORY', memory_get_usage());
define('START_TIME', microtime(true));

chdir(dirname(__DIR__) . '/system');
require 'vendor/autoload.php';

(function () {
    $container = require_once 'config/container.php';
    $app = $container->get(Application::class);

    (require_once 'config/pipeline.php')($app);
    (require_once 'config/routes.php')($app);

    $app->run(ServerRequestCreator::create());
})();
