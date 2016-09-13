function focusEle(ele){
	try {document.getElementById(ele).focus();}
	catch(e){}
}
function updateEle(ele,content){
	document.getElementById(ele).innerHTML = content;
}
function timestamp(){
	return new Date().getTime();
}
var XMLHttp = {  
	_objPool: [],
	_getInstance: function () {
		for (var i = 0; i < this._objPool.length; i ++) {
			if (this._objPool[i].readyState == 0 || this._objPool[i].readyState == 4) {
				return this._objPool[i];
			}
		}
		this._objPool[this._objPool.length] = this._createObj();
		return this._objPool[this._objPool.length - 1];
	},
	_createObj: function(){
		if (window.XMLHttpRequest){
			var objXMLHttp = new XMLHttpRequest();
		} else {
			var MSXML = ['MSXML2.XMLHTTP.5.0', 'MSXML2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP', 'Microsoft.XMLHTTP'];
			for(var n = 0; n < MSXML.length; n ++){
				try{
					var objXMLHttp = new ActiveXObject(MSXML[n]);
					break;
				}catch(e){}
			}
		}
		if (objXMLHttp.readyState == null){
			objXMLHttp.readyState = 0;
			objXMLHttp.addEventListener('load',function(){
				objXMLHttp.readyState = 4;
				if (typeof objXMLHttp.onreadystatechange == "function") {  
					objXMLHttp.onreadystatechange();
				}
			}, false);
		}
		return objXMLHttp;
	},
	sendReq: function(method, url, data, callback){
		var objXMLHttp = this._getInstance();
		with(objXMLHttp){
			try {
				if (url.indexOf("?") > 0) {
					url += "&randnum=" + Math.random();
				} else {
					url += "?randnum=" + Math.random();
				}
				open(method, url, true);
				setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				send(data);
				onreadystatechange = function () {  
					if (objXMLHttp.readyState == 4 && (objXMLHttp.status == 200 || objXMLHttp.status == 304)) {  
						callback(objXMLHttp);
					}
				}
			} catch(e) {
				alert('emria:error');
			}
		}
	}
};
function sendinfo(url,node){
	updateEle(node,"<div><span style=\"background-color:#FFFFE5; color:#666666;\">加载中...</span></div>");
	XMLHttp.sendReq('GET',url,'',function(obj){updateEle(node,obj.responseText);});
}
function loadr(url,tid){
	url = url+"&stamp="+timestamp();
	var r=document.getElementById("r_"+tid);
	var rp=document.getElementById("rp_"+tid);
	if (r.style.display=="block"){
		r.style.display="none";
		rp.style.display="none";
	} else {
		r.style.display="block";
		r.innerHTML = '<span style=\"background-color:#FFFFE5;text-align:center;font-size:12px;color:#666666;\">加载中...</span>';
		XMLHttp.sendReq('GET',url,'',function(obj){r.innerHTML = obj.responseText;rp.style.display="block";});
	}
}
function reply(url,tid){
	var rtext=document.getElementById("rtext_"+tid).value;
	var rname=document.getElementById("rname_"+tid).value;
	var rcode=document.getElementById("rcode_"+tid).value;
	var rmsg=document.getElementById("rmsg_"+tid);
	var rn=document.getElementById("rn_"+tid);
	var r=document.getElementById("r_"+tid);
	var data = "r="+rtext+"&rname="+rname+"&rcode="+rcode+"&tid="+tid;
	XMLHttp.sendReq('POST',url,data,function(obj){
		if(obj.responseText == 'err1'){rmsg.innerHTML = '(回复长度需在140个字内)';
		}else if(obj.responseText == 'err2'){rmsg.innerHTML = '(昵称不能为空)';
		}else if(obj.responseText == 'err3'){rmsg.innerHTML = '(验证码错误)';
		}else if(obj.responseText == 'err4'){rmsg.innerHTML = '(不允许使用该昵称)';
		}else if(obj.responseText == 'err5'){rmsg.innerHTML = '(已存在该回复)';
		}else if(obj.responseText == 'err0'){rmsg.innerHTML = '(禁止回复)';
		}else if(obj.responseText == 'succ1'){rmsg.innerHTML = '(回复成功，等待管理员审核)';
		}else{r.innerHTML += obj.responseText;rn.innerHTML = Number(rn.innerHTML)+1;rmsg.innerHTML=''}});
}
function re(tid, rp){
	var rtext=document.getElementById("rtext_"+tid).value = rp;
	focusEle("rtext_"+tid);
}
function commentReply(pid,c){
	var response = document.getElementById('comment-post');
	document.getElementById('comment-pid').value = pid;
	document.getElementById('cancel-reply').style.display = '';
	c.parentNode.parentNode.appendChild(response);
        $('#reply_state_box').html('');
        $('#user_comment_result').html('');
}
function cancelReply(){
	var commentPlace = document.getElementById('comment-place'),response = document.getElementById('comment-post');
	document.getElementById('comment-pid').value = 0;
	document.getElementById('cancel-reply').style.display = 'none';
	commentPlace.appendChild(response);
}

function AddFavorite(sURL, sTitle) {
try {
window.external.addFavorite(sURL, sTitle);
}
catch (e) {
try {
window.sidebar.addPanel(sTitle, sURL, "");
}
catch (e) {
alert("加入收藏失败，请使用Ctrl+D进行添加");
}
}
}
function SetHome(obj, vrl) {
try {
obj.style.behavior = 'url(#default#homepage)'; obj.setHomePage(vrl);
}
catch (e) {
if (window.netscape) {
try {
netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
}
catch (e) {
alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
}
var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
prefs.setCharPref('browser.startup.homepage', vrl);
}
}
}
function commentSubmit(){
    $('#submit').val('提交中...');
    var comname = $('#comname').val();
    var commail = $('#commail').val();
    var comurl = $('#comurl').val();
    var comment = $('#comment').val();
    var comgid = $('#comgid').val();
    var compid = $('#comment-pid').val();
    $.ajax({
        type:'post',
        url:'https://blog.lifezq.com/index.php?action=addcom',
        data:{'comname':comname,'commail':commail,'comurl':comurl,'comment':comment,'gid':comgid,'pid':compid},
        success:function (msg){
            var preg=/<a\s+href=.*<\/a>/;
             msg=msg.replace(/class="main"/,'class="user_comment_result"')
             msg=msg.replace(preg,'')
             if(compid){
                 $('#reply_state_box').html(msg)
             }else{
                 $('#user_comment_result').html(msg);
             }
             $('#submit').val('发表评论');
            return false;
        }
    });
    return false;
}

//邮件自动补全代码
    //自动显示
function autoShow() {
    var obj = document.getElementById("commail");
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
    setValue(newIndex, $("#commail"));
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
       $('#auto-show').css('width',now_W+5+'px'); 
    }else{
       $('#auto-show').css('width','166px');  
    }
    
}