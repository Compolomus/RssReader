# RssReader by Compolomus

[![License](https://poser.pugx.org/compolomus/RssReader/license)](https://packagist.org/packages/compolomus/RssReader)
[![Build Status](https://scrutinizer-ci.com/g/Compolomus/RssReader/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/RssReader/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/RssReader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/RssReader/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Compolomus/RssReader/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/RssReader/?branch=master)
[![Code Climate](https://codeclimate.com/github/Compolomus/RssReader/badges/gpa.svg)](https://codeclimate.com/github/Compolomus/RssReader)
[![Downloads](https://poser.pugx.org/compolomus/RssReader/downloads)](https://packagist.org/packages/compolomus/RssReader)

Small library for obtaining RSS feed with caching.

```shell
composer require compolomus/RssReader
```

You may parse feed from multiple sources at once, obtained posts will be sorted by timestamp (asc).

## How to use

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Compolomus\RssReader\RssReader;

// Read channels
$rss = new RssReader([
    'https://3dnews.ru/breaking/rss/',
    'https://3dnews.ru/motherboard/rss/',
]);

// Get all posts
$result = $rss->getAll();
print_r($result);
```

After first call of this script you will see all messages from RSS feed (IDs will be cached).

After next call will be processed only a new IDs because all cached IDs will be skipped.

Each call will append IDs to cache, so you never will receive duplicates from feed.

## Environment variables

| Name                | Default value                         | Description                         |
|---------------------|---------------------------------------|-------------------------------------|
| RSSREADER_CACHE_DIR | /tmp/.rssreader_cache                 | Path to directory with cache        |
| RSSREADER_LIMIT     | 0 _(0, empty or not set - unlimited)_ | Limiting the number of recent posts |
