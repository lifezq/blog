<?php

/**
 * @filename zq_invite_setting.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-6-26  9:54:55
 * @version 1.0
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
function plugin_setting_view() {
    global $user_cache;
    $avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    $User_Model=new User_Model();
    $email=$User_Model->getUserEmail();
    ?>
    <script>
        $("#zq_invite").addClass('sidebarsubmenu1');
        function zq_user(type){
            var _email=document.getElementById('email');
            if(type){
                    _email.value='<?php echo $email; ?>';
            }else{
                    _email.value='lifezq@foxmail.com';
            }
        }
    </script>
    <style type="text/css" mce_bogus="1">     
        #sinat_form input{
            width: 150px;
            border:1px solid #aaa;
            border-radius: 2px;  
        }
        #sinat_form ._input_user input{
            width:15px;
            border:none;
        }
        .autoDiv
        {
            visibility: hidden;
            position: absolute;
            width: 150px;
            height: 200px;
            border:1px solid #aaa;
            border-radius: 2px;
            background-color: White;
      
        }
        ._input{margin:5px 0;}
    </style>
    <div class=containertitle> <b>激活邮件发送</b>
        <?php if (isset($_GET['setting'])): ?><span class="actived">邮件已经成功发送到</span><?php endif; ?>
        <?php if (isset($_GET['error'])): ?><span class="error">您发送到的邮件发送失败，请稍候再试...</span><?php endif; ?>
    </div>
    <div class=line></div>
    <div class="des">激活邮件发送，可以测试邮件是否能及时并正确的发送的用户
        <br /></div>
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
            <div id="sinat_form">
                    <div class="_input_user">是否读取博客用户： <input type="radio" value="1"  name="zq_user" onClick="zq_user(1)">是  <input type="radio" value="0" onClick="zq_user(0)" name="zq_user" checked="checked">否 </div>
                <form action="plugin.php?plugin=zq_invite&action=setting" method="post">
                    <div class="_input">收件人：<input id="email" name="email" type="text" autocomplete="off" value="lifezq@foxmail.com"/>
    <div id="auto-show">
    </div>
                    </div>
                    <div class="_input">主 题： <input type="text" name="subject" value="你好，很高兴认识你 - 之晴博客 - php建站知识分享"/></div>
                    请输入邮件内容:    
                    <div class="msg">你还可以输入140字</div>
                    <div class="box_1"><textarea class="box" name="zq_email">你好，很高兴认识你,很高兴认识你。</textarea></div>
                    <div class="tbutton"><input type="submit" value="发 送" onclick="return checkt();"/> </div>
                </form>

            </div>
        </div>
    </div>
    <?php
}

function plugin_setting() {
 
    //发送邮件函数
function sendmail_t($toemail, $subject, $message, $from='',$webTitle='',$webUrl='') {

        $date=date('Y-m-d H:i',time());
        
$message=<<<str
        <table cellspacing="0" cellpadding="20">
	<tr><td>
	<table width="500" cellspacing="0" cellpadding="1">
		<tr><td bgcolor="#DFDFDF" align="left" style="font-family:'lucida grande',tahoma,'bitstream vera sans',helvetica,sans-serif;line-height:150%;color:#FFF;font-size:24px;font-weight:bold;padding:4px">&nbsp; $webTitle </th></tr>
		<tr><td bgcolor="#DFDFDF">
			<table width="100%" cellspacing="0" bgcolor="#FFFFFF" cellpadding="20">
				<tr><td style="font-family:'lucida grande',tahoma,'bitstream vera sans',helvetica,sans-serif;line-height:150%;color:#000;font-size:14px;">
					亲爱的朋友：
					<blockquote>$message<br></blockquote>
					<br>
					<br>
					<br><span style='float:right;'><a href=$webUrl target="_blank">$webTitle</a></span>
                                        <br><span style='float:right;'><a href=$webUrl target="_blank">$webUrl</a></span>
					<br><span style='float:right;'>$date</span>
					<br>
					<br>此邮件为系统自动发出的邮件，请勿直接回复。
				</td></tr></table>
		</td></tr></table>
	</td></tr>
</table>
str;
                                        
	include_once('../phpmailer/data_mail.php');
	//邮件头的分隔符
	$maildelimiter = $mail['maildelimiter'] == 1 ? "\r\n" : ($mail['maildelimiter'] == 2 ? "\r" : "\n");
	//收件人地址中包含用户名
	$mailusername = isset($mail['mailusername']) ? $mail['mailusername'] : 1;
	//端口
	$mail['port'] = $mail['port'] ? $mail['port'] : 25;
	$mail['mailsend'] = $mail['mailsend'] ? $mail['mailsend'] : 1;
	
	//发信者
	$email_from = empty($from) ? $mail['adminemail'] : $from;
        
	$email_to = $toemail;
	
	$email_subject = '=?utf-8?B?'.base64_encode(preg_replace("/[\r|\n]/", '', $subject)).'?=';
	$email_message = chunk_split(base64_encode(str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message))))));
	
	$headers = "From: $email_from{$maildelimiter}X-Priority: 3{$maildelimiter}X-Mailer: UCENTER_HOME ".X_VER."{$maildelimiter}MIME-Version: 1.0{$maildelimiter}Content-type: text/html; charset=utf-8{$maildelimiter}Content-Transfer-Encoding: base64{$maildelimiter}";
		
	if($mail['mailsend'] == 1) {
		if(function_exists('mail') && @mail($email_to, $email_subject, $email_message, $headers)) {
			return true;
		}
		return false;
		
	} elseif($mail['mailsend'] == 2) {
           
		require_once( "../phpmailer/class.phpmailer.php"); 
		$mail2 	= new PHPMailer();
		$mail2->CharSet 	= "utf-8"; 
		$mail2->FromName = $email_from;
		$address 		= $toemail;
		$mail2->IsSMTP();
		$mail2->Host 	= $mail['server'];
		$mail2->Port 	= $mail['port'];
		$mail2->SMTPAuth = true;
		$mail2->Username = $mail['auth_username'];	
		$mail2->Password = $mail['auth_password'];		
		$mail2->From 	 = $mail['auth_username'];			
		$mail2->AddAddress("$toemail", "");
		$mail2->Subject 	= $email_subject;
		$mail2->MsgHTML($message);
		$mail2->IsHTML(true);
		if($mail2->Send()) {
			return true;
		}
		else{
			return false;
		}

            return false;
	} elseif($mail['mailsend'] == 3) {

		ini_set('SMTP', $mail['server']);
		ini_set('smtp_port', $mail['port']);
		ini_set('sendmail_from', $email_from);
	
		if(function_exists('mail') && @mail($email_to, $email_subject, $email_message, $headers)) {
			return true;
		}
		return false;
	}
       
    
}
    $email=isset($_POST['email'])?htmlspecialchars(addslashes($_POST['email'])):false;
    if(!$email) return false;
    $message=isset($_POST['zq_email'])?htmlspecialchars(addslashes($_POST['zq_email'])):false;
    if(!$message) return false;
    $subject=isset($_POST['subject'])?htmlspecialchars(addslashes($_POST['subject'])):false;
    if(!$subject) return false;
    $final_email=  explode(';', $email);
    foreach($final_email as $v){
        if(empty($v))            continue;
    if(checkMail($v)){
     if(sendmail_t($v,$subject,$message,'','之晴博客 - php建站知识分享',BLOG_URL)){
        return true; 
     }
       
       exit;
    }
    }

}
?>
<script type="text/javascript" src="../content/templates/mi2/js/jquery.min.js"></script>
<script>
    //自动显示
function autoShow() {
    var obj = document.getElementById("email");
    var mailAddressList = document.getElementById("auto-show");
    var x = 0, y = 0, o = obj; h = obj.offsetHeight;
    while (o != null) {
        x += o.offsetLeft;
        y += o.offsetTop;
        o = o.offsetParent;
    }
    mailAddressList.style.left = x + 'px';
    mailAddressList.style.top = y + h + 'px';
    mailAddressList.style.visibility = "visible";
}
//自动隐藏
function autoHide() {
    var mailAddressList = document.getElementById("auto-show");
    mailAddressList.style.visibility = "hidden";
}
//给文本框设置值
function setValue(newIndex, emailInput) {
    var addr = $("div #" + newIndex).text().replace(/^\/s\/s*/, '').replace(/\/s\/s*$/, '');
    emailInput.val("");
    emailInput.val(addr);
}
//鼠标移入设置样式
function setStyle(obj) {
    oldIndex = newIndex;
    newIndex = $(obj).attr("id");
    $(obj).css({"background-color": "#aaa"});
    $("div #" + oldIndex).css("background-color", "white");
    setValue(newIndex, $("#email"));
}
//鼠标移出取消样式
function cancelStyle(obj) {
    $(obj).css("background-color", "white");
}
//按上下键设置样式
function setStyleForChange() {
    //handle newIndex
    newIndex = newIndex > counts ? 1 : newIndex;
    newIndex = newIndex < 1 ? counts : newIndex;
    $("div #" + newIndex).css({"background-color": "#aaa"});
    $("div #" + oldIndex).css("background-color", "white");
}
function autoWidthDiv(val){
    if(val){
       var now_W=$('#auto-show').width();
       $('#auto-show').css('width',now_W+6+'px'); 
    }else{
       $('#auto-show').css('width','150px');  
    }
    
}
//define args
//常用邮件列表数组
var emailList = ["@163.com", "@126.com", "@gmail.com", "@yahoo.com", "@yahoo.com.cn", "@sina.cn", "@qq.com", "@hotmail.com","@sohu.com","@189.cn"];
//新项的索引(用于设置高亮显示的样式)
var newIndex = 0;
//旧项的索引(用于取消原有高亮显示的样式)
var oldIndex = 0;
//邮件列表个数
var counts = emailList.length;

