<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 22:52
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Storage;

use Doctrine\Common\Cache\Cache;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;
use Zeroleaf\Bati\Config\Yaml;

/**
 * @property ResponseInterface $response
 * @property array             $jsonResponseData
 *
 * @package Zeroleaf\Bati\Cache
 */
trait DataStorage
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @Given /^我将响应数据中的 (\S+) 存储为 (\S+)$/
     *
     * @param string $responseKey
     * @param string $targetKey
     */
    public function saveJsonResponseDataAs($responseKey, $targetKey)
    {
        $this->getCache()->save($targetKey, $this->getResponseValue($responseKey));
    }

    /**
     * @Given /^(?:则|那么)存储数据中的 (\S+) (?:等于|为) (\S+)$/
     * 
     * @param string $key
     * @param mixed  $val
     */
    public function assertCacheValue($key, $val)
    {
        $cached = $this->getCache()->fetch($key);

        Assert::assertEquals($val, $cached);
    }

    /**
     * @return Cache
     */
    protected function getCache()
    {
        if (! isset($this->cache)) {
            $this->cache = (new CacheManager(Yaml::instance()))->getCache();
        }

        return $this->cache;
    }
}