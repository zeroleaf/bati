<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 22:10
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Storage;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\ArrayCache;
use Zeroleaf\Bati\Config\Repository;

/**
 * Class Manager
 *
 * @package Zeroleaf\Bati\Cache
 */
class CacheManager
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * Manager constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;

        $this->resolveCache();
    }

    /**
     * 初始化 Cache.
     */
    protected function resolveCache()
    {
        $driver = $this->config->get('cache.driver');

        $targetMethod = sprintf('get%sCache', ucfirst($driver));

        try {
            $this->cache = $this->{$targetMethod}();
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException("未知的 Cache Driver: {$driver}");
        }
    }

    /**
     * 获取数组缓存.
     */
    public function getArrayCache()
    {
        return new ArrayCache();
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }
}