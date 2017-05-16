<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 20:11
 */

namespace app\common\utils;


use think\Cache;
use think\Config;

class Base
{
    protected $apiUrl;
    protected $httpClient;
    private  $token;
    private  $appId;
    private  $appSecret;
    public function __construct()
    {
        $this->apiUrl = Config::get('wechat.base_url');
        $this->token = Config::get("wechat.app_token");
        $this->appId = Config::get("wechat.app_id");
        $this->appSecret = Config::get("wechat.app_secret");
        $this->httpClient = new HttpClient(['base_uri'=>$this->apiUrl]);
    }

    protected function checkResult($body){
        $bodyArr = json_decode($body,true);
        if($bodyArr['errmsg'] !== 'ok'){
            return false;
        }
        return true;
    }

    //?grant_type=client_credential&appid=APPID&secret=APPSECRET
    /**获取accessToken
     * @return bool|mixed
     */
    public function getAccessToken(){
        $access_token = Cache::get("access_token");
        if(!empty($access_token)){
            return $access_token;
        }
        $uri = 'token?grant_type=client_credential&appid='.$this->appId.'&secret='.$this->appSecret;
        $body = $this->httpClient->sendRequestWithGet($uri);
        if(!empty($body)){
            $bodyArr = json_decode($body,true);
            if(isset($bodyArr['errcode'])){
                return false;
            }else{
                Cache::set("access_token",$bodyArr['access_token'],$bodyArr['expires_in']);
                return $bodyArr['access_token'];
            }
        }
        return false;
    }

    /**获取微信服务器列表
     * @return bool
     */
    public function getWechatServerIpList(){
        $ipList = Cache::get('wx_server_ip_list');
        if(!empty($ipList)){
            return $ipList;
        }
        //https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN
        //$accessToken = $this->getAccessToken();
        if(empty($this->accessToken)){
            return false;
        }
        $uri = 'getcallbackip?access_token='.$this->accessToken;
        $body = $this->httpClient->sendRequestWithGet($uri);
        if(!empty($body)){
            $bodyArr = json_decode($body,true);
            if(isset($bodyArr['errcode'])){
                return false;
            }else{
                Cache::set("wx_server_ip_list",$bodyArr['ip_list']);
                return $bodyArr['ip_list'];
            }
        }else{
            return false;
        }
    }
}