<?php 
include_once('../include/header.php');
include('is_login.php');
if(isset($_GET['id'])){
	$checkin_id = $_GET['id'];
	$view_extends = $obj->getViewExtendedCheckinDays($checkin_id, $hotel_id);
	//print_r($view_extends);die;
}
?>
<!-- popup form #3 --> 
<div class="content">
	<div class="form-wizard">
		<div class="row">
			<div class="col-md-12 col-sm-7">
				<div class="data-container">
		         	<h3 class="heading">Extended Checkin date details</h3>
		         	<?php foreach ($view_extends as $view_extend) { ?>
						<dl>
							<dt>Booking Via</dt>
							<dd><?php echo $view_extend['booking_via']?></dd>
						</dl>
						<dl>
							<dt>Booking ID</dt>
							<dd><?php echo $view_extend['booking_id']?></dd>
						</dl>
						<dl>
							<dt>Check In Date</dt>
							<dd> <?php echo $view_extend['checkin_date']?> </dd>
						</dl>
						<dl>
							<dt>Check Out Date</dt>
							<dd><?php echo $view_extend['checkout_date']?></dd>
						</dl>
						<dl>
							<dt>Extended Days</dt>
							<dd><?php echo $view_extend['booking_nights']?></dd>
						</dl>
						<dl>
							<dt>Booking Amount</dt>
							<dd><?php echo $view_extend['booking_amount']?></dd>
						</dl>
						<hr style="height:1px;border:none;color:#333;background-color:#333;">
					<?php } ?>
				</div><!--/ .data-container-->
			</div>
		</div><!--/ .row-->
	</div>
</div>  
