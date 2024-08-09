<?php 

	session_start();

	echo '<h4 style="margin-left:20px;color:#f34343;text-align:center;">Only For Foreigners</h4>



	<div class="field">

		<label class="main">Arrival Date<span style="color:red;"> * </span>:</label>';?>



		<?php if(isset($_SESSION['arrival_date'])){ ?>

		<?php echo '<input class="date-pick ipt" type="text" value="';?><?php echo $_SESSION['arrival_date'];?><?php echo  '" id="arrival_date" name="arrival_date" placeholder="">';?>

		<?php } else { ?>	

		<?php echo '<input class="date-pick ipt" type="text" value="';?><?php if(isset($update_checkin_details['arrival_date'])) echo $update_checkin_details['arrival_date']; ?><?php echo  '" id="arrival_date" name="arrival_date" placeholder="Select arrival date">';?>

		<?php } ?>

	<?php echo '</div>

	<div class="field">

		<label class="main">Arrival Location <span style="color:red;"> * </span>:</label>';?>

		<?php if(isset($_SESSION['arrlocation'])){ ?>

		<?php echo '<input name="arrlocation" id="arrlocation" value="';?><?php echo $_SESSION['arrlocation'];?><?php echo '" type="text" class="ipt"  placeholder="Enter Arrival Location/Airport">';?>

		<?php } else { ?>

		<?php echo '<input name="arrlocation" id="arrlocation" value="';?><?php if(isset($update_checkin_details['arrival_location'])) echo $update_checkin_details['arrival_location']; ?><?php echo  '" type="text" class="ipt"  placeholder="Enter Arrival Location/Airport">';?>

		<?php } ?>

	<?php echo '</div>



	<div class="field">

		<label class="main">Passport Number<span style="color:red;"> * </span>:</label>';?>

		<?php if(isset($_SESSION['passport'])){ ?>

		<?php echo '<input name="passport" id="passport" value="';?><?php echo $_SESSION['passport'];?><?php echo '" type="text" class="ipt"  placeholder="Enter Passport Number">';?>

		<?php } else { ?>

		<?php echo '<input name="passport" id="passport" value="';?><?php if(isset($update_checkin_details['passport_number'])) echo $update_checkin_details['passport_number']; ?><?php echo  '" type="text" class="ipt"  placeholder="Enter Passport Number">';?>

		<?php } ?>

	<?php echo '</div>

	<div class="field">

		<label class="main">Passport Valid Upto<span style="color:red;"> * </span>:</label>';?>

		<?php if(isset($_SESSION['passportexp'])){ ?>

		<?php echo '<input name="passportexp" id="passportexp" value="';?><?php echo $_SESSION['passportexp'];?><?php echo '" type="text" class="ipt"  placeholder="Enter Passport Expiry Date">';?>

		<?php } else { ?>

		<?php echo '<input name="passportexp" id="passportexp" value="';?><?php if(isset($update_checkin_details['pass_expiry_date'])) echo $update_checkin_details['pass_expiry_date']; ?><?php echo  '" type="text" class="ipt"  placeholder="Enter Passport Expiry Date">';?>

		<?php } ?>

	<?php echo '</div>



	<div class="field">

		<label class="main">Visa Number<span style="color:red;"> * </span>:</label>';?>

		<?php if(isset($_SESSION['visa'])){ ?>

		<?php echo '<input name="visa" id="visa" value="';?><?php echo $_SESSION['visa'];?><?php echo '" type="text" class="ipt"  placeholder="Enter Visa Number">';?>

		<?php } else { ?>

		<?php echo '<input name="visa" id="visa" value="';?><?php if(isset($update_checkin_details['visa_number'])) echo $update_checkin_details['visa_number']; ?><?php echo '" type="text" class="ipt"  placeholder="Enter Visa Number">';?>

		<?php } ?>

	<?php echo '</div>



	<div class="field">

		<label class="main">Visa Valid upto<span style="color:red;"> * </span>:</label>';?>

		<?php if(isset($_SESSION['visa_valid'])){ ?>

		<?php echo '<input name="visa_valid" id="visa_valid" value="';?><?php echo $_SESSION['visa_valid'];?><?php echo '" type="text" class="ipt"  placeholder="Enter Validation Date">';?>

		<?php } else { ?>

		<?php echo '<input name="visa_valid" id="visa_valid" value="';?><?php if(isset($update_checkin_details['visa_expiry_date'])) echo $update_checkin_details['visa_expiry_date']; ?><?php echo '" type="text" class="ipt"  placeholder="Enter Validation Date">';?>

		<?php } ?>

	<?php echo '</div>';?>

	<?php echo "

	<script>

				var nowTemp = new Date();

				var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

				var checkin = $('#arrival_date').datepicker({

					

					todayHighlight: true,



					beforeShowDay: function (date) {

						return date.valueOf() >= now.valueOf();

					},

					autoclose: true



				}).on('changeDate', function (ev) {

					if (ev.date.valueOf() > checkout.datepicker('getDate').valueOf() || !checkout.datepicker('getDate').valueOf()) {



						var newDate = new Date(ev.date);

						newDate.setDate(newDate.getDate() + 1);

						checkout.datepicker('update', newDate);



					}

					$('#arrival_date')[0].focus();

				});





				var checkout = $('#check_out1').datepicker({

					beforeShowDay: function (date) {

						if (!checkin.datepicker('getDate').valueOf()) {

							return date.valueOf() >= new Date().valueOf();

						} else {

							return date.valueOf() > checkin.datepicker('getDate').valueOf();

						}

					},

					autoclose: true



				}).on('changeDate', function (ev) {});

				</script>

	";



