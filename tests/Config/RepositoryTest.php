<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 21:43
 *
 * @author limi
 */

namespace Tests\Bati\Config;

use Tests\Bati\TestCase;
use Zeroleaf\Bati\Config\Repository;

/**
 * Class RepositoryTest
 *
 * @package Tests\Bati\Config
 */
abstract class RepositoryTest extends TestCase
{
    /**
     * @return Repository
     */
    protected abstract function getRepository();

    /**
     * 获取测试.
     */
    public function testGet()
    {
        $cache = $this->getRepository()->get('cache.driver');
        $this->assertEquals('array', $cache);
    }
}
