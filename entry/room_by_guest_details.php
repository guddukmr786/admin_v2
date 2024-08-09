<?php 
include_once("../include/config.php");
$obj = new Database();
$room_number = $_GET['room'];
$hotel_id = $_COOKIE['hotel_id'];
$query = "SELECT *  FROM check_in_details WHERE room_number = '$room_number' AND hotel_id = '$hotel_id' AND status=0";
//echo $query;die;
$query_exe = $obj->execute($query);
$result = $obj->getResult($query_exe);

echo 

'<div class="details" style="border:1px dotted">
	<div class="data">
	  	<h4> Guest Details of Room Number ';?><?php echo $room_number;?><?php echo '</h4>
	  	<hr>
        <h3>';?><?php echo $result['name'];?><?php echo '</h3>
        <p><strong>Email  :  </strong>';?> <?php echo $result['email'];?><?php echo '</p>
        <p><strong>Phone  : </strong> ';?><?php echo $result['phone'];?><?php echo '</p>
        <p><strong>Check-in Date: </strong>';?><?php $date_m = date_format( new DateTime($result['inserted_date']), 'd M Y, D H:i A' ); echo $date_m;?><?php echo '</p>
        <p><strong>Check-out Date: </strong>';?><?php echo $result['checkout_date'];?><?php echo '</p>
	  	<p class="btn_add" style="padding-right:72px;">
			<a href="bill.php?checkin_id=';?><?php echo $result["checkin_id"];?><?php echo '"><i class="fa fa-eye">&nbsp;</i>View Bill</a>
			<a href="bill.php?checkin_id=';?><?php echo $result["checkin_id"];?><?php echo '"><i class="fa fa-sign-out">&nbsp;</i>Checkout</a>
			<a href="add_summary.php?checkin_id=';?><?php echo $result["checkin_id"];?><?php echo '"><i class="fa fa-pencil">&nbsp;</i>Add Room Summary</a>
		</p>
	</div>
</div>';?>