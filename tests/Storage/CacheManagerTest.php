<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 22:34
 *
 * @author limi
 */

namespace Tests\Bati\Storage;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Zeroleaf\Bati\Config\Yaml;
use PHPUnit\Framework\TestCase;
use Zeroleaf\Bati\Storage\CacheManager;

/**
 * Class ManagerTest
 *
 * @package Tests\Bati\Cache
 */
class CacheManagerTest extends TestCase
{
    /**
     * @var CacheManager
     */
    protected $manager;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->manager = new CacheManager(new Yaml());
    }

    /**
     * 
     */
    public function testGetCache()
    {
        $cache = $this->manager->getCache();
        $this->assertTrue($cache instanceof ArrayCache);

        $this->doSimpleCacheAssert($cache);
    }

    /**
     * @param Cache $cache
     */
    protected function doSimpleCacheAssert(Cache $cache)
    {
        $cache->save($id = 'string', $data = 'data for one');
        $this->assertEquals($data, $cache->fetch($id));

        $cache->save($id = 'array', $data = ['name' => 'zeroleaf']);
        $this->assertEquals($data, $cache->fetch($id));
    }
}