echo "<script>

$(document).ready(function(){ 

	$('#arrival_date,#arrlocation,#passport,#passportexp,#visa,#visa_valid').click(function(){

		$('#arrival_date').css('border', '');

		$('#arrlocation').css('border', '');

		$('#passport').css('border', '');

		$('#passportexp').css('border', '');

		$('#visa').css('border', '');

		$('#visa_valid').css('border', '');

	})

});

$('#next').on('click', function(e) {

	var arrival_date = $('#arrival_date');

	var arrlocation = $('#arrlocation');

	var passport = $('#passport');

	var passportexp = $('#passportexp');

	var visa = $('#visa');

	var visa_valid = $('#visa_valid');

	if(!arrival_date.val()) {

		$('#arrival_date').css('border', '1px solid red');

		$('#arrival_date').focus();

		e.preventDefault();

	}

	if(!arrlocation.val()) {

		$('#arrlocation').css('border', '1px solid red');

		$('#arrlocation').focus();

		e.preventDefault();

	}

	if(!passport.val()) {

		$('#passport').css('border', '1px solid red');

		$('#passport').focus();

		e.preventDefault();

	}

	if(!passportexp.val()) {

		$('#passportexp').css('border', '1px solid red');

		$('#passportexp').focus();

		e.preventDefault();

	}

	if(!visa.val()) {

		$('#visa').css('border', '1px solid red');

		$('#visa').focus();

		e.preventDefault();

	}

	if(!visa_valid.val()) {

		$('#visa_valid').css('border', '1px solid red');

		$('#visa_valid').focus();

		e.preventDefault();

	}

	

	if(arrival_date.val()) {

		$('#arrival_date').css('border', '');

	}



	if(arrlocation.val()) {

		$('#arrlocation').css('border', '');

	}

	if(passport.val()) {

		$('#passport').css('border', '');

	}

	if(passportexp.val()) {

		$('#passportexp').css('border', '');

	}



	if(visa.val()) {

		$('#visa').css('border', '');

	}

	if(visa_valid.val()) {

		$('#visa_valid').css('border', '');

	}



	

});



</script>";

	

?>