<?php

use Compolomus\RssReader\RssReader;

require_once __DIR__ . '/../vendor/autoload.php';

$rss = new RssReader(__DIR__ . '/../.env');

$rss->addChannel('https://3dnews.ru/breaking/rss/');
$rss->addChannel('https://3dnews.ru/motherboard/rss/');

$result = $rss->getAll();
echo '<pre>' . print_r($result, true) . '</pre>';
