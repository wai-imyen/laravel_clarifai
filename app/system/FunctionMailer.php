<?php

/* Email樣板 start */
if(!function_exists('EmailTemplate'))
{
	function EmailTemplate($etType,$time, $parms,$parms2,$parms3)
	{
		include ('CustomSetting.php');
		switch(strtolower($etType))
		{
			case 'register':
			default:
					$message = '
							<div class="" style="border: solid 1px #ccc;width:100%;max-width:500px;margin: 0 auto;overflow:hidden;line-height:24px;font-family: \'Myriad Web Pro\', \'Arial\',\'微軟正黑體\';">

								<div class="" style="width: 90%;max-width:540px;padding:4px;margin: 0 auto;font-size: 12px;">
									<h4 >帳號啟用信件</h4>
									<p>--------------------------------------------------------------------------</p>
									<p>親愛的會員 您好,</p>
									<p>您於 '.$time.' 註冊了 RankBar 會員, 謝謝您的支持！</p>
									<p>請 <a href="'.$parms.'">點選此連結</a> 以啟用您的帳號。</p>
									<br>
									<p>有任何問題歡迎隨時聯繫電子客服信箱 <a href="mailto:hello@ktrees.com">'.$defaultEmailAccount.'</a></p>
									<p style="text-align: right">RankBar 團隊 敬上</p>
								</div>
							</div>


					';
			break;

			case 'forget_password':
					$message = '
							<div class="" style="border: solid 1px #ccc;width:100%;max-width:500px;margin: 0 auto;overflow:hidden;line-height:24px;font-family: \'Myriad Web Pro\', \'Arial\',\'微軟正黑體\';">

							    <div class="" style="width: 90%;max-width:540px;padding:4px;margin: 0 auto;font-size: 12px;">
							        <h4 >密碼重設通知</h4>
							        <p>--------------------------------------------------------------------------</p>
							        <p>親愛的會員 您好,</p>
							        <p>您的會員密碼已於 '.$time.' 重新設定，</p>
							        <p>新的密碼為 <span style="color:red;font-weight:bold;">'.$parms.'</span> </p>
							        <p>請 <a href="'.$case_backend_domain.'/login.php">重新登入</a>，並至會員管理中重新修改密碼。</p>

							        <br>
							        <p>有任何問題歡迎隨時聯繫電子客服信箱 <a href="mailto:hello@ktrees.com">'.$defaultEmailAccount.'</a></p>
							        <p style="text-align: right">RankBar 團隊 敬上</p>
							    </div>
							</div>
					';
			break;

			case 'cb_member':
					$message = '
							<div class="" style="border: solid 1px #ccc;width:100%;max-width:500px;margin: 0 auto;overflow:hidden;line-height:24px;font-family: \'Myriad Web Pro\', \'Arial\',\'微軟正黑體\';">

							    <div class="" style="width: 90%;max-width:540px;padding:4px;margin: 0 auto;font-size: 12px;">
							        <h4 >封測會員需求表單通知</h4>
							        <p>--------------------------------------------------------------------------------------------</p>
							        <p>新的封測會員需求表單於 '.$time.' 送出，</p>
							        <p>IP 位置 : '.$parms.' </p>
							    </div>
							</div>
					';
			break;

			case 'member_open':
					$message = '
							<p>Hi '.$parms.',</p>
							<p>您的 Rankbar 懶客酒吧 帳號已經開通，</p>

							<p>經過多次的調整，懶客酒吧終於要開始進行封測了。<br />
							本次的封測預計會進行3個月，<br />
							大家的會員方案為 "進階方案"<br />
							1. 可同時監測7個網站<br />
							2. 各網站可以追蹤30個關鍵字<br />
							3. 各個網站監測5個競爭對手<br />
							4. 每2天更新一次關鍵字排名 </p>

							<p>若封測期間延長，我們將自動替封測的使用者帳號增加使用效期，<br />
							若封測期間提早結束，我們將於封測結束時間前2周通知各位使用者，<br />
							封測結束後大家將恢復免費方案，依然可以正常使用懶客酒吧的各個功能<br />
							但是超出方案使用範圍的部分將會暫停運作。<br />
							詳細的方案介紹請參考  懶客方案</p>

							<p>目前有參與問卷填寫的朋友們將獲得測試帳號與密碼，<br />
							本平台封測期間將鎖定註冊功能，採用邀請制度，<br />
							若您有朋友也想體驗懶客酒吧，請您透過您的信箱提供您朋友的信箱帳號，<br />
							我們將發送測試帳號給您的好友。</p>

							<p>在使用上有任何的疑問或是功能建議都歡迎您隨時提出，謝謝您的不吝指教，<br />
							有協助進行封閉測試的朋友們在網站正式對外營運後將獲得 "小額方案3個月" 的小禮物，<br />
							若您有提供非常有建設性的建議或修正的話我們定會給予大大的方案獎勵感謝您的回報。</p>

							<p>懶客酒吧封閉測試<br />
							網址: https://rank.bar/<br />
							登入帳號: '.$parms2.'<br />
							登入密碼:'.$parms3.'<br />
							再次謝謝您的參與，<br />
							期待您的使用與回饋。</p>

							<p>謝謝您,<br />
							懶客酒吧客服小組</p>

							<p>- - - - - - - - - - - - - </p>

							<p>汘 澍 文 創 有 限 公 司, K t r e e s   D e s i g n ,  L t d .<br />
							A D D /   新 北 市 板 橋 區 長 江 路 2 段 2 4 5 號<br />
							T E L /  ( 0 2 )  2 2 5 2   5 1 8 9 <br />
							F A X /  ( 0 2 ) 2 2 5 1   2 4 8 8 <br />
							V A T /  5 4 2 8   6 8 9 6 <br />
							W E B / w w w . k t r e e s . c o m<br />
							E M L / s e r v i c e @ k t r e e s . c o m</p>
					';
			break;


		}

		return $message;
	}
}
/* Email樣板 end */

