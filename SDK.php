<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/10/18
 * Time: 14:58
 */
abstract class SDK
{

    protected $APPID = '1254379720';
    //API鉴权key
    protected $API_KEY = '94521339e64a053b8261e17cb6d89372';
    //推流防盗链key
    protected $PUSH_KEY = 'c9d8744b8636523b3a52dcfdac1bf068';
    //腾讯云分配bizid
    protected $BIZID = '11512';
    //接口url
    protected $url;
    //接口
    protected $interface;

    protected $time;

    /**
     * 获取签名
     * @return string
     */
    protected function getSign()
    {
        $this->time = time();
        return md5($this->API_KEY. $this->time);
    }

    protected function request()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}