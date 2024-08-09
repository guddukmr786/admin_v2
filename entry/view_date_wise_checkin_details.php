<?php 
include_once('../include/header.php');

include('is_login.php');

if(!empty($_GET['checkin_id'])){
	$checkin_id = $_GET['checkin_id'];
	$date_checkin_details = $obj->getDateWiseCheckinDetailsListById($checkin_id, $hotel_id);
	
}
?>
<div class="content">

	<p class="btn_add">
		<a href="date_wise_checkin_details.php" ><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Go Back</a>
	</p>
	<div class="col-md-6"><h4><span class="clr_red">Booking Date :&nbsp;</span> <?php $date_m = date_format( new DateTime($date_checkin_details['inserted_date']), 'd-M-Y, D H:i A' ); echo $date_m;?></h4></div>

	<div class="form-wizard">
		<div class="row">
			<div class="col-md-8 col-sm-7">
				<div class="data-container">
					<span id="error"></span>
					
					<h3 class="heading">Guest Checked In History</h3>
					<dl>
						<dt>Serial Number</dt>
						<dd><?php echo $date_checkin_details['serial_number'];?></dd>
					</dl>
					<dl>
						<dt>Full Name</dt>
						<dd><?php echo $date_checkin_details['name'];?></dd>
					</dl>
					<?php if(!empty($date_checkin_details['son_of'])) { ?>
					<dl>
						<dt>Father Name</dt>
						<dd><?php echo $date_checkin_details['son_of'];?></dd>
					</dl>
					<?php } ?>
					<dl>
						<dt>Email Id</dt>
						<dd><?php echo $date_checkin_details['email'];?></dd>
					</dl>
					<dl>
						<dt>Phone No</dt>
						<dd><?php echo $date_checkin_details['phone'];?></dd>
					</dl>
					<dl>
						<dt>Country</dt>
						<dd><?php echo $date_checkin_details['country'];?></dd>
					</dl>
					<dl>
						<dt>State</dt>
						<dd><?php echo $date_checkin_details['state'];?></dd>
					</dl>
					<dl>
						<dt>Last Location</dt>
						<dd><?php echo $date_checkin_details['last_location'];?></dd>
					</dl>
					<?php if(!empty($date_checkin_details['next_location'])) { ?>
					<dl>
						<dt>Next Location</dt>
						<dd><?php echo $date_checkin_details['next_location'];?></dd>
					</dl>
					<?php } ?>
					<dl>
						<dt>Purpouse</dt>
						<dd><?php echo $date_checkin_details['purpouse'];?></dd>
					</dl>
					<dl>
						<dt>Booking Via</dt>
						<dd><?php echo $date_checkin_details['booking_via'];?></dd>
					</dl>
					<dl>
						<dt>Booking ID</dt>
						<dd><?php echo $date_checkin_details['booking_id'];?></dd>
					</dl>
					
					<dl>
						<dt>Booking Amount</dt>
						<dd><?php echo $date_checkin_details['booking_amount'];?> Rs.</dd>
					</dl>
					
					<dl>
						<dt>Check In Date</dt>
						<dd><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$date_checkin_details['checkin_date'])));?></dd>
					</dl>
					<dl>
						<dt>Check Out Date</dt>
						<dd><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$date_checkin_details['checkout_date'])));?></dd>
					</dl>
					<?php if($date_checkin_details['final_checkout_date'] != '0000-00-00 00:00:00' ) { ?>
					<dl>
						<dt>Final Check Out Date</dt>
						<dd><?php echo date('d M, Y, D H:i A',strtotime($date_checkin_details['final_checkout_date']));?></dd>
					</dl>
					<?php } ?>
					<dl>
						<dt>Number of nights</dt>
						<dd><?php echo $date_checkin_details['booking_nights'];?></dd>
					</dl>
					<dl>
						<dt>Number of Guest</dt>
						<dd><?php echo $date_checkin_details['no_of_person'];?></dd>
					</dl>
					<dl>
						<dt>Room Number</dt>
						<dd><?php echo $date_checkin_details['room_number'];?></dd>
					</dl>
					<dl>
						<dt>Meal Plan</dt>
						<dd><?php echo $date_checkin_details['meal_plan'];?></dd>
					</dl>
					<dl>
						<dt>Checked In By</dt>
						<dd><?php echo $date_checkin_details['inserted_by'];?></dd>
					</dl>
					<?php if(!empty($date_checkin_details['checkout_by'])) { ?>
					<dl>
						<dt>Check Out By</dt>
						<dd><?php echo $date_checkin_details['checkout_by'];?></dd>
					</dl>
					<?php } ?>
					
				</div><!--/ .data-container-->
			</div>
		</div><!--/ .row-->
	</div>

	<!--Hotel transfer modal-->
	<a href="#select_hotel" class="overlay" id="select_hotel"></a>
	<div class="popup1"> 
	</div>
</div>

<?php include('../include/footer.php');?>

<script>
$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});
</script>
</body>
</html>

