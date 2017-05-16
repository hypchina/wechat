<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 19:06
 */

namespace app\common\utils;


use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use think\Log;

/**http://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html
 * Guzzle 手册连接
 * Class HttpClient
 * @package app\common\utils
 */
class HttpClient
{
    private $client;

    public function  __construct(array $a = []){
        //$config = array_merge(['timeout'  => 30.0,'verify'=>'D:\phpStudy\Apache\conf\ssl\server.crt'],$a);
        $config = array_merge(['timeout'=> 30.0,'verify'=>false] , $a);
        $this->client = new Client($config);
    }

    /**发送get请求
     * @param string $uri
     * @param array $options
     * @return string
     */
    public function sendRequestWithGet($uri = '', array $options = [],$returnResponse=false){
        //$this->checkRequest($options);
        $response = $this->client->request('GET',$uri,$options);
        if(!$returnResponse){
            $body = $response->getBody()->getContents();
        }else{
            $body = $response->getBody();
        }
        $this->setLog($body,$uri);
        return $body;
    }

    /**发送post请求
     * @param string $uri
     * @param array $options
     * @return string
     *发送 application/x-www-form-urlencoded POST请求需要你传入 form_params 数组参数，数组内指定POST的字段。
     * 'form_params' => [
    'field_name' => 'abc',
    'other_field' => '123',
    'nested_field' => [
    'nested' => 'hello'
    ]
    ]
     */
    public function sendRequestWithPost($uri = '', array $options = []){
        //$options = array_merge($options,['verify'=>false]);
        //$options['verify'] = 'D:\phpStudy\Apache\conf\ssl\server.crt';
        //$this->checkRequest($options);
        $response = $this->client->request('POST',$uri,$options);
        $body = $response->getBody()->getContents();
        $this->setLog($body,$uri);
        return $body;
    }

    /**发送异步请求
     * @param $url
     */
    public function sendAsyncRequest($url){
        $promise = $this->client->requestAsync('GET', 'http://httpbin.org/get');
    }

    public function setLog($body,$uri){
        $config = $this->client->getConfig();
        $arr['response_body'] = $body;
        $arr['request_config'] = json_encode($config);
        $arr['request_url'] = $config['base_uri'].$uri;
        Log::info(json_encode($arr),'向微信发起请求');
    }

    private function checkRequest(&$options){
        // Grab the client's handler instance.
        $clientHandler = $this->client->getConfig('handler');
        // Create a middleware that echoes parts of the request.
        $tapMiddleware = Middleware::tap(function ($request) {
            dump($request->getHeader('Content-Type'));
            dump($request);
            // application/json
            dump($request->getBody()->getContents());
            // {"foo":"bar"}
        });
        $options['handler'] = $tapMiddleware($clientHandler);
    }
}