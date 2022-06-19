<?php

declare(strict_types=1);

namespace Compolomus\RssReader;

use DateTime;
use DOMDocument;
use DOMXPath;
use SplFileObject;
use Symfony\Component\Dotenv\Dotenv;

class RssReader
{
    private SplFileObject $cache;

    private string $cacheFile;

    private string $cacheIdsFile;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/.env');
        $dir = getenv('CACHEDIR');

        $this->cacheFile = $dir . '/cacheChannels.txt';
        $this->cacheIdsFile = $dir . '/cacheIds.txt';

        if (!is_dir($dir)) {
            mkdir($dir);
        }


        $this->cache = new SplFileObject($this->cacheFile, 'a+b');
    }

    public function addChannel(string $url): bool
    {
        if (!in_array($url, file($this->cacheFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), true)) {
            return (bool)$this->cache->fwrite($url . PHP_EOL);
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
                preg_match('#\/(\d+)\/#', $link, $matches);
                $timestamp = (new DateTime($item->getElementsByTagName('pubDate')->item(0)->nodeValue))->getTimestamp();
                $id = @$matches[1];
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
        $file = new SplFileObject($this->cacheIdsFile, 'a+b');
        $cacheIds = $this->setCacheIds($ids);
        $file->fwrite(implode(PHP_EOL, $cacheIds) . PHP_EOL);

        return $result;
    }

    protected function getCacheChannels(): array
    {
        return file($this->cacheFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    protected function getCacheIds(): array
    {
        return file($this->cacheIdsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    }

    protected function setCacheIds(array $data): array
    {
        return array_column('cacheId', $data);
    }
}
