<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/19
 * Time: 11:31
 *
 * @author limi
 */

namespace Zeroleaf\Bati;

use Behat\Behat\Context\Context;
use Zeroleaf\Bati\Transform\Manager;
use Zeroleaf\Bati\Storage\DataStorage;
use Psr\Http\Message\ResponseInterface;
use Zeroleaf\Bati\Assert\ResponseAssert;
use Zeroleaf\Bati\Http\MakesHttpRequests;

/**
 * Class BatiContext
 *
 * @package Zeroleaf\Bati
 */
class BatiContext implements Context
{
    use DataStorage;

    use MakesHttpRequests;
    use ResponseAssert;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Json 响应数据
     *
     * @var array
     */
    protected $jsonResponseData = [];

    /**
     * @var Manager
     */
    protected $transformer;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->transformer = new Manager();
    }

    /**
     * @return Manager
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function getResponseValue($key, $default = null)
    {
        return array_get($this->jsonResponseData, $key, $default);
    }
}