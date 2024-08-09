<?php 
include('../lib/fetch_values.php'); 
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];

if(isset($_GET['room_number']) && isset($_GET['type']) && $_GET['type'] == "add_summary"){
	$room_number = $_GET['room_number'];
	$results = $obj->getRoomGuestDetails($room_number, $hotel_id);
	if(is_array($results)){
		echo 0;
	}else{
		echo 1;
	}
}
if(isset($_GET['room_number']) && isset($_GET['type']) && $_GET['type'] == "view_summary"){
	$room_number = $_GET['room_number'];
	$results = $obj->getRoomGuestDetails($room_number, $hotel_id);
	if(is_array($results)){
		echo 2;
	}else{
		echo 3;
	}
}

?>