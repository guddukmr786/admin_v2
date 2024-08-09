<?php 
echo "hi";die;
include_once('../include/config.php');
$db = new Database();
if(isset($_GET['cid'])){
	$id = $_POST['id'];
	echo $id;die;
	if(!empty($id)){
		$fcdate = $_POST['final_checkout'];

		$query = $db->execute("UPDATE check_in_details SET final_checkout_date = '$fcdate' WHERE checkin_id='$id'");
		$query = $db->execute("UPDATE guest_checkin_history SET final_checkout_date = '$fcdate' WHERE checkin_id='$id'");
		echo 0;

	}else{
		echo 1;
	}
		
}
?>