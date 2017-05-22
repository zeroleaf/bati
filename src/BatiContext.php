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
use Psr\Http\Message\ResponseInterface;
use Zeroleaf\Bati\Assert\ResponseAssert;
use Zeroleaf\Bati\Http\MakesHttpRequests;
use Zeroleaf\Bati\Transform\Manager;

/**
 * Class BatiContext
 *
 * @package Zeroleaf\Bati
 */
class BatiContext implements Context
{
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
}