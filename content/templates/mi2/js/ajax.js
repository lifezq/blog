
/**
 * Ajax 请求方法
 *@author 姚洪肖
 *@param url 要访问的地址（不带参数）
 *@param paramdata 访问的参数（形式为aaa=bbb&ccc=ddd&eee=fff。。。）
 *@return 返回请求结果
 *
 *
 *  Action中的写法
 *		PrintWriter out = null;
 *		response.setContentType("text/html; charset=UTF-8");
 *		response.setHeader("cache-control", "no-cache");
 *		String message = "";
 *		try {
 *			out = response.getWriter();
 *			//调用用service得到请求结果
 *			message = service.process(request);
 *		} catch (IOException e) {
 *			GetLogs.syserror.error(e.getMessage(), e);
 *		} finally {
 *			if (null != out) {
 *				out.write(message);
 *				out.flush();
 *				out.close();
 *			}
 *		}
 *		return null;
 *
 *
 */
function AjaxRequest(url,paramdata){
	var xmlHttp;
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
    xmlHttp.open("POST", url, false);
    xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xmlHttp.send(paramdata);
   return xmlHttp.responseText;
}