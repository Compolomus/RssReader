<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Compolomus\RssReader\RssReader;
use Symfony\Component\Dotenv\Dotenv;

// Load env variables
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// Read channels
$rss = new RssReader([
    'https://3dnews.ru/breaking/rss/',
    'https://3dnews.ru/motherboard/rss/',
]);

// Get all posts
$result = $rss->getAll();
print_r($result);
