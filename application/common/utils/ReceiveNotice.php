<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 16:13
 */

namespace app\common\utils;


use think\Request;

/**接收微信的通知
 * Class ReceiveNotice
 * @package app\common\utils
 */
class ReceiveNotice
{
    private $request;
    private $input;
    public function __construct()
    {
        $this->request = Request::instance();
        $this->input = $this->request->getInput();
        Loader::import('wechatsdk.sha1',EXTEND_PATH);
    }

    /**
     * 取消关注
     */
    public function cancelTheAttention(){

    }




}