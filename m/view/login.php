<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
$error='';
 if(isset($_GET['error'])){
     switch($_GET['error']){
         case false:
            $error='用户名或密码不能为空!' ;
             break;
         case '-3':
             $error='验证码不正确!' ;
             break;
         case '-1':
             $error='您帐户还没有激活，请先激活后再登录!' ;
             break;
         case '-2':
             $error='密码不正确!' ;
             break;
     }
 }
?>

<div id="m">
	<form method="post" action="./index.php?action=auth">
		用户名<br />
	    <input type="text" name="user" /><br />
	    密码<br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value=" 登 录" />
	</form>
    <div style="background-color: #FFEBE8;border: 1px solid #CC0000;border-radius: 4px 4px 4px 4px;margin: 8px auto 0;padding: 8px 11px;width: 90%;<?php if(empty($error)){echo 'display:none;';}?>"><?php echo $error; ?></div>
</div>