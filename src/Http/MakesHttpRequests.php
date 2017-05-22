<?php

namespace Zeroleaf\Bati\Http;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * Created by PhpStorm.
 * Date: 2017/5/18
 * Time: 22:43
 *
 * Http 请求.
 *
 * @author limi
 */
trait MakesHttpRequests
{
    /**
     * @var
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var string
     */
    protected $requestUrl;

    /**
     * @var array
     */
    protected $requestData = [];

    /**
     * @Given /^在 (\S+) 域$/
     * @param $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @Given /^对于 (\S+) 的 (\S+) 请求$/
     * @param $method
     * @param $url
     */
    public function forRequest($method, $url)
    {
        $this->requestMethod = strtolower($method);
        $this->requestUrl    = $url;
    }

    /**
     * @Given /^我在 (\S+) 中填入了 (\S+)$/
     * @param $key
     * @param $val
     */
    public function setRequestData($key, $val)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->requestData[$key] = $this->getTransformer()->transform($val);
    }

    /**
     * @Given /^我(?:提交|执行)了该请求$/
     */
    public function doRequest()
    {
        $options    = [];
        $httpClient = $this->newHttpClient();

        if (($method = $this->requestMethod) === 'get') {
            $this->requestUrl = $this->requestUrl . '?' . http_build_query($this->requestData);
        }
        else {
            $options = [
                RequestOptions::BODY => $this->requestData,
            ];
        }

        $this->response = $response = $httpClient->request($method, $this->requestUrl, $options);

        // 如果有响应数据, 假设为 JSON, 并设置对应的响应
        if ($body = $response->getBody()) {
            $this->jsonResponseData = @json_decode((string) $body, true);
        }
    }

    /**
     * @return Client
     */
    protected function newHttpClient()
    {
        $config = [];

        if ($this->baseUri) {
            $config['base_uri'] = $this->baseUri;
        }

        return new Client($config);
    }
}