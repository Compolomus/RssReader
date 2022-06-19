<?php declare(strict_types=1);

namespace Compolomus\RssReader;

use SplFileObject;

class FileCache implements CacheInterface
{
    public function __construct(
        public ?string         $cacheDir = null,
        private string         $cacheIdsFile = 'cacheIds.txt',
        private ?SplFileObject $cacheIds = null,
    ) {
        // Read path cache dir from env
        if (null === $this->cacheDir) {
            $this->cacheDir = $_ENV['RSSREADER_CACHE_DIR'];
        }

        if (!is_dir($this->cacheDir)) {
            if (!mkdir($this->cacheDir) && !is_dir($this->cacheDir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->cacheDir));
            }
        }

        $this->cacheIds = new SplFileObject($this->cacheDir . '/' . $this->cacheIdsFile, 'a+b');
    }

    /**
     * @param array $ids List of IDs to save
     *
     * @return int Amount of saved bytes
     */
    public function saveIds(array $ids = []): int
    {
        return $this->cacheIds->fwrite(implode(PHP_EOL, $ids) . PHP_EOL);
    }

    /**
     * Get list of cached IDs
     *
     * @return array
     */
    public function getIds(): array
    {
        $cacheFile = $this->cacheDir . '/' . $this->cacheIdsFile;

        return
            file_exists($cacheFile)
                ? file($cacheFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
                : [];
    }
}
