<?php
include_once("QQLogin/comm/session.php");
function get_curl_contents($url, $second = 30)
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


//载入读取存入用户数据
define('EMLOG_ROOT', dirname(__FILE__));

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/include/lib/function.base.php';

  //Step2：通过Authorization Code获取Access Token
  if($_REQUEST['state'] == $_SESSION['state']) 
  {
     //拼接URL   
     $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
     . "client_id=" . $_SESSION["appid"] . "&redirect_uri=" . urlencode($_SESSION["callback"])
     . "&client_secret=" . $_SESSION["appkey"] . "&code=" . $_REQUEST["code"];
   
     $response = get_curl_contents($token_url);

     if (strpos($response, "callback") !== false)
     {
        $lpos = strpos($response, "(");
        $rpos = strrpos($response, ")");
        $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        $msg = json_decode($response);
        
        if (isset($msg->error))
        {
            emMsg($msg->error_description, WEB_ROOT,1);
        }
     }


     //Step3：使用Access Token来获取用户的OpenID
     $params = array();
     parse_str($response, $params);
     
     $_SESSION["access_token"] = $params["access_token"];
     $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$params['access_token'];
     
     $str  = get_curl_contents($graph_url);
 
     if (strpos($str, "callback") !== false)
     {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
     }
     $user = json_decode($str);
     
     if (isset($user->error))
     {
         emMsg($user->error_description, WEB_ROOT,1);
     }
     setcookie('ZQ_BIND_OPENID',$user->openid,time()+3600*12,'/',WEB_COOKIE_DOMAIN);
     
     $_SESSION["openid"] = $user->openid;
  }
  else 
  {
      emMsg("The state does not match. You may be a victim of CSRF.", WEB_ROOT,1);
  }

function get_user_info() {
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION["access_token"]
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_curl_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}
$User_Model=new User_Model();
$username=$User_Model->zqAppLogin($_SESSION["openid"],'qq');

    if($username){
        //如果QQ登录给一QQ登录标识，后面好做QQ同步处理
        $_SESSION['zq_qqlogin']=1;
        //设置cookie
        LoginAuth::setAuthCookie($username, 1);
    }else{
        $userinfo=  get_user_info();
        setcookie('qq-username',addslashes(trim($userinfo['nickname'])),time()+3600*24*30,'/', WEB_COOKIE_DOMAIN);  
    }

 emMsg('登录成功，正在为您跳转...', WEB_ROOT,1,1);
//setcookie('qq-avatar',addslashes(trim($userinfo['figureurl_qq_2'])));

//$userinfo['nickname']= iconv('utf-8','gb2312',$userinfo['nickname']);
//$userinfo['gender']= iconv('utf-8','gb2312',$userinfo['gender']);
/*
$User_Model=new User_Model();

$newUser = $User_Model->qqLogin(addslashes(trim($userinfo['nickname'])),addslashes(trim($userinfo['figureurl_qq_2'])));
if($newUser){
  $CACHE = Cache::getInstance();
  $CACHE->updateCache(array('sta','user'));  
}

*/

//echo "<script>window.top.location.href='http://blog.lifezq.com';</script>";
/*
 *
allow_url_fopen: 1
appid : 100465609
4636c7104c62959c01996dd298dace6a----4636c7104c62959c01996dd298dace6a
token_url :https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=100465609&redirect_uri=http%3A%2F%2Fblog.lifezq.com%2Fget_access_token.php&client_secret=bfaa74cc1d1e5a80fe8f03a178278a11&code=EFBDE90B4C9138207054948DFCB97C03
access_token=1B2ECD8793A23921FF6DB2D7C44B51F4&expires_in=7776000&refresh_token=67E42E9B4FA35C489361618483416404
string(111) "access_token=1B2ECD8793A23921FF6DB2D7C44B51F4&expires_in=7776000&refresh_token=67E42E9B4FA35C489361618483416404"
bool(false)
graph_url: https://graph.qq.com/oauth2.0/me?access_token=1B2ECD8793A23921FF6DB2D7C44B51F4
callback( {"client_id":"100465609","openid":"9627655493159714C9D50EC114C7B830"} );

string(83) "callback( {"client_id":"100465609","openid":"9627655493159714C9D50EC114C7B830"} );
"
Hello 9627655493159714C9D50EC114C7B830
 * array(14) { 
 * ["ret"]=> int(0) 
 * ["msg"]=> string(0) "" 
 * ["nickname"]=> string(18) "涔嬫櫞锛屽徎婀俱€�" 
 * ["gender"]=> string(3) "鐢�" 
 * ["figureurl"]=> string(73) "http://qzapp.qlogo.cn/qzapp/100465609/9627655493159714C9D50EC114C7B830/30" 
 * ["figureurl_1"]=> string(73) "http://qzapp.qlogo.cn/qzapp/100465609/9627655493159714C9D50EC114C7B830/50" 
 * ["figureurl_2"]=> string(74) "http://qzapp.qlogo.cn/qzapp/100465609/9627655493159714C9D50EC114C7B830/100" 
 * ["figureurl_qq_1"]=> string(69) "http://q.qlogo.cn/qqapp/100465609/9627655493159714C9D50EC114C7B830/40" 
 * ["figureurl_qq_2"]=> string(70) "http://q.qlogo.cn/qqapp/100465609/9627655493159714C9D50EC114C7B830/100" 
 * ["is_yellow_vip"]=> string(1) "1" 
 * ["vip"]=> string(1) "1" 
 * ["yellow_vip_level"]=> string(1) "7" 
 * ["level"]=> string(1) "7" 
 * ["is_yellow_year_vip"]=> string(1) "1" 
 * }
 */
?>