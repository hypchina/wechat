<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 19:49
 */

namespace app\common\utils;



/**素材管理
 * Class MaterialManage
 * @package app\common\utils
 */
class MaterialManage extends Base
{
    private $accessToken;

    public function __construct()
    {
        parent::__construct();
        $this->accessToken = $this->getAccessToken();
    }

    /**添加临时素材
     * @param $fileUri：文件资源；可以使 url路径|文件路径
     * @return bool
     */
    public function addTempMaterial($fileUri){
        if(empty($fileUri)){
            return false;
        }
        $uri = "media/upload?access_token={$this->accessToken}&type=thumb";
        $resource = file_get_contents($fileUri,'r');
        if(empty($resource)){
            return false;
        }
        //要日天，微信这个上传不支持fopen资源对象，渣渣 搞了半天
        $options = [
            'multipart' => [
                [
                    'name'=>'media',
                    'filename'=>'simeifei.jpg',
                    'contents'=>$resource
                ]
            ],
            'debug' => true
        ];
        $body = $this->httpClient->sendRequestWithPost($uri,$options);
        //{"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
        return $this->checkResult($body);
    }

    /**获取临时素材
     * @param $media_id:素材id,在添加的时候返回的
     * @return bool
     */
    public function getTempMaterial($media_id,$outFile=''){
        if(empty($media_id)){
            return false;
        }
        $uri = $this->apiUrl.'media/get?access_token='.$this->accessToken.'&media_id='.$media_id;
        if(!empty($outFile)){
            $this->httpClient->sendRequestWithGet($uri,['sink'=>$outFile]);
        }else{
            $body = $this->httpClient->sendRequestWithGet($uri,['stream' => true],true);
            while (!$body->eof()) {
                echo $body->read(1024);
            }
        }

    }

    protected function checkResult($body){
        $bodyArr = json_decode($body,true);
        if(!empty($bodyArr['errcode'])){
            return false;
        }
        return true;
    }
}