<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
$booking_vias = $obj->getAllBookingViaCategories();
if(isset($_GET['checkin_id'])){
	$checkin_id = $_GET['checkin_id'];
	$reslut = $obj->getCheckedoutValueForRecheckin($checkin_id);
	$resluts = explode(' ', $reslut['name']);
}
?>

<!--Re-checkin modal -->
  <h3 class="text-center" style="text-align:center!important;">Room is ready To Book</h3>
    <span id="success"></span>
    <form action="#" class="idealforms" id="checkin_form" enctype="multipart/form-data" role="form" name="checkin_form" >
      	<span id="messsage" style="color:green;margin-left:0px;"></span>
      	<span id="error" style="color:red;margin-left:25px;"></span>
      	<div class="clear"></div>
	    <div class="field">
			<label class="main">R. Entry Number<span style="color:red;"> * </span>:</label>
			<input name="serial" id="serial" type="text" value="<?php if(isset($_SESSION['serial'])) echo $_SESSION['serial'];?>" class="ipt"  placeholder="Enter serial number"></br>
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
		              	if(isset($resluts[0])){
		             	?>
		             	<option value="<?php echo $namet;?>"<?php if($resluts[0] == $namet) echo 'selected="selected"';?>><?php echo $namet;?></option>
		             	<?php } else { ?>
		              	<option value="<?php echo $namet; ?>"><?php echo $namet;?></option>
		              	<?php } } ?>
		            </select><?php */?>
		            <input name="fname[]" id="fname" value="<?php if(isset($resluts[1])) echo $resluts[1]; if(!empty($resluts[2])) echo " ".$resluts[2];?>" class="ipt" type="text" placeholder="Enter Your Full Name" >
	          	</div>
	          	<div class="field">
		            <label class="main">Gender:</label>
		            <select name="gender[]" id="selectt" class="gender" style="width: 278px!important;">
		              <?php $genders = array('Male','Female','Other');
		              foreach ($genders as $gender) {
		              if(isset($resluts[2])){
		              ?>
		              <option value="<?php echo $gender;?>"<?php if($resluts[2] == $gender) echo 'selected="selected"';?>><?php echo $gender;?></option>
		              <?php } else { ?>
		              <option value="<?php echo $gender;?>"><?php echo $gender;?></option>
		              <?php } } ?>
		            </select>
	          	</div>
	        </span>
	        <div class="clear"></div>
        	<span id="wrapelement1"></span>
      	</div>
      	<div style="float:right;margin-right:85px;" class="field buttons">
       	 	<label class="main">&nbsp;</label>
        	<input type="button" id="add_row" value="Add Person" class="add_person">
        	<input type="button" id="delete_row" value="Delete Person" class="delete_person">
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
			<?php if(isset($_SESSION['bookingid'])) { ?>
			<input name="bookingid" id="bookingid" value="<?php echo $_SESSION['bookingid']; ?>" type="text" class="ipt"  placeholder="Enter Booking ID">
			<?php } else { ?>
			<input name="bookingid" id="bookingid" value="<?php if(isset($update_checkin_details['booking_id'])) echo $update_checkin_details['booking_id']; ?>" type="text" class="ipt"  placeholder="Enter Booking ID">
			<?php } ?>
		</div>
		<div class="clear"></div>
      	<div class="field">
        	<label class="main">E-Mail<span style="color:red;"> * </span>:</label>
        	<input name="email" id="email" value="<?php if(isset($reslut['email'])) echo $reslut['email'];?>" type="email" class="ipt"  placeholder="Enter your Email ID">
      	</div>

      	<div class="field">
        	<label class="main">Phone No<span style="color:red;"> * </span>:</label>
        	<input name="phone" id="phone" value="<?php if(isset($reslut['phone'])) echo $reslut['phone'];?>" type="text" class="ipt"  placeholder="Enter your Phone Number">
      	</div>
      	<div class="field">
        	<label class="main">Coming From:<br>(Last Location)</label>
        	<input id="lastlocation" name="lastlocation" class="ipt"  type="text" placeholder="Your Last Location"   >
      	</div>
      	<div class="field">
        	<label class="main">Going To:<br>(Next Location)</label>
        	<input id="nextlocation" name="nextlocation" class="ipt"  type="text" placeholder="Your Next Location"   >
      	</div>
      	<div class="field">
        	<label class="main">Check In Date<span style="color:red;"> * </span>:</label>
        	<input class="date-pick ipt" type="text" id="checkin" name="checkin" placeholder="Check In Date">
      	</div>
      
      	<div class="field">
        	<label class="main">Check Out Date<span style="color:red;"> * </span>:</label>
        	<input class="date-pick ipt" type="text" id="checkout" name="checkout" placeholder="Check Out Date">
      	</div>
      	<div class="field">
	        <label class="main">Booking Nights<span style="color:red;"> * </span>:</label>
	        <input name="nights" id="nights" type="number" class="ipt"  placeholder="Enter Booking Nights">
      	</div>
      	<div class="field">
	        <label class="main">Purpouse<span style="color:red;"> * </span>:</label>
	        <select name="purpose" id="selectt" class="purpose">
	          	<option value="">Select an purpouse</option>
	          	<?php
	          	$purpouses = array('Tourist','Official/Bussiness','Medical','Exam','Interview','Other');
	         	foreach ($purpouses as $purpouse) { 
	         	if(isset($reslut['purpouse'])){
	          	?>
	          	<option value="<?php echo $purpouse;?>"<?php if($reslut['purpouse'] == $purpouse) echo 'selected="selected"';?>><?php echo $purpouse;?></option>
	          	<?php } else { ?>
	          	<option value="<?php echo $purpouse;?>"><?php echo $purpouse;?></option>
	          	<?php } } ?>
	        </select>
      	</div>
      	<div class="clear"></div>

      	<div class="field">
			<label class="main">Room Number<span style="color:red;"> * </span>:</label>
			<input name="roomno" id="roomno" type="text" class="ipt" placeholder="Enter Room Number">
		</div>
				<div class="field">
			<label class="main">Booking Amount:</label>
			<input name="b_amount" id="b_amount" value="" type="text" class="ipt"  placeholder="Booking Amount">
		</div>

		<div class="field">
	        <input name="e_adult_charge" id="e_adult_charge" type="hidden" value="" class="ipt">
	    </div>
      	<div class="field">
	        <input name="h_tax" id="h_tax" type="hidden" value="" class="ipt">
	    </div>
      	
 		<div class="field">
	        <input name="a_charge" id="a_charge" type="hidden" value="" class="ipt">
	    </div>	    
	    <div class="field">
	        <input name="g_comm" id="g_comm" type="hidden" value="" class="ipt" >
	    </div>
	    <div class="field">
	        <input name="gst_18" id="gst_18" type="hidden" value="" class="ipt">
	    </div>
	    <div class="field">
	        <input name="comm_inc_gst" id="comm_inc_gst" type="hidden" value="" class="ipt">
	    </div>
	    <div class="field">
	        <input name="pay_hotel" id="pay_hotel" type="hidden" value="" class="ipt">
	    </div>
	    <div class="field">
	        <input name="arrival_b_id" id="arrival_b_id" type="hidden" value="" class="ipt">
	    </div>
		<div class="field buttons" style="margin-left:50%;">
			<button type="button" id="<?php echo $checkin_id;?>" class="btn-success">Book Now</button>
    	</div>
    </form>
  <a class="close" href=""></a> 
