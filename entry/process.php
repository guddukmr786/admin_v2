<?php 
include_once('../lib/update_values.php');
$obj = new UpdateValues();
if(isset($_GET['type']) && $_GET['type'] == 'cancelled'){
	$id = $_GET['id'];
	$type = $_GET['type'];
	$call_function = $obj->updateStatus($id, $type);
}

if(isset($_GET['type']) && $_GET['type'] == 'checkedin'){
	$id = $_GET['id'];
	$type = $_GET['type'];
	$call_function = $obj->updateStatus($id, $type);
}

if(isset($_GET['type']) && $_GET['type'] == 'checkDuplicateBookingID'){
	$booking_id = $_GET['booking_id'];
	$booking = $obj->getDuplicateBookingId($booking_id);
}
if(isset($_GET['type']) && $_GET['type'] ="arrival_booking_check_status"){
	$booking_id = $_GET['booking_id'];
	$obj->getCheckedinStatusByBookingId($booking_id); 
}
?>