<?php

	/**
	 *	網址格式驗證
	 *
	 *	@param string $url			// 網址
	 *
	 *	@return boolean
	 */
	if( ! function_exists('is_valid_url'))
	{
		function is_valid_url($url)
		{
			if (preg_match('/^((ftp|http|https):\/\/)?(www.)?(?!.*(ftp|http|https|www.))[a-zA-Z0-9_-]+(\.[a-zA-Z]+)+((\/)[\w#]+)*(\/\w+\?[a-zA-Z0-9_]+=\w+(&[a-zA-Z0-9_]+=\w+)*)?$/i', $url))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}

		}
	}

	/**
	 *	寄信
	 *
	 *	@param string $sender			// 寄件者
	 *	@param string $to				// 收件者
	 *	@param string $subject			// 主旨
	 *	@param string $message			// 信件內容
	 *
	 *	@return string
	 */
	if( ! function_exists('AwsSesMailer'))
	{
		function AwsSesMailer($sender, $to, $subject,$message)//多位收件者以,分隔
		{
		    include 'aws/aws-autoloader.php';
		    define('USERNAME','AKIAJSJOJB6QDQNABC6Q');
		    define('PASSWORD','Ah4jftRTOqosWzSQcwuoqgHb1f5pdGIGgZNpOziyZ4Te');
		    define('HOST', 'email-smtp.us-east-1.amazonaws.com');
		    define('PORT', '587');

		    include 'include/Mail/Mail.php';
		    include('include/Mail_Mime/Mail/mime.php');

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

		    if (PEAR::isError($result))
		    {
		      //echo("Email not sent. " .$result->getMessage() ."\n");
		      $return['MessageId'] = $result->getMessage();
		    } else
		    {
		      //echo("Email sent!"."\n");
		        $return['MessageId'] = 'success';
		    }
		    //echo $return['MessageId'];

		    return $return;
		}
	}



    	/**
    	 *	寫入表單 LOG
    	 *
    	 *	@param array $form_content			// 表單陣列
    	 *
    	 *	@return void
    	 */
    	if ( ! function_exists('set_form_log'))
    	{
    	    function set_form_log($form_content, $method)
    	    {
    	    	$content = '';

    	    	$token = (isset($form_content['_token'])) ? $form_content['_token'] : 0 ;

    	    	foreach ($form_content as $key => $val) {

    	    		if ($key != '_token')
    	    		{
    	    			if (is_array($val))
    	    			{
    	    				$content2 = '';

    	    				$content2 .= ', '.$key.' { ';

    	    				foreach ($val as $key2 => $val2)
    	    				{
    	    					if ($key2 == 0)
    	    					{
    	    						$content2 .= '['.$key2.']'.' = '.$val2;
    	    					}
    	    					else
    	    					{
    	    						$content2 .= ', ['.$key2.']'.' = '.$val2;
    	    					}
    	    				}

    	    				$content2 .= ' }';

    	    				$content .= $content2;
    	    			}
    	    			elseif ($key == 'password' || $key == 'old_password' || $key == 'new_password' || $key == 'check_password')
    	    			{
    	    				$content .= ', ['.$key.']'.' = '.mcrypt_encode($val);

    	    			}
    	    			else
    	    			{
    	    				$content .= ', ['.$key.']'.' = '.$val;
    	    			}
    	    		}

    	    	}
    	    	$content = substr($content, 2);

    	    	$member_id = (isset($_SESSION['login_m_id'])) ? $_SESSION['login_m_id'] : 0 ;

    	    	$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    	    	$log = date('Y-m-d H:i:s').' '.$method.' m_id: '.$member_id.', token: '.$token.', '.$content.', '.$url.', IP: '.get_ip().' '."\r\n".PHP_EOL;

    	    	error_log($log ,3 ,dirname(__FILE__).'/../log/form_log.txt');
    	    }
        }

	/**
	 * 圖形驗證碼檢查
	 *
	 * @param  string	$captcha		// 驗證碼
	 *
	 * return Void
	 */
	if ( ! function_exists('captcha_verify'))
	{
		function captcha_verify($captcha)
		{

			if ( ! isset($_SESSION['TW_turing_string']) || ! $captcha || strtoupper($_SESSION['TW_turing_string']) != strtoupper($captcha))
			{
				AlertWindow('login.php', $alertMessage = '驗證碼有誤！');	// 轉回前一頁

				exit();
			}

			// 清除驗證碼 session
			unset($_SESSION['TW_turing_string']);

		}
	}

	/**
	 * 資料加密
	 *
	 * @param  string	$data			資料內容
	 * @param  string	$SecretHashKey	加密 key
	 * @param  string	$SecretHashIV	加密 key
	 *
	 * return Void
	 */
	if ( ! function_exists('mcrypt_encode'))
	{
		function mcrypt_encode($data, $SecretHashKey = 'jhy7A6DHyrZGDHNa', $SecretHashIV = '8AJSit6AeDFSA12a')
		{
			if ($data != '')
			{
				$return = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $SecretHashKey,  $data, MCRYPT_MODE_CBC, $SecretHashIV));
			}
			else
			{
				$return = $data;
			}

			return $return;
		}
	}

	/**
	 * 資料解密
	 *
	 * @param  string	$data			資料內容
	 * @param  string	$SecretHashKey	加密 key
	 * @param  string	$SecretHashIV	加密 key
	 *
	 * return Void
	 */
	if ( ! function_exists('mcrypt_decode'))
	{
		function mcrypt_decode($data, $SecretHashKey = 'jhy7A6DHyrZGDHNa', $SecretHashIV = '8AJSit6AeDFSA12a')
		{
			if ($data != '')
			{
				$return = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $SecretHashKey, base64_decode($data), MCRYPT_MODE_CBC, $SecretHashIV));
			}
			else
			{
				$return = $data;
			}

			return $return;
		}
	}


	/**
	 *	警告視窗
	 *
	 *	@param string $url			// 跳轉頁面
	 *	@param string $target		// 視窗開啟方式
	 *	@param string $alertMessage	// 警告消息
	 *	@param int $close			// 填 1 的話就會把這個畫面關掉
	 *	@param int $reload			// 填 1 的話會把opener的畫面更新
	 *
	 *	@return VOID
	 */
	if ( ! function_exists('AlertWindow'))
	{
		function AlertWindow($url, $alertMessage = '', $target = '', $close = 0, $reload = 0)
		{
			$alert_script = '
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<script language="JavaScript" type="text/JavaScript">
			';

			if ($alertMessage != '')
			{
				$alert_script .= 'alert("'.$alertMessage.'");';
			}

			if ($url == 'back')
			{
				$alert_script .= 'javascript:history.back();';
			}
			elseif (trim($url) != '')
			{
				if ($target == '_parent')
				{
					$alert_script .= 'parent.location.href = "'.$url.'" ;';
				}
				elseif ($target == '_blank')
				{
					$alert_script .= 'blank.location.href = "'.$url.'" ;';
				}
				elseif ($target == '_self' || $target == '')
				{
					$alert_script .= 'location.href = "'.$url.'" ;';
				}
			}
			else
			{
				$alert_script .= 'location.reload();';
			}

			if ($reload)
			{
				$alert_script .= 'window.opener.location.reload();';
			}

			if ($close)
			{
				$alert_script .= 'window.close();';
			}

			$alert_script .= '</script>';

			echo $alert_script;

			if (trim($url))
			{
				exit();
			}
		}
	}

	/**
	 *	設定分頁
	 *
	 *	@param array $data			// 分頁的設定
	 *
	 *	@return pager
	 */
	if ( ! function_exists('setPageination'))
	{
		function setPageination($data = array())
		{
			$pagination = new Pagination();

			if ($data)
			{
				foreach ($data as $key => $val)
				{
					$pagination->$key = $val;
				}
			}

			return $pagination->render();
		}
	}

	/**
	 * 取得 CSRF Token
	 *
	 * @return String
	 */
	if ( ! function_exists('csrf_token'))
	{
	    function csrf_token()
	    {
			return sha1(session_id().HOST_BACK_URL);
	    }
	}

	/**
	 * 取得 CSRF Token Input HTML
	 *
	 * @return String
	 */
	if( ! function_exists('csrf_input'))
	{
	    function csrf_input()
	    {
			return '<input type="hidden" name="_token" value="'.csrf_token().'">';
	    }
	}

	/**
	 * 取得 CSRF Token Input HTML
	 *
	 * @return String
	 */
	if( ! function_exists('csrf_meta'))
	{
	    function csrf_meta()
	    {
			return '<meta name="csrf-token" content="'.csrf_token().'">';
	    }
	}

	/**
	 * 驗證 CSRF Token
	 *
	 * @param string $token
	 * @param string $type
	 *
	 * @return Void
	 */
	if( ! function_exists('csrf_check'))
	{
	    function csrf_check($token, $type = '1')
	    {
			$token = trim($token);
			// $token = trim($token).'000';
			if ($token != sha1(session_id().HOST_BACK_URL))
			{
				switch($type)
				{
					case '1':
						AlertWindow('back','錯誤的操作! c.1412');
					break;

					case '2':
						exit('金鑰驗證錯誤');
					break;

					case '3':
						exit(json_encode('金鑰驗證錯誤'));
					break;
				}
			}
	    }
	}

