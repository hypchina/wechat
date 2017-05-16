<?php
namespace app\index\controller;

use think\Db;
use think\image\Exception;

class Index
{

    public function index()
    {
        dump(1111);
        die("1213");
    }

    public function ttt(){
        echo 'ttt';
    }

    public function test(){
        header('Content-Type:text/html;charset=utf-8');
        $filename = "static/data.txt";
        $newFile = "static/flag.txt";
        if(file_exists($newFile)){
            die("数据已经添加！");
        }

//打开文件
        $fh = fopen($filename,"r");
//一次读取一行
        while(!feof($fh)){
            $goods_name=fgets($fh);
            $goods_price=fgets($fh);
            $goods_image =fgets($fh);
            //下面这两句不看 ，这是我框架自带的插入数据的写法
            $data = ['goods_name'=>$goods_name,'goods_price'=>$goods_price,'goods_image'=>$goods_image];
            $boolean = Db::table('goods')->insert($data);
        }
        fclose($fh);
        //数据插入完成之后 创建一个文件 标记数据已经添加完毕
        file_put_contents($newFile,"数据已经添加完毕！");
        var_dump($boolean);
    }

    /**
     * 从文件中导入sql数据到数据库
     */
    public function sourceSqlFromFile(){
        $sqlFile = 'static/data.sql';
        if(!is_file($sqlFile)){
            die('文件不存在');
        }
        //dump(checkBOM('static/data.sql',1));die;
        //这个checkBOM方法用于解决data.sql文件的bom头格式，
        //影响读取字符串多了3个字节，导致导入数据库失败，暂时可以不用管，
        //由于我框架好像不支持批量执行sql，就写了一个
        if(checkBOM($sqlFile,0)){
            checkBOM($sqlFile,1);
        }
        $sql = file_get_contents($sqlFile);
        if(empty($sql)){
           new Exception("文件存在");
        }else{
            $conn = mysqli_connect("127.0.0.1","root","123456");

            $r = mysqli_multi_query($conn,$sql);
            if(!$r){
                dump(mysqli_error($conn));die;
            }
            mysqli_close($conn);
            dump($r);die;
        }
    }

    /**
     * 所有的Db::都是我框架自带的查询数据库的方式，你可能用不起
     * 之后学了thinkphp就好了，查询数据库替换成自己的就好了
     * 3题
     */
    public function deleteData(){
        $imgPath = 'static/images/';
        $result = Db::table("goods")->field("id,goods_image")->select();
        foreach($result as $val){
            if(!is_file($imgPath.$val['goods_image'])){
                Db::table("goods")->where("id",$val['id'])->delete();
            }
        }
    }

    /**
     * 4题
     */
    public function deleteFile(){
        $imgPath = 'static/images/';
        $fileArray = scandir($imgPath);//获取目录下直接所属的所有文件和文件夹的名称
        array_shift($fileArray);//过滤掉隐藏的本级目录和父级目录
        array_shift($fileArray);
        //获取数据库中的图片名称
        $dbArray = Db::name("goods")->column("goods_image");
        //获取目录中的图片名称与数据库中图片名称的差集，返回目录中存在但是数据库中不存在的图片名称
        $diffArray = array_diff($fileArray,$dbArray);
        foreach($diffArray as $img){
            @unlink($imgPath.$img);//删除这些图片
        }
    }

    public function qrcode(){
        $save = "static/tmp/qrcode.png";
        \PHPQRCode\QRcode::png("https://www.baidu.com",false, 'H', 6, 2);exit();
    }

    public function write(){
        $array = [
            100=>['id'=>1,'name'=>'重庆','pid'=>0],
            200=>['id'=>1,'name'=>'大渡口','pid'=>100],
            300=>['id'=>1,'name'=>'凤阳','pid'=>200],
        ];
        $array = include 'array.php';
        //file_put_contents('array.php',"<?php return ".var_export($array,true).";");
        var_export($array);
    }
}
