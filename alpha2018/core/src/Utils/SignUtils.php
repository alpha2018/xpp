<?php namespace AlphaUtils;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/5/4
 * Time: 下午4:47
 */
class SignUtils
{
    public static function generateNonceStr()
    {
        $nonceStr = '';

        return $nonceStr;
    }

    public static function generateWeChatSign($arr, $key)
    {
        ksort($arr);
        $httpQueryStr = http_build_query($arr);
        $httpQueryStr = $httpQueryStr.'$key='.$key;
        $sign = strtoupper(md5($httpQueryStr));

        return $sign;
    }

    public function generateAlipaySign($arr)
    {

    }
}