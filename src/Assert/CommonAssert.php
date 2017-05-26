<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/26
 * Time: 11:08
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Assert;

use PHPUnit\Framework\Assert;

/**
 * Trait CommonAssert
 *
 * @package Zeroleaf\Bati\Assert
 */
trait CommonAssert
{
    /**
     * @Given /^(?:则|那么) (\S+) (?:等于|为) (\S+)$/
     * @param string $key
     * @param mixed  $val
     */
    public function assertValueEquals($key, $val)
    {
        Assert::assertEquals($this->transform($key), $val);
    }
}