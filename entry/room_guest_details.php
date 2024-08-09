<?php 
include('../include/header2.php');

include('is_login.php');

$destination = 'upload/checkinimages/';
$booking_vias = $obj->getAllBookingViaCategories();
if(isset($_GET['room_number'])){
	$room_number = $_GET['room_number'];
	$room_guest_details = $obj->getRoomGuestDetails($room_number, $hotel_id);
	$checkin_id = $_SESSION['checkin_id'] = $room_guest_details['checkin_id'];
	$checkin_date = $room_guest_details['checkin_date'];
	$checkin_ids = $obj->getCheckinIdsById($checkin_id);

	$extend_books = $obj->getExtendedBookingDetails($checkin_id, $hotel_id);

	$guest_name = $obj->getAllGuestName($checkin_id);
}

?>
<div class="content">
<div class="col-md-6"><h4><span class="clr_red">Customer Name :&nbsp;</span> <?php echo $room_guest_details['name'];?></h4></div>
<div class="col-md-6"><h4><span class="clr_red">Booking ID :&nbsp;</span> <?php echo $room_guest_details['booking_id'];?></h4></div>
<div class="col-md-6"><h4><span class="clr_red">Booking Date :&nbsp;</span> <?php $date_m = date_format( new DateTime($room_guest_details['inserted_date']), 'd M Y, D H:i A' ); echo $date_m;?></h4></div>
	<hr>
	<p class="btn_add">
		<a href="bill.php?checkin_id=<?php echo $room_guest_details['checkin_id'];?>" ><i class="fa fa-eye">&nbsp;</i>View Bill</a>
		<a href="bill.php?checkin_id=<?php echo $room_guest_details['checkin_id'];?>"><i class="fa fa-sign-out">&nbsp;</i>Checkout</a>
		<!--<a href="#"><i class="fa fa-print">&nbsp;</i>Print</a>-->
		<a href="add_summary.php?checkin_id=<?php echo $room_guest_details['checkin_id'];?>" ><i class="fa fa-pencil">&nbsp;</i>Add Room Summary</a>
		<a href="index.php?type=update&checkin_id=<?php echo $room_guest_details['checkin_id'];?>&room_number=<?php echo $room_number;?>" ><i class="fa fa-pencil">&nbsp;</i>Update Details</a> 
	</p>
	<div class="form-wizard">
		<div class="row">
			<div class="col-md-12 col-sm-7">
				<?php /* if(isset($_SESSION['extend_msg'])){?>
				<span style="color:green;font-weight:bold"><?php echo $_SESSION['extend_msg'];unset($_SESSION['extend_msg']);?></span>
				<?php } elseif (isset($_SESSION['extend_erro_msg'])) { ?>
				<span style="color:red;font-weight:bold"><?php echo $_SESSION['extend_erro_msg'];unset($_SESSION['extend_erro_msg']);?></span>
				<?php } */ ?>
				<div class="data-container">
					<h3 class="heading">Customer Personal Information</h3>
					<dl>
						<dt>R. Serial Number</dt>
						<dd><?php echo $room_guest_details['serial_number'];?></dd>
					</dl>
					<dl>
						<dt>Name</dt>
						<?php if(isset($guest_name['name'])){ ?>
						<dd><?php echo $room_guest_details['name'];?>&nbsp;&nbsp;&nbsp;<a href="#guestname" style="text-decoration:none;font-weight:600;font-size:15px;" data-toggle="modalguestname" id="<?php echo $room_guest_details['checkin_date'];?>">View all Guest Name</a></dd>
						<?php } else { ?>
						<dd><?php echo $room_guest_details['name'];?>
						<?php } ?>
					</dl>
					<dl> 
						<dt>Gender</dt>
						<dd><?php echo $room_guest_details['gender'];?></dd>
					</dl>
					<dl>
						<dt>Email Id</dt>
						<dd><?php echo $room_guest_details['email'];?></dd>
					</dl>
					<dl>
						<dt>Phone No</dt>
						<dd><?php echo $room_guest_details['phone'];?></dd>
					</dl>
					<dl>
						<dt>Country</dt>
						<dd><?php echo $room_guest_details['country'];?></dd>
					</dl>
					<dl>
						<dt>City</dt>
						<dd><?php echo $room_guest_details['state'];?></dd>
					</dl>
					<?php /*?><dl>
						<dt>Pin Code</dt>
						<dd><?php echo $room_guest_details['pincode'];?></dd>
					</dl>
					
					<dl>
						<dt>Date of Birth</dt>
						<dd><?php echo $room_guest_details['date_of_birth'];?></dd>
					</dl><?php */?>
					<dl>
						<dt>Coming From </dt>
						<dd><?php echo $room_guest_details['last_location'];?></dd>
					</dl>
					<dl>
						<dt>Next Location</dt>
						<dd><?php echo $room_guest_details['next_location'];?></dd>
					</dl>
					<?php if(!empty($room_guest_details['passport_number'])){ ?>
					<dl>
						<dt>Passport No</dt>
						<dd><?php echo $room_guest_details['passport_number'];?></dd>
					</dl>
					<?php } if(!empty($room_guest_details['pass_expiry_date'])){ ?>
					<dl>
						<dt>Passport Valid upto</dt>
						<dd><?php echo $room_guest_details['pass_expiry_date'];?></dd>
					</dl>
					<?php } if(!empty($room_guest_details['visa_number'])){ ?>
					<dl>
						<dt>Visa No</dt>
						<dd><?php echo $room_guest_details['visa_number'];?></dd>
					</dl>
					<?php } if(!empty($room_guest_details['visa_expiry_date'])){ ?>
					<dl>
						<dt>Visa Valid upto</dt>
						<dd><?php echo $room_guest_details['visa_expiry_date'];?></dd>
					</dl>
					<?php } ?>
					<?php /*?><dl>
						<dt>Address</dt>
						<dd><?php echo $room_guest_details['address'];?></dd>
					</dl><?php */?>
					<dl>
						<dt>Document's</dt>
						<dd>
							<?php foreach ($checkin_ids as $document) { ?>
							<a target="_blank" href="<?php echo $destination.$document['id_proof'];?>"><img src="<?php echo $destination.$document['id_proof'];?>" style="height:50px!important; widht:100px!important;"></a>
							<?php } ?>
						</dd>
					</dl>
					
					<h3 class="heading">Customer Booking Information</h3>
					<dl>
						<dt>Booking Via</dt>
						<dd><?php echo $room_guest_details['compnay_name'];?></dd>
					</dl>
					<dl>
						<dt>Booking ID</dt>
						<dd><?php echo $room_guest_details['booking_id'];?></dd>
					</dl>
					<dl>
						<dt>Check In Date</dt>
						<dd><?php echo $room_guest_details['checkin_date'];?></dd>
					</dl>

					<?php if( isset($extend_books['c_date']) ) { ?>
					<dl>
						<dt>Check Out Date</dt>
						<dd><?php echo $extend_books['c_date'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="text-decoration:none;font-weight:600;font-size:15px" href="view_extended_days.php?id=<?php echo $checkin_id;?>"><i class="fa fa-pencil">&nbsp;</i>Extended</a></dd>
					</dl>
					<?php } else { ?>
					<dl>
						<dt>Check Out Date</dt>
						<dd><?php echo $room_guest_details['checkout_date'];?></dd>
					</dl>
					<?php } ?>

					<dl>
						<dt>Booking Days</dt>
						<dd><?php  echo $room_guest_details['booking_nights'];?></dd>
					</dl>

					<dl>
						<dt>Extended Days</dt>
						<dd><?php echo $room_guest_details['extended_days'];?></dd>
					</dl>

					<dl>
						<dt>Room Number</dt>
						<dd><?php echo $room_guest_details['room_number'];?></dd>
					</dl>

					<dl>
						<dt>Persons</dt>
						<dd><?php echo $room_guest_details['no_of_person'];?> (Adult/child)</dd>
					</dl>
					<dl>
						<dt>Booking Amount</dt>
						<dd><?php echo $room_guest_details['booking_amount'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Extra Adult Charges</dt>
						<dd><?php echo $room_guest_details['charge_per_adult'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Meal Plan</dt>
						<dd><?php echo $room_guest_details['meal_plan'];?></dd>
					</dl>
					<dl>
						<dt>Checked-in By</dt>
						<dd><?php echo $room_guest_details['inserted_by'];?></dd>
					</dl>
				</div><!--/ .data-container--> 
			</div>
		</div><!--/ .row-->
		
	</div>
	<p class="btn_add">
		<?php if(empty($room_guest_details)){ ?>
		<a href="room_view.php?room_status=empty&room_number=<?php echo $room_number;?>" ><i class="fa fa-pencil">&nbsp;</i>Clean your room</a> 
		<?php } ?>
		
		<?php if( isset($extend_books['c_date']) ) { ?>
		<a href="view_extended_days.php?id=<?php echo $checkin_id;?>"><i class="fa fa-pencil">&nbsp;</i>View Extended booking day's</a> 
		<?php } ?>
		<a href="#extend" data-toggle="modal" id="<?php echo $checkin_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Extend Booking day's</a>
		<a href="#transfer" data-target="#myModal2" data-toggle="modaltransfer" id="<?php echo $checkin_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Transfer Room</a>
	</p>
	
	<a href="#x" class="overlay" id="view_extended"></a>
	<div class="popup">
	<!-- view extended details modal here-->
	
	</div>


	<a href="#x" class="overlay" id="guestname"></a>
	<div class="popup">
	<!-- view all guest name modal here-->
	
	</div>

	<a href="#x" class="overlay" id="extend"></a>
	<div class="popup3"> 
		<h3 class="text-center">Extend Booking Day's</h3>
			<span id="error" style="color:red;font-weight:bold;"></span>
			<span id="messsage"></span>
			<form class="idealforms" id="extend_form" enctype="multipart/form-data" role="form" name="extend_form" autocomplete="on">
			
				<div class="field">
					<label class="main">Booking Via<span style="color:red;"> * </span>:</label>
					<select name="booking_via" id="selectt" class="booking_via">
						<option value="">Select an booking via</option>
						<?php 
						foreach ($booking_vias as $booking_via) {
							if(isset($_SESSION['booking_via'])){
						?>
						<option value="<?php echo $booking_via['booking_via_id'];?>"<?php if($booking_via['booking_via_id'] == $_SESSION['booking_via']) echo 'selected="selected"' ;?>><?php echo $booking_via['category_name'];?></option>
						<?php } elseif (isset($update_booking_details['booking_via'])) { ?>
						<option value="<?php echo $booking_via['booking_via_id'];?>"<?php if($booking_via['booking_via_id'] == $update_booking_details['booking_via']) echo 'selected="selected"' ;?>><?php echo $booking_via['category_name'];?></option>
						<?php } else { ?>
						<option value="<?php echo $booking_via['booking_via_id'];?>"><?php echo $booking_via['category_name'];?></option>
						<?php } } ?>
					</select>
				</div>
				
				<div class="field">
					<label class="main">Booking ID<span style="color:red;"> * </span>:</label>
					<?php if(isset($_SESSION['bookingid'])) { ?>
					<input name="bookingid" id="bookingid" value="<?php echo $_SESSION['bookingid']; ?>" type="text" class="ipt"  placeholder="Enter Booking ID">
					<?php } else { ?>
					<input name="bookingid" id="bookingid" value="<?php if(isset($update_checkin_details['booking_id'])) echo $update_checkin_details['booking_id']; ?>" type="text" class="ipt"  placeholder="Enter Booking ID">
					<?php } ?>
				</div>
				<div class="clear"></div>

				<div class="field">
					<label class="main">Check In Date<span style="color:red;"> * </span>:</label>
					<?php if(isset($_SESSION['checkin'])){ ?>
					<input class="date-pick ipt" value="<?php echo $_SESSION['checkin'];?>" type="text" id="checkin" name="checkin" placeholder="Check In Date">
					<?php } elseif (isset($update_checkin_details['checkin_date'])) { ?>
						<input class="date-pick ipt" type="text" value="<?php echo $update_checkin_details['checkin_date']; ?>" id="checkin" name="checkin" placeholder="Check In Date">
					<?php } else { ?>
					<input class="date-pick ipt" type="text" id="checkin" name="checkin" placeholder="Check In Date">
					<?php } ?>
				</div>
				
				<div class="field">
					<label class="main">Check Out Date<span style="color:red;"> * </span>:</label>
					<?php if(isset($_SESSION['checkout'])){ ?>
					<input class="date-pick ipt" type="text" value="<?php echo $_SESSION['checkout'];?>" id="checkout" name="checkout" placeholder="Check Out Date">
					<?php } elseif (isset($update_checkin_details['checkout_date'])) { ?>
					<input class="date-pick ipt" type="text" id="checkout" value="<?php echo $update_checkin_details['checkout_date']; ?>" name="checkout" placeholder="Check Out Date">
					<?php } else { ?>
					<input class="date-pick ipt" type="text" id="checkout" name="checkout" placeholder="Check Out Date">
					<?php } ?>
				</div>
				
				<div class="field">
					<label class="main">Extended Day's<span style="color:red;"> * </span>:</label>
					<?php if(isset($_SESSION['nights'])){ ?>
					<input name="nights" id="nights" value="<?php echo $_SESSION['nights'];?>" type="number" class="ipt"  placeholder="Enter Booking Nights">
					<?php } elseif (isset($update_checkin_details['booking_nights'])) { ?>
					<input name="nights" id="nights" value="<?php echo $update_checkin_details['booking_nights']; ?>" type="number" class="ipt"  placeholder="Enter Booking Nights" >
					<?php } else { ?>
					<input name="nights" id="nights" type="number" class="ipt"  placeholder="Enter Booking Nights">
					<?php } ?>
				</div>
				<div class="field">
					<label class="main">Booking Amount:</label>
					<?php if(isset($_SESSION['b_amount'])){ ?>
					<input name="b_amount" id="b_amount" value="<?php echo $_SESSION['b_amount'];?>" type="text" class="ipt"  placeholder="Booking Amount">
					<?php } else { ?>
					<input name="b_amount" id="b_amount" value="<?php if(isset($update_checkin_details['booking_amount'])) echo $update_checkin_details['booking_amount']; ?>" type="text" class="ipt"  placeholder="Booking Amount">
					<?php } ?>
					<input type="hidden" id="checkin_id" name="checkin_id" value="<?php echo $checkin_id;?>">
				</div>
				<p>&nbsp;</p>
				<h4><input type="button" name="submitform_extendedbooking" id="submitform_extendedbooking" value="Submit" style="padding:5px 10px 5px 10px;" ></h4>
			</form>
		<a class="close" href=""></a> 
	</div>

	<a href="#x" class="overlay" id="transfer"></a>
	<div class="popup1"> 
		<h3 class="text-center">Room Transfer </h3>
			<span id="errort" style="color:red;font-weight:bold;"></span>
			<span id="messsaget" style="color:green;font-weight:bold;"></span>
			<form class="idealforms" id="extend_form" enctype="multipart/form-data" role="form" name="extend_form">
				<div class="field">
					<label class="main" style="width:175px;margin-left:120px;">Enter Room Number<span style="color:red;"> * </span>:</label>
					<input class="ipt" type="text" id="room_number" name="room_number" placeholder="Please enter room number where u want to shift" >
				</div>
				<p>&nbsp;</p>
				<h4><input type="button" name="transfer_room" id="transfer_room" value="Submit" style="padding:5px 10px 5px 10px;" ></h4>
			</form>
		<a class="close" href=""></a> 
	</div>
</div>
<?php include('../include/footer.php');?>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".popup1").on('shown.bs.modal', function(){
        $(this).find('#room_number').focus();
    });
});
</script>
<!--<script type="text/javascript">
$('a[data-toggle=modalextend]').click(function(){
	var checkin_id = $(this).attr('id');
	$.ajax({
		url : 'view_extended_days.php?checkin_id='+checkin_id,
		success:function(data){
			$('.popup').show().html(data);
		}
	});
});
</script>-->
<script type="text/javascript">
$('a[data-toggle=modalguestname]').click(function(){
	var checkin_date = $(this).attr('id');

	$.ajax({
		url : 'view_all_guest_name.php?checkin_date='+checkin_date,
		success:function(data){
			$('.popup').show().html(data);
		}
	});
});
</script>

