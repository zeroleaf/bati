<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 21:46
 *
 * @author limi
 */

namespace Tests\Bati\Config;

use Zeroleaf\Bati\Config\Yaml;

/**
 * Class YamlTest
 *
 * @package Tests\Bati\Config
 */
class YamlTest extends RepositoryTest
{
    /**
     * @var Yaml
     */
    protected $repository;

    /**
     * 初始化.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = new Yaml();
    }

    /**
     * @return Yaml
     */
    protected function getRepository()
    {
        return $this->repository;
    }

}
