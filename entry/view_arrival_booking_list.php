<?php 
include_once('../include/header.php');

include('is_login.php');

if(!empty($_GET['arrival_b_id'])){
	$arrival_b_id = $_GET['arrival_b_id'];
	$arr_booking_details = $obj->getArrivalBookingListById($arrival_b_id, $hotel_id);
	if($arr_booking_details['booking_status'] == 'transfered'){
		$booking_id = $arr_booking_details['booking_id']; 
   	 	$hotel_name = $obj->getTransferedBookingHotelName($booking_id);
   	 	$checkinDetails = $obj->getTransferedBookingCheckinDetails($booking_id);
	}
	
	//$checkin_date = $arr_booking_details['checkin_date'];
}
?>
<div class="content">
	<p class="btn_add">
		<a href="arrival_booking_entry.php?type=update_booking&arrival_b_id=<?php echo $arr_booking_details['arrival_b_id'];?>" ><i class="fa fa-pencil">&nbsp;</i>Update Details</a>
		<?php if(isset($arr_booking_details['booking_status']) && $arr_booking_details['booking_status'] == 'cancelled') { ?>
		<a id= "cancelled" style="background-color:#FF4646!important;"><i class="fa fa-times">&nbsp;</i>Cancelled</a> 
		<?php } else { ?>
		<a href="#" id= "cancel" alt="<?php echo $arr_booking_details['arrival_b_id'];?>"><i class="fa fa-pencil">&nbsp;</i>Cancel Booking</a> 
		<?php } ?>

		<?php if(isset($arr_booking_details['booking_status']) && $arr_booking_details['booking_status'] == 'checkedin') { ?>
		<a id="checkedin" style="background-color:#499F4D!important;"><i class="fa fa-check">&nbsp;</i>Checked-In</a> 
		<?php } else { ?>
		<a href="#" id="checkin" alt="<?php echo $arr_booking_details['arrival_b_id'];?>"><i class="fa fa-pencil">&nbsp;</i>Check-In</a> 
		<?php } ?>


		<?php if(isset($arr_booking_details['booking_status']) && $arr_booking_details['booking_status'] == 'transfered') { ?>
		<a id="transferred" style="background-color:#499F4D!important;"><i class="fa fa-check">&nbsp;</i>Transferred</a> 
		<?php } else { ?>
		<a href="#select_hotel" data-target="#myModal2" data-toggle="modaltransfer" id="<?php echo $arrival_b_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Hotel Transfer</a> 
		<?php } ?>
		<?php /*?><a href="#select_hotel" data-target="#myModal2" data-toggle="modaltransfer" id="<?php echo $arrival_b_id;?>" ><i class="fa fa-pencil">&nbsp;</i>Hotel Transfer</a><?php */?>
		
	</p>
	<div class="col-md-6"><h4><span class="clr_red">Booking Date :&nbsp;</span> <?php $date_m = date_format( new DateTime($arr_booking_details['inserted_date']), 'd M Y, D H:i A' ); echo $date_m;?></h4></div>
	<?php if(!empty($hotel_name)){ ?>
	<div class="col-md-6">
		<h4 style="margin-left:0px;">Transferred In <span style="color:#499F4D;font-weight: 600;"><?php echo $hotel_name['hotel_name'];?></span></h4>
		<h4>Room Number : <span style="color:#499F4D;font-weight: 600;"><?php echo $checkinDetails['room_number'];?></span></h4>
	</div>
	<?php } ?>

	<div class="form-wizard">
		<div class="row">
			<div class="col-md-8 col-sm-7">
				<div class="data-container">
					<span id="error"></span>
					<h3 class="heading">Booking Arrival Details</h3>
					<dl>
						<dt>Full Name</dt>
						<dd><?php echo $arr_booking_details['guest_name'];?></dd>
					</dl>
					<dl>
						<dt>Email Id</dt>
						<dd><?php echo $arr_booking_details['guest_email'];?></dd>
					</dl>
					<dl>
						<dt>Phone No</dt>
						<dd><?php echo $arr_booking_details['guest_phone'];?></dd>
					</dl>
					<dl>
						<dt>Country</dt>
						<dd><?php echo $arr_booking_details['country'];?></dd>
					</dl>
					<dl>
						<dt>Booking Via</dt>
						<dd><?php echo $arr_booking_details['compnay_name'];?></dd>
					</dl>
					<dl>
						<dt>Booking ID</dt>
						<dd><?php echo $arr_booking_details['booking_id'];?></dd>
					</dl>
					<dl>
						<dt>Room Category</dt>
						<dd><?php echo $arr_booking_details['room_category'];?></dd>
					</dl>
					
					<dl>
						<dt>Booking Mode</dt>
						<dd><?php echo $arr_booking_details['booking_mode'];?></dd>
					</dl>
					<dl>
						<dt>Pickup</dt>
						<dd><?php echo $arr_booking_details['pickup'];?></dd>
					</dl>
					<dl>
						<dt>Flight Details</dt>
						<dd><?php echo $arr_booking_details['flight_details'];?></dd>
					</dl>
					<dl>
						<dt>Check In Date</dt>
						<dd><?php echo $arr_booking_details['checkin_date'];?></dd>
					</dl>
					<dl>
						<dt>Check Out Date</dt>
						<dd><?php echo $arr_booking_details['checkout_date'];?></dd>
					</dl>
					<dl>
						<dt>Number of Guest</dt>
						<dd><?php echo $arr_booking_details['no_of_guest'];?></dd>
					</dl>
					<dl>
						<dt>Number of Room</dt>
						<dd><?php echo $arr_booking_details['noof_room'];?></dd>
					</dl>
					<div class="clear"></div>
					<p>GST Calculation<p>
					<hr>
					<dl>
						<dt>Room Charges</dt>
						<dd><?php echo $arr_booking_details['room_charge'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Extra Adult/Child Charges</dt>
						<dd><?php echo $arr_booking_details['e_adult_charge'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Hotel Taxes</dt>
						<dd><?php echo $arr_booking_details['h_tax'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>(A) Hotel Gross Charges</dt>
						<dd><?php echo $arr_booking_details['a_charge'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Goibibo Commission</dt>
						<dd><?php echo $arr_booking_details['g_comm'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Goibibo GST @ 18 %</dt>
						<dd><?php echo $arr_booking_details['gst_18'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>(B)Goibibo Commission (inc GST):</dt>
						<dd><?php echo $arr_booking_details['comm_inc_gst'];?> Rs.</dd>
					</dl>
					<dl>
						<dt>Goibibo to Pay Hotel(A-B)</dt>
						<dd><?php echo $arr_booking_details['pay_hotel'];?> Rs.</dd>
					</dl>
					
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

  $('a[data-toggle="modaltransfer"]').click(function(){
    var arrival_b_id = $(this).attr('id');
    $.ajax({
      url : 'select_hotel.php?arrival_b_id='+arrival_b_id,
      success:function(data){
        $(".popup1").show().html(data);
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
    $("#cancel").click(function(){
      var id = $(this).attr('alt');
      if(confirm('Are you sure ?')){
      	$.ajax({
	      	url : 'process.php?type=cancelled&id='+id,
	      	success:function(data){
	      		if(data==0) { 
	      			$("#error").hide();
	      			$("#cancel").replaceWith('<a id= "cancelled" style="background-color:#FF4646!important;" ><i class="fa fa-times">&nbsp;</i>Cancelled</a>');
	      		} else {
	      			$("#error").html("<span style='color:red;'>Error please try again later.<span>");  
	      		}
	      	}
	      });
      	}
    });
</script>
<script type="text/javascript">
    $("#checkin").click(function(){
      var id = $(this).attr('alt');
      	if(confirm('Are you sure ?')){
      
	      	$.ajax({
		      	url : 'process.php?type=checkedin&id='+id,
		      	success:function(data){
		      		if(data==0){
		      			$("#error").hide();
		      			$("#checkin").replaceWith('<a id= "checkedin" style="background-color:#499F4D!important;"><i class="fa fa-check">&nbsp;</i>Checked-In</a>');
		      		} else { 
		      			$("#error").html("<span style='color:red;'>Error please try again later.<span>"); 
		      		} 
		      	}
		    });
	    }
    });
</script>
<script type="text/javascript">
	$('.booking_via,#bookingid,#checkin,#checkout,#nights').click(function(){
		$('.booking_via').css("border", "");
		$('#bookingid').css("border", "");
		$('#checkin').css("border", "");
		$('#checkout').css("border", "");
		$('#nights').css("border", "");
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
	        	window.location.href='arrival_booking_list.php';
	      	}
	    });
	});
</script>


<script>
$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});
</script>
</body>
</html>

