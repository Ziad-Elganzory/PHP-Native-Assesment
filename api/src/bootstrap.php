<?php

require_once __DIR__ . '/Helpers/LoadEnv.php';
load_env(__DIR__ . '/../.env');

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', __DIR__ . '/../src');

use Src\Core\Router;

$router = new Router();

$routesPath = APP_DIR . '/Routes';
foreach (glob("$routesPath/*.php") as $routeFile) {
    $route = require $routeFile;
    if (is_callable($route)) {
        $route($router);
    }
}

$GLOBALS['router'] = $router;



?>
