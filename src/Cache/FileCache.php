<?php declare(strict_types=1);

namespace Compolomus\RssReader\Cache;

use Compolomus\RssReader\Exceptions\DirectoryNotFoundException;
use SplFileObject;

class FileCache implements CacheInterface
{
    public function __construct(
        public string          $cacheDir = '/tmp/.rssreader_cache',
        public string          $cacheFile = 'cacheIds.txt',
        private ?SplFileObject $cacheIds = null,
    ) {
        // Read path cache dir from env
        if (!empty($_ENV['RSSREADER_CACHE_DIR'])) {
            $this->cacheDir = $_ENV['RSSREADER_CACHE_DIR'];
        }

        if (!empty($_ENV['RSSREADER_CACHE_FILE'])) {
            $this->cacheFile = $_ENV['RSSREADER_CACHE_FILE'];
        }

        if (!is_dir($this->cacheDir)) {
            if (!mkdir($this->cacheDir) && !is_dir($this->cacheDir)) {
                throw new DirectoryNotFoundException(sprintf('Directory "%s" is not found', $this->cacheDir));
            }
        }

        $this->cacheIds = new SplFileObject($this->cacheDir . '/' . $this->cacheFile, 'a+b');
    }

    /**
     * @param array $items List of IDs to save
     *
     * @return int Amount of saved bytes
     */
    public function save(array $items = []): int
    {
        $ids = array_column($items, 'id');
        return $this->cacheIds->fwrite(implode(PHP_EOL, $ids) . PHP_EOL);
    }

    /** @inheritDoc */
    public function getIds(): array
    {
        $cacheFile = $this->getCacheFilePath();

        return
            file_exists($cacheFile)
                ? file($cacheFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
                : [];
    }

    /** @inheritDoc */
    public function get(): array
    {
        return $this->getIds();
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
