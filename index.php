<?php

include("include/config.php");

setcookie("ip_addres", $_SERVER['REMOTE_ADDR'], time() + (21600 * 30), "/");
$db = new Database();
$all_hotels = $db->execute("SELECT * FROM hotels WHERE status = 0");
$hotels = $db->getResults($all_hotels);
$msg = "";
$current_date = DATE_TIME;

if (!isset($_SESSION['token'])):
	$token = md5(uniqid(rand(), TRUE));
	$_SESSION['token'] = $token;
else:
	$token = $_SESSION['token'];
endif;

if (!empty($_COOKIE['login_h_id'])) {
	header("Location:entry/room_view.php");
}
if (isset($_POST['login'])) {

	$username = isset($_POST['username']) ? strip_tags($_POST['username']) : false;
	$password = isset($_POST['password']) ? md5($_POST['password']) : false;
	$token1 = isset($_POST['token']) ? $_POST['token'] : false;
	//$username=strip_tags($_POST['username']);
	//$password=md5($_POST['password']);

	if ($_SESSION['token'] != $token1) {

		$msg = "Invalid! User Name / Password..";
	} else {

		$sql = "SELECT * FROM `admin_login` WHERE `user_name` = '$username' AND `password` = '$password' AND status = 0 LIMIT 1";
		$chk123 = $db->execute($sql);
		$result = $db->getResult($chk123);
		$numrows = $db->rowCount();
		if ($numrows > 0) {


			$token1 = openssl_random_pseudo_bytes(16);
			$token = bin2hex($token1);

			$admin_id = $result['admin_id'];
			//This is tha token in admin id
			setcookie("admin_id", $token, time() + (21600 * 30), "/");
			setcookie("user_name", $result['user_name'], time() + (21600 * 30), "/");
			setcookie("full_name", $result['name'], time() + (21600 * 30), "/");
			setcookie("hotel_id", $result['hotel_id'], time() + (21600 * 30), "/");
			setcookie("user_type", $result['user_type_hai'], time() + (21600 * 30), "/");
			setcookie("previleges", $result['previleges'], time() + (21600 * 30), "/");

			$ip_address = $_SERVER['REMOTE_ADDR'];
			$upqr = $db->execute("UPDATE admin_login SET ip_address = '" . $ip_address . "' , last_login='$current_date', token = '" . $token . "' WHERE admin_id='" . $admin_id . "'");
			//echo "INSERT INTO login_history(`admin_id`, `ip_address`, `last_login`) VALUES('$admin_id','$ip_address','$current_date')";die;
			$db->execute("INSERT INTO login_history(`admin_id`, `ip_address`, `last_login`) VALUES('$admin_id','$ip_address','$current_date')");
			$login_h_id = $db->LastId();
			setcookie("login_h_id", $login_h_id, time() + (21600 * 30), "/");
			/*if(isset($_POST['remember_me'])){ // if user check the remember me checkbox
		        $year = time()+31556926;
		        setcookie('username', $formData['username'], $year);
		        setcookie('password', $formData['password'], $year);
		    } else { // if user not check the remember me checkbox
		        $year = time()+31556926;
		        setcookie('username', '', $year);
		        setcookie('password', '', $year);
		    }*/
			header("Location:entry/room_view.php");
			exit();
		} else {

			$msg = "Invalid! User Name / Password.";
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title>Check In Room Login Pannel</title>
	<!--Custom Theme files-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description"
		content="Call Us on +91-9999331194 to book Paharganj Budget Hotel at best offered price,New Delhi Hotels at lowest price , highly recommended by Lonely Planet. special offers Hotel in delhi,Lowest Price Guaranteed Hotel in Paharganj.">
	<meta name="keywords"
		content="Budget Hotel In Paharganj, Cheap Hotels In delhi,3 Star Hotels In Delhi, Delhi Hotels,Budget Hotel">

	<!-- Custom Theme files -->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!--web-fonts-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" async>
	<style type="text/css">
		select#soflow,
		select#soflow-color {
			-webkit-appearance: button;
			-webkit-border-radius: 2px;
			-webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
			-webkit-padding-end: 20px;
			-webkit-padding-start: 2px;
			-webkit-user-select: none;
			background-position: 97% center;
			background-repeat: no-repeat;
			border: 1px solid #AAA;
			color: #555;
			font-size: inherit;
			margin: 20px;
			overflow: hidden;
			padding: 5px 10px;
			text-overflow: ellipsis;
			white-space: nowrap;
			width: 300px;
		}

		select#soflow-color {
			color: #fff;
			background-color: #779126;
			-webkit-border-radius: 20px;
			-moz-border-radius: 20px;
			border-radius: 20px;
			padding-left: 15px;
		}

		input[type="text"] {
			display: block;
			margin: 20px;
			width: 300px;
			font-family: sans-serif;
			font-size: 18px;
			appearance: none;
			box-shadow: none;
			border-radius: none;
			padding: 5px 10px;
		}

		input[type="text"]:focus {
			outline: none;
		}
	</style>
	<!--Modal forgot pass-->

</head>


<body>
	<!-- main -->
	<div class="main">
		<h1 style="font-family:'Jacques Francois Shadow';color:white;">Check In Room Login Pannel</h1>
		<div class="login-form">
			<div class="login-left">
				<div class="logo">
					<img src="images/img1.jpg" alt="" />
					<h2>Welcome To</h2>
					<p>Check In Room</p>
				</div>
				<div class="social-icons">
					<ul>
						<li><a href="https://www.facebook.com/www.checkinroom.in/" target="_blank"><img src="images/i1.png"
									alt="" /></a></li>
						<li><a href="https://twitter.com/room_check" target="_blank" class="twt"><img src="images/i2.png"
									alt="" /></a></li>
					</ul>
				</div>
			</div>
			<div class="login-right">
				<div class="sap_tabs">
					<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
						<ul class="resp-tabs-list">
							<li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span>Welcome To Check In Room</span><img
									width="35px;" height="20px;" src="line.png" title=""></td>&nbsp; <a target="_blank"
									href="http://app.axisrooms.com/accounts/checkInRoomLogin.html">Axis Rooms</a></li>

						</ul>
						<div class="resp-tabs-container">
							<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
								<div class="login-top">
									<?php if (isset($msg)) { ?>
										<span style="color:red;"><?php echo $msg; ?></span>
									<?php } ?>
									<form method="post" action="#" name="login_form" id="login_form">
										<input type="text" class="email" name="username" id="username"
											value="<?php if (isset($_COOKIES['username'])) echo $_COOKIES['username']; ?>"
											placeholder="Username" required />
										<input type="password" class="password" name="password" id="password"
											value="<?php if (isset($_COOKIES['password'])) echo $_COOKIES['password']; ?>"
											placeholder="Password" required />
										<input type="hidden" name="token" id="token" value="<?php if (isset($token)) echo $token; ?>">
										<div style="margin-top:49px;" class="login-bottom login-bottom1">
											<div class="submit">
												<input type="submit" value="LOGIN" name="login" id="login" />
											</div>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a style="padding: 8px 12px!important;background-color: #0e3070;border-color: #0e3070;"
												type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Forgotten
												your password?</a>
										</div>
										<p>&nbsp;</p>
									</form>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="clear"> </div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Forgot Your password?</h4>
				</div>
				<div class="modal-body">
					<span class="mess"></span>
					<form method="post" action="#" name="login_form" id="login_form">
						<label style="padding-left:20px;">E-mail ID</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input style="width:300px;padding: 5px 5px 5px 5px;" type="text" placeholder="Enter your E-mail ID"
							class="password" name="email" id="email" value="" required />


						<div class="submit" style="padding-left:20px;">
							<input style="padding:5px 17px 5px 16px;" type="button" value="Submit" name="forgot" id="forgot" />
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!--//main -->
	<div class="copyright">
		<p> &copy; 2015 <strong>Check In Room </strong>. All rights reserved | Design by : <a
				href="http://digitalindiawebsolutions.com/" target="_blank"><strong>Digital India Web Solutions</strong></a></p>
	</div>
</body>

</html>

<!--js-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" async></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" async></script>
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="entry/js/formvalidation.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#horizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true // 100% fit in a container
		});
	});
	$("#forgot").click(function() {
		var email = $("#email").val();
		$.ajax({
			url: 'forgot_password.php?email=' + email,
			success: function(res) {
				if (res == 0) {
					$('.mess').html(
						'<div class="alert alert-success">Password reset link has been sent to your registered E-mail ID please check your email.</div>'
					);
					$("#email").val('');
				} else {
					$('.mess').html('<div class="alert alert-danger">Please enter your valid E-mail ID .</div>');
				}
			}
		});
	});
	$("#login").click(function(e) {
		var username = $('#username');
		var password = $('#password');

		if (!username.val()) {
			$('#username').css("border", "1px solid red");
			$('#username').focus();
			e.preventDefault();
		}

		if (!password.val()) {
			$('#password').css("border", "1px solid red");
			$('#password').focus();
			e.preventDefault();
		}

		$("#username").click(function() {
			$("#username").css("border", " ");
		});
		$("#password").click(function() {
			$("#password").css("border", " ");
		});
	});
</script>