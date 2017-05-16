<?php
namespace app\wechat\controller;

use app\common\utils\Wechat;
use think\Config;
use think\Loader;
use think\Log;
use think\Request;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 16:50
 */
class Callback
{
    private $request;

    /**
     * 微信回调通知接口
     */
    public function notice(){
        $result = $this->verifyRequest();
        if($result){
            $postXml = $this->request->getInput();
            Log::info($postXml,"wechat_notice_post");
            $this->dispatchServlet($postXml);
            echo '';
        }else{
            echo "Fail";
        }
    }

    private function verifyRequest(){
        Loader::import('wechatsdk.sha1',EXTEND_PATH);
        $this->request = Request::instance();
        $param = $this->request->get();
        $signature = $param['signature'];
        $timestamp = $param['timestamp'];
        $nonce = $param['nonce'];
        //$echostr = $param['echostr'];//只有在第一次验证的时候有这个get参数
        $token = Config::get("wechat.app_token");

        $result = \SHA1::checkSignature($token, $timestamp, $nonce,$signature);
        //echo $token;
        Log::info(json_encode($param),"wechat_notice_get");
        return $result;
    }

    /**xml转array
     * @param $data
     * @return mixed
     */
    public function paramXmlToArray($data){
        libxml_disable_entity_loader(true);
        $postObj = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        Log::info(json_encode($postObj),"解析微信的通知");
        return json_decode($postObj,true);
    }

    /**消息分发器
     * @param $postXml
     */
    private function dispatchServlet($postXml){
        $postArr = $this->paramXmlToArray($postXml);

        switch ($postArr['Event']){
            case 'CLICK':{
                    if($postArr['EventKey'] == Wechat::MENU_ROOT_ONE){

                    }
                break;
            }
        }

    }




}