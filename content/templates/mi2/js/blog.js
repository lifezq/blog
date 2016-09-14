function AddFavorite(sURL, sTitle) {
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch(e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch(e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

function SetHome(obj, vrl) {
    try {
        obj.style.behavior = 'url(#default#homepage)';
        obj.setHomePage(vrl);
    } catch(e) {
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            } catch(e) {
                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
            }
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage', vrl);
        }
    }
}

function getBrowserWidth() {
    var _clientWidth;
    if (document.documentElement && document.documentElement.clientWidth) {
        _clientWidth = document.documentElement.clientWidth;
    } else if (document.body && document.body.clientWidth) {
        _clientWidth = document.body.clientWidth;
    } else if (document.documentElement && document.documentElement.offsetWidth) {
        _clientWidth = document.documentElement.offsetWidth; //网页可见区域宽,包括边线的宽)
    } else if (document.body && document.body.offsetWidth) {
        _clientWidth = document.body.offsetWidth; //网页可见区域宽,包括边线的宽)
    } else if (window.screen.availWidth) {
        _clientWidth = window.screen.availWidth;
    } else {
        _clientWidth = 1024;
    }
    return _clientWidth;
}

// auth.js
var _submit = document.getElementById('submit');
_submit.onmouseover = function() {
    this.style.color = '#CC0000';
    this.style.background = '#D9D9D9';
}
_submit.onmouseout = function() {
    this.style.color = '#FF0000';
    this.style.background = '#FDEBD9';
}

function login() {
    $("#TB_window").css({
        'height': '370px'
    });
    $("#TB_ajaxContent").css({
        'height': '370px'
    });
    $("#TB_ajaxContent").load('/login.php?height=370;width=400');
}

function register() {
    $("#TB_window").css({
        'height': '370px'
    });
    $("#TB_ajaxContent").css({
        'height': '370px'
    });
    $("#TB_ajaxContent").load('<?php echo BLOG_URL; ?>/register.php?height=370;width=400');
}

function _jswrite(obj, str) {
    if (obj.innerHTML) {
        obj.innerHTML = str;
    } else {
        obj.innerTEXT = str;
    }
}

var xmlHttp;
var type = 0;
function createXMLHttpRequest() {
    //Mozilla
    if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
        if (xmlHttp.overrideMimeType) {
            xmlHttp.overrideMimeType("text/xml");
        }
    } //以下是 IE
    else if (window.ActiveXObject) {
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e) {}
        }
    }
}

