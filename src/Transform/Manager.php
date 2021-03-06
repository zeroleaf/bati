<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/19
 * Time: 00:26
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Transform;

use Faker\Factory;
use Faker\Generator;

/**
 * Class Manager
 *
 * @package Zeroleaf\Bati\Transform
 */
class Manager
{
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * Manager constructor.
     *
     * @param string $locale
     */
    public function __construct($locale = 'zh_CN')
    {
        $this->faker = Factory::create($locale);
    }

    /**
     * @return Generator
     */
    public function getFaker()
    {
        return $this->faker;
    }

    /**
     * @param $provider
     */
    public function addProvider($provider)
    {
        $this->getFaker()->addProvider($provider);
    }

    /**
     * @param string $val
     *
     * @return string
     */
    public function transform($val)
    {
        if (($fake = $this->getFake($val)) !== false) {
            return $this->transformFake($fake);
        }

        return $val;
    }

    /**
     * @param string $val
     *
     * @return string|false
     */
    protected function getFake($val)
    {
        $pattern = '/^\{(.+)\}$/';

        if (preg_match($pattern, $val, $matches)) {
            return $matches[1];
        }

        return false;
    }

    /**
     * @param string $fake
     *
     * @return string
     */
    protected function transformFake($fake)
    {
        if (preg_match("/\((.*)\)/", $fake, $matches)) {
            $arguments = array_map([$this, 'formatArgument'], explode(',', $matches[1]));
        }

        $format = substr($fake, 0, strpos($fake, '(') ?: strlen($fake));

        return $this->getFaker()->format($format, $arguments ?? []);
    }

    /**
     * @param string $val
     *
     * @return mixed
     */
    protected function formatArgument($val)
    {
        $subject = trim($val, ", \t\n\r\0\x0B");

        return $this->cast($subject);
    }

    /**
     * @param string $val
     *
     * @return mixed
     */
    protected function cast($val)
    {
        if (preg_match("/^'(.*)'$/", $val, $matches)) {
            return $matches[1];
        }

        if (is_numeric($val)) {
            return strpos($val, '.') === false ? intval($val) : floatval($val);
        }

        if ($val === 'true') {
            return true;
        }

        if ($val === 'false') {
            return false;
        }

        if ($val === 'null') {
            return null;
        }

        // TODO 添加数组的支持
        return $val;
    }
}