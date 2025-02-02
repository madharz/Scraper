<?php

require_once __DIR__ . '/MeteopostScraper.php';
require_once __DIR__ . '/InformationSeeker.php';

// @TODO check https://stackoverflow.com/questions/11048835/php-pass-parameters-from-command-line-to-a-php-script
$cityId = '18697/';

try {
    $scraper = new MeteopostScraper();
    $html = $scraper->getWeather($cityId);

    $seeker = new InformationSeekerFromFile();
    header('Content-Type: application/json; charset=UTF-8');
    echo $seeker->getInfo($html);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
