<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/23
 * Time: 10:53
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Transform;

use Doctrine\Common\Cache\Cache;

/**
 * Class StorageTransformer
 *
 * @package Zeroleaf\Bati\Transform
 */
class StorageTransformer extends TransformerBase
{
    /**
     * @var string
     */
    protected $pattern = '/^\$(\S+)$/';

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * StorageTransformer constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $val
     *
     * @return bool
     */
    public function isTransformable($val)
    {
        return $this->getTransformKey($val) !== false;
    }

    /**
     * @param string $val
     *
     * @return mixed
     */
    public function transform($val)
    {
        $transformKey = $this->getTransformKey($val);

        return $this->getCache()->fetch($transformKey);
    }

    /**
     * @param string $val
     *
     * @return string|false
     */
    protected function getTransformKey($val)
    {
        if (! preg_match($this->pattern, trim($val), $matches)) {
            return false;
        }

        return $matches[1];
    }

    /**
     * @return Cache
     */
    protected function getCache()
    {
        return $this->cache;
    }
}