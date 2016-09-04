<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.2
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

/**
 * @brief 本文件包含了OAuth认证过程中会用到的公用方法 
 */

require_once("config.php");

function do_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}
/*
function get_url_contents($url)
{
    if (ini_get("allow_url_fopen") == "1")
        return file_get_contents($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result =  curl_exec($ch);
    curl_close($ch);

    return $result;
}
 * 
 */
function get_url_contents($url, $second = 30)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_TIMEOUT,$second);//设置cURL允许执行的最长秒数
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);//当此项为true时,curl_exec($ch)返回的是内容;为false时,curl_exec($ch)返回的是true/false
    
    //以下两项设置为FALSE时,$url可以为"https://login.yahoo.com"协议
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  FALSE);

    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}
?>
