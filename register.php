<?php require_once './init.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>注册  - 之晴博客 </title>
    </head>
    <style type="text/css">
    *{margin:0px;border:0px;padding:0px;}
    body{font:12px "宋体";}
    a{color:#000;text-decoration:none;}
    a:hover{color:#F30;text-decoration:underline;}
    input{padding:0px;margin:0px;}
    .txtbox,.verbox{border:1px solid #E79F50;height:20px;line-height:22px;width:120px;}
    .verbox{width:55px;}
    .bfont{font:700 12px "宋体";}
    #login{width:400px;height:100%;overflow:hidden;margin:0px auto;}
    #title{width:400px;height:25px;line-height:25px;color:#F60;padding-left:40px;font-weight:700;background-color:#FDEBD9;text-align:left;margin:0px auto;}
    #title a{color:#F60;}
    #title a:hover{color:#FF3300;}
    #loginbox{width:390px;height:auto;margin:10px 20px;float:left;display:inline;}
    #btnlogin{width:55px;height:60px;float:right;margin:10px 30px 10px 5px;}
    #forget{width:200px;margin:0px auto;height:25px;line-height:25px;text-align:center;}
    #forget span{width:80px;display:inline;margin:0px 10px;}
    .submit{padding:3px;cursor:pointer;}
    .notice{display:inline-block;width:170px;color:#D11E51;text-align: left;}
    #agree_notice{width:158px;}
    .registered{color:#aaa;margin-left:50px;}
    #registeriframe{width:100px;height:1px;}
    .submit{width:50px;height:25px;margin-top:10px;border-radius: 4px;border:1px solid lightpink;color: #FF0000;background: #FDEBD9;}
    .submit:hover{color: #CC0000;background: #D9D9D9;}
    .clear_box{position: relative;display: inline-block;}
    .clear_email{width:15px;height:15px;background: #fff;font-size:12px;line-height: 15px;position:absolute;left:107px;top:2px;+margin-top:3px;z-index: 100;text-decoration: none;display: none;}
    a.clear_email:hover{text-decoration: none;}
    .autoDiv
    {
    visibility: hidden;
    position: absolute;
    +left:1px;
    +top:20px;
    width: 120px;
    height: 150px;
    _height:130px;
    +height: 150px!important;
    border:1px solid #aaa;
    border-radius: 2px;
    background-color: White;
    text-align:left;
    }
    .autoDiv div{cursor: default;}
    #TB_ajaxContent{
    overflow: hidden;
    }
    </style>
    <script type="text/javascript" src="<?php echo BLOG_URL; ?>/content/templates/mi2/js/jquery.min.js"></script>
    <body>
        <div id="login">
            <div id="title"><a href="<?php echo BLOG_URL; ?>">之晴博客</a> - 用户注册  <span class="registered">已经注册,现在就去<a href="javascript:void(0)" onClick="login()"><strong>登录</strong></a>吧。</span></div>
            <div style="width:400px;height:auto;overflow: hidden;margin:0px auto;text-align: center;" id="register_box">
                <form action="<?php echo BLOG_URL; ?>/admin/user_register.php?action=register" method="post" target="registeriframe">
                    <table id="loginbox" border="0" cellpadding="0" cellspacing="0">
                        <tr style="height:30px">
                            <td class="bfont" align="right">用户名：</td>
                            <td><input class="txtbox" type="text" name="login" onblur="checkReg(1,this.value)"/> <font color="#f00">*</font></td>
                            <td width="190"><span id="login_notice" class="notice">&nbsp;</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td class="bfont" align="right">密&nbsp;&nbsp;码：</td>
                            <td><input class="txtbox" type="password" name="password"  onblur="checkReg(4,this.value)" id="password"/> <font color="#f00">*</font></td>
                            <td><span id="password_notice" class="notice">&nbsp;</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td class="bfont" align="right">确认密码：</td>
                            <td><input class="txtbox" type="password" name="password2"  onblur="checkReg(5,this.value+'-'+document.getElementById('password').value)"/> <font color="#f00">*</font></td>
                            <td><span id="password2_notice" class="notice">&nbsp;</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td class="bfont" align="right">邮&nbsp;&nbsp;箱：</td>
                            <td><div class="clear_box"><input class="txtbox" type="text" name="email"  onblur="checkReg(2,this.value)" id="email"/><a class="clear_email" href="javascript:;" node-type="clear" id="clear_email" title="email">×</a> <font color="#f00">*</font><div id="auto-show"></div>  </div></td>
                            <td><span id="email_notice" class="notice">&nbsp;请认真填写一个常用的邮箱，并用于帐号激活</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td class="bfont" align="right">验证码：</td>
                            <td><input class="verbox" type="text" name="verifycode" size="5" maxlength="5" onblur="checkReg(3,this.value)"/> <img align="absmiddle" src="<?php echo BLOG_URL; ?>/include/lib/checkcode.php" onclick="this.src=this.src+'?'+Math.random()"></td>
                            <td><span id="verify_notice" class="notice">&nbsp;</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td align="left" colspan="3"><input type="hidden" value="writer" name="role"/> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox" name="agree" value="1"/> 我已同意《<a href="javascript:void(0);" onClick="window.open('<?php echo BLOG_URL; ?>/treaty.html', 'treaty', 'width=470,height=550')">之晴使用协议</a>》 <span id="agree_notice" class="notice">&nbsp;</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td align="center" colspan="3"><input type="hidden" id="isSubmitOk" name="isSubmitOk" value="1"/> <input  type="submit" value="注 册" class="submit" id="submit" onClick="if(document.getElementById('isSubmitOk').value=='-1'){ return false; }"/> </td>
                        </tr>
                    </table>
                </form>
                <div id="btnlogin">
                </div>
            </div>
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

    function _jswrite(obj,str){ if(obj.innerHTML){ obj.innerHTML=str;}else{obj.innerTEXT=str;}}
    var xmlHttp;
    var type=0;
    function createXMLHttpRequest () {
    //Mozilla
    if ( window.XMLHttpRequest ) {
    xmlHttp = new XMLHttpRequest ();
    if ( xmlHttp.overrideMimeType ) {
    xmlHttp.overrideMimeType("text/xml");
    }
    }  //以下是 IE
    else if ( window.ActiveXObject ) {
    try {
    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
    try {
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) { }
    }}}


    function startRequest (url) {
    createXMLHttpRequest ();
    //触发 onreadystatechange 时调用“handleStateChange();”
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open ( "GET", url, true );
    xmlHttp.send ( null );
    }
    function handleStateChange() {
    if ( xmlHttp.readyState == 4 ) {
    // alert("xmlHttp.status="+xmlHttp.status);
    if ( xmlHttp.status == 200 ) {
    var msg=xmlHttp.responseText;
    document.getElementById("isSubmitOk").value='1';
    if(msg<0){
    document.getElementById("isSubmitOk").value='-1';
    if(msg=='-1'){
    _jswrite(document.getElementById("login_notice"),'用户名已经注册');
    }else if(msg=='-2'){
    _jswrite(document.getElementById("email_notice"),'邮箱格式不正确');
    }else if(msg=='-3'){
    _jswrite(document.getElementById("verify_notice"),'验证码不正确');
    }else if(msg=='-4'){
    _jswrite(document.getElementById("login_notice"),'用户名至少为两个字符');
    }else if(msg=='-5'){
    _jswrite(document.getElementById("password_notice"),'密码至少为6个字符');
    }else if(msg=='-6'){
    _jswrite(document.getElementById("password2_notice"),'密码至少为6个字符');
    }else if(msg=='-7'){
    _jswrite(document.getElementById("password2_notice"),'再次密码不一致');
    }else if(msg=='-8'){
    _jswrite(document.getElementById("email_notice"),'邮箱已经存在');
    }
    }
    else{
    switch(type){
    case 1:
    _jswrite(document.getElementById("login_notice"),'&nbsp;');
    break;
    case 2:
    _jswrite(document.getElementById("email_notice"),'&nbsp;');
    break;
    case 3:
    _jswrite(document.getElementById("verify_notice"),'&nbsp;');
    break;
    case 4:
    _jswrite(document.getElementById("password_notice"),'&nbsp;');
    break;
    case 5:
    _jswrite(document.getElementById("password2_notice"),'&nbsp;');
    break;
    }
    }
    } else {
    //alert("获取资料出错!");
    }
    }}
    function checkReg(types,val){
    type=types;
    var url='<?php echo BLOG_URL; ?>/admin/user_register.php?action=register&op=check&type='+types+'&data='+val
    startRequest(url)
    }
    function login(){
    $("#TB_window").css({'height':'370px'})
    $("#TB_ajaxContent").css({'height':'370px'})
    $("#TB_ajaxContent").load('<?php echo BLOG_URL; ?>/login.php?height=370;width=400')
    }
    </script>
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
    //    mailAddressList.style.left = x + 'px';
    //    mailAddressList.style.top = y + h + 'px';
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
    $('#clear_email').attr('title',addr);
    if(emailInput.val() != ''){
    $('#clear_email').show();
    }else{
    $('#clear_email').hide();
    }
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
    $('#auto-show').css('width',now_W+8+'px');
    }else{
    $('#auto-show').css('width','120px');
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
    $('#clear_email').click(function(){
    $("#email").val('');
    $('#clear_email').hide();
    $('#clear_email').attr('title','email');
    })
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
    $('#clear_email').attr('title',currentVal);
    }
    $('#clear_email').show();
    }
    //如果按下退格键或删除键
    if (keyCode == 8 || keyCode == 46) {
    emailInput.val("");
    $('#clear_email').hide();
    $('#clear_email').attr('title','email');
    autoWidthDiv(false);
    for (var i = 1; i <= counts; i++) {
    $("div #" + i).text("").text(emailList[i - 1]);
    }
    }
    });
    });
    </script>
</html>
<?php echo ob_get_clean();?>