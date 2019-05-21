<?php

declare(strict_types=1);

use Sredni\Controller\PromoController;
use Sredni\Controller\TestController;
use Sredni\Routing\Route;

return [
    new Route(
        'get',
        '/test',
        TestController::class . ':test'
    ),
    new Route(
        'get',
        '/promo2mp3',
        PromoController::class . ':promoVideoToAudio'
    )
];