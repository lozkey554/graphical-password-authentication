<?php	
	function sendOTP($email,$otp) {
		// require('phpmailer/src/PHPMailer.php');
		// require('phpmailer/src/SMTP.php');
	
		$message_body = "One Time Password for PHP login authentication is:<br/><br/>" . $otp;
		// $mail = new PHPMailer();
		// $mail->IsSMTP();
		// $mail->SMTPDebug = 0;
		// $mail->SMTPAuth = TRUE;
		// $mail->SMTPSecure = 'tls'; // tls or ssl
		// $mail->Port     = "SMTP port";
		// $mail->Username = "SMTP username";
		// $mail->Password = "SMTP Password";
		// $mail->Host     = "SMTP HOST";
		// $mail->Mailer   = "smtp";
		// $mail->SetFrom("FROM EMAIL", "FROM NAME");
		// $mail->AddAddress($email);
		// $mail->Subject = "OTP to Login";
		// $mail->MsgHTML($message_body);
		// $mail->IsHTML(true);		
		// $result = $mail->Send();
		$headers = "";
		$sender = "segunjames554@gmail.com";

		$headers .= "Content-type: text/html;\r\n";
        $headers .= "From: $sender";
        $result = mail($email, "OTP TO LOGIN", $message_body, $headers);

		return $result;
	}
?>