</div>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.reveal.js" type="text/javascript"></script>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script> 
<script type="text/javascript">
	$(document).on('keyup click','#bookingid',function(){
		var booking_id = $(this).attr('value');
		var booking_via = $(".booking_via").val();
		if(booking_via != 12){
			$.ajax({
				url : 'getTaxCalculation.php?booking_id='+booking_id,
				dataType : 'JSON',
				method : 'post',
				success : function(data){
					if(data){
						$("#b_amount").val(data.room_charge);
						$("#e_adult_charge").val(data.e_adult_charge);
						$("#h_tax").val(data.h_tax);
						$("#a_charge").val(data.a_charge);
						$("#g_comm").val(data.g_comm);
						$("#gst_18").val(data.gst_18);
						$("#comm_inc_gst").val(data.comm_inc_gst);
						$("#pay_hotel").val(data.pay_hotel);
						$("#arrival_b_id").val(data.arrival_b_id);
						
					}else{

						$("#b_amount").val("");
						$("#e_adult_charge").val("");
						$("#h_tax").val("");
						$("#a_charge").val("");
						$("#g_comm").val("");
						$("#gst_18").val("");
						$("#comm_inc_gst").val("");
						$("#pay_hotel").val("");
						$("#arrival_b_id").val("");
					}
				}
			});
		}else{

			$("#b_amount").val("");
			$("#e_adult_charge").val("");
			$("#h_tax").val("");
			$("#a_charge").val("");
			$("#g_comm").val("");
			$("#gst_18").val("");
			$("#comm_inc_gst").val("");
			$("#pay_hotel").val("");
		}
	});
