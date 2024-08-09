<?php 
include_once('../include/config.php');
$db = new Database();
$hotel_id = $COOKIE['hotel_id'];
if(isset($_GET['booking_id'])){
	$booking_id = $_GET['booking_id'];

	$query = $db->execute("SELECT * FROM arrival_booking_history WHERE booking_id = '$booking_id' AND hotel_id = '$hotel_id'");
	$results = $db->getResult($query);
	echo json_encode($results);
}
?>