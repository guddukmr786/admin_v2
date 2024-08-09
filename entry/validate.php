<?php 
if(isset($_GET['email'])){
	$email = $_GET['email'];
	if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
 		echo 1;
	} else {
 		echo 0;
 	}
}

if(isset($_GET['phone'])){
	$phone = $_GET['phone'];
	$length = strlen($phone);
	if(!preg_match("/^[1-9,][0-9,]*$/", $phone)){
		echo 1;
	}else{
		echo 0;
	}
	
}
?>