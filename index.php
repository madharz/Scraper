<?php
require 'vendor/autoload.php';
require_once __DIR__ . '/MeteopostScraper.php';
require_once __DIR__ . '/InformationSeeker.php';

$scraper = new MeteopostScraper();
$seeker = new InformationSeekerFromFile();

try {
    $scraper->getContent();
    $weatherInfo = $seeker->getInfo();

    echo "city: ". $weatherInfo['city'] . "\n";
    echo "minTemp: ". $weatherInfo['minTemp'] . "\n";
    echo "maxTemp: ". $weatherInfo['maxTemp'] . "\n";

} catch (Exception $e) {
    throw new Exception("Exception information: " . $e->getMessage());
}