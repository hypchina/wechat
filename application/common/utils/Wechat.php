<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 21:17
 */

namespace app\common\utils;


use think\Cache;
use think\Config;

class Wechat extends Base
{

    const MENU_ROOT_ONE = 'menu_root_01';
    const MENU_ROOT_TWO = 'menu_root_02';
    const MENU_ROOT_THREE = 'menu_root_03';


    private  $accessToken;


    public function  __construct(){
        parent::__construct();
        $this->accessToken = $this->getAccessToken();
    }

    /**
     * 创建微信自定义菜单
     * 成功返回true
     */
    public function createCustomMenu($menuOptionArray){
        if(empty($menuOptionArray)){
            return false;
        }
        $uri = 'menu/create?access_token='.$this->accessToken;
//        如果是$postParam['json']方式传输，就要外面加一个数组
//        $menuOption = [
//            $menuOptionArray
//        ];
        //body的方式传输
        $menuOption = $menuOptionArray;
        //$postParam['json'] = $menuOption;//json方式会自动把中文UNICODE，所以用body代替，
        //php5.4新增的JSON_UNESCAPED_UNICODE，防止中文JSON_UNESCAPED_UNICODE，如果要用json传递那么就要先把中文urlencode

        $postParam['body'] = json_encode($menuOption,JSON_UNESCAPED_UNICODE);
        $postParam['decode_content'] = false;
        $postParam['headers'] = ['Content-Type'=>'application/json'];//如果是$postParam['json']就不用设置这个header

        $body = $this->httpClient->sendRequestWithPost($uri,$postParam);
        return $this->checkResult($body);
    }


    /**删除自定义菜单（包括全部个性化菜单）
     * @return bool
     */
    public function delCustomMenu(){
        $uri = 'menu/delete?access_token='.$this->accessToken;
        $body = $this->httpClient->sendRequestWithPost($uri);
        return $this->checkResult($body);
    }



}