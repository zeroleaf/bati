<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/23
 * Time: 10:49
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Transform;

/**
 * Interface TransformerInterface
 *
 * @package Zeroleaf\Bati\Transform
 */
interface TransformerInterface
{
    /**
     * @param string $val
     *
     * @return bool
     */
    public function isTransformable($val);

    /**
     * @param string $val
     *
     * @return mixed
     */
    public function transform($val);
}