<?php
require_once '../include/config.php';
$db = new Database();
$msg="";

if($_REQUEST['chage_pass'])
{
	if($_POST['old_pass'] == "" || $_POST['new_pass'] == "" || $_POST['conf_pass'] == "")
	{
		$_SESSION['error_msg']="All Field are Require!";
		header('Location:change_pass.php');
	}
	else
	{
		$pass = md5($_POST['old_pass']);
		
		$newpass = $_POST['new_pass'];
		
		$cnfpass = $_POST['conf_pass'];	
		
		$id= $_COOKIE['admin_id'];
		
		$query=$db->execute("SELECT * FROM admin_login WHERE token='$id'");
		$query_data=$db->getResult($query);
		$passdb=$query_data['password'];
		
		if( $pass != $passdb ) {

			$_SESSION['error_msg']="Old password is wrong!";
			header('Location:change_pass.php'); 
		} elseif ( $newpass != $cnfpass ) {

			$_SESSION['error_msg']="New password and confirm password are doesn't matching!";
			header('Location:change_pass.php');
		} else {	
			
			$password = md5($newpass);
			$db->execute("UPDATE admin_login SET password='".$password."' WHERE token='$id'");
			$_SESSION['msg']="Password changed successfully!";
			header('Location:change_pass.php');
		}
	}
}

?>