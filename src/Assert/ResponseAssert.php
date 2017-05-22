<?php

namespace Zeroleaf\Bati\Assert;

use GuzzleHttp\Cookie\SetCookie;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;

/**
 * Created by PhpStorm.
 * Date: 2017/5/18
 * Time: 23:34
 *
 * @property array             $jsonResponseData
 * @property ResponseInterface $response
 *
 * @author limi
 */
trait ResponseAssert
{
    /**
     * @Given /^(?:那么|则)?响应的状态码(?:等于|为) (\S+)$/
     * @param string $statusCode
     */
    public function assertStatusCodeEquals($statusCode)
    {
        Assert::assertEquals($statusCode, $this->response->getStatusCode());
    }

    /**
     * @Given /^(?:那么|则)?响应的状态码满足 (\S+)$/
     * @param string $pattern
     */
    public function assertStatusCodeRegexMatch($pattern)
    {
        Assert::assertRegExp($pattern, (string) $this->response->getStatusCode());
    }

    /**
     * @Given /^则响应的 Cookie (\S+) 等于 (\S+)$/
     * @param string $key
     * @param string $val
     */
    public function assertCookieEquals($key, $val)
    {
        $cookies = $this->response->getHeader('Set-Cookie');

        foreach ($cookies as $cookie) {
            $setCookie = SetCookie::fromString($cookie);
            if ($key == $setCookie->getName()) {
                Assert::assertEquals($val, $setCookie->getValue());

                return;
            }
        }

        Assert::fail("未知的 Cookie {$key}");
    }

    /**
     * @Given /^(?:那么|则)?响应数据中的 (\S+) (?:等于|为) (\S+)$/
     *
     * @param string $key
     * @param string $val
     */
    public function assertJsonResponseDataEquals($key, $val)
    {
        Assert::assertEquals($val, $this->getResponseValue($key));
    }

    /**
     * @Given /^(?:那么|则)?响应数据中的 (\S+) (?:是|类型为) (\S+)$/
     *
     * @param string $key
     * @param string $type
     *
     * @internal param string $val
     */
    public function assertJsonResponseDataIs($key, $type)
    {
        $this->assertIsType($this->getResponseValue($key), $type);
    }

    /**
     * @param mixed  $val
     * @param string $type
     */
    protected function assertIsType($val, $type)
    {
        switch ($targetType = strtolower(trim($type))) {
            case 'bool':
            case 'boolean':
                $result = is_bool($val);
                break;
            case 'int':
            case 'long':
            case 'integer':
                $result = is_int($val);
                break;
            case 'real':
            case 'float':
            case 'double':
                $result = is_float($val);
                break;
            case 'numeric':
                $result = is_numeric($val);
                break;
            case 'string':
                $result = is_string($val);
                break;
            case 'null':
                $result = is_null($val);
                break;
            case 'array':
                $result = is_array($val);
                break;
            case 'object':
                $result = is_object($val);
                break;
            default:
                throw new \InvalidArgumentException("未知的类型 {$targetType}");
        }

        Assert::assertTrue($result);
    }

    /**
     * @Given /^(?:那么|则)?响应数据中的 (\S+) 满足 (\S+)$/
     * @param string $key
     * @param string $pattern
     */
    public function assertJsonResponseDataRegexMatch($key, $pattern)
    {
        Assert::assertRegExp($pattern, (string) $this->getResponseValue($key));
    }
}