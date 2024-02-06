<?php
//session_start();
//error_reporting(0);
require 'PHPMailerAutoload.php';
				require_once "class.phpmailer.php";
				$mail = new PHPMailer();
				$mail->IsSMTP(); // send via SMTP
			    $mail->Host = '';
				$mail->SMTPAuth = true; // turn on SMTP authentication
				$mail->Username = ""; // Enter your SMTP username
				$mail->Password = ""; // SMTP password'
		        //$mail->SMTPSecure = 'tls'; 
				$mail->SMTPSecure = 'ssl'; 
				$mail->SMTPDebug = false;
				$mail->Port = 465;
				//$mail->Port = 26;
				$webmaster_email = ""; //Add reply-to email address
			
				$mail->From = $webmaster_email;
				$mail->FromName = "COMPANY NAME";
				//$mail->AddAddress($email,$name);
				//$mail->AddBCC("i#", "Customer relation officer");
				$mail->AddReplyTo($webmaster_email,"No-Reply");
				 //$mail->AddReplyTo($webmaster_email,"No-Reply");
				//$mail->AddReplyTo("No-Reply");
				$mail->WordWrap = 50; // set word wrap
				$mail->IsHTML(true); // send as HTML
?>
