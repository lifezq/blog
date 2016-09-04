<?php
/**
 * Plugin Name: 虾米音乐播放器
 * Version: 1.0
 * Plugin URL:http://lwllo.com
 * Description: 根据关键词获取虾米音乐搜索结果,生成虾米音乐播放器代码，并自动插入到文章中
 * Author: 老王
 * Author Email: lwllo.82@gmail.com
 * Author URL: http://lwllo.com
 */

function music() {
        $cssUrl  = BLOG_URL. 'content/plugins/XiaMiPlayer/style.css';
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssUrl}\" id=\"text\"/>";
?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript">
			textEditor = document.getElementById('text');
			textEditor.setContent = function(text, id) {
				 //IE support
				  if (document.selection) {
				    textEditor.focus();
				    sel = document.selection.createRange();
				    sel.text = text;
				    sel.select();
				  }
				  //MOZILLA/NETSCAPE support
				  else if (textEditor.selectionStart || textEditor.selectionStart == '0') {
				    var startPos = textEditor.selectionStart;
				    var endPos = textEditor.selectionEnd;
				    // save scrollTop before insert
				    var restoreTop = textEditor.scrollTop;
				    textEditor.value = textEditor.value.substring(0, startPos) + text + textEditor.value.substring(endPos, textEditor.value.length);
				    if (restoreTop > 0) {
				      // restore previous scrollTop
				      textEditor.scrollTop = restoreTop;
				    }
				    textEditor.focus();
				    textEditor.selectionStart = startPos + text.length;
				    textEditor.selectionEnd = startPos + text.length;
				  } else {
				    textEditor.value += text;
				    textEditor.focus();
				  }
			}
		    /** 这两个函数在插件中必须实现 */
		    var insertImageToEditor = function (title, url, link, cid) {
		        textEditor.setContent('<a href="'+link+'" title="'+title+'"><img src="'+url+'" alt="'+title+'" /></a>', '');
		    };
		    
		    var insertLinkToEditor = function (title, url, link, cid) {
		        textEditor.setContent('<a href="' + url + '" title="' + title + '">' + title + '</a>', '');
		    };
		</script>
		<script type="text/javascript">
		jQuery.noConflict();
		jQuery('#text').before('<a href=\"#\" id=\"editorTool\">插入歌曲</a>');
		jQuery('#editorTool').click(function() {
			jQuery('#editorTool').after('<div id=\"searchPanel\"></div>');
			jQuery('#searchPanel').html('<form><input type=\"text\" id=\"xiami_search\" value=\"\"><input type=\"hidden\" id=\"xiami_page\" value=\"1\"><div id=\"DoSearch\" onclick=\"search();\">搜索</div></form><div class=\"close\" onclick=\"rm();\">X</div><div id=\"xiami_list\"><div id=\"xiami_result\"></div><div id=\"xiami_navi\" page="1"><a href="#" class="pre" onclick="pre();" style="display:inline-table;border:none;float:left;"></a><a href="#" class="next" onclick="next();" style="display:inline-table;border:none;float:right;"></a></div>');
		});
		function pre() {
			var n = jQuery('#xiami_navi'), p = Number(n.attr('page'))-1;
			if(p == 1) jQuery('.pre').html('');
			n.attr('page', p);
			search();
		}
		function next() {
			var n = jQuery('#xiami_navi'), p = Number(n.attr('page'))+1;
			n.attr('page', p);
			search();
		}
		function search() {
			var k = jQuery('#xiami_search').val(), p = Number(jQuery('#xiami_navi').attr('page'));
			jQuery('.pre').html('上一页');
			jQuery('.next').html('下一页');
			if (k) {
				jQuery('#xiami_result').html('正在载入请稍后...');
				jQuery.getJSON('http://www.xiami.com/app/nineteen/search/key/'+k+'/page/'+p+'?callback=?',function(data) {
					jQuery('#xiami_result').html('');
					jQuery.each(data.results,
					function(i, item) {
						jQuery('<a href=\"#\" onclick=\"show(\'' + item.song_id + '\');\">' + decodeURIComponent(item.song_name).split('+').join(' ') + ' - ' + decodeURIComponent(item.artist_name).split('+').join(' ') + '</a>').appendTo('#xiami_result');
					});
				});
			} else {
				alert('请输入歌曲名称!')
			}
		}
		
		function more() {
			var k = jQuery('#xiami_search').val();
			var p = jQuery('#xiami_page');
			p.val(parseInt(p.val()) + 1);
			jQuery.getJSON('http://www.xiami.com/app/nineteen/search/key/' + k + '/page/' + p.val() + '?callback=?',
			function(data) {
				jQuery.each(data.results,
				function(i, item) {
					jQuery('<a href=\"#\" onclick=\"show(\'' + item.song_id + '\');\">' + decodeURIComponent(item.song_name) + ' - ' + decodeURIComponent(item.artist_name) + '</a>').appendTo('#xiami_result')
				})
			})
		}
		function rm() {
			jQuery('#searchPanel').remove()
		}
		function show(id) {
			jQuery('#searchPanel').remove();
			var t = jQuery('#text');
			var c = '<embed src="http://www.xiami.com/widget/1883615_' + id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed>';
			t.val(t.val() + c);
			editor(c)
		}
		function editor(c) {
			if (window.frames.length > 0) {
				if (fck = window.frames['text___Frame']) var _c = fck.document.getElementsByTagName('iframe')[0].contentDocument.body;
				else if (mce = window.frames['text_ifr']) var _c = mce.document.body;
				else if (kin = document.getElementsByClassName('ke-edit-iframe')[0]) var _c = kin.contentDocument.body;
				else if (cke = document.getElementsByClassName('cke_wysiwyg_frame')[0]) var _c = cke.contentDocument.body;
				_c.innerHTML = _c.innerHTML + c
			}
		}
		jQuery('#xiami_search').keydown(function() {
			if(event.keyCode == '13') {
				search();	
			}
		});
<?php
		echo '</script>';
	}

addAction('adm_writelog_head', 'music');

