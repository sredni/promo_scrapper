<?php

declare(strict_types=1);

use Slim\App;
use Sredni\Response\ResponseFormatMiddleware;
use Sredni\Routing\Route;

require '../vendor/autoload.php';

$routing = require '../config/routing.php';
$container = require '../config/container.php';
$app = new App($container);

$app->add(new ResponseFormatMiddleware($container->get('settings')['debug']));

$app->group('/api', function () use ($app, $routing) {
    foreach ($routing as $route) {
        if (!$route instanceof Route) {
            throw new InvalidArgumentException(
                sprintf('Invalid routing argument expected %s, got %s', Route::class, get_class($route))
            );
        }

        $app->map([$route->method()], $route->route(), $route->action());
    }
});

$app->run();