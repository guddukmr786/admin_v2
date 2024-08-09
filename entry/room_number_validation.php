<?php 
include_once('../include/config.php');
$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];
if(isset($_GET['roomno'])){
	$roomno = $_GET['roomno'];
	$query_room = "SELECT * FROM room_details WHERE room_number = '$roomno' AND room_status = 'empty' AND hotel_id = '$hotel_id' LIMIT 1";
	$execute = $db->execute($query_room);
	$result = $db->rowCount($execute);
	if($result > 0){
		echo 0;die;
	}else{
		echo 1;die;
	}

}
?>