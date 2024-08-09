<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
$booking_vias = $obj->getAllBookingViaCategories();
if(isset($_GET['arrival_b_id'])){
	$arrival_b_id = $_GET['arrival_b_id'];
	$reslut = $obj->getArrivalBookingListById($arrival_b_id, $hotel_id);
}
?>

<!--Re-checkin modal -->
	<h3 style="text-align: center!important;font-size:25px;">Room is ready To Book</h3>
	<span id="success"></span>
	<form action="insert_data.php" class="idealforms" id="checkin_form" enctype="multipart/form-data" role="form" name="checkin_form" autocomplete="on">
      	<span class="messsage" style="margin-left:22px;color:red;font-weight:bold;"></span>
      	<div class="clear"></div>
      	<div class="field">
        	<label class="main">R. Entry Number<span style="color:red;"> * </span>:</label>
        	<input name="serial" id="serial" type="text" value="<?php if(isset($_SESSION['serial'])) echo $_SESSION['serial'];?>" class="ipt"  placeholder="Enter serial number">
      	</div>
      	<div class="field">
        	<label class="main">Room Number <span style="color:red;"> * </span>:</label>
        	<input name="roomno" id="roomno" type="text" value="<?php if(isset($_SESSION['roomno'])) echo $_SESSION['roomno'];?>" class="ipt"  placeholder="Enter Room Number"></br>
      	</div>
      	<div class="clear"></div>
      	<div class="wrapagain">
        	<span id="wrapelement0">
          		<div class="field">
	            	<label class="main">Full Name<span style="color:red;"> * </span>:</label>
	            	<?php /*?><select name="nametitle[]" id="small_select" class="nametitle">
	              		<?php 
	              		$nametitles= array('Mr','Mrs','Miss');
	              		foreach ($nametitles as $namet) { 
	              		?>
	              		<option value="<?php echo $namet; ?>"><?php echo $namet;?></option>
	              		<?php } ?>
	            	</select><?php */?>
	              	<input name="fname[]" id="fname" value="<?php if(!empty($reslut['guest_name'])) echo $reslut['guest_name'];?>" class="ipt" type="text" placeholder="Enter Your Full Name2" >
          		</div>
          		<div class="field">
            		<label class="main">Gender:</label>
		            <select name="gender[]" id="selectt" class="gender" style="width: 278px!important;">
		              	<?php $genders = array('Male','Female','Other');
		              	foreach ($genders as $gender) { ?>
		              	<option value="<?php echo $gender;?>"><?php echo $gender;?></option>
		              	<?php } ?>
		            </select>
          		</div>
        	</span>
	        <div class="clear"></div>
	        <span id="wrapelement1"></span>
      	</div>
      	<div style="margin-left:520px" class="field buttons">
	        <label class="main">&nbsp;</label>
	        <input  type="button" id="add_row" value="Add Person" class="add_person">
	        <input  type="button" id="delete_row" value="Delete Person" class="delete_person">
	    </div>
      	<div class="clear"></div>
      	<div class="field">
	        <label class="main">E-Mail<span style="color:red;"> * </span>:</label>
	        <input type="hidden" id="arri_id" name="arri_id" value="">
	        <input name="email" id="email" type="text" value="" class="ipt"  placeholder="Enter your Email ID"></br>
	        <span id="email_msg"></span>  
	    </div>

	     <div class="field">
	        <label class="main">Phone No<span style="color:red;"> * </span>:</label>
	        <input name="phone" id="phone" value="" type="text" class="ipt"  placeholder="Enter your Phone Number">
	        <br>
	        <span id="phone_error"></span>
	    </div>
     	<div class="clear"></div>
     	<div class="field">
			<label class="main">Booking Via<span style="color:red;"> * </span>:</label>
			<select name="booking_via" id="selectt" class="booking_via">
				<option value="">Select an booking via</option>
				<?php 
				foreach ($booking_vias as $booking_via) {
					if(isset($_SESSION['booking_via'])){
				?>
				<option value="<?php echo $booking_via['booking_via_id'];?>"<?php if($booking_via['booking_via_id'] == $_SESSION['booking_via']) echo 'selected="selected"' ;?>><?php echo $booking_via['category_name'];?></option>
				<?php } elseif (isset($reslut['booking_via'])) { ?>
				<option value="<?php echo $booking_via['booking_via_id'];?>"<?php if($booking_via['booking_via_id'] == $reslut['booking_via']) echo 'selected="selected"' ;?>><?php echo $booking_via['category_name'];?></option>
				<?php } else { ?>
				<option value="<?php echo $booking_via['booking_via_id'];?>"><?php echo $booking_via['category_name'];?></option>
				<?php } } ?>
			</select>
		</div>
		
		<div class="field">
			<label class="main">Booking ID<span style="color:red;"> * </span>:</label>
			<input name="bookingid" id="bookingid" value="<?php if(isset($reslut['booking_id'])) echo $reslut['booking_id']; ?>" type="text" class="ipt"  placeholder="Enter Booking ID">
		</div>
		<div class="clear"></div>
      	
      	<div class="field">
        	<label class="main">Check In Date<span style="color:red;"> * </span>:</label>
        	<input class="date-pick ipt" type="text" value="<?php if(!empty($reslut['checkin_date'])) echo $reslut['checkin_date'];?>" id="checkin" name="checkin" placeholder="Check In Date">
      	</div>
      
      	<div class="field">
	        <label class="main">Check Out Date<span style="color:red;"> * </span>:</label>
	        <input class="date-pick ipt" type="text" id="checkout" value="<?php if(isset($reslut['checkout_date'])) echo $reslut['checkout_date'];?>" name="checkout" placeholder="Check Out Date">
	    </div>
	    <div class="field">
	        <label class="main">Booking Nights<span style="color:red;"> * </span>:</label>
	        <input name="nights" id="nights" type="number" value="<?php if(isset($_SESSION['nights'])) echo $_SESSION['nights'];?>" class="ipt"  placeholder="Enter Booking Nights">
	    </div>
	    <div class="field">
       		<label class="main">Number of Guest:</label>
        	<input id="noofguest" name="noofguest" value="<?php if(isset($reslut['no_of_guest'])) echo $reslut['no_of_guest'];?>" class="ipt"  type="text" placeholder="Number of Guest"   >
  	    </div>
  	    <div class="field">
        	<label class="main">Coming From:<span style="color:red;"> * </span>:</label>
        	<input id="lastlocation" name="lastlocation" class="ipt" value="<?php if(isset($_SESSION['lastlocation'])) echo $_SESSION['lastlocation'];?>" type="text" placeholder="Your Last Location"   >
      	</div>
      	<div class="field">
			<label class="main">Going To:<br>(Next Location)<span style="color:red;"> * </span>:</label>
			<input id="nextlocation" name="nextlocation" value="<?php if(isset($_SESSION['nextlocation'])) echo $_SESSION['nextlocation'];?>" class="ipt"  type="text" placeholder="Your Next Location"   >
		</div>
		<div class="clear"></div>
      	<div class="field">
	        <label class="main">Purpouse<span style="color:red;"> * </span>:</label>
	        <select name="purpose" id="selectt" class="purpose">
	         	<option value="">Select an purpouse</option>
	          	<?php
	          	$purpouses = array('Tourist','Official/Bussiness','Medical','Exam','Interview','Other');
	          	foreach ($purpouses as $purpouse) { 
	          	?>
	          	<option value="<?php echo $purpouse;?>"><?php echo $purpouse;?></option>
	          	<?php  } ?>
	        </select>
      	</div>
      	
      	<div class="field">
	        <label class="main">Booking Amount<span style="color:red;"> * </span>:</label>
	        <input name="amount" id="amount" type="text" value="<?php if(isset($reslut['room_charge'])) echo $reslut['room_charge'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
      	
      	<div class="field">
	        <input name="e_adult_charge" id="e_adult_charge" type="hidden" value="<?php if(isset($reslut['e_adult_charge'])) echo $reslut['e_adult_charge'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
      	<div class="field">
	        <input name="h_tax" id="h_tax" type="hidden" value="<?php if(isset($reslut['h_tax'])) echo $reslut['h_tax'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
      	
 		<div class="field">
	        <input name="a_charge" id="a_charge" type="hidden" value="<?php if(isset($reslut['a_charge'])) echo $reslut['a_charge'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>	    
	    <div class="field">
	        <input name="g_comm" id="g_comm" type="hidden" value="<?php if(isset($reslut['g_comm'])) echo $reslut['g_comm'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
	    <div class="field">
	        <input name="gst_18" id="gst_18" type="hidden" value="<?php if(isset($reslut['gst_18'])) echo $reslut['gst_18'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
	    <div class="field">
	        <input name="comm_inc_gst" id="comm_inc_gst" type="hidden" value="<?php if(isset($reslut['comm_inc_gst'])) echo $reslut['comm_inc_gst'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
	    <div class="field">
	        <input name="pay_hotel" id="pay_hotel" type="hidden" value="<?php if(isset($reslut['pay_hotel'])) echo $reslut['pay_hotel'];?>" class="ipt"  placeholder="Enter Booking Amount">
	    </div>
	    <div class="clear"></div>
     	<input type="button" class="reset" style="padding:5px 20px 5px 20px;margin-left:339px;" id="reset_arrival" value="Reset" />
     	
     	<button style="float: right!important;margin-right:370px;" type="button" id="quick_checkin"  class="reset">Book Now</button>
     	<img class="modallodar" style="display: none" alt="" src="images/ajax-loader-search.gif" />
    </form>
  	<a class="close" href=""></a> 
