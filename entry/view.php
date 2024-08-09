<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
$hotels = $obj->getHotelDetailsById($hotel_id); 

$booking_vias = $obj->getAllBookingViaCategories();

include_once('../include/header.php');


include('is_login.php');

$destination = 'upload/checkinimages/';

if(!empty($_GET['checkin_id'])){

	$checkin_id = $_GET['checkin_id'];

	$checkin_details = $obj->getEntryListById($checkin_id);
	$checkin_date = $checkin_details['checkin_date'];
	//$checkin_person_name = $obj->getTouristNameById($checkin_id);

	$checkin_ids = $obj->getCheckinIdsById($checkin_id, $checkin_date);

}

?>

<div class="content">

	<p class="btn_add"><a href="bill.php?checkin_id=<?php echo $checkin_details['checkin_id'];?>" ><i class="fa fa-eye">&nbsp;</i>View Bill</a> <!--<a href="#" ><i class="fa fa-print">&nbsp;</i>Print</a>-->
		<a href="bill.php?checkin_id=<?php echo $checkin_details['checkin_id'];?>" ><i class="fa fa-eye">&nbsp;</i>Checkout</a>
		<a href="add_summary.php?checkin_id =<?php echo $checkin_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Add Room Summary</a> 
		<a href="index.php?type=update&checkin_id=<?php echo $checkin_details['checkin_id'];?>&room_number=<?php echo $checkin_details['room_number'];?>" ><i class="fa fa-pencil">&nbsp;</i>Update Details</a> 
	</p>
	<div class="col-md-6"><h4><span class="clr_red">Checkin Date & Time :&nbsp;</span> <?php $date_m = date_format( new DateTime($checkin_details['inserted_date']), 'd-M-Y, D H:i A' ); echo $date_m;?></h4></div>


	<div class="form-wizard">
		<div class="row">
			<div class="col-md-8 col-sm-7">
				<div class="data-container">
					<h3 class="heading">Customer Personal Information</h3>
					<dl>
						<dt>R. Serial Number</dt>
						<dd><?php echo $checkin_details['serial_number'];?></dd>
					</dl>
					<dl>
						<dt>Full Name</dt>
						<dd><?php echo $checkin_details['name'];?></dd>
					</dl>
					<dl>
						<dt>Gender</dt>
						<dd><?php echo $checkin_details['gender'];?>&nbsp;&nbsp;&nbsp;<a href="#guestname" data-toggle="modalguestname" id="<?php echo $room_guest_details['checkin_date'];?>">View all Guest Name</a></dd>
					</dl>
					
					<dl>
						<dt>Email Id</dt>
						<dd><?php echo $checkin_details['email'];?></dd>
					</dl>
					<dl>
						<dt>Phone No</dt>
						<dd><?php echo $checkin_details['phone'];?></dd>
					</dl>
					<dl>
						<dt>Country</dt>
						<dd><?php echo $checkin_details['country'];?></dd>
					</dl>
					<dl>
						<dt>City</dt>
						<dd><?php echo $checkin_details['state'];?></dd>
					</dl>
					<?php /*?><dl>
						<dt>Pin Code</dt>
						<dd><?php echo $checkin_details['pincode'];?></dd>
					</dl>
					<dl>
						<dt>Date of Birth</dt>
						<dd><?php echo $checkin_details['date_of_birth'];?></dd>
					</dl><?php */?>
					<dl>
						<dt>Coming From </dt>
						<dd><?php echo $checkin_details['last_location'];?></dd>
					</dl>
					<dl>
						<dt>Next Location</dt>
						<dd><?php echo $checkin_details['next_location'];?></dd>
					</dl>
					<?php if(!empty($checkin_details['passport_number'])){ ?>
					<dl>
						<dt>Passport No</dt>
						<dd><?php echo $checkin_details['passport_number'];?></dd>
					</dl>
					<dl>
						<dt>Passport valid upto</dt>
						<dd><?php echo $checkin_details['pass_expiry_date'];?></dd>
					</dl>
					<dl>
						<dt>Visa No</dt>
						<dd><?php echo $checkin_details['visa_number'];?></dd>
					</dl>
					<dl>
						<dt>Visa valid upto</dt>
						<dd><?php echo $checkin_details['visa_expiry_date'];?></dd>
					</dl>
					<?php } ?>
					<?php /*?><dl>
						<dt>Address</dt>
						<dd><?php echo $checkin_details['address'];?></dd>
					</dl><?php */?>

					<dl>
						<dt>Document's</dt>
						<dd>
							<?php foreach ($checkin_ids as $document) { ?>
							<a target="_blank" href="<?php echo $destination.$document['id_proof'];?>"><img src="<?php echo $destination.$document['id_proof'];?>" hight="50px" width="50px"></a>
							<?php } ?>
						</dd>
					</dl>
					<h3 class="heading">Customer Booking Information</h3>
					<dl>
						<dt>Booking Via</dt>
						<dd><?php echo $checkin_details['compnay_name'];?></dd>
					</dl>
					<dl>
						<dt>Booking ID</dt>
						<dd><?php echo $checkin_details['booking_id'];?></dd>
					</dl>
					<dl>
						<dt>Check In Date</dt>
						<dd><?php echo $checkin_details['checkin_date'];?></dd>
					</dl>
					<dl>
						<dt>Check Out Date</dt>
						<dd><?php echo $checkin_details['final_checkout_date'];?></dd>
					</dl>
					<dl>
						<dt>Booking Days</dt>
						<dd><?php echo $checkin_details['booking_nights'];?></dd>
					</dl>
					<dl>
						<dt>Extended Days</dt>
						<dd><?php echo $checkin_details['extended_days'];?></dd>
					</dl>
					<dl>
						<dt>Room Number</dt>
						<dd><?php echo $checkin_details['room_number'];?></dd>
					</dl>
					<dl>
						<dt>Booking Amount</dt>
						<dd><?php echo $checkin_details['booking_amount'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Extra Adult Charges</dt>
						<dd><?php echo $checkin_details['charge_per_adult'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Persons</dt>
						<dd><?php echo $checkin_details['no_of_person'];?></dd>
					</dl>
					<dl>
						<dt>Meal Plan</dt>
						<dd><?php echo $checkin_details['meal_plan'];?></dd>
					</dl>
					<dl>
						<dt>Checked In By</dt>
						<dd><?php echo $checkin_details['inserted_by'];?></dd>
					</dl>
					<dl>
						<dt>Check Out By</dt>
						<dd><?php echo $checkin_details['checkout_by'];?></dd>
					</dl>
				</div><!--/ .data-container-->
			</div>
		</div><!--/ .row-->
	</div>
	<p class="btn_add">
		<a href="view_extended_days.php?id=<?php echo $checkin_id;?>" data-toggle="modalextend"><i class="fa fa-pencil">&nbsp;</i>View Extended booking day's</a> 
		<a href="#extend" data-toggle="modal" id="<?php echo $checkin_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Extend Booking day's</a>
		<a href="#transfer" data-target="#myModal2" data-toggle="modaltransfer" id="<?php echo $checkin_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Transfer Room</a>
	</p>

	<a href="#x" class="overlay" id="guestname"></a>
	<div class="popup">
	<!-- view all guest name modal here-->
	
	</div>

	<a href="#x" class="overlay" id="extend"></a>
	<div class="popup3"> 
		<h3 class="text-center" style="margin-left:400px;">Extend Booking Day's</h3>
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
						<?php } elseif (isset($update_checkin_details['booking_via'])) { ?>
						<option value="<?php echo $booking_via['booking_via_id'];?>"<?php if($booking_via['booking_via_id'] == $update_checkin_details['booking_via']) echo 'selected="selected"' ;?>><?php echo $booking_via['category_name'];?></option>
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
		<h3 class="text-center" style="margin-left:400px;">Room Transfer </h3>
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
<script src="js/bootstrap-datepicker.js"></script>
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

	$(".hotel").change(function(){
	   	var hotel_id = $(this).attr("value");
	    $.ajax({
	      	url : "save_hotel_id.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
	      	success:function(data){
	        	window.location.href='entry_list.php';
	      	}
	    });
	 });

</script>
<script>
$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});
</script>
</body>
</html>

