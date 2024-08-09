<?php 
include_once('../include/config.php');
class InsertDataClass {
	
	function __construct()
	{
		$this->db = new Database();
	}

	public function updateCirHotlesDetails(){
		
		$name = $_POST['h_name'];
		$email = isset($_POST['email']) ? $_POST['email'] : false;
		$contact = $_POST['contact'];
		$address1 = $_POST['address1'];
		$address2 = isset($_POST['address2']) ? $_POST['address2'] : false;
		$star = isset($_POST['star']) ? $_POST['star'] : false;
		$id = $_POST['id'];
		
		if($name != "" && $contact != "" && $address1 != "" ){

			if(!empty($id) && $id != ""){
				//`hotel_id`, `hotel_name`, `hotel_email`, `hotel_phone`, `hotel_address`, `hotel_address1`, `hotel_star`, `status`, `added_date`
				$query = "UPDATE hotels SET hotel_name = '$name', hotel_email = '$email',hotel_phone = '$contact', hotel_address = '$address1', hotel_address1 = '$address2', hotel_star = '$star' WHERE hotel_id = '$id'";
				$this->db->execute($query);
				echo 2;

			}else{

				$query = "INSERT INTO hotels(`hotel_name`, `hotel_email`, `hotel_phone`, `hotel_address`, `hotel_address1`, `hotel_star`) VALUES('$name','$email','$contact','$address1','$address2','$star'";
				$this->db->execute($query);
				echo 0;
			}
		}else{
			echo 1;
		}
	}
}


?>