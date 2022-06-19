<?php

use Compolomus\RssReader\RssReader;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load('.env');
$dir = $_ENV['CACHEDIR'];

$rss = new RssReader($dir);

$rss->addChannel('https://3dnews.ru/breaking/rss/');
$rss->addChannel('https://3dnews.ru/motherboard/rss/');

$result = $rss->getAll();
echo '<pre>' . print_r($result, true) . '</pre>';