</div>
<!--<script src="js/jquery.min.js" type="text/javascript"></script>-->
<!--<script src="js/jquery.reveal.js" type="text/javascript"></script>-->
<!--<script src="js/quantity-bt.js"></script>-->
<!--<script src="js/bootstrap-datepicker.js"></script>-->
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>

<script>
	//replace white space
	$(function(){
	  $('#phone').bind('input', function(){
	    $(this).val(function(_, v){
	     return v.replace(/\s+/g, '');
	    });
	  });
	});

	$(document).ready(function(){
	    var var_i = $('#i');
		if(var_i.val()){
			var i= var_i.val();
			$("#delete_row").show();
		} else {
			var i=1;
			$("#delete_row").hide();
		}
	    $("#delete_row").hide();
	    $("#add_row").click(function(){
	      	$('#wrapelement'+i).html('<div class="field"><label class="main">Full Name:</label><input name="fname[]" id="fname" class="ipt" type="text" placeholder="Enter Your Full Name" ></div><div class="field"><label class="main">Gender:</label><select name="gender[]" id="selectt" class="gender" style="width: 278px!important;"><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div><div class="clear"></div>');
	     	$('.wrapagain').append('<span id="wrapelement'+(i+1)+'"></span>');
	      	i++; 
	      	$("#delete_row").show();
	    });
	    $("#delete_row").click(function(){
	      	if(i <= 2){
	        	$("#delete_row").hide();
	      	}
	      	if(i>1){
	        	$("#wrapelement"+(i-1)).html('');
	        	i--;
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
$(document).ready(function(){ 
	$('#serial,#fname,#father_name,#email,#phone,.purpose,#checkin,#checkout,#lastlocation,#nextlocation').click(function(){
		$('#serial').css("border", "");
		$('#fname').css("border", "");
		$('#father_name').css("border", "");
		$('#email').css("border", "");
		$('#phone').css("border", "");
		$('.purpose').css("border", "");
		$('#checkin').css("border", "");
		$('#checkout').css("border", "");
		$('#lastlocation').css("border", "");
		$('#nextlocation').css("border", "");
		$('#roomno').css("border", "");
	})
});

$('#quick_checkin').on('click', function(e) {
	var serial = $('#serial');
	var fname = $('#fname');
	var father_name = $('#father_name');
	var email = $('#email');
	var phone = $('#phone');
	var purpose = $('.purpose');
	var checkin = $('#checkin');
	var checkout = $('#checkout');
	var lastlocation = $('#lastlocation');
	var nextlocation = $('#nextlocation');
	var roomno = $('#roomno');

	if(!serial.val()) {
	  	$('#serial').css("border", "1px solid red");
	  	$('#serial').focus();
	  	e.preventDefault();
	} 
	if(!fname.val()) {
	  	$('#fname').css("border", "1px solid red");
	  	$('#fname').focus();
	  	e.preventDefault();
	} 
	if(!father_name.val()) {
	  	$('#father_name').css("border", "1px solid red");
	  	$('#father_name').focus();
	  	e.preventDefault();
	} 
	if(!email.val()) {
	  	$('#email').css("border", "1px solid red");
	  	$('#email').focus();
	  	e.preventDefault();
	} 

	if(!phone.val()) {
	  	$('#phone').css("border", "1px solid red");
	  	$('#phone').focus();
	  	e.preventDefault();
	} 

	if(!checkin.val()) {
	 	$('#checkin').css("border", "1px solid red");
	  	$('#checkin').focus();
	  	e.preventDefault();
	} 
	if(!checkout.val()) {
	  	$('#checkout').css("border", "1px solid red");
	  	$('#checkout').focus();
	  	e.preventDefault();
	} 
	if(!lastlocation.val()) {
	  	$('#lastlocation').css("border", "1px solid red");
	  	$('#lastlocation').focus();
	  	e.preventDefault();
	} 
	if(!nextlocation.val()) {
	  	$('#nextlocation').css("border", "1px solid red");
	  	$('#nextlocation').focus();
	  	e.preventDefault();
	} 
	if(!purpose.val()) {
	  	$('.purpose').css("border", "1px solid red");
	  	$('.purpose').focus();
	  	e.preventDefault();
	}
	if(!roomno.val()) {
	  	$('#roomno').css("border", "1px solid red");
	  	$('#roomno').focus();
	  	e.preventDefault();
	}

});
</script>

<script type="text/javascript">
$(document).ready(function(){ 
	$('#roomno').keyup(function(){
		var roomno = $("#roomno").val();
		$.ajax({
			url : 'room_number_validation.php?roomno='+roomno,
			success:function(data){
				if(data == 0){
					$('.messsage').hide();
				}else if(data == 1){
					$('.messsage').show().html('Room number is not valid...please check it.')
				}else{
					$('.messsage').show().html(data);
				}
			}
		});
	});
	
	$('#quick_checkin').click(function(){
		var formData = $('#checkin_form').serialize();
		$.ajax({
	    	url : 'insert_data.php?type=quickbooking',
	    	type : 'POST',
	    	data : formData,
	    	cache: false,
	    	beforeSend: function () {
			    $(".modallodar").show();
			},
	    	success:function(data){ 

	    		$(".modallodar").hide();
	    		if(data == 'All field are required.'){
		      		$('.messsage').html(data);
		      	} else if(data == 'success') {
		      		
		      		window.location.href='room_view.php';
		      	}else if(data == 4) {
		      		$(".messsage").html("Room number is not valid...please check it.");
		      	}else if(data == "email") {
		      		
		      		$(".email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
		      	}else if(data == "phone") {
		      		
		      		$(".phone_error").show().html("<span style='font-size:10px;color:red;'>Invalid Phone Number.. Please enter your valid Phone Number</span>");
		      	}else{
		      		
		      		$(".messsage").html("Error please try again later.");
		      	}
		    }
	  	});
	});
});
</script>

