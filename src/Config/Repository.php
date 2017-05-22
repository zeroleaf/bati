<?php

namespace Zeroleaf\Bati\Config;

/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 20:27
 *
 * @author limi
 */
interface Repository
{
    /**
     * 是否有给定的 key
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * 获取给定 key 的值.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * 获取所有配置.
     *
     * @return array
     */
    public function all();
}