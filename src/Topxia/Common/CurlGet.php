<?php

namespace Topxia\Common;

class CurlGet
{
    public static function get($url)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($c);
        curl_close($c);
        if(!$data){
            return '读取标题失败,请手动填写标题';
        }
        $code = mb_detect_encoding($data);
        if ($code == 'GBK') {
            $data = mb_convert_encoding($data, "UTF-8", "GBK");
        }
        if($code != 'GBK' && $code !='UTF-8'){
            return '读取标题失败,请手动填写标题';
        }
        $postStart = strpos($data,'<title>')+7;
        $postEnd = strpos($data,'</title>');
        $length = $postEnd - $postStart;
        $title = substr($data ,$postStart, $length);
        return $title;
    }
}