function startRequest(url) {
    createXMLHttpRequest();
    //触发 onreadystatechange 时调用“handleStateChange();”
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function handleStateChange() {
    if (xmlHttp.readyState == 4) {
        // alert("xmlHttp.status="+xmlHttp.status);
        if (xmlHttp.status == 200) {
            var msg = xmlHttp.responseText;

            document.getElementById("isSubmitOk").value = '1';
            if (msg < 0) {
                document.getElementById("isSubmitOk").value = '-1';
                if (msg == '-1') {
                    _jswrite(document.getElementById("login_notice"), '用户名已经注册');

                } else if (msg == '-2') {
                    _jswrite(document.getElementById("email_notice"), '邮箱格式不正确');

                } else if (msg == '-3') {
                    _jswrite(document.getElementById("verify_notice"), '验证码不正确');

                } else if (msg == '-4') {
                    _jswrite(document.getElementById("login_notice"), '用户名至少为两个字符');
                } else if (msg == '-5') {
                    _jswrite(document.getElementById("password_notice"), '密码至少为6个字符');
                } else if (msg == '-6') {
                    _jswrite(document.getElementById("password2_notice"), '密码至少为6个字符');
                } else if (msg == '-7') {
                    _jswrite(document.getElementById("password2_notice"), '再次密码不一致');
                } else if (msg == '-8') {
                    _jswrite(document.getElementById("email_notice"), '邮箱已经存在');
                } else if (msg == '-9') {
                    _jswrite(document.getElementById("uid_bind_notice"), 'UID不存在');
                } else if (msg == '-10') {
                    _jswrite(document.getElementById("uid_bind_notice"), '请填写正确的UID');
                } else if (msg == '-11') {
                    _jswrite(document.getElementById("login_notice"), '用户名至少为两个字符');
                } else if (msg == '-12') {
                    _jswrite(document.getElementById("login_notice"), '该用户不存在');
                } else if (msg == '-13') {
                    _jswrite(document.getElementById("login_notice"), '该帐户已经被绑定，请选择其它帐户!');
                } else if (msg == '-14') {
                    _jswrite(document.getElementById("uid_bind_notice"), '该帐户已经被绑定，请选择其它帐户!');
                } else if (msg == '-15') {
                    _jswrite(document.getElementById("email_notice"), '该帐户已经被绑定，请选择其它帐户!');
                }
            } else {
                switch (type) {
                case 1:
                    _jswrite(document.getElementById("login_notice"), '&nbsp;');
                    break;
                case 2:
                    _jswrite(document.getElementById("email_notice"), '&nbsp;');
                    break;
                case 3:
                    _jswrite(document.getElementById("verify_notice"), '&nbsp;');
                    break;
                case 4:
                    _jswrite(document.getElementById("password_notice"), '&nbsp;');
                    break;
                case 5:
                    _jswrite(document.getElementById("password2_notice"), '&nbsp;');
                    break;
                case 6:
                    _jswrite(document.getElementById("uid_bind_notice"), '&nbsp;');
                    break;
                case 7:
                    _jswrite(document.getElementById("login_notice"), '&nbsp;');
                    break;

                }
            }
        } else {
            //alert("获取资料出错!");
        }
    }
}

function checkReg(types, val) {
    type = types;
    var url = '/admin/user_register.php?action=register&op=check&type=' + types + '&data=' + val;
    startRequest(url);
}

//自动显示
function autoShow() {
    var obj = document.getElementById("email");
    var mailAddressList = document.getElementById("auto-show");
    var x = 0,
    y = 0,
    o = obj;
    h = obj.offsetHeight;
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
    $('#clear_email').attr('title', addr);
    if (emailInput.val() != '') {
        $('#clear_email').show();
    } else {
        $('#clear_email').hide();
    }
}

//鼠标移入设置样式
function setStyle(obj) {
    oldIndex = newIndex;
    newIndex = $(obj).attr("id");
    $(obj).css({
        "background-color": "#aaa"
    });
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
    newIndex = newIndex < 1 ? counts: newIndex;
    $("div #" + newIndex).css({
        "background-color": "#aaa"
    });
    $("div #" + oldIndex).css("background-color", "white");
}

function autoWidthDiv(val) {
    if (val) {
        var now_W = $('#auto-show').width();
        $('#auto-show').css('width', now_W + 8 + 'px');
    } else {
        $('#auto-show').css('width', '120px');
    }

}

function getClassName(classToSearch) {
    var tagName = '*';
    var elementsToReturn = new Array();
    var elementList = document.getElementsByTagName(tagName);
    var nLen = elementList.length;
    var pattern = new RegExp("\\b" + classToSearch + "\\b");
    for (var i = 0; i < nLen; i++) {
        if (pattern.test(elementList[i].className)) {
            elementsToReturn[elementsToReturn.length] = elementList[i];
        }
    }
    return elementsToReturn;
}

function showBind(val) {

    var name = getClassName('bind');
    for (var i = 0; i < name.length; i++) {
        name[i].style.display = 'none';
    }
    var _class = '';
    if (val == '1') {
        _class = 'login_bind';
    } else if (val == '2') {
        _class = 'uid_bind';
    } else if (val == '3') {
        _class = 'email_bind';
    }

    name = getClassName(_class);

    for (var i = 0; i < name.length; i++) {

        name[i].style.display = 'block';
    }
}

//define args
//常用邮件列表数组
var emailList = ["@163.com", "@126.com", "@gmail.com", "@yahoo.com", "@yahoo.com.cn", "@sina.cn", "@qq.com", "@hotmail.com", "@sohu.com", "@189.cn"];
//新项的索引(用于设置高亮显示的样式)
var newIndex = 0;
//旧项的索引(用于取消原有高亮显示的样式)
var oldIndex = 0;
//邮件列表个数
var counts = emailList.length;
$('#clear_email').click(function() {
    $("#email").val('');
    $('#clear_email').hide();
    $('#clear_email').attr('title', 'email');
}); $(document).ready(function() {
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
    emailInput.keyup(function(event) {
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
            if (currentVal.length > 5) {
                autoWidthDiv(true)
            }
            //如果原来已包含有@字符
            if (currentVal.indexOf("@") > -1) {
                emailInput.val("");
                autoWidthDiv(false); //让autodiv宽度复原
                for (var i = 1; i <= counts; i++) {
                    $("div #" + i).text("").text(emailList[i - 1]);
                }
                return;
            }
            for (var i = 1; i <= counts; i++) {
                $("div #" + i).text("").text(currentVal + emailList[i - 1]);
                $('#clear_email').attr('title', currentVal);
            }
            $('#clear_email').show();
        }
        //如果按下退格键或删除键
        if (keyCode == 8 || keyCode == 46) {
            emailInput.val("");
            $('#clear_email').hide();
            $('#clear_email').attr('title', 'email');
            autoWidthDiv(false);
            for (var i = 1; i <= counts; i++) {
                $("div #" + i).text("").text(emailList[i - 1]);
            }
        }
    });
});