<?php 
require '../include/config.php';

class UpdateValues
{
	private $db;
	private $id;
	private $type;
	function __construct()
	{
		$this->db = new Database();
	}

	public function updateStatus($id, $type){
		$this->id = $id;
		$this->type = $type;
		$query = "UPDATE arrival_booking_history SET booking_status = '$type' WHERE arrival_b_id ='$id'";
		$execute = $this->db->execute($query);
		echo 0;die;
	}

	public function getDuplicateBookingId($id){
		$hotel_id = $_COOKIE['hotel_id'];
		$this->id = $id;
		$query = "SELECT * FROM arrival_booking_history WHERE booking_id ='$id' AND hotel_id = '$hotel_id'";
		$execute = $this->db->execute($query);
		$num_rows = $this->db->rowCount();
		if($num_rows > 0){ 
			echo 0;die;
		} else {
			echo 1;die;
		}
	}
	//for updation stataus of checked
	public function getCheckedinStatusByBookingId($id){
		$this->id = $id;
		$current_date = CURR_DATE;
		$query = "UPDATE arrival_booking_history SET booking_status='checkedin' WHERE booking_id ='$id' AND checkin_date='$current_date'";
		$execute = $this->db->execute($query);
		$affted = $this->db->affectedRows($execute);
		if($affted > 0){ 
			echo 0;die;
		} else {
			echo 1;die;
		}
	}

	
}
?>