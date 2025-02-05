<?php

require_once __DIR__ . '/MeteopostScraper.php';
require_once __DIR__ . '/InformationSeeker.php';

if ($argc < 2) {
    exit("Usage: php index.php <city_id>\n");
}

$cityId = trim($argv[1]);

try {
    $scraper = new MeteopostScraper();
    $html = $scraper->getWeather();

    $seeker = new InformationSeekerFromFile();
    header('Content-Type: application/json; charset=UTF-8');
    echo $seeker->getInfo($html,$cityId);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