</script>
<script>
	$(document).ready(function(){
	    var i=1;
	    $("#delete_row").hide();
	    $("#add_row").click(function(){
	      	$('#wrapelement'+i).html('<div class="field"><label class="main">Full Name:</label><input name="fname[]" id="fname" class="ipt" type="text" placeholder="Enter Your Full Name" ></div><div class="field"><label class="main">Gender:</label><select name="gender[]" id="selectt" class="gender" style="width: 278px!important;"><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div>');
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
<script type="text/javascript">
	$('.btn-success').click(function(){
	  	var checkin_id = $(this).attr('id');
	  	$.ajax({
	    	url : 'insert_data.php?checkin_id='+checkin_id +'&type=recheckin',
	    	type : 'POST',
	    	data : $('form').serialize(),
	    	cache: false,
	    	success:function(data){
	    		if(data == 'All field are required.'){
		      		$('#error').show().html(data);
		      	} else{
		      		$("#error").hide();
		      		$("#checkin_form")[0].reset();
		      		$('#messsage').html(data);
		      		
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
$(document).ready(function(){ 
	$('#serial,#fname,#father_name,#email,#phone,.purpose,#checkin,#checkout,#lastlocation,#nextlocation,.booking_via,#bookingid').click(function(){
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
		$('#booking_via').css("border", "");
		$('#bookingid').css("border", "");
	})
});

$('.btn-success').on('click', function(e) {
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
	var booking_via = $('.booking_via');
	var bookingid = $('#bookingid');
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
	if(!booking_via.val()) {
	  	$('.booking_via').css("border", "1px solid red");
	  	$('.booking_via').focus();
	  	e.preventDefault();
	}
	if(!bookingid.val()) {
	  	$('#bookingid').css("border", "1px solid red");
	  	$('#bookingid').focus();
	  	e.preventDefault();
	}


	if(fname.val()) {
	  	$('#fname').css("border", "");
	}
	if(email.val()) {
	  	$('#email').css("border", "");
	}

	if(phone.val()) {
	  	$('#phone').css("border", "");
	}

	if(checkin.val()) {
	  	$('#checkin').css("border", "");
	}

	if(checkout.val()) {
	  	$('#checkout').css("border", "");
	}

	if(lastlocation.val()) {
	  	$('#lastlocation').css("border", "");
	}
	if(nextlocation.val()) {
	  	$('#nextlocation').css("border", "");
	}
	if(purpose.val()) {
	  	$('.purpose').css("border", "");
	}
	if(roomno.val()) {
	  	$('#roomno').css("border", "");
	}
	if(booking_via.val()) {
	  	$('.booking_via').css("border", "");
	}
	if(bookingid.val()) {
	  	$('#bookingid').css("border", "");
	}
});
</script>
