<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 22:04
 */

namespace app\wechat\controller;


use app\common\utils\Wechat;
use GuzzleHttp\Client;
use think\Cache;
use think\Config;
use think\Loader;
use think\Log;

class PubApi
{
        public function getAccessToken(){
            $wechat = new Wechat();
            $accessToken = $wechat->getAccessToken();
        }

        public function getWxServerListIp(){
            $wechat = new Wechat();
            $iplist = $wechat->getWechatServerIpList();
            dump($iplist);
        }

    public function paramXml(){
        Loader::import('wechatsdk.xmlparse',EXTEND_PATH);
        $pc = new \XMLParse();//(Config::get("wechat.app_token"), '', Config::get("wechat.app_id"));

        $data = "<xml><ToUserName><![CDATA[gh_9695604e127a]]><\/ToUserName>\n<FromUserName><![CDATA[oPvJ4wgugxZzKcKcnn5qKWEwwtE0]]><\/FromUserName>\n<CreateTime>1494579650<\/CreateTime>\n<MsgType><![CDATA[event]]><\/MsgType>\n<Event><![CDATA[subscribe]]><\/Event>\n<EventKey><![CDATA[]]><\/EventKey>\n<\/xml>";
        $result = $pc->extract($data);
        dump($result);
    }
}