<script type="text/javascript">
$('#transfer_room').click(function(){
	var room = $('#room_number').val();
	$.ajax({
		url : 'transfer_room.php?room_number='+room,
		success:function(data){
			if(data == 1){
				$('#errort').html('<span>Erron! Please try again later.</span>');
			} else if(data == 2){
				$('#errort').html('<span>Please enter your room number.</span>');
			} else if(data == 3){
				$('#errort').html('<span>This room is not available for transfer.</span>');
			} else if(data == 0){
				$('#errort').remove();
				$('#messsaget').html('<span>Room transfer successfully completed.<span>');
				$('#room_number').val(" ");
				setTimeout('', 1000000);
				window.location.href='room_view.php';
			}
		}
	});
});
$('a[data-toggle="modaltransfer"]').click(function(){
	$('#room_number').focus();
});
</script>
<script>
	$(document).ready(function () {
		$("#checkin").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });
		$("#checkout").datepicker({ beforeShow: setminDate });
		var start1 = $('#checkin');      
		function setminDate() {          
			var p = start1.datepicker('getDate');          
			if (p) { 
				var k ="01/30/2012";            
				return {
					minDate: p,
					maxDate:k
				}};         
			}           
			function clearEndDate(dateText, inst) {          
				end1.val('');      
			}  
		});
	$(function() {
		$( "#checkout" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
		$( "#checkin" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
	});
	$('#nights').click(function() {
		var start = $('#checkin').datepicker('getDate');
		var end   = $('#checkout').datepicker('getDate');
		var days   = (end - start)/1000/60/60/24;
		$("#nights").val(days);
	});
</script>
<script type="text/javascript">
		$('#submitform_extendedbooking').click(function(){
			var formData = $('form').serialize()
			$.ajax({
				url : 'insert_data.php?type=extend_form_data',
				type : 'POST',
				data : formData,
				cache: false,
				success:function(data){
					if(data == 'Error'){
						$('#messsage').show().html('<span id="messsage" style="color:red;font-weight:bold;text-align:center;">Error in extend booking date please try again later.</span>');
						
					}else{
						$('#messsage').show().html('<span id="messsage" style="color:green;font-weight:bold;text-align:center;">Booking date is extended.</span>');
						$('.booking_via').val(" ");
						$('#bookingid').val(" ");
						$('#checkin').val(" ");
						$('#checkout').val(" ");
						$('#nights').val(" ");
						$('#b_amount').val(" ");
					}
				}
			});
		});
	</script>
<script type="text/javascript">
	$('.booking_via,#bookingid,#checkin,#checkout,#nights,#b_amount').click(function(){
		var formData =$("#extend_form").serialize();
		$.ajax({
			type : 'POST',
			url : 'insert_data.php?type=save_formdata_extended',
			data : formData,
			success:function(data){
				
			}
		});
	});
	$('#checkin').change(function(){
		var checkin_date = $("#checkin").val();
		$.ajax({
			url : 'insert_data.php?type=duplication_checkindate',
			type : 'POST',
			data : 'checkin_date='+ checkin_date,
			success:function(data){
				//alert(data);
				if(data == 1){
					$('#messsage').html('<span id="messsage" style="color:red;font-weight:bold;text-align:center;">Checkin Date must be > '+checkin_date+'</span>');
					$('#messsage').show();
					$('#checkin').focus();
				}else if(data == 0){
					$('#messsage').hide();
				}
			}
		});
	});
	$('#checkout').change(function(){
		var checkout_date = $("#checkout").val();
		$.ajax({
			url : 'insert_data.php?type=duplication_checkoutdate',
			type : 'POST',
			data : 'checkout_date='+checkout_date,
			success:function(data) {
				if(data == 1){
					$('#messsage').html('<span id="messsage" style="color:red;font-weight:bold;text-align:center;">Checkout date must be > '+checkout_date+'</span>');
					$('#messsage').show();
					$('#checkout').focus();
				} else if(data == 0){
					$('#messsage').hide();
				}
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){  
		$('#room_number').click(function(){
			$('#room_number').css("border", "");
		})
	});
	$('#transfer_room').on('click', function(e) {
		var room_number = $('#room_number');
		
		if(!room_number.val()) {
			$('#room_number').css("border", "1px solid red");
			$('#room_number').focus();
			e.preventDefault();
			//return false;
		} 
		
		if(room_number.val()) {
			$('#room_number').css("border", "");
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){  

		$('.booking_via,#bookingid,#checkin,#checkout,#nights').click(function(){
			$('.booking_via').css("border", "");
			$('#bookingid').css("border", "");
			$('#checkin').css("border", "");
			$('#checkout').css("border", "");
			$('#nights').css("border", "");
		})

	});

	$('#submitform_extendedbooking').on('click', function(e) {
		var booking_via = $('.booking_via');
		var bookingid = $('#bookingid');
		var checkin = $('#checkin');
		var checkout = $('#checkout');
		var nights = $('#nights');
		
		if(!booking_via.val()) {
			$('.booking_via').css("border", "1px solid red");
			$('.booking_via').focus();
			e.preventDefault();
			//return false;
		} 
		if(!bookingid.val()) {
			$('#bookingid').css("border", "1px solid red");
			$('#bookingid').focus();
			e.preventDefault();
			//return false;
		} 
		
		if(!checkin.val()) {
			$('#checkin').css("border", "1px solid red");
			$('#checkin').focus();
			e.preventDefault();
			//return false;
		} 
		if(!checkout.val()) {
			$('#checkout').css("border", "1px solid red");
			$('#checkout').focus();
			e.preventDefault();
			//return false;
		} 

		if(!nights.val()) {
			$('#nights').css("border", "1px solid red");
			$('#nights').focus();
			e.preventDefault();
			//return false;
		} 
		
		if(booking_via.val()) {
			$('.booking_via').css("border", "");
		}
		
		if(bookingid.val()) {
			$('#bookingid').css("border", "");
		}

		if(checkin.val()) {
			$('#checkin').css("border", "");
		}

		if(checkout.val()) {
			$('#checkout').css("border", "");
		}

		if(nights.val()) {
			$('#nights').css("border", "");
		}
	});
</script>

