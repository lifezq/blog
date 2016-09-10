﻿<?php require_once './init.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>登录  - 之晴博客 </title>
    </head>
    <style type="text/css">
    *{margin:0px;border:0px;padding:0px;}
    body{font:12px "宋体";}
    a{color:#000;text-decoration:none;}
    a:hover{color:#F30;text-decoration:underline;}
    input{padding:0px;margin:0px;}
    .txtbox,.verbox{border:1px solid #E79F50;height:20px;line-height:22px;width:120px;}
    .verbox{width:55px;float:left;}
    .verbox_img{float:left;}
    .bfont{font:700 12px "宋体"}
    #login{width:400px;height:100%;overflow:hidden;margin:0px auto;}
    #title{width:400px;height:25px;line-height:25px;color:#F60;font-weight:700;background-color:#FDEBD9;text-align:center;margin:0px auto;}
    #title a{color:#F60;}
    #title a:hover{color:#FF3300;}
    #loginbox{width:185px;height:auto;margin:10px auto;}
    #btnlogin{height:35px;text-align:center;}
    #forget{width:200px;margin:0px auto;height:25px;line-height:25px;text-align:center;}
    #forget span{width:70px;display:inline;margin:0px 5px;}
    .submit{padding:3px;cursor:pointer;}
    .box_3{clear:both;height:25px;line-height:25px;text-align:center}
    .a_1{color:#06F;text-decoration:underline;font-weight:700}
    .login-error{display:none;background-color:#FFEBE8; border: 1px solid #CC0000; margin: 8px auto 0px; padding: 8px 11px; width:190px;border-radius: 4px;}
    #registeriframe{width:100px;height:1px;}
    .submit{width:50px;height:25px;border-radius: 4px;border:1px solid lightpink;color: #FF0000;background: #FDEBD9;}
    .submit:hover{color: #CC0000;background: #D9D9D9;}
    #TB_ajaxContent{
    overflow: hidden;
    }
    </style>
    <body>
        <div id="login">
            <div id="title"><a href="<?php echo BLOG_URL; ?>">之晴博客</a> - 用户登录</div>
            <div style="width:320px;height:auto;margin:0px auto;">
                <form action="<?php echo BLOG_URL; ?>/admin/index.php?action=login&op=floated" method="post" target="registeriframe">
                    <table id="loginbox" border="0" cellpadding="0" cellspacing="0">
                        <tr style="height:30px">
                            <td class="bfont">用户名：</td>
                            <td><input class="txtbox" type="text" name="user" /></td>
                        </tr>
                        <tr style="height:30px">
                            <td class="bfont">密&nbsp;&nbsp;码：</td>
                            <td><input class="txtbox" type="password" name="pw" /></td>
                        </tr>
                        <tr style="height:30px">
                            <td class="bfont">验证码：</td>
                            <td><input class="verbox" type="text" name="imgcode"  size="5" maxlength="5"/> <img  src="<?php echo BLOG_URL; ?>/include/lib/checkcode.php" onclick="this.src=this.src+'?'+Math.random()" class="verbox_img"/></td>
                        </tr>
                        <tr>
                            <td  colspan="2" align="center"><input id="ispersis" type="checkbox" value="1" name="ispersis"/> <label for="ispersis">记住密码</label></td>
                        </tr>
                    </table>
                    <div id="btnlogin"><input type="submit" value="登 录" class="submit"  id="submit" /></div>
                </form>
            </div>
            <div style=" clear:both;"></div>
            <div class="login-error" id="login-error">&nbsp;</div>
            <div style=" clear:both;"></div>
            <div id="forget">
                <span style="float:left;"><a href="#">忘记密码？</a></span>
                <span style="float:right;"><a  href="javascript:void(0)" onclick="register()">没有注册？</a></span>
            </div>
            <div class="box_3">注册会员后,评论留言更方便喔。<a class="a_1" href="javascript:void(0)" onclick="register()">点击注册</a></div>
            <div><iframe  src="" name="registeriframe" id="registeriframe" frameborder="0" height="1"></iframe></div>
        </div>
    </body>
    <script>
    var _submit=document.getElementById('submit');
    _submit.onmouseover=function(){
    this.style.color='#CC0000';
    this.style.background='#D9D9D9';
    }
    _submit.onmouseout=function(){
    this.style.color='#FF0000';
    this.style.background='#FDEBD9';
    }
    function register(){
    $("#TB_window").css({'height':'370px'})
    $("#TB_ajaxContent").css({'height':'370px'})
    $("#TB_ajaxContent").load('<?php echo BLOG_URL; ?>/register.php?height=370;width=400')
    }
    </script>
</html>

<?php echo ob_get_clean();?>