/* 透過AWS郵件伺服器發信 start */
if(!function_exists('AwsSesMailer'))
{
	function AwsSesMailer($sender, $to, $subject,$message)//多位收件者以,分隔
	{
		include '../aws/aws-autoloader.php';
		define('USERNAME','AKIAJSJOJB6QDQNABC6Q');
		define('PASSWORD','Ah4jftRTOqosWzSQcwuoqgHb1f5pdGIGgZNpOziyZ4Te');
		define('HOST', 'email-smtp.us-east-1.amazonaws.com');
		define('PORT', '587');

		include '../include/Mail/Mail.php';
		include('../include/Mail_Mime/Mail/mime.php');

		$headers = array (
		  'From' => $sender,
		  'To' => $to,
		  'Subject' => $subject);

		$smtpParams = array (
		  'host' => HOST,
		  'port' => PORT,
		  'auth' => true,
		  'username' => USERNAME,
		  'password' => PASSWORD
		);

		$mime_params = array(
		  'text_encoding' => '7bit',
		  'text_charset'  => 'UTF-8',
		  'html_charset'  => 'UTF-8',
		  'head_charset'  => 'UTF-8'
		);

		// Creating the Mime message
		$crlf = "\n";
	    $mime = new Mail_mime();

	    $mime->setTXTBody(strip_tags($message));
	    $mime->setHTMLBody($message);
	    $body = $mime->get($mime_params);
	    $headers = $mime->headers($headers);

		 // Create an SMTP client.
		$mail = Mail::factory('smtp', $smtpParams);


		// Send the email.
		$result = $mail->send($to, $headers, $body);

		if (PEAR::isError($result)) {
		  //echo("Email not sent. " .$result->getMessage() ."\n");
		  $return['MessageId'] = $result->getMessage();
		} else {
		  //echo("Email sent!"."\n");
			$return['MessageId'] = 'success';
		}
		//echo $return['MessageId'];

		return $return;
	}
}
/* 透過AWS郵件伺服器發信 end */

?>
