<script type="text/javascript">
/* <![CDATA[ */
    function grin(tag) {
    	var myField;
    	tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
    		myField = document.getElementById('comment');
    	} else {
    		return false;
    	}
    	if (document.selection) {
    		myField.focus();
    		sel = document.selection.createRange();
    		sel.text = tag;
    		myField.focus();
    	}
    	else if (myField.selectionStart || myField.selectionStart == '0') {
    		var startPos = myField.selectionStart;
    		var endPos = myField.selectionEnd;
    		var cursorPos = endPos;
    		myField.value = myField.value.substring(0, startPos)
    					  + tag
    					  + myField.value.substring(endPos, myField.value.length);
    		cursorPos += tag.length;
    		myField.focus();
    		myField.selectionStart = cursorPos;
    		myField.selectionEnd = cursorPos;
    	}
    	else {
    		myField.value += tag;
    		myField.focus();
    	}
    }
/* ]]> */
</script>
<?php $max_face = 41;
if (!isset($_GET['face'])) {
	$max_face = 16;
}

for ($i = 1; $i < $max_face; $i++) {
	echo "<a href=\"javascript:grin('[" . $i . "]')\"><img src=\"" . WEB_ROOT . "/content/templates/mi2/images/face/" . $i . ".gif\" width='40' height='40' alt='faces'/></a>";
}
?>
<br />
<?php if (!isset($_GET['face'])): ?>
<span style="float:right;"><a href="javascript:;" onClick="$('#face_box').load('<?php echo TEMPLATE_URL; ?>includes/smiley.php?face=m')">更多&gt;&gt;</a>&nbsp;&nbsp;</span>
<?php endif;?>

