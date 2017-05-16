<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 19:15
 */

namespace app\common\utils;


class MenuEvent
{
    /**
     * 一级根菜单
     */
    public function menu_root_one($responseData){
        $xml_format = NoticeFormat::getMusicFormat();

        $toUserName = $responseData['FromUserName'];//$responseData['FromUserName']-》发送方帐号（一个OpenID）
        $formUserName = $responseData['ToUserName'];//$responseData['ToUserName']-》开发者微信号
        $ctime = time();//创建时间
        $msgType = 'music';//音乐类型
        $Title = 'music';//音乐标题-否
        $Description = 'music';//音乐描述-否
        $MusicURL = 'music';//音乐链接-否
        $HQMusicUrl = 'music';//高质量音乐链接 WIFI环境优先使用该链接播放音乐-否
        $ThumbMediaId = 'music';//缩略图的媒体id，通过素材管理中的接口上传多媒体文件，得到的id
        sprintf($xml_format,$toUserName,$formUserName,$ctime,$msgType,$Title,$Description,$MusicURL,$HQMusicUrl,$ThumbMediaId);
    }
}