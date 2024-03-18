<?php declare(strict_types=1);

namespace Compolomus\RssReader;

use function array_column;
use function array_merge;
use function count;
use function crc32;
use function in_array;
use function trim;

use Compolomus\RssReader\Cache\CacheInterface;
use Compolomus\RssReader\Cache\FileCache;

class RssReader
{
    public function __construct(
        public array           $channels = [],
        public ?CacheInterface $cache = new FileCache(),
        public int             $limit = 0,
        public bool            $enable_categories = false,
    ) {
        if (!empty($_ENV['RSSREADER_LIMIT'])) {
            $this->limit = (int) $_ENV['RSSREADER_LIMIT'];
        }
    }

    /**
     * Obtain all posts details from RSS feed
     *
     * @param string $path It can be a path to file or http(s):// address
     *
     * @return mixed
     * @throws \JsonException
     */
    public function getChannel(string $path): array
    {
        // Read content of RSS feed
        $fileContents = file_get_contents($path);
        $fileContents = str_replace(["\n", "\r", "\t"], '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml    = simplexml_load_string($fileContents, "SimpleXMLElement", LIBXML_NOCDATA);

        // Convert content to simpler format
        $encode = json_encode($simpleXml, JSON_THROW_ON_ERROR);
        $decode = json_decode($encode, true, 512, JSON_THROW_ON_ERROR);

        // Return array
        return $decode ?? [];
    }

    /**
     * @throws \Exception
     */
    public function getPostsFromChannel(string $path): ?array
    {
        $channel = $this->getChannel($path);
        $items   = $channel['channel']['item'];

        // Parse all items in loop
        $result = [];
        foreach ($items as $item) {
            $itemId = crc32($item['link']);
            if (!in_array($itemId, $this->cache->getIds(), false)) {
                $itemTimestamp = (new \DateTime($item['pubDate']))->getTimestamp();
                $result[] = $item + ['_id' => $itemId, '_timestamp' => $itemTimestamp];
            }
        }

        return $result;
    }

    /**
     * Return array with only unique elements
     *
     * @param array $array
     *
     * @return array
     */
    public function getUnique(array $array): array
    {
        $serialized = array_map('serialize', $array);
        $unique     = array_unique($serialized);

        return array_intersect_key($array, $unique);
    }

    /**
     * @throws \Exception
     */
    public function getAll(): array
    {
        $results = [];
        foreach ($this->channels as $channel) {
            $results[] = $this->getPostsFromChannel($channel);
        }

        // Merge results from all sources
        $results = array_merge(...$results);

        // Only unique records
        $results = $this->getUnique($results);

        // Sort array by timestamp column
        usort($results, static function ($a, $b) {
            if ($a['_timestamp'] === $b['_timestamp']) {
                return 0;
            }
            // ASC order
            return ($a['_timestamp'] > $b['_timestamp']) ? 1 : -1;
        });

        // Extract IDs and save them all
        if (count($results)) {
            $this->cache->save($results);
        }

        // Slice last few posts if limit is set
        if (!empty($this->limit)) {
            $results = array_slice($results, -$this->limit, $this->limit);
        }

        return $results;
    }
}
