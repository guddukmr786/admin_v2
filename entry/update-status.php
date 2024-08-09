<?php 
include_once('../include/config.php');
$db = new Database();
if( isset( $_GET['status'] ) && isset( $_GET['type'] ) && $_GET['type'] == 'employee' ) {
	$status = $_GET['status'];
	$id = $_GET['id'];
	$query = $db->execute( "UPDATE employees SET status = '$status' WHERE employee_id = '$id'" );
	echo 0;
} elseif( isset( $_GET['status'] ) && isset($_GET['type']) && $_GET['type'] == 'hotels' ) {
	$status = $_GET['status'];
	$id = $_GET['id'];
	$query = $db->execute( "UPDATE hotels SET status='$status' WHERE hotel_id = '$id'" );
	echo 0;
}elseif( isset( $_GET['status'] ) ) {
	$status = $_GET['status'];
	$id = $_GET['id'];
	$query = $db->execute( "UPDATE admin_login SET status='$status' WHERE admin_id = '$id'" );
	echo 0;
}
?>