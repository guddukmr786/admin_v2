<?php 
include('../include/header.php');

include('is_login.php');
$countries = $obj->getCountries();
$booking_vias = $obj->getAllBookingViaCategories();
//Updation code here
if(!empty($_GET['arrival_b_id']) && !empty($_GET['type']) && $_GET['type'] = 'update_booking'){
	$arrival_b_id = $_GET['arrival_b_id'];
	$_SESSION['type'] = $_GET['type'];
	$unset_session = $obj->unsetEntryFormSession();
	$update_booking_details = $obj->getArrivalBookingListById($arrival_b_id, $hotel_id);
	$_SESSION['flight'] = $update_booking_details['flight_details'];
}
?>
<style type="text/css">
	#fname{
	    text-transform:capitalize;
	}
</style>

<div class="content">
	<div class="idealsteps-container">
		<form action="#" class="idealforms" id="checkin_form" enctype="multipart/form-data" method="post" role="form" name="checkin_form" autocomplete="on">
		
		<h3 style='text-align: center;color:#F34343;'>Arrival Booking Detials</h3>
		
		<div class="field">
			<label class="main">Booking ID: </label>
			<?php if(isset($_SESSION['booking_id'])) { ?>
			<input type="text" name="booking_id" id="booking_id"  value="<?php echo $_SESSION['booking_id'];?>"  class="ipt"  placeholder="Booking ID">
			<?php } else { ?>
			<input name="booking_id" id="booking_id"  value="<?php if(isset($update_booking_details['booking_id'])) echo $update_booking_details['booking_id']; ?>"  type="text" class="ipt"  placeholder="Booking ID">
			<?php } ?>
			<br/><span id="duplicate"></span>
		</div>
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
		<div class="clear"></div>
		<div class="field">
			<label class="main">Guest Name <span style="color:red;"> * </span>: </label>
			<?php if(isset($_SESSION['name'])) { ?>
			<input type="text" name="name" id="fname"  value="<?php echo $_SESSION['name'];?>"  class="ipt"  placeholder="Guest Name">
			<?php } else { ?>
			<input name="name" id="fname"  value="<?php if(isset($update_booking_details['guest_name'])) echo $update_booking_details['guest_name']; ?>"  type="text" class="ipt" placeholder="Guest Name">
			<?php } ?>
		</div>
		<div class="field">
			<label class="main">E-Mail:</label>
			<?php if(isset($_SESSION['email'])) { ?>
			<input name="email" id="email"  value="<?php echo $_SESSION['email'];?>" type="email" class="ipt"  placeholder="Enter your Email ID"><br>
			<?php } else { ?>
			<input name="email" id="email" type="email" value="<?php if(isset($update_booking_details['guest_email'])) echo $update_booking_details['guest_email']; ?>" class="ipt"  placeholder="Enter your Email ID"><br>
			<?php } ?>
			<span id="email_msg"></span>
		</div>

		<div class="field">
			<label class="main">Phone No<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['phone'])) { ?>
			<input name="phone" id="phone" value="<?php echo $_SESSION['phone'];?>" type="text" class="ipt"  placeholder="Enter your Phone Number"><br>
			<?php } else { ?>
			<input name="phone" id="phone" value="<?php if(isset($update_booking_details['guest_phone'])) echo $update_booking_details['guest_phone']; ?>" type="text" class="ipt"  placeholder="Enter your Phone Number"><br>
			<?php } ?>
			<span id="phone_msg"></span>
		</div>
		<div class="field">
			<label class="main">Country<span style="color:red;"> * </span>:</label>
			<select name="fkcountry" id="selectt" class="fkcountry">
				<option value="">Select Country</option>
				<?php foreach ($countries as $country) { 
					if(isset($_SESSION['fkcountry'])) {
				?>
				<option value="<?php echo $country['country_name']?>"<?php if($country['country_name'] == $_SESSION['fkcountry']) echo 'selected="selected"';?>><?php echo $country['country_name']?></option>
				
				<?php } elseif (isset($update_booking_details['country'])) { ?>

				<option value="<?php echo $country['country_name']?>"<?php if($country['country_name'] == $update_booking_details['country']) echo 'selected="selected"';?>><?php echo $country['country_name']?></option>
				<?php } else { ?>
				<option value="<?php echo $country['country_name']?>"><?php echo $country['country_name']?></option>
				<?php } } ?>
			</select>
		</div>
		<div class="clear"></div>	
		<div class="field">
			<label class="main">Room Category<span style="color:red;"> * </span>:</label>
			<select name="category" id="selectt" class="category">
				<option value="">Select Room Category</option>
				<?php
				$room_cat = array('Suites Room Only','Suites Room With Breakfast','Suites Room With Breakfast & Dinner','Deluxe Room Only','Deluxe Room with Breakfast','Deluxe Room with Breakfast & Dinner','Executive Room Only','Executive Room with Breakfast','Executive Room with Breakfast & Dinner','Super Deluxe Room Only','Super Deluxe Room with Breakfast','Super Deluxe Room with Breakfast & Dinner','Triple Room Only','Triple Room with Breakfast','Triple Room with Breakfast & Dinner','Family Room Only','Family Room with Breakfast','Family Room with Breakfast & Dinner');
				foreach ($room_cat as $room_ca) {
					if(isset($_SESSION['category'])) { 
				?>
				<option value="<?php echo $room_ca;?>"<?php if($room_ca == $_SESSION['category']) echo 'selected="selected"';?>><?php echo $room_ca;?></option>
				
				<?php } elseif (!empty($update_booking_details['room_category'])) { ?>

				<option value="<?php echo $room_ca;?>"<?php if($room_ca == $update_booking_details['room_category']) echo 'selected="selected"';?>><?php echo $room_ca;?></option>
				
				<?php } else { ?>
				<option value="<?php echo $room_ca;?>"><?php echo $room_ca;?></option>
				<?php } } ?>
			</select>
		</div>
		
		<div class="field">
			<label class="main">Booking Mode:</label>
			<select name="mode" id="selectt" class="mode">
				<option value="">Booking Mode</option>
				<?php
				$booking_mode = array('prepaid tariff','Pay at hotel');
				foreach ($booking_mode as $b_mode) {
					if(isset($_SESSION['mode'])) { 
				?>
				<option value="<?php echo $b_mode;?>"<?php if($b_mode == $_SESSION['mode']) echo 'selected="selected"';?>><?php echo $b_mode;?></option>
				
				<?php } elseif (!empty($update_booking_details['booking_mode'])) { ?>

				<option value="<?php echo $b_mode;?>"<?php if($b_mode == $update_booking_details['booking_mode']) echo 'selected="selected"';?>><?php echo $b_mode;?></option>
				
				<?php } else { ?>
				<option value="<?php echo $b_mode;?>"><?php echo $b_mode;?></option>
				<?php } } ?>
			</select>
		</div>
		<div class="clear"></div>	
		<div class="field">
			<label class="main">Check In Date<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['checkin'])){ ?>
			<input class="date-pick ipt" value="<?php echo $_SESSION['checkin'];?>" type="text" id="checkin" name="checkin" placeholder="Check In Date">
			<?php } elseif (isset($update_booking_details['checkin_date'])) { ?>
				<input class="date-pick ipt" type="text" value="<?php echo $update_booking_details['checkin_date']; ?>" id="checkin" name="checkin" placeholder="Check In Date">
			<?php } else { ?>
			<input class="date-pick ipt" type="text" id="checkin" name="checkin" placeholder="Check In Date">
			<?php } ?>
		</div>
		
		<div class="field">
			<label class="main">Check Out Date<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['checkout'])){ ?>
			<input class="date-pick ipt" type="text" value="<?php echo $_SESSION['checkout'];?>" id="checkout" name="checkout" placeholder="Check Out Date">
			<?php } elseif (isset($update_booking_details['checkout_date'])) { ?>
			<input class="date-pick ipt" type="text" id="checkout" value="<?php echo $update_booking_details['checkout_date']; ?>" name="checkout" placeholder="Check Out Date">
			<?php } else { ?>
			<input class="date-pick ipt" type="text" id="checkout" name="checkout" placeholder="Check Out Date">
			<?php } ?>
		</div>
		<div class="field">
			<label class="main">Expected Checkin Time<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['ex_ch_time'])){ ?>
			<input class="date-pick ipt" type="time" value="<?php echo $_SESSION['ex_ch_time'];?>" id="ex_ch_time" name="ex_ch_time" placeholder="Expected checkin time">
			<?php } elseif (isset($update_booking_details['ex_ch_time'])) { ?>
			<input class="date-pick ipt" type="time" id="checkout" value="<?php echo $update_booking_details['ex_ch_time']; ?>" name="ex_ch_time" placeholder="Expected checkin time">
			<?php } else { ?>
			<input class="date-pick ipt" type="time" id="ex_ch_time" name="ex_ch_time" placeholder="Expected checkin time">
			<?php } ?>
		</div>
		<div class="field">
			<label class="main">Number of Guest<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['noofguest'])) { ?>
			<input name="noofguest" id="noofguest" value="<?php echo $_SESSION['noofguest'];?>" type="number" class="ipt"  placeholder="Number of Guest"><br>
			<?php } else { ?>
			<input name="noofguest" id="noofguest" value="<?php if(isset($update_booking_details['no_of_guest'])) echo $update_booking_details['no_of_guest']; ?>" type="number" class="ipt"  placeholder="Number of Guest"><br>
			<?php } ?>
			<span id="phone_msg"></span>
		</div>
		<div class="clear"></div>
		<div class="field">
			<label class="main">Number of Room:</label>
			<?php if(isset($_SESSION['noofroom'])) { ?>
			<input name="noofroom" id="noofroom" value="<?php echo $_SESSION['noofroom'];?>" type="number" class="ipt"  placeholder="Number of Room"><br>
			<?php } else { ?>
			<input name="noofroom" id="noofroom" value="<?php if(isset($update_booking_details['noof_room'])) echo $update_booking_details['noof_room']; ?>" type="number" class="ipt"  placeholder="Number of Room"><br>
			<?php } ?>
			<span id="phone_msg"></span>
		</div>
		
		
	    <p class="field" style="margin-right: 210px;">
	    <label class="main" style="margin-left:20px;">Pickup<span style="color:red;"> * </span>:</label>
	    <?php if(isset($update_booking_details['pickup'])){ ?>
	    <label class="ideal-radiocheck-label"><input style="position: absolute; left: -9999px;" name="pickup" id="pickup" value="Yes" type="radio" <?php echo ($update_booking_details['pickup'] == "Yes") ? 'checked="checked"' : '';?>>Yes</label>
	    <label class="ideal-radiocheck-label"><input style="position: absolute; left: -9999px;" name="pickup" id="pickup" value="No" type="radio" <?php echo ($update_booking_details['pickup'] == "No") ? 'checked="checked"' : '';?>>No</label>
		<?php } else{ ?>
		<label class="ideal-radiocheck-label"><input style="position: absolute; left: -9999px;" name="pickup" id="pickup" value="Yes" type="radio" <?php if(isset($_SESSION['pickup'])){ echo ($_SESSION['pickup'] == "Yes") ? 'checked="checked"' : '';} ?>>Yes</label>
	    <label class="ideal-radiocheck-label"><input style="position: absolute; left: -9999px;" name="pickup" id="pickup" value="No" type="radio" <?php if(isset($_SESSION['pickup'])){ echo ($_SESSION['pickup'] == "No") ? 'checked="checked"' : '';} ?>>No</label>
		<?php } ?>
	    </p>
	    <span style="display: none;" class="error"></span>
	    <span id="flight_details"></span>
        <span id="flight_details_update">
	        <?php if(isset($_SESSION['pickup']) && $_SESSION['pickup'] == 'Yes' || isset($update_booking_details['pickup']) && $update_booking_details['pickup'] =='Yes'){ ?>
	        <div class="field"> 
				<label class="main">Fligt Details : </label>
				<textarea placeholder="Flight Details" type="text" id="flight" name="flight"><?php if(isset($_SESSION['flight'])) echo $_SESSION['flight']; ?></textarea>
			</div>
			<?php } ?>
		</span>


		<div class="clear"></div>
		<span style="margin-left:20px;">GST Calculation</span>
		<hr>
		<div class="field">
			<label class="main">Room Charges<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['room_charge'])){ ?>
			<input name="room_charge" id="room_charge" value="<?php echo $_SESSION['room_charge'];?>" type="number" class="ipt"  placeholder="Room Charges">
			<?php } else { ?>
			<input name="room_charge" id="room_charge" value="<?php if(isset($update_booking_details['room_charge'])) echo $update_booking_details['room_charge']; ?>" type="number" class="ipt"  placeholder="Room Charges">
			<?php } ?>
		</div>

		<div class="field">
			<label class="main">Extra Adult/Child Charges:</label>
			<?php if(isset($_SESSION['e_adult_charge'])){ ?>
			<input name="e_adult_charge" id="e_adult_charge" value="<?php echo $_SESSION['e_adult_charge'];?>" type="number" class="ipt"  placeholder="Extra Adult/Child Charges">
			<?php } else { ?>
			<input name="e_adult_charge" id="e_adult_charge" value="<?php if(isset($update_booking_details['e_adult_charge'])) echo $update_booking_details['e_adult_charge'];else echo 0.00; ?>" type="number" class="ipt"  placeholder="Extra Adult/Child Charges">
			<?php } ?>
		</div>

		<div class="field">
			<label class="main">Hotel Taxes<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['h_tax'])){ ?>
			<input name="h_tax" id="h_tax" value="<?php echo $_SESSION['h_tax'];?>" type="text" class="ipt"  placeholder="Hotel Taxes ex.- 1000 (prepaid/pay at hotel)">
			<?php } else { ?>
			<input name="h_tax" id="h_tax" value="<?php if(isset($update_booking_details['h_tax'])) echo $update_booking_details['h_tax']; ?>" type="text" class="ipt"  placeholder="Hotel Taxes ex.- 1000 (prepaid/pay at hotel)">
			<?php } ?>
		</div>

		<div class="field">
			<label class="main">(A) Hotel Gross Charges<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['a_charge'])){ ?>
			<input onclick="javascript:addNumbers()" name="a_charge" id="a_charge" value="<?php echo $_SESSION['a_charge'];?>" type="number" class="ipt"  placeholder="(A) Hotel Gross Charges">
			<?php } else { ?>
			<input onclick="javascript:addNumbers()" name="a_charge" id="a_charge" value="<?php if(isset($update_booking_details['a_charge'])) echo $update_booking_details['a_charge']; ?>" type="number" class="ipt"  placeholder="(A) Hotel Gross Charges">
			<?php } ?>
		</div>

		<div class="field">
			<label class="main">OTA Commission<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['g_comm'])){ ?>
			<input name="g_comm" id="g_comm" value="<?php echo $_SESSION['g_comm'];?>" type="number" class="ipt"  placeholder="Commission">
			<?php } else { ?>
			<input name="g_comm" id="g_comm" value="<?php if(isset($update_booking_details['g_comm'])) echo $update_booking_details['g_comm']; ?>" type="number" class="ipt"  placeholder="Commission">
			<?php } ?>
		</div> 

		<div class="field">
			<label class="main">OTA GST @ 18 %<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['gst_18'])){ ?>
			<input name="gst_18" id="gst_18" value="<?php echo $_SESSION['gst_18'];?>" type="number" class="ipt"  placeholder="GST @ 18 %">
			<?php } else { ?>
			<input name="gst_18" id="gst_18" value="<?php if(isset($update_booking_details['gst_18'])) echo $update_booking_details['gst_18']; ?>" type="number" class="ipt"  placeholder="GST @ 18 %">
			<?php } ?>
		</div>

		<div class="field">
			<label class="main">(B)OTA Commission (inc GST)<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['comm_inc_gst'])){ ?>
			<input onclick="javascript:addCommission()" name="comm_inc_gst" id="comm_inc_gst" value="<?php echo $_SESSION['comm_inc_gst'];?>" type="number" class="ipt"  placeholder="(B)OTA Commission (inc GST)">
			<?php } else { ?>
			<input onclick="javascript:addCommission()" name="comm_inc_gst" id="comm_inc_gst" value="<?php if(isset($update_booking_details['comm_inc_gst'])) echo $update_booking_details['comm_inc_gst']; ?>" type="number" class="ipt"  placeholder="(B)OTA Commission (inc GST)">
			
			<?php } ?>
		</div>
		
		<div class="field">
			<label class="main">OTA to Pay Hotel(A-B)<span style="color:red;"> * </span>:</label>
			<?php if(isset($_SESSION['pay_hotel'])){ ?>
			<input onclick="javascript:subTatoal()" name="pay_hotel" id="pay_hotel" value="<?php echo $_SESSION['pay_hotel'];?>" type="number" class="ipt"  placeholder="OTA to Pay Hotel(A-B)">
			<?php } else { ?>
			<input onclick="javascript:subTatoal()" name="pay_hotel" id="pay_hotel" value="<?php if(isset($update_booking_details['pay_hotel'])) echo $update_booking_details['pay_hotel']; ?>" type="number" class="ipt"  placeholder="OTA to Pay Hotel(A-B)">
			<?php } ?>
		</div>
		
        <?php if(isset($arrival_b_id)){ ?>
       		<input type="hidden" name="arrival_b_id" value="<?php echo $arrival_b_id;?>" >
        <?php } ?>
		<div class="footer">
			<div id="arrival_mess"></div>
			<div class="field buttons">
				<label class="main">&nbsp;</label>
				<input type="button" class="reset" id="reset" value="Reset" />
				<input type="button" id="submit_arr_booking" class="preview" name="submit_arr_booking" value="Submit">
				<img class="modallodar" style="display: none" alt="" src="images/ajax-loader-search.gif" />
			</div>
		</div>
	</div>
