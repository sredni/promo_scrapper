<?php

declare(strict_types=1);

return [
    'promo_url_pattern' => 'https://promo.com/promoVideos/data/search-promo-family-collection?page=1&sort_order=best_match&type=free&limit=1&keyword=%s',
    'debug' => (int)$_ENV['SCRAPPER_DEBUG'] ?? 0,
    'temporary_path' => $_ENV['SCRAPPER_TEMPORARY_PATH'] ?? '/tmp',
    'persistent_path' => $_ENV['SCRAPPER_PERSISTENT_PATH'] ?? '',
];