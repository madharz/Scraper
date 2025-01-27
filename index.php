<?php
require 'vendor/autoload.php';
require_once __DIR__ . '/MeteopostScraper.php';
require_once __DIR__ . '/InformationSeeker.php';

$scraper = new MeteopostScraper();
$scraper->getContent();

$seeker = new InformationSeekerFromFile();
$seeker->getInfo();
