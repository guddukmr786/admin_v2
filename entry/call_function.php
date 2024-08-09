<?php 
include('insert_data_class.php');
$obj = new InsertDataClass();

if(isset($_GET['type']) && $_GET['type'] == "cir_hotel_details"){
	$result = $obj->updateCirHotlesDetails();
}
?>