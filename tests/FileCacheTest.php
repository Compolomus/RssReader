<?php declare(strict_types=1);

namespace Compolomus\RssReader\Tests;

use Compolomus\RssReader\Cache\FileCache;
use PHPUnit\Framework\TestCase;

class FileCacheTest extends TestCase
{
    private string    $testCacheDir;
    private FileCache $fileCache;

    protected function setUp(): void
    {
        $this->testCacheDir = sys_get_temp_dir() . '/FileCacheTest';

        if (!file_exists($this->testCacheDir)) {
            mkdir($this->testCacheDir, 0775, true);
        }

        $this->fileCache = new FileCache($this->testCacheDir, 'cacheIdsTest.txt');
    }

    protected function tearDown(): void
    {
        system('rm -rf ' . escapeshellarg($this->testCacheDir));
    }

    public function testSaveIdsAndGetIds(): void
    {
        $items = [
            ['id' => 'id1'],
            ['id' => 'id2'],
            ['id' => 'id3'],
        ];
        $ids = array_column($items, 'id');

        // Test saving IDs
        $numBytesWritten = $this->fileCache->save($items);
        $this->assertGreaterThan(0, $numBytesWritten);

        // Test getting IDs
        $cachedIds = $this->fileCache->get();
        $this->assertEquals($ids, $cachedIds);
    }

    public function testGetIdsEmpty(): void
    {
        $cachedIds = $this->fileCache->get();
        $this->assertEquals([], $cachedIds);
    }
}
