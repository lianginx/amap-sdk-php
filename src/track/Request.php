<?php

namespace amap\track;

use amap\enum\TrackEnum;
use GuzzleHttp\Client;


class Request
{

    public $response;

    public $data = [];

    function __construct(string $url, string $method = 'GET', array $params = [], array $options = [])
    {
        // 默认拦截API错误状态, 抛出异常
        $options['throw_api_error'] = !isset($options['throw_api_error']) ?? true;

        $client = new Client([
            'base_uri' => TrackEnum::API_BASE_URL,
        ]);

        $config = require __DIR__ . '/../Config.php';
        $options['query']['key'] = $config['api_key'];
        switch ($method) {
            case 'GET':
                $options['query'] = array_merge($params, $options['query'] ?? []);
                break;
            default:
                $options['form_params'] = array_merge($params, $options['form_params'] ?? []);
                break;
        }

        $this->response = $response = $client->request($method, $url, $options);

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200)
            throw new \Exception('网络请求失败');

        $body = $response->getBody()->getContents();
        $jsonBody = json_decode($body, true) ?? [];
        if ($jsonBody['errcode'] != 10000 && $options['throw_api_error']) {
            throw new \Exception($jsonBody['errmsg']);
        }

        $this->data = $jsonBody['data'] ?? [];
    }

}
