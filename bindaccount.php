<?php require_once './init.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>绑定帐号  - 之晴博客 </title>
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
    #title{width:400px;height:25px;line-height:25px;color:#F60;font-weight:700;background-color:#FDEBD9;text-align:center;margin:0px auto;}
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
    .submit{width:50px;height:25px;margin-top:10px;border-radius: 4px;border:1px solid lightpink;color: #FF0000;}
    .submit:hover{color: #CC0000;background: #D9D9D9;}
    .clear_box{position: relative;display: inline-block;}
    .clear_email{width:15px;height:15px;background: #fff;font-size:12px;line-height: 15px;position:absolute;left:106px;top:2px;+margin-top:3px;z-index: 100;text-decoration: none;display: none;}
    a.clear_email:hover{text-decoration: none;}
    .bind_select{+margin:10px 5px 0 0;}
    #TB_ajaxContent{
    overflow:hidden;
    }
    .autoDiv
    {
    visibility: hidden;
    position: absolute;
    +left:0px;
    +top:23px;
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
    </style>
    <script type="text/javascript" src="<?php echo BLOG_URL; ?>/content/templates/mi2/js/jquery.min.js"></script>
    <body>
        <div id="login">
            <div id="title"><a href="<?php echo BLOG_URL; ?>">之晴博客</a> - 绑定已有帐号  </div>
            <div style="width:400px;height:210px;overflow: hidden;margin:0px auto;text-align: center;" id="register_box">
                <form action="<?php echo BLOG_URL; ?>/admin/user_register.php?action=register&op=bindAccount" method="post" target="registeriframe">
                    <table id="loginbox" border="0" cellpadding="0" cellspacing="0">
                        <tr style="height:30px">
                            <td class="bfont" align="right"><select name="bindType" onchange="showBind(this.value);" class="bind_select">
                                <option value="1" selected="selected">用户名</option>
                                <option value="2">UID</option>
                                <option value="3">Email</option>
                            </select> &nbsp;</td>
                            <td><div class="clear_box"><input class="txtbox login_bind bind" type="text" name="login" onblur="checkReg(7,this.value)"/> <input class="txtbox email_bind bind" type="text" name="email"  onblur="checkReg(2,this.value)" style="display:none;" id="email"/><a class="clear_email" href="javascript:;" node-type="clear" id="clear_email" title="email">×</a><div id="auto-show"></div> <input class="txtbox uid_bind bind" type="text" name="uid"  onblur="checkReg(6,this.value)" style="display:none;"/></div></td>
                            <td width="190"><span id="login_notice" class="notice login_bind bind">&nbsp;请输入您要绑定的用户名</span><span id="email_notice" class="notice email_bind bind" style="display:none;">&nbsp;请认真填写一个常用的邮箱</span><span id="uid_bind_notice" class="notice uid_bind bind" style="display:none;">&nbsp;如果您知道用户ID，可以填写UID</span></td>
                        </tr>
                        <tr style="height:30px">
                            <td align="center" colspan="3"><input type="hidden" id="isSubmitOk" name="isSubmitOk" value="1"/> <input  type="submit" value="绑 定" class="submit" onClick="if(document.getElementById('isSubmitOk').value=='-1'){ return false; }"/> </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div><iframe  src="" name="registeriframe" id="registeriframe" frameborder="0" height="1"></iframe></div>
        </div>
    </body>
    <script>
    function getClassName(classToSearch) {
    var tagName='*';
    var elementsToReturn = new Array();
    var elementList = document.getElementsByTagName(tagName);
    var nLen = elementList.length;
    var pattern = new RegExp("\\b"+classToSearch+"\\b");
    for(var i = 0; i < nLen; i++){
    if( pattern.test(elementList[i].className) ){
    elementsToReturn[elementsToReturn.length] = elementList[i];
    }
    }
    return elementsToReturn;
    }
    function showBind(val){
    var name=getClassName('bind');
    for(var i=0;i<name.length;i++){
    name[i].style.display='none';
    }
    var _class='';
    if(val == '1'){
    _class='login_bind';
    }else if(val == '2'){
    _class='uid_bind';
    }else if(val == '3'){
    _class='email_bind';
    }
    name=getClassName(_class);
    for(var i=0;i<name.length;i++){
    name[i].style.display='block';
    }
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
    } catch (e) {
    }
    }
    }
    }

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
    }else if(msg=='-9'){
    _jswrite(document.getElementById("uid_bind_notice"),'UID不存在');
    }else if(msg=='-10'){
    _jswrite(document.getElementById("uid_bind_notice"),'请填写正确的UID');
    }else if(msg=='-11'){
    _jswrite(document.getElementById("login_notice"),'用户名至少为两个字符');
    }else if(msg=='-12'){
    _jswrite(document.getElementById("login_notice"),'该用户不存在');
    }else if(msg=='-13'){
    _jswrite(document.getElementById("login_notice"),'该帐户已经被绑定，请选择其它帐户!');
    }else if(msg=='-14'){
    _jswrite(document.getElementById("uid_bind_notice"),'该帐户已经被绑定，请选择其它帐户!');
    }else if(msg=='-15'){
    _jswrite(document.getElementById("email_notice"),'该帐户已经被绑定，请选择其它帐户!');
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
    case 6:
    _jswrite(document.getElementById("uid_bind_notice"),'&nbsp;');
    break;
    case 7:
    _jswrite(document.getElementById("login_notice"),'&nbsp;');
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
    $("#TB_window").css({'height':'280px'})
    $("#TB_ajaxContent").css({'height':'280px'})
    $("#TB_ajaxContent").load('<?php echo BLOG_URL; ?>/login.php?height=160;width=400')
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