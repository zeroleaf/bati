<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/23
 * Time: 11:37
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Transform;

use Zeroleaf\Bati\BatiContext;
use Zeroleaf\Bati\Config\Repository;

/**
 * Class Transformer
 *
 * @package Zeroleaf\Bati\Transform
 */
class Transformer
{
    /**
     * @var BatiContext
     */
    protected $context;

    /**
     * @var array
     */
    protected $transformers;

    /**
     * Transformer constructor.
     *
     * @param BatiContext $context
     */
    public function __construct(BatiContext $context)
    {
        $this->context = $context;

        $this->initializeTransformers();
    }

    /**
     *
     */
    protected function initializeTransformers()
    {
        $this->transformers = [
            new FakerTransformer($this->getConfig()),
            new StorageTransformer($this->getCache()),
        ];
    }

    /**
     * 转换.
     *
     * @param string $val
     * @param bool   $failOnNotTransformable
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function transform($val, $failOnNotTransformable = false)
    {
        /** @var TransformerInterface $transformer */
        foreach ($this->transformers as $transformer) {
            if ($transformer->isTransformable($val)) {
                return $transformer->transform($val);
            }
        }

        if ($failOnNotTransformable) {
            throw new \InvalidArgumentException("Not transformable value {$val}");
        }

        return $val;
    }

    /**
     * @return BatiContext
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return Repository
     */
    public function getConfig()
    {
        return $this->getContext()->getConfig();
    }

    /**
     * @return \Doctrine\Common\Cache\Cache
     */
    protected function getCache()
    {
        return $this->getContext()->getCache();
    }
}