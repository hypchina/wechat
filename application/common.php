<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 检测字符串是否为UTF8编码
 * @param  string  $str 被检测的字符串
 * @return boolean
 */
function is_utf8($str){
    $len = strlen($str);
    for($i = 0; $i < $len; $i++){
        $c = ord($str[$i]);
        if ($c > 128) {
            if (($c > 247)) return false;
            elseif ($c > 239) $bytes = 4;
            elseif ($c > 223) $bytes = 3;
            elseif ($c > 191) $bytes = 2;
            else return false;
            if (($i + $bytes) > $len) return false;
            while ($bytes > 1) {
                $i++;
                $b = ord($str[$i]);
                if ($b < 128 || $b > 191) return false;
                $bytes--;
            }
        }
    }
    return true;
}


function checkBOM ($filename,$auto=0) {
    $contents=file_get_contents($filename);
    $charset[1]=substr($contents, 0, 1);
    $charset[2]=substr($contents, 1, 1);
    $charset[3]=substr($contents, 2, 1);
    if (ord($charset[1])==239 && ord($charset[2])==187 && ord($charset[3])==191) {
        if ($auto==1) {
            $rest=substr($contents, 3);
            rewrite ($filename, $rest);
            //return ("<font color=red>BOM found, automatically removed.</font>");
            return true;
        } else {
            //return ("<font color=red>BOM found.</font>");
            return true;
        }
    }
    //else return ("BOM Not Found.");
    else return false;
}

function rewrite ($filename, $data) {


    $filenum= fopen($filename, "w");


    flock($filenum, LOCK_EX);


    fwrite($filenum, $data);


    fclose($filenum);


}