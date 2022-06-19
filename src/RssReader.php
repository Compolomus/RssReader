<?php

declare(strict_types=1);

namespace Compolomus\RssReader;

use DateTime;
use DOMDocument;
use DOMXPath;
use SplFileObject;
use Symfony\Component\Dotenv\Dotenv;

use function PHPUnit\Framework\fileExists;

class RssReader
{
    private SplFileObject $cache;

    private SplFileObject $cacheIds;

    private string $cacheFile;

    private string $cacheIdsFile;

    public function __construct(string $envFile = __DIR__ . '/.env')
    {
        $dotenv = new Dotenv();
        $dotenv->load($envFile);
        $dir = $_ENV['CACHEDIR'];

        $this->cacheFile = $dir . '/cacheChannels.txt';
        $this->cacheIdsFile = $dir . '/cacheIds.txt';


        if (!is_dir($dir)) {
            mkdir($dir);
        }


        $this->cache = new SplFileObject($this->cacheFile, 'a+b');
        $this->cacheIds = new SplFileObject($this->cacheIdsFile, 'a+b');
    }

    public function addChannel(string $url): bool
    {
        if (!in_array($url, file($this->cacheFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), true)) {
            return (bool) $this->cache->fwrite($url . PHP_EOL);
        }

        return false;
    }

    public function getAll(): array
    {
        $dom = new DOMDocument();
        $result = [];
        $ids = [];

        foreach ($this->getCacheChannels() as $chanel) {
            $dom->load($chanel);
            $items = $dom->getElementsByTagName('item');
            $xpath = new DOMXpath($dom);
            foreach ($items as $item) {
                $link = $item->getElementsByTagName('link')->item(0)->nodeValue;
                preg_match('#\/(\d{3,})\/{0,1}#', $link, $matches);
                $timestamp = (new DateTime($item->getElementsByTagName('pubDate')->item(0)->nodeValue))->getTimestamp();
                $id = $matches[1];
                $cacheId = $id . '-' . $timestamp;
                if (!in_array($cacheId, $this->getCacheIds(), true)) {
                    $result[] = [
                        'id' => $id,
                        'title' => $item->getElementsByTagName('title')->item(0)->nodeValue,
                        'desc' => trim(strip_tags($item->getElementsByTagName('description')->item(0)->nodeValue)),
                        'link' => $link,
                        'timestamp' => $timestamp,
                        'img' => $xpath->query('//enclosure/@url')->item(0)->nodeValue,
                        'cacheId' => $cacheId
                    ];
                    $ids[] = $cacheId;
                }
            }
        }

        if (count($ids)) {
            $this->cacheIds->fwrite(implode(PHP_EOL, $ids) . PHP_EOL);
        }

        return $result;
    }

    protected function getCacheChannels(): array
    {
        return fileExists($this->cacheFile) ? file(
            $this->cacheFile,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        ) : [];
    }

    protected function getCacheIds(): array
    {
        return fileExists($this->cacheIdsFile) ? file(
            $this->cacheIdsFile,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        ) : [];
    }

}
