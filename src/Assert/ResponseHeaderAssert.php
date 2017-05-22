<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 23:18
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Assert;

use GuzzleHttp\Cookie\SetCookie;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait ResponseHeaderAssert
 *
 * @property ResponseInterface $response
 *
 * @package Zeroleaf\Bati\Assert
 */
trait ResponseHeaderAssert
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
        /** @var SetCookie $cookie */
        if (! $cookie = $this->getCookie($key)) {
            Assert::fail("未知的 Cookie {$key}");
        }

        Assert::assertEquals($val, $cookie->getValue());
    }
}