</div>       
<?php include('../include/footer.php');?>
<script type="text/javascript" src="js/formvalidation.js"></script>
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(".hotel").change(function(){
	   	var hotel_id = $(this).attr("value");
	    $.ajax({
	      	url : "save_hotel_id.php?hotel_id="+hotel_id,
	      	success:function(data){
	        	window.location.href='arrival_booking_entry.php';
	      	}
	    });
	});
</script>
<script>
$('form.idealforms').idealforms('addRules', {
	'comments': 'required minmax:50:200'
});

</script>

<script type="text/javascript">
	//on keyup
	$(document).on('keyup','#room_charge,#e_adult_charge,#h_tax,#a_charge',function(){
    	var room_charge = $('#room_charge').val();
    	var e_adult_charge = $('#e_adult_charge').val();
    	var h_tax = $('#h_tax').val();
    	if(room_charge && h_tax){
    		
    		var total = parseFloat(room_charge) + parseFloat(e_adult_charge) + parseFloat(h_tax);
    		$('#a_charge').val(total);
    	}

    });

    $(document).on('keyup','#g_comm,#gst_18,#comm_inc_gst',function(){
    	var g_comm = $('#g_comm').val();
    	var gst_18 = $('#gst_18').val();
    	if(g_comm && gst_18){
    		var total1 = parseFloat(g_comm) + parseFloat(gst_18);
    		$('#comm_inc_gst').val(total1);
    	}

    });

    $(document).on('keyup','#gst_18,#comm_inc_gst,#pay_hotel',function(){
    	var a_charge = $('#a_charge').val();
    	var comm_inc_gst = $('#comm_inc_gst').val();
    	if(a_charge && comm_inc_gst){
    		var total2 = parseFloat(a_charge) - parseFloat(comm_inc_gst);
    		$('#pay_hotel').val(total2);
    	}
    });

    //on click
    $(document).on('click','#room_charge,#e_adult_charge,#h_tax,#a_charge',function(){
    	var room_charge = $('#room_charge').val();
    	var e_adult_charge = $('#e_adult_charge').val();
    	var h_tax = $('#h_tax').val();
    	if(room_charge && h_tax){
    		
    		var total = parseFloat(room_charge) + parseFloat(e_adult_charge) + parseFloat(h_tax);
    		$('#a_charge').val(total);
    	}

    });

    $(document).on('click','#g_comm,#gst_18,#comm_inc_gst',function(){
    	var g_comm = $('#g_comm').val();
    	var gst_18 = $('#gst_18').val();
    	if(g_comm && gst_18){
    		var total1 = parseFloat(g_comm) + parseFloat(gst_18);
    		$('#comm_inc_gst').val(total1);
    	}

    });

    $(document).on('click','#gst_18,#comm_inc_gst,#pay_hotel',function(){
    	var a_charge = $('#a_charge').val();
    	var comm_inc_gst = $('#comm_inc_gst').val();
    	if(a_charge && comm_inc_gst){
    		var total2 = parseFloat(a_charge) - parseFloat(comm_inc_gst);
    		$('#pay_hotel').val(total2);
    	}
    });
    
</script>
<script>
	/*$('#checkout').datepicker({
        dateFormat: "dd/m/yy" 
    });

    $("#checkin").datepicker({
        dateFormat: "dd/m/yy", 
        minDate:  0,
        onSelect: function(date){            
            var date1 = $('#checkin').datepicker('getDate');           
            var date = new Date( Date.parse( date1 ) ); 
            date.setDate( date.getDate() + 1 );        
            var newDate = date.toDateString(); 
            newDate = new Date( Date.parse( newDate ) );                      
            $('#checkout').datepicker("option","minDate",newDate);            
        }
    });*/


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
	$('input[type="radio"]').click(function(){
		var value = $(this).attr('value');
		//var ssflight = '<?php //if(isset($_SESSION["flight"])){ echo $_SESSION["flight"];}?>';
		if(value == 'Yes'){
			
				$.ajax({
					url : 'flight_details_inputbox.php',
					success:function(data){
						$("#flight_details_update").hide();
						$("#flight_details").show().html(data);
					}
				});
			
		}else{	
			$("#flight_details_update").hide();
			$("#flight_details").hide();
		}
	});
	$(document).ready(function(){
		var pickup = '<?php if(isset($_SESSION["pickup"])) echo $_SESSION["pickup"];?>';
		if(pickup == 'No'){
			$("#flight_details_update").hide();
		}
	});

	//Email Validation here
	$("#phone").click(function(){
		var email = $("#email").val();
		if(email){
			$.ajax({
				url : 'validate.php?email='+email,
				success:function(data){
					if(data == 1){
						$("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					}else{
						$("#email_msg").hide();
					}
				}
			});
		}
	});

	$("#submit_arr_booking").click(function(){
	
		var email = $("#email").val();
		
		//$("#email_msg").hide();
		var fname = $('#fname');
		var email = $('#email');
		var phone = $('#phone');
		var fkcountry = $('.fkcountry');
		var booking_via = $('.booking_via');
		var checkin = $('#checkin');
		var checkout = $('#checkout');
		var booking_id = $('#booking_id');
		var category = $('.category');
		var mode = $('.mode');
		var noofguest = $('#noofguest');
		var flight = $('#flight');
		var formData = $('#checkin_form').serialize();
		if(noofguest.val().length > 2){
			$("#arrival_mess").show().html("<div class='alert alert-danger'>Please fill valid number of guest field</div>");
			return false;
		}

		if($("#noofroom").val().length > 2){
			$("#arrival_mess").show().html("<div class='alert alert-danger'>Please fill valid number of room field</div>");
			return false;
		}

		if(fname.val() && phone.val() && fkcountry.val() && booking_via.val() && checkin.val() && checkout.val() && category.val() && noofguest.val()){
			$.ajax({
				url : 'insert_data.php?type=arrival_booking',
				type : 'POST',
				data : formData,
				beforeSend: function () {
				    $(".modallodar").show();
				},
				success:function(data){
					
					$(".modallodar").hide();

					if(data == 1){
						$("#arrival_mess").show().html("<div class='alert alert-danger'>Please fill out all required field</div>");
					} else if(data == 2) {
						$("#arrival_mess").show().html("<div class='alert alert-danger'>This Booing ID allready inserted!</div>");
					}  else if(data == 4) {
						$("#arrival_mess").show().html("<div class='alert alert-danger'>Please enter a valid Email ID for ex..(example@gmail.com)</div>");
					} else if(data == 0) {
						$("#arrival_mess").show().html("<div class='alert alert-success'>Booking data has been saved.!</div>");
						$("#booking_id").val(" ");
						$("#fname").val(" ");
						$("#email").val(" ");
						$("#phone").val(" ");
						$(".fkcountry").val(" ");
						$("#category").val(" ");
						$(".mode").val(" ");
						$("#pickup").val(" ");
						$("#flight").val(" ");
						$("#company").val(" ");
						$("#checkin").val(" ");
						$("#checkout").val(" ");
						$("#b_amount").val(" ");
						$("#noofguest").val(" ");
						$("#room_charge").val(" ");
						$("#h_tax").val(" ");
					} else if(data == 3) {
						$("#arrival_mess").show().html("<div class='alert alert-success'>Booking data has been Updated.!</div>");
						$("#booking_id").val(" ");
						$("#fname").val(" ");
						$("#email").val(" ");
						$("#phone").val(" ");
						$(".fkcountry").val(" ");
						$("#category").val(" ");
						$(".mode").val(" ");
						$("#pickup").val(" ");
						$("#flight").val(" ");
						$("#company").val(" ");
						$("#checkin").val(" ");
						$("#checkout").val(" ");
						$("#b_amount").val(" ");
						$("#noofguest").val(" ");
						$("#room_charge").val(" ");
						$("#h_tax").val(" ");
					} else {
						$("#arrival_mess").show().html("<div class='alert alert-danger'>Something is wrong so please try again later.</div>");
					}
				}
			});
		}
				
	});

	//Phone Validation here
	<?php /*?>$("#phone").keyup(function(){
		var phone = $("#phone").val();
		$.ajax({
			url : 'validate.php?phone='+phone,
			success:function(data){
				if(data == 1){
					$("#phone_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Phone number! please enter your valid Phone Number</span>");
					return false;
				}else{
					$("#phone_msg").hide();

				}
			}
		});
	});
	$("#submit_arr_booking").click(function(){
		var phone = $("#phone").val();
		$.ajax({
			url : 'validate.php?phone='+phone,
			success:function(data){
				if(data == 1){
					$("#phone_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Phone number! please enter your valid Phone Number</span>");
					return false;
				}else{
					$("#phone_msg").hide();
					var formData = $('#checkin_form').serialize();
					$.ajax({
						url : 'insert_data.php?type=arrival_booking',
						type : 'POST',
						data : formData,
						success:function(data){
							if(data == 1){
								$("#arrival_mess").show().html("<span style='color:red;'>All field are required!</span>");
							} else if(data == 2){
								$("#arrival_mess").show().html("<span style='color:red;'>This Booing ID allready inserted!</span>");
							} else {
								$("#arrival_mess").show().html("<span style='color:red;'>Booking data has been saved.!</span>");
								$("#booking_id").val(" ");
								$("#fname").val(" ");
								$("#email").val(" ");
								$("#phone").val(" ");
								$(".fkcountry").val(" ");
								$("#category").val(" ");
								$(".mode").val(" ");
								$("#pickup").val(" ");
								$("#flight").val(" ");
								$("#company").val(" ");
								$("#checkin").val(" ");
								$("#checkout").val(" ");
							}
						}
					});
				}
			}
		});
	});<?php */?>
</script>
<script type="text/javascript">
$("#booking_id").keyup(function(){
	var booking_id = $(this).attr('value');
	if(booking_id){
		$.ajax({
			url : 'process.php?type=checkDuplicateBookingID&booking_id='+booking_id,
			success:function(data){
				if(data == 0){
					$("#duplicate").show().html("<span style='color:red;margin:118px;font-size:11px;'>This Booking id is allready inserted.<span>");
				}else if(data == 1){
					$("#duplicate").hide();
				}
			}
		});
	}
});
$("#booking_id").click(function(){
	var booking_id = $(this).attr('value');
	if(booking_id){
		$.ajax({
			url : 'process.php?type=checkDuplicateBookingID&booking_id='+booking_id,
			success:function(data){
				if(data == 0){
					$("#duplicate").show().html("<span style='color:red;margin:118px;font-size:11px;'>This Booking id is allready inserted.<span>");
				}else if(data == 1){
					$("#duplicate").hide();
				}
			}
		});
	}
});
</script>
<script type="text/javascript">
	$(".hotel").change(function(){
	   	var hotel_id = $(this).attr("value");
	    $.ajax({
	      	url : "save_hotel_id.php?hotel_id="+hotel_id,
	      	success:function(data){
	        	window.location.href='arrival_booking_entry.php';
	      	}
	    });
	 });
</script>
</body>
</html>