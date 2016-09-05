<?php


function sendmail($toemail, $subject, $message, $from='',$webTitle='',$webUrl='') {

        $date=date('Y-m-d H:i',time());
        
$message=<<<str
        <table cellspacing="0" cellpadding="20">
	<tr><td>
	<table width="500" cellspacing="0" cellpadding="1">
		<tr><td bgcolor="#DFDFDF" align="left" style="font-family:'lucida grande',tahoma,'bitstream vera sans',helvetica,sans-serif;line-height:150%;color:#FFF;font-size:24px;font-weight:bold;padding:4px">&nbsp; $webTitle </th></tr>
		<tr><td bgcolor="#DFDFDF">
			<table width="100%" cellspacing="0" bgcolor="#FFFFFF" cellpadding="20">
				<tr><td style="font-family:'lucida grande',tahoma,'bitstream vera sans',helvetica,sans-serif;line-height:150%;color:#000;font-size:14px;">
					
					<blockquote>$message<br></blockquote>
					<br>
					<br>
					<br><span style='float:right;'><a href="$webUrl" target="_blank">$webTitle</a></span>
                                        <br><span style='float:right;'><a href="$webUrl" target="_blank">$webUrl</a></span>
					<br><span style='float:right;'>$date</span>
					<br>
					<br>
				</td></tr></table>
		</td></tr></table>
	</td></tr>
</table>
str;
                                        
	include_once('data_mail.php');
	
	
	$maildelimiter = $mail['maildelimiter'] == 1 ? "\r\n" : ($mail['maildelimiter'] == 2 ? "\r" : "\n");

	$mailusername = isset($mail['mailusername']) ? $mail['mailusername'] : 1;
	
	$mail['port'] = $mail['port'] ? $mail['port'] : 25;
	$mail['mailsend'] = $mail['mailsend'] ? $mail['mailsend'] : 1;
	
	$email_from = empty($from) ? $mail['adminemail'] : $from;
        
	$email_to = $toemail;
	
	$email_subject = '=?utf-8?B?'.base64_encode(preg_replace("/[\r|\n]/", '', $subject)).'?=';
	$email_message = chunk_split(base64_encode(str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message))))));
	
	$headers = "From: $email_from{$maildelimiter}X-Priority: 3{$maildelimiter}X-Mailer: UCENTER_HOME ".X_VER."{$maildelimiter}MIME-Version: 1.0{$maildelimiter}Content-type: text/html; charset=utf-8{$maildelimiter}Content-Transfer-Encoding: base64{$maildelimiter}";
		echo $mail['mailsend'];
	if($mail['mailsend'] == 1) {
		if(function_exists('mail') && @mail($email_to, $email_subject, $email_message, $headers)) {
			return true;
		}
		return false;
		
	} elseif($mail['mailsend'] == 2) {
           
		require_once("class.phpmailer.php"); 
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
                $ok=$mail2->Send();
                var_dump($ok);
                exit;
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
?>