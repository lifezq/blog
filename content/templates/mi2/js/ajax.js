
/**
 * Ajax ���󷽷�
 *@author Ҧ��Ф
 *@param url Ҫ���ʵĵ�ַ������������
 *@param paramdata ���ʵĲ�������ʽΪaaa=bbb&ccc=ddd&eee=fff��������
 *@return ����������
 *
 *
 *  Action�е�д��
 *		PrintWriter out = null;
 *		response.setContentType("text/html; charset=UTF-8");
 *		response.setHeader("cache-control", "no-cache");
 *		String message = "";
 *		try {
 *			out = response.getWriter();
 *			//������service�õ�������
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