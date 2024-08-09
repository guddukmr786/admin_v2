<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
if(isset($_GET['room_number'])){
	$room_number = $_GET['room_number'];
	$checkin_id = $_SESSION['checkin_id'];
	$result = $obj->roomTranserferProcess($checkin_id, $room_number, $hotel_id);
	echo $result;
}

?>