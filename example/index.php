<?php

use Compolomus\RssReader\RssReader;
use Compolomus\RssReader\Cache;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load('.env');
$dir = $_ENV['CACHEDIR'];

$cache = new Cache($dir);

$rss = new RssReader($cache);

$rss->getCache()->addChannel('https://3dnews.ru/breaking/rss/');
$rss->getCache()->addChannel('https://3dnews.ru/motherboard/rss/');

$result = $rss->getAll();
echo '<pre>' . print_r($result, true) . '</pre>';
