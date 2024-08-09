<?php
include("include/config.php");
require '../PHPMailer/src/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;

$db = new Database();

if (isset($_GET['email'])) {
	$email = $_GET['email'];
	$query = "SELECT * FROM admin_login WHERE email = '$email' LIMIT 1";
	$execute = $db->execute($query);
	$result = $db->getResult($execute);
	$num = $db->rowCount($execute);
	if ($num > 0) {
		$email_ss = $result['email'];
		$enc_email = base64_encode($email_ss);
		$time = time();
		//$password = $result['password'];
		$subject = "Forgot password link.";

		// HTML email starts here

		$message  = "<html><body>";

		$message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

		$message .= "<tr><td>";

		$message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

		$message .= "<tbody>

				      	<tr align='center' height='50' style='font-family:Verdana, Geneva, sans-serif;'>

				       		<td style='background-color:#035CA7; text-align:center;'>

				       			<a href='http://www.admin.checkinroom.com/' target='_blank' style='color:#fff; text-decoration:none;'><img style='height:50px;' src='http://www.checkinroom.com/images/logo.png' alt='check in room logo'></a>
				       		</td>
				      	</tr>
				      	<tr>
				       		<td colspan='4' style='padding:15px;'>
				       			<h4>Hi there,</h4>
					        	<hr />
					        	<p style='margin-left:50px;font-size:15px; font-family:Verdana, Geneva, sans-serif;'>
					        	It looks like you requested to reset password
					        	</p>
					        	<p style='margin-left:50px;font-size:15px; font-family:Verdana, Geneva, sans-serif;'>
					        	If that sound right you can reset your password clicking on button blow.
					        	</p>
						        <p style='margin-left:50px;font-size:15px; font-family:Verdana, Geneva, sans-serif;'>
						        <a href='http://www.admin.checkinroom.com/new_password.php?token=$enc_email&t=$time' target ='_blank'><img style='width:150px;height:50px;' src='http://admin.checkinroom.com/resetbutton.png' alt='reset button'></p>


					       </td>
				      	</tr>
			      	</tbody>";

		$message .= "</table>";

		$message .= "</td></tr>";

		$message .= "</table>";

		$message .= "</body></html>";

		$mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->isHTML(true);

		$mail->Host = "www.admin.checkinroom.com";  // Specify main and backup server

		$mail->From = "booking@admin.checkinroom.com";

		$mail->FromName = "Check in rooms";

		$mail->addAddress($email_ss);

		$mail->addBCC('guddu@digitalindiawebsolutions.com');

		$mail->Subject = $subject;

		$mail->Body = $message;

		$mail->AltBody = '';

		if (!$mail->send()) {
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			echo 2;
		} else {

			echo 0;
		}
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'generate_pass') {
	$email = $_POST['email'];
	$n_pass = $_POST['new_pass'];
	$conf_pass = $_POST['conf_pass'];

	if ($n_pass != "" && $conf_pass != "" && $email != "") {

		if ($n_pass == $conf_pass) {

			if (isset($_GET['t']) && (time() - $_GET['t'] > 1200)) {
				session_unset();
				session_destroy();
				header("Location:expire.php");
			} else {
				$query = "SELECT * FROM admin_login WHERE email = '$email' LIMIT 1";
				$exe = $db->execute($query);
				$rows = $db->rowCount($exe);
				if ($rows > 0) {
					$password = md5($n_pass);
					$db->execute("UPDATE admin_login SET password = '$password' WHERE email = '$email'");
					echo 0;
				} else {
					echo 3;
					die;
				}
			}
		} else {

			echo 2;
			die;
		}
	} else {

		echo 1;
		die;
	}
}