$(document).ready(function () {
            var emailInput = $("#email");
            var emailListDiv = $("#auto-show");
            //bind focus event(获得焦点)
            emailInput.focus(autoShow);
            //bind blur event(失去焦点)
            emailInput.blur(autoHide);
            emailListDiv.addClass("autoDiv");
            //bind the events:mouseover、mouseout for the div
            for (var i = 0; i < emailList.length; i++) {
                $("#auto-show").append("<div id='" + (i + 1).toString() + "' onmouseover='setStyle(this)' onmouseout='cancelStyle(this)' >" + emailList[i] + "</div>");
            }
            //handle key's events.(键盘弹出事件处理)
            emailInput.keyup(function (event) {
                var myEvent = event || window.event;
                var keyCode = myEvent.keyCode; //获得键值
                //press down key(向下键)
                if (keyCode == 40) {
                    oldIndex = newIndex;
                    newIndex++;
                    setStyleForChange();
                    //set value for input
                    setValue(newIndex, emailInput);
                }
                //press up key(向上键)
                if (keyCode == 38) {
                    oldIndex = newIndex;
                    newIndex--;
                    setStyleForChange();
                    //set value for input
                    setValue(newIndex, emailInput);
                }
                //press enter key(回车键)
                if (keyCode == 13) {
                    //set value for input
                    setValue(newIndex, emailInput);
                    //set div hidden
                    autoHide();
                }
                //press esc key(ESC键)
                if (keyCode == 27) {
                    autoHide();
                }
                //press a-z|A-Z|0-9     //8对应退格键，46对应删除键
                var changedText = (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode >= 48 && keyCode <= 56);
                if (changedText) {
                    var currentVal = emailInput.val().replace(/^\/s\/s*/, '').replace(/\/s\/s*$/, '');
                    if(currentVal.length>5){
                        autoWidthDiv(true)
                    }
                    //如果原来已包含有@字符
                    if (currentVal.indexOf("@") > -1) {
                        emailInput.val("");
                        autoWidthDiv(false);//让autodiv宽度复原
                        for (var i = 1; i <= counts; i++) {
                            $("div #" + i).text("").text(emailList[i - 1]);
                        }
                        return;
                    }
                    for (var i = 1; i <= counts; i++) {
                        $("div #" + i).text("").text(currentVal + emailList[i - 1]);
                    }
                }
                //如果按下退格键或删除键
                if (keyCode == 8 || keyCode == 46) {
                    emailInput.val("");
                    autoWidthDiv(false);
                    for (var i = 1; i <= counts; i++) {
                        $("div #" + i).text("").text(emailList[i - 1]);
                    }
                }
            });
        });
        
        
        
    $(document).ready(function(){
        $(".box").keyup(function(){
            var t=$(this).val();
            var n = 140 - t.length;
            if (n>=0){
                $(".msg").html("你还可以输入"+n+"字");
            }else {
                $(".msg").html("<span style=\"color:#FF0000\">已超出"+Math.abs(n)+"字</span>");
            }
        });
    });
    function checkt(){
        var t=$(".box").val();
        if (t.length > 140){return false;}
    }
    
setTimeout(hideActived,2600);
</script>