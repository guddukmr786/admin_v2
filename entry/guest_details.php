<?php 
require_once '../include/config.php';
$db = new Database();

if(isset($_GET['bid'])){
	$bid = $_GET['bid'];
	$query = $db->execute("SELECT * FROM check_in_details WHERE booking_id = '$bid' limit 1");
	$result = $db->getResult($query);
	echo json_encode($result);
}
?>