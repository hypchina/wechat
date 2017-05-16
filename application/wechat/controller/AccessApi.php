<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 22:03
 */

namespace app\wechat\controller;


use app\common\utils\MaterialManage;
use app\common\utils\Wechat;
use think\Request;

class AccessApi
{
    private $wechat;
    public function __construct()
    {
        $this->wechat = new Wechat();
    }

    public function setCustomeMenu(){
        //自定义菜单
        $menuOptionArray = [
            'button'=>[
                [ 'name'=> '菜单一','type'=>'click','key'=>Wechat::MENU_ROOT_ONE],
                [ 'name'=> '菜单二','type'=>'view','url'=>'http://www.soso.com/'],
                [
                    'name'=> '菜单三',
                    'sub_button'=>[
                        [
                            'name'=>'访问百度',
                            'type'=>'view',
                            'url'=>'https://www.baidu.com'
                        ],
                        [
                            'name'=>'扫码',
                            'type'=>'scancode_push',
                            'key'=>'saoma'
                        ],
                        [
                            "type"=> "pic_sysphoto",
                            "name"=> "系统拍照发图",
                            "key"=> "sysphoto",
                        ]
                    ]
                ]
            ]
        ];


        $iplist = $this->wechat->createCustomMenu($menuOptionArray);
        dump($iplist);
    }

    public function delCustomMenu(){
        $res = $this->wechat->delCustomMenu();
        dump($res);
    }

    public function addTempMaterial(){
        $manage = new MaterialManage();
        $uri = 'http://p1.music.126.net/uftR_cktA4ws-wWHkampzA==/2885118514874262.jpg?param=90y90';
        $res = $manage->addTempMaterial($uri);
        dump($res);
    }

    public function getTempMaterial(){
        $manage = new MaterialManage();
        header('Content-Type: image/jpeg');
        $media_id = 'WOVa77v19tT_NxemUf7ysuZInC_AkJFUInkXr1PHfUk675boVH_2E_pbh4vZIdaC';
        //$res = $manage->getTempMaterial($media_id,'uploads/'.$media_id.'.jpg');
        $res = $manage->getTempMaterial($media_id);die;
    }

    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('media');
        $r = Request::instance();

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move('uploads');
        if($info){
            dump($_FILES);
            dump($r->get());
            dump($r->post());
            dump($r->getInput());
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

    public function sendUpload(){
        $uri = "http://119.23.235.82/WeChat/AccessApi/upload";
        $resouse = fopen('http://p1.music.126.net/uftR_cktA4ws-wWHkampzA==/2885118514874262.jpg?param=90y90','r');

        $options = [
            'multipart' => [
                [
                    'name'=>'media',
                    'filename'=>'simeifei.jpg',
                    'contents'=>$resouse
                ]
            ]
        ];
//        dump($options);die;
        $pc = new \GuzzleHttp\Client(['timeout'=> 30.0,'verify'=>false]);
        $body = $pc->request('POST',$uri,$options);
        echo $body->getBody()->getContents();
    }

    public function testUp(){
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=R5hbqQx2uYx7KsQCH62IVLJaFOiGf93SXczeFwyKlMNExck-7K9UjhfqJ8i14iMQ24HDD2jvWzWZcfnsFCzZyS3cCtOhTPZN4QBdcnrhvT8jsv83jvVy2lsb0KXNZurnFFEdADATTS&type=image";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($ch , CURLOPT_URL , $url);
         curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch , CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
         curl_setopt($ch , CURLOPT_POSTFIELDS, 'http://p1.music.126.net/uftR_cktA4ws-wWHkampzA==/2885118514874262.jpg?param=90y90');
         $output = curl_exec($ch);
         if(!$output){
             dump(curl_error($ch));
         }
         curl_close($ch);
         dump($output);
    }
}