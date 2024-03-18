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

## Usage

You can parse feed from multiple sources at once, and obtained posts will be sorted by timestamp (asc). Here's an example of how to use the `RssReader` class:

**Example**: Parsing RSS feeds and retrieving all posts

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Compolomus\RssReader\RssReader;

// Prepare RSS reader
$rss = new RssReader([
    'https://3dnews.ru/breaking/rss/',
    'https://3dnews.ru/motherboard/rss/',
]);

// Get all posts
$result = $rss->getAll();
print_r($result);
```

After the first call of this script, you will see all messages from the RSS
feed with their IDs cached. On subsequent calls, only new IDs will be
processed because all cached IDs will be skipped. Each call will append IDs
to the cache, ensuring that you never receive duplicates from the feed.

**Advanced example**: Same as above but with customizing cache settings

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Compolomus\RssReader\Cache\FileCache;
use Compolomus\RssReader\RssReader;

// Prepare cache
$cache = new FileCache('/tmp/RssReader', 'ids.txt');

// Prepare RSS reader
$rss = new RssReader([
    'https://3dnews.ru/breaking/rss/',
    'https://3dnews.ru/motherboard/rss/',
], $cache);

// Get all posts
$result = $rss->getAll();
print_r($result);
```

## Environment Variables

The `RssReader` library supports several environment variables for customization:

| Name                 | Default value                         | Description                                |
|----------------------|---------------------------------------|--------------------------------------------|
| RSSREADER_LIMIT      | 0 _(0, empty or not set - unlimited)_ | Limiting the number of recent posts        |
| RSSREADER_CACHE_DIR  | /tmp/.rssreader_cache                 | Path to directory with cache               |
| RSSREADER_CACHE_FILE | cacheIds.txt                          | Name of file in which cache will be stored |

Environment variable `RSSREADER_LIMIT` allows limiting the number of recent posts.
By default, there is no limit (0 or empty). The cache directory and filename
can also be customized using the `RSSREADER_CACHE_DIR` and `RSSREADER_CACHE_FILE`
environment variables.

## Testing

To run tests for this library, execute the following command:

```shell
composer test
```

## Quality Assurance

This project uses several tools to ensure code quality and maintainability:

* PHP_CodeSniffer: Checks the code syntax and style against the PSR-12 standard.
* PHPStan: Performs static analysis of the codebase to find potential bugs and errors.
* PHPUnit: Used for testing purposes.
