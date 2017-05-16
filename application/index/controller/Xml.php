<?php
namespace app\index\controller;
//use think\org\Slog;
use think\Log;
use think\log\driver\Socket;

class Xml{
    public function index(){
        $arr = array(
            "name"=>"hyp",
            "sex"=>"man",
            "age"=>"26",
        );

        $xml = new \think\response\Xml();
        $xml->data($arr)->options(['root_node'=>'apps'])->send();
    }

    public function json(){
        $arr =array(
            array(
                "name"=>"hyp",
                "sex"=>"man",
                "age"=>"26",
            ),
            array(
                "name"=>"zl",
                "sex"=>"man",
                "age"=>"26",
            )
        );
        $json = new \think\response\Json();
        $json->data($arr)->send();
    }

    public function sendMail(){
        //require 'PHPMailerAutoload.php';
        require 'D:\phpStudy\WWW\animate\vendor\autoload.php';
        $mail = new \PHPMailer;


        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '1370248863@qq.com';                 // SMTP username
        $mail->Password = 'dxehusnpqbgagidg';                           // SMTP password
        $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('1370248863@qq.com', 'Mailer');
        $mail->addAddress('442515883@qq.com', 'qianbei');     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Here is the subject';//标题
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';//内容
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    public function sendSlog(){
        //trace('日志信息','info');
        Log::write('测试日志信息，这是警告级别，并且实时写入','notice');
    }
}