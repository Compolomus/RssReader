<?php declare(strict_types=1);

namespace Compolomus\RssReader;

use Compolomus\RssReader\Cache\CacheInterface;
use Compolomus\RssReader\Exceptions\DatabaseConnectionException;
use PDO;

// TODO
class SqliteCache implements CacheInterface
{
    public function __construct(
        public string $cacheDir = '/tmp/.rssreader_cache',
        public string $cacheFile = 'cache.sqlite',
        private ?PDO  $connection = null,
    ) {
        // Read path cache dir from env
        if (!empty($_ENV['RSSREADER_CACHE_DIR'])) {
            $this->cacheDir = $_ENV['RSSREADER_CACHE_DIR'];
        }

        try {
            $this->connection = new PDO('sqlite:' . $this->getCacheFilePath());
            $this->createTables();
        } catch (\Exception $e) {
            throw new DatabaseConnectionException($e->getMessage());
        }
    }

    /**
     * @param array $items List of news items to save
     *
     * @return int Affected rows count
     */
    public function save(array $items = []): int
    {
        $stmt = $this->connection->prepare('REPLACE INTO news (id, title, link, content) VALUES (:id, :title, :link, :content)');
        foreach ($items as $item) {
            $json = json_encode($item);
            $stmt->bindValue(':id', $item['id']);
            $stmt->bindValue(':title', $item['title']);
            $stmt->bindValue(':link', $item['link']);
            $stmt->bindValue(':content', $json);
            $stmt->execute();
        }

        return count($items);
    }

    // TODO
    public function getIds(): array
    {
        return [];
    }

    /**
     * Get list of cached news items
     *
     * @return array
     */
    public function get(): array
    {
        $stmt = $this->connection->prepare('SELECT id, title, link, content FROM news');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create tables if they don't exist
     */
    private function createTables(): void
    {
        $this->connection->exec('CREATE TABLE IF NOT EXISTS news (id TEXT PRIMARY KEY, title TEXT, link TEXT, content TEXT)');
    }

    /**
     * Get path to sqlite database file
     *
     * @return string
     */
    private function getCacheFilePath(): string
    {
        return $this->cacheDir . '/' . $this->cacheFile;
    }
}
