<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 17:03
 */

return [
    'app_id'=>'wx8a0849f241a7c826',
    'app_secret'=>'14f54391458f1b756c390370389f8306',
    'app_token'=>'sdfsdf14f54391458f1b756c390370389f8306',
    'base_url'=>"https://api.weixin.qq.com/cgi-bin/",
    'msg_type'=>['event'],
    'event_type'=>[
        'subscribe',//关注
        'CLICK',//点击菜单
        'VIEW',//点击菜单跳转连接
        'scancode_push',//扫码
        'scancode_waitmsg',//扫码弹提示框
        'pic_sysphoto',//拍照并发图
        'pic_photo_or_album',//弹出拍照或相册发图
        'pic_weixin',//弹出微信相册
        'location_select'//弹出地理位置选择器的事件推送
    ],
];