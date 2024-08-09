<?php 
require_once('../include/config.php');
$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];
/*if(isset($_GET['type']) && $_GET['type'] == "delete_daybook"){
	$ids = $_POST['id'];
	foreach ($ids as $id) {
		$del_query = "DELETE FROM taxi_gallery WHERE taxi_gallery_id = '$id'";
		$db->execute($del_query);
	}
	return 0;	
}*/

if(isset($_GET['type']) && $_GET['type'] == "delete_daybook"){
	$id = $_GET['id'];
	$del_query = "DELETE FROM day_book_entry WHERE day_b_id = '$id'";
	$db->execute($del_query);
	return 0;	
}
if(isset($_GET['type']) && $_GET['type'] == "delete_employee_details"){
	$id = $_GET['id'];
	$del_query = "DELETE FROM employees WHERE employee_id = '$id' AND hotel_id = '$hotel_id'";
	$db->execute($del_query);

	$ids_query = $db->execute("SELECT * FROM employee_ids WHERE employee_id = '$id' AND hotel_id = '$hotel_id'");
	$row_count = $db->rowCount($ids_query);
	$results = $db->getResults($ids_query);
	if( $row_count > 0 ){
		$destination = 'upload/employees_ids/';
		foreach ($results as $result) {
			$del_img = $destination.$result['images'];
			unlink($del_img);
		}
		$id_Del = "DELETE FROM employee_ids WHERE employee_id = '$id' AND hotel_id = '$hotel_id'";
		$db->execute($id_Del);
	}
	return 0;	
}

if(isset($_GET['type']) && $_GET['type'] == "delete_travel"){
	$id = $_GET['id'];
	$del_query = "DELETE FROM travel_details WHERE id = '$id'";
	$db->execute($del_query);
	return 0;	
}

if(isset($_GET['type']) && $_GET['type'] == "delete_party"){
	$id = $_GET['id'];
	$del_query = "DELETE FROM booking_via WHERE booking_via_id = '$id'";
	$db->execute($del_query);
	return 0;
}
if(isset($_GET['type']) && $_GET['type'] == "delete_invoice"){
	$id = $_GET['id'];
	$del_query = "DELETE FROM invoice_details WHERE travel_id = '$id'";
	$db->execute($del_query);
	return 0;	
}

if(isset($_GET['type']) && $_GET['type'] == "delete_hotel"){
	$id = $_GET['id'];
	$del_query = "DELETE FROM hotel_details WHERE hotel_details_id = '$id'";
	$db->execute($del_query);
	return 0;	
}
?>