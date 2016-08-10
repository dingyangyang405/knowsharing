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
        $pos = strpos($data,'UTF-8');
        if ($pos === false) {
            $data = iconv("gbk","utf-8",$data);
        }
        $postStart = strpos($data,'<title>')+7;
        $postEnd = strpos($data,'</title>');
        $length = $postEnd - $postStart;
        $title = substr($data ,$postStart, $length);
        return $title;
    }
}