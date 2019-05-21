<?php

declare(strict_types=1);

use FFMpeg\FFMpeg;
use GuzzleHttp\Client;
use Slim\Container;
use Sredni\Controller\PromoController;
use Sredni\Converter\VideoToAudioConverter;
use Sredni\Crawler\PromoCrawler;
use Sredni\Service\PromoScrapperService;

$config = require '../config/config.php';

return new Container([
    'settings' => $config,
    //CONTROLLERS
    PromoController::class => function(Container $container) {
        return new PromoController($container->get(PromoScrapperService::class));
    },

    //SERVICES
    PromoScrapperService::class => function(Container $container) {
        return new PromoScrapperService(
            $container->get(PromoCrawler::class),
            $container->get(VideoToAudioConverter::class),
            $container->get('settings')['promo_url_pattern']
        );
    },
    PromoCrawler::class => function(Container $container) {
        return new PromoCrawler(
            $container->get(Client::class),
            $container->get('settings')['temporary_path']
        );
    },
    VideoToAudioConverter::class => function(Container $container) {
        return new VideoToAudioConverter(
            $container->get(FFMpeg::class),
            $container->get('settings')['persistent_path']
        );
    },
    Client::class => function(Container $container) {
        return new Client();
    },
    FFMpeg::class => function(Container $container) {
        return FFMpeg::create();
    },
//    'audio_to_video_converter' => function(Container $container) {},
]);