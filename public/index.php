<?php

error_reporting(E_ALL);

version_compare(PHP_VERSION, '5.5', '<') and die('PHP version must above 5.5.');

define("ROOT_PATH", dirname(__DIR__));

date_default_timezone_set("UTC");

session_start();

//load composer autoload
require ROOT_PATH . '/vendor/autoload.php';

//load config
$config = require ROOT_PATH . '/config/config.php';
if (file_exists($productionConfigFile = ROOT_PATH . '/config/production/config.php') ) {
    $productionConfig = require $productionConfigFile;
    $config = array_replace_recursive($config,$productionConfig);
}

//load function
require ROOT_PATH . '/function.php';

//load route
$routes = require ROOT_PATH . '/routes.php';

// using FastRoute to dispatch
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) use ($routes) {
    if (is_array($routes) && !empty($routes)) foreach ($routes as $key => $value) {
        $count = count($value);
        if ($count == 2) {
            $r->addRoute(['GET', 'POST'], reset($value), next($value));
        } elseif ($count == 3) {
            $r->addRoute(reset($value), next($value), next($value));
        }
    }
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        send_http_status(404);
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        send_http_status(405);
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $dir = $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $method = 'default' ;
        if ($handler == '/') {
            require ROOT_PATH.'/app/main.php';
            exit();
        } elseif ($atPoint = strpos($handler,'@')) {
            $dir = substr($handler,0,$atPoint);
            $method = substr($handler, $atPoint+1);
        }
        if (!file_exists($handlerPath = ROOT_PATH.'/app/'.$dir.'/'.$method.'.php')) {
            send_http_status(404);
            exit('method not found');
        }
        require ROOT_PATH.'/qiniu.php';
        require $handlerPath;
        break;
}
