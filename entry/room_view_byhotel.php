<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

include('is_login.php');

$hotel_id = $_COOKIE['hotel_id'] = $_GET['hotel_id'];
$hotels = $obj->getHotelDetailsById($hotel_id); 
$all_hotels = $obj->getAllHotelDetails(); 



$ground = $obj->getGroundFloorRoom($hotel_id);
$floor1 = $obj->getFirstFloorRoom($hotel_id);
$floor2 = $obj->getFirstSecondRoom($hotel_id); 
$floor3 = $obj->getFirstThirdRoom($hotel_id);  
$floor4 = $obj->getFirstFounthRoom($hotel_id);  
$msg="";
?>

<?php echo '

<div class="content_wrapper"> ';?>
	<?php if( !empty( $ground ) ) { ?>
	<?php echo ' <div class="row mt10">
		<div class="col-md-12">';?>
			<?php if(isset($msg)){?>
			<?php echo '<span> ';?><?php echo $msg;?><?php echo ' </span> ';?>
			<?php } if(isset($_SESSION['success'])){ ?>
			<?php echo '
			<span style="color:green;"><b>';?>?php echo $_SESSION['success']; unset($_SESSION['success']);?><?php echo ' </b></span>';?>
			<?php } elseif (isset($_SESSION['error'])) { ?>
			<?php echo '<span style="color:red;"><b>';?><?php echo $_SESSION['error']; unset($_SESSION['error']);?><?php echo '</b></span>';?>
			<?php }?>
			<?php echo '<h3 class="heading">Groun Floor</h3>';?>
			<?php foreach ($ground as $ground_value) { 
				if($ground_value['room_status']=="booked"){
					?>
					<?php echo '<div class="col-md-2 rooms rooms_booked" >
						<h4 class="text-center room_text"><a href="room_guest_details.php?room_number=';?><?php echo $ground_value['room_number'];?><?php echo '" >';?><?php echo $ground_value['room_number'];?><?php echo '</a></h4>
					</div>';?>
				<?php } elseif ($ground_value['room_status']=="empty") { ?>
				<?php echo '<div class="col-md-2 rooms rooms_vacant">
						<h4 class="text-center room_text"><a href="#empty" data-toggle="modal" id="';?><?php echo $ground_value['room_number'];?>" ><?php echo $ground_value['room_number'];?><?php echo '</a></h4>
					</div>';?>
				<?php } elseif ($ground_value['room_status'] == "cleaning") { ?>

				<?php echo '<div class="col-md-2 rooms rooms_ready">
						<h4 class="text-center room_text"><a href="#ready" data-toggle="modal" id="';?><?php echo $ground_value['room_number'];?>"><?php echo $ground_value['room_number'];?><?php echo '</a></h4>
					</div>';?>
			<?php } } ?>
		<?php echo '</div>';?><!--col-md-12-->
	<?php echo '</div>';?><!--row-->
	<?php } if ( !empty( $floor1 )  ) { ?>
	<?php echo '<div class="row mt10">
		<div class="col-md-12">';?>
			<?php if(isset($_SESSION['success'])){ ?>
			<?php echo '<span style="color:green;"><b>';?><?php echo $_SESSION['success']; unset($_SESSION['success']);?><?php echo '</b></span>';?>
			<?php } elseif (isset($_SESSION['error'])) { ?>
			<?php echo '<span style="color:red;"><b>';?><?php echo $_SESSION['error']; unset($_SESSION['error']);?><?php echo '</b></span>';?>
			<?php } ?>
			<?php echo '<h3 class="heading">First Floor</h3>';?>
			<?php foreach ($floor1 as $floor1_value) { 
				if($floor1_value['room_status']=="booked"){
			?>

			<?php echo '<div class="col-md-2 rooms rooms_booked" >
				<h4 class="text-center room_text"><a href="room_guest_details.php?room_number=';?><?php echo $floor1_value['room_number'];?>"><?php echo $floor1_value['room_number'];?><?php echo '</a></h4>
			</div>';?>
			<?php } elseif ($floor1_value['room_status']=="empty") { ?>
			<?php echo '<div class="col-md-2 rooms rooms_vacant">

				<h4 class="text-center room_text"><a href="#empty" data-toggle="modal" id="';?><?php echo $floor1_value['room_number'];?>"><?php echo $floor1_value['room_number'];?><?php echo '</a></h4>

			</div>';?>

			<?php } elseif ($floor1_value['room_status'] == "cleaning") { ?>
			<?php echo '<div class="col-md-2 rooms rooms_ready">
				<h4 class="text-center room_text"><a href="#ready" data-toggle="modal" id="';?><?php echo $floor1_value['room_number'];?>"><?php echo $floor1_value['room_number'];?><?php echo '</a></h4>

			</div>';?>
			<?php } } ?>
		<?php echo '</div>';?><!--col-md-12-->
	<?php echo '</div>';?><!--row-->
	<?php } if ( !empty( $floor2 )  ) { ?>
	<?php echo '<div class="row mt10">
		<div class="col-md-12">';?>

			<?php if(empty($floor1)){ ?>

			<?php echo '<h3 style="color:#0E3070;">';?><?php echo $hotels['hotel_name']?><?php echo '</h3>';?>

			<?php if(isset($_SESSION['success'])){ ?>

			<?php echo '<span style="color:green;"><b>';?><?php echo $_SESSION['success']; unset($_SESSION['success']);?><?php echo '</b></span>';?>

			<?php } elseif (isset($_SESSION['error'])) { ?>

			<?php echo '<span style="color:red;"><b>';?><?php echo $_SESSION['error']; unset($_SESSION['error']);?><?php echo '</b></span>';?>

			<?php } ?>

			<?php } ?>

			<?php echo '<h3 class="heading">Second Floor</h3>';?>



			<?php foreach ($floor2 as $floor2_value) { 



				if($floor2_value['room_status']=="booked"){



			?>



			<?php echo '<div class="col-md-2 rooms rooms_booked" >



				<h4 class="text-center room_text"><a href="room_guest_details.php?room_number=';?><?php echo $floor2_value['room_number'];?>"><?php echo $floor2_value['room_number'];?><?php echo '</a></h4>';?>



			<?php echo '</div>';?>



			<?php } elseif ($floor2_value['room_status']=="empty") { ?>



			<?php echo '<div class="col-md-2 rooms rooms_vacant">



				<h4 class="text-center room_text"><a href="#empty" data-toggle="modal" id="';?><?php echo $floor2_value['room_number'];?>"><?php echo $floor2_value['room_number'];?><?php echo '</a></h4>



			</div>';?>



			<?php } elseif ($floor2_value['room_status'] == "cleaning") { ?>



			<?php echo '<div class="col-md-2 rooms rooms_ready">



				<h4 class="text-center room_text"><a href="#ready" data-toggle="modal" id="';?><?php echo $floor2_value['room_number'];?>"><?php echo $floor2_value['room_number'];?><?php echo '</a></h4>



			</div>';?>



			<?php } } ?>



		<?php echo '</div>';?><!--col-md-12-->



	<?php echo '</div>';?><!--row-->

	<?php } if ( !empty( $floor3 )  ) { ?>

	<?php echo '<div class="row mt10">



		<div class="col-md-12">';?>

			<?php if(empty($floor2)){ ?>

			<?php echo '<h3 style="color:#0E3070;">';?><?php echo $hotels['hotel_name']?><?php echo '</h3>';?>

			<?php if(isset($_SESSION['success'])){ ?>

			<?php echo '<span style="color:green;"><b>';?><?php echo $_SESSION['success']; unset($_SESSION['success']);?><?php echo '</b></span>';?>

			<?php } elseif (isset($_SESSION['error'])) { ?>

			<?php echo '<span style="color:red;"><b>';?><?php echo $_SESSION['error']; unset($_SESSION['error']);?><?php echo '</b></span>';?>

			<?php } ?>

			<?php } ?>

			<?php echo '<h3 class="heading">Third Floor</h3>';?>



			<?php foreach ($floor3 as $floor3_value) { 



				if($floor3_value['room_status']=="booked"){ ?>



				<?php echo '<div class="col-md-2 rooms rooms_booked" >



					<h4 class="text-center room_text"><a href="room_guest_details.php?room_number=';?><?php echo $floor3_value['room_number'];?>"`><?php echo $floor3_value['room_number'];?><?php echo '</a></h4>



				</div>';?>



				<?php } elseif ($floor3_value['room_status']=="empty") { ?>



				<?php echo '<div class="col-md-2 rooms rooms_vacant">



					<h4 class="text-center room_text"><a href="#empty" data-toggle="modal" id="';?><?php echo $floor3_value['room_number'];?>"><?php echo $floor3_value['room_number'];?><?php echo '</a></h4>



				</div>';?>



				<?php } elseif ($floor3_value['room_status'] == "cleaning") { ?>



				<?php echo '<div class="col-md-2 rooms rooms_ready">



					<h4 class="text-center room_text"><a href="#ready" data-toggle="modal" id="';?><?php echo $floor3_value['room_number'];?>"><?php echo $floor3_value['room_number'];?><?php echo '</a></h4>



				</div>';?>



			<?php } } ?>



		<?php echo '</div>';?><!--col-md-12-->



	<?php echo '</div>';?><!--row-->

	<?php } if ( !empty( $floor4 )  ) { ?>

		<?php echo '<div class="row mt10">

			<div class="col-md-12">';?>

				<?php if(empty($floor3)){ ?>

				<?php echo '<h3 style="color:#0E3070;">';?><?php echo $hotels['hotel_name']?><?php echo '</h3>';?>

				<?php if(isset($_SESSION['success'])){ ?>

				<?php echo '<span style="color:green;"><b>';?><?php echo $_SESSION['success']; unset($_SESSION['success']);?><?php echo '</b></span>';?>

				<?php } elseif (isset($_SESSION['error'])) { ?>

				<?php echo '<span style="color:red;"><b>';?><?php echo $_SESSION['error']; unset($_SESSION['error']);?><?php echo '</b></span>';?>

				<?php } ?>

				<?php } ?>

				<?php echo '<h3 class="heading">Fourth Floor</h3>';?>

				<?php foreach ($floor4 as $floor4_value) { 

					if($floor3_value['room_status']=="booked"){ ?>

					<?php echo '<div class="col-md-2 rooms rooms_booked" >

						<h4 class="text-center room_text"><a href="room_guest_details.php?room_number=';?><?php echo $floor4_value['room_number'];?>"`><?php echo $floor4_value['room_number'];?><?php echo '</a></h4>

					</div>';?>

					<?php } elseif ($floor4_value['room_status']=="empty") { ?>

					<?php echo '<div class="col-md-2 rooms rooms_vacant">

						<h4 class="text-center room_text"><a href="#empty" data-toggle="modal" id="';?><?php echo $floor4_value['room_number'];?>"><?php echo $floor4_value['room_number'];?><?php echo '</a></h4>

					</div>';?>

					<?php } elseif ($floor4_value['room_status'] == "cleaning") { ?>

					<?php echo '<div class="col-md-2 rooms rooms_ready">

						<h4 class="text-center room_text"><a href="#ready" data-toggle="modal" id="';?><?php echo $floor4_value['room_number'];?>"><?php echo $floor4_value['room_number'];?><?php echo '</a></h4>

					</div>';?>

				<?php } } ?>

			<?php echo '</div>';?><!--col-md-12-->

		<?php echo '</div>';?><!--row-->

	<?php } ?>

	<?php echo '

</div>



</div>



<div class="clearfix"></div>





<a href="#x" class="overlay" id="empty"></a>

<div class="popup1"> 

	<h3 class="text-center">Room is ready To Book</h3>

		<span id="success"></span>

		<form action="insert_data.php" class="idealforms" id="checkin_form" enctype="multipart/form-data" role="form" name="checkin_form" autocomplete="on">

			<span id="messsage" style="color:red;font-weight:bold;"></span>

			<div class="wrapagain">

				<span id="wrapelement0">

					<div class="field">

						<label class="main">Full Name<span style="color:red;"> * </span>:</label>

						<select name="nametitle[]" id="small_select" class="nametitle">';?>

							<?php 

							$nametitles= array('Mr','Mrs','Miss');

							foreach ($nametitles as $namet) { 

								if(isset($_SESSION['nametitle'])){

							?>

							<?php echo '<option value="';?><?php echo $namet; ?>"<?php if($_SESSION['nametitle'][0] == $namet) echo 'selected="selected"';?>><?php echo $namet;?><?php echo '</option>';?>

							<?php } else{ ?>

							<?php echo '<option value="';?><?php echo $namet; ?>"><?php echo $namet;?><?php echo '</option>';?>

							<?php } } ?>

						<?php echo '</select>';?>

						<?php if(isset($_SESSION['fname'])){ ?>

							<?php echo '<input name="fname[]" id="fname" value="';?><?php echo $_SESSION['fname'][0];?>" <?php echo 'class="ipt_small" type="text" placeholder="Enter Your Full Name" >';?>

						<?php  } else { ?>

							<?php echo '<input name="fname[]" id="fname" class="ipt_small" type="text" placeholder="Enter Your Full Name" >';?>

						<?php } ?>

					<?php echo '</div>

					<div class="field">

						<label class="main">Gender:</label>

						<select name="gender[]" id="selectt" class="gender" style="width: 278px!important;">';?>

							<?php $genders = array('Male','Female','Other');

							foreach ($genders as $gender) {

								if(isset($_SESSION['gender'])){

							?>

							<?php echo '<option value="';?><?php echo $gender;?>"<?php if($_SESSION['gender'][0]== $gender) echo'selected="selected"'; ?>><?php echo $gender;?><?php echo '</option>';?>

							<?php } else { ?>

							<?php echo '<option value="';?><?php echo $gender;?>"><?php echo $gender;?><?php echo '</option>';?>

							<?php } } ?>

						<?php echo '</select>

					</div>

				</span>';?>

				<!-- here code for updade only -->

				<?php 

				if(isset($_SESSION['fname'])){

					$i=1;

					$count = count($_SESSION['fname']);

					if($count > $i){

						for ($y=1; $y < $count; $y++) {  ?>

							<?php echo '<span id="wrapelement';?><?php echo $i;?><?php echo '">

							<div class="field">

								<label class="main">Full Name<span style="color:red;"> * </span>:</label>



								<select name="nametitle[]" id="small_select" class="nametitle">';?>

									<?php 

									$nametitles= array('Mr','Mrs','Miss');

									foreach ($nametitles as $namet) { 

										if(isset($_SESSION['nametitle'])) {

									?>

										<?php echo '<option value="';?><?php echo $namet; ?>"<?php if($namet == $_SESSION['nametitle'][$i]) echo 'selected="selected"';?>><?php echo $namet;?><?php echo '</option>';?>

										<?php } else {?>

										<?php echo '<option value="<?php echo $namet; ?>"><?php echo $namet;?></option>';?>

									<?php } } ?>

								<?php echo '</select>';?>

								<?php if(isset($_SESSION['fname'])){ ?>

								<?php echo '<input name="fname[]" id="fname" value="';?><?php echo $_SESSION['fname'][$i];?><?php echo '" class="ipt_small" type="text" placeholder="Enter Your Full Name" >';?>

								<?php  } else { ?>

								<?php echo '<input name="fname[]" id="fname" value="" class="ipt_small" type="text" placeholder="Enter Your Full Name" >';?>

								<?php } ?>

							<?php echo '</div>

							<div class="field">

								<label class="main">Gender:</label>

								<select name="gender[]" id="selectt" class="gender" style="width:278px!important;">';?>

									<?php $genders = array('Male','Female','Other');



										foreach ($genders as $gender) {

											if(isset($_SESSION['gender'])) {

												//foreach ( $_SESSION['gender'] as $SSgender ) {

									?>

									<?php echo '<option value="';?><?php echo $gender;?>" <?php if($gender == $_SESSION['gender'][$i]) echo 'selected="selected"';?>><?php echo $gender;?><?php echo '</option>';?>

									<?php } else { ?>

									<?php echo '<option value="';?><?php echo $gender;?>"><?php echo $gender;?><?php echo '</option>';?>

									<?php } }  ?>

								<?php echo '</select>';?>

							<?php echo '</div>';?>

						<?php echo '</span>';?>

						<?php ++$i;?>

						<?php } ?>

						<?php echo '<span id="wrapelement';?><?php echo $i;?><?php echo '"></span>';?>

						<?php echo '<input type="hidden" id="i" value="';?><?php echo $i; ?><?php echo '" >';?>

				<?php } } else { ?>

				<?php echo '<span id="wrapelement1"></span>';?>

				<?php  } ?>

			<?php echo '</div>

			<div  class="field buttons">

				<label class="main">&nbsp;</label>

				<input type="button" id="add_row" value="Add Person" class="add_person">

				<input type="button" id="delete_row" value="Delete Person" class="delete_person">

			</div>

			<div class="clear"></div>

			<div class="field">

				<label class="main">E-Mail<span style="color:red;"> * </span>:</label>';?>

				<?php echo '<input name="email" id="email" type="text" value="';?><?php if(isset($_SESSION['email'])) echo $_SESSION['email'];?><?php echo '" class="ipt"  placeholder="Enter your Email ID">

			</div>';?>



			<?php echo '<div class="field">

				<label class="main">Phone No<span style="color:red;"> * </span>:</label>

				<input name="phone" id="phone" value="';?><?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'];?><?php echo '" type="text" class="ipt"  placeholder="Enter your Phone Number">

			</div>

			<div class="field">

				<label class="main">Coming From:<br>(Last Location)<span style="color:red;"> * </span>:</label>

				<input id="lastlocation" name="lastlocation" class="ipt" value="';?><?php if(isset($_SESSION['lastlocation'])) echo $_SESSION['lastlocation'];?><?php echo '" type="text" placeholder="Your Last Location"   >

			</div>

			<div class="field">

				<label class="main">Going To:<br>(Next Location)<span style="color:red;"> * </span>:</label>

				<input id="nextlocation" name="nextlocation" value="';?><?php if(isset($_SESSION['nextlocation'])) echo $_SESSION['nextlocation'];?><?php echo '" class="ipt"  type="text" placeholder="Your Next Location"   >

			</div>

			<div class="field">

				<label class="main">Check In Date<span style="color:red;"> * </span>:</label>

				<input class="date-pick ipt" type="text" value="';?><?php if(isset($_SESSION['checkin'])) echo $_SESSION['checkin'];?><?php echo '" id="checkin" name="checkin" placeholder="Check In Date">

			</div>

			

			<div class="field">

				<label class="main">Check Out Date<span style="color:red;"> * </span>:</label>

				<input class="date-pick ipt" type="text" id="checkout" value="';?><?php if(isset($_SESSION['checkout'])) echo $_SESSION['checkout'];?><?php echo '" name="checkout" placeholder="Check Out Date">

			</div>

			<div class="field">

				<label class="main">Booking Nights<span style="color:red;"> * </span>:</label>

				<input name="nights" id="nights" type="number" value="';?><?php if(isset($_SESSION['nights'])) echo $_SESSION['nights'];?><?php echo '" class="ipt"  placeholder="Enter Booking Nights">

			</div>

			<div class="field">

				<label class="main">Purpouse<span style="color:red;"> * </span>:</label>

				<select name="purpose" id="selectt" class="purpose">

					<option value="">Select an purpouse</option>';?>

					<?php

					$purpouses = array('Tourist','Official/Bussiness','Medical','Exam','Interview','Other');

					foreach ($purpouses as $purpouse) { 

						if(isset($_SESSION['purpose'])){

					?>

					<?php echo '<option value="';?><?php echo $purpouse;?>"<?php if($_SESSION['purpose'] == $purpouse ) echo 'selected="selected"';?>><?php echo $purpouse;?><?php echo '</option>';?>

					<?php } else { ?>

					<?php echo '<option value="';?><?php echo $purpouse;?>"><?php echo $purpouse;?><?php echo '</option>';?>

					<?php } } ?>

				<?php echo '</select>

			</div>

			<p>&nbsp;</p>

			<h4><input type="button" class="reset" style="padding:5px 20px 5px 20px;" id="reset" value="Reset" />&nbsp;<a id="submitform" title="" href="##">Book Now</a></h4>

		</form>

	<a class="close" href=""></a> 

</div>

		<a href="#x" class="overlay" id="ready"></a>

		<div class="popup1"> 

			<h3 class="text-center">Room is Under Cleaning</h3>

			<h4><a href="?room_status=empty" id="ready">Ready To Book</a></h4>

			<a class="close" href=""></a> 

		</div>



		<a href="#recheckin" class="overlay" id="recheckin"></a>

		<div class="popup1"> ';?>

		<!-- recheckin modal-->

		<?php echo '</div>';?>
<?php echo ' 
<script>
	$(document).ready(function(){var touch=$("#touch-menu");var menu=$(".menu");$(touch).on("click",function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(":hidden")){menu.removeAttr("style");}});});
	</script>
	<script type="text/javascript">

	$("a[data-toggle=modal]").click(function(){
		var room_number = $(this).attr("id");
		$("a[href=?room_status=empty]").attr("href", "?room_status=empty&room_number="+room_number);
		$("form[action=insert_data.php]").attr("action", "insert_data.php?room_number="+room_number);
		$("a[title=""]").attr("title", room_number);

	});
	</script>
	<script>
	$(document).ready(function () {

		$("#checkin").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });

		$("#checkout").datepicker({ beforeShow: setminDate });

		var start1 = $("#checkin");      
		function setminDate() {          
			var p = start1.datepicker("getDate");          
			if (p) { 
				var k ="01/30/2012";            
				return {
					minDate: p,
					maxDate:k
				}};         
			}           
			function clearEndDate(dateText, inst) {          
				end1.val("");      
			}  
		});
	$(function() {
		$( "#checkout" ).datepicker({ dateFormat: "mm/dd/yyyy" });
		$( "#checkin" ).datepicker({ dateFormat: "mm/dd/yyyy" });
	});
	$("#nights").click(function() {
		var start = $("#checkin").datepicker("getDate");
		var end   = $("#checkout").datepicker("getDate");
		var days   = (end - start)/1000/60/60/24;
		$("#nights").val(days);
	});
	</script>
	<script type="text/javascript">

	$("a[data-toggle=modalbooked]").click(function(){

		var room_number = $(this).attr("id");
		$.ajax({
			url : "room_guest_details.php?room_number="+room_number,
			success:function(data){
				$(".popup").show().html(data);
			}

		});

	});

	</script>
	
	<script>
		$(document).ready(function(){
			var var_i = $("#i");
			if(var_i.val()){
				var i= var_i.val();
				$("#delete_row").show();
			} else {
				var i=1;
				$("#delete_row").hide();
			}
			
			
			$("#add_row").click(function(){
				$("#wrapelement"+i).html("<div class="field"><label class="main">Full Name:</label><select name="nametitle[]" id="small_select"><option value="Mr" selected>Mr</option><option value="Mrs">Mrs</option><option value="Miss">Miss</option></select><input name="fname[]" id="fname" class="ipt_small" type="text" placeholder="Enter Your Full Name" ></div><div class="field"><label class="main">Gender:</label><select name="gender[]" id="selectt" class="gender" style="width: 278px!important;"><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div>");
				$(".wrapagain").append("<span id="wrapelement"+(i+1)+""></span>");
				i++; 
				$("#delete_row").show();
			});
			$("#delete_row").click(function(){
				if(i <= 2){
					$("#delete_row").hide();
				}
				if(i>1){
					$("#wrapelement"+(i-1)).html("");
					i--;
				}
			});
		});
	</script>
	<script type="text/javascript">

	$("#email").keypress(function(){

		var email = $("#email").val();
		$.ajax({

			url : "insert_data.php?email="+email,
			success:function(data){

				$("#messsage").html(data);

			}

		});

	});

	</script>
	<script type="text/javascript">
	$("#phone").click(function(){
		var email = $("#email").val();
		$.ajax({
			url : "insert_data.php?email="+email,
			success:function(data){
				$("#messsage").html(data);
			}
		});
	});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){ 

		$("#fname,#email,#phone,.purpose,#checkin,#checkout,#lastlocation,#nextlocation").click(function(){
			$("#fname").css("border", "");
			$("#email").css("border", "");
			$("#phone").css("border", "");
			$(".purpose").css("border", "");
			$("#checkin").css("border", "");
			$("#checkout").css("border", "");
			$("#lastlocation").css("border", "");
			$("#nextlocation").css("border", "");
		})

	});

	$("a[href="##"]").on("click", function(e) {

		var fname = $("#fname");
		var email = $("#email");
		var phone = $("#phone");
		var purpose = $(".purpose");
		var checkin = $("#checkin");
		var checkout = $("#checkout");
		var lastlocation = $("#lastlocation");
		var nextlocation = $("#nextlocation");
		
		if(!fname.val()) {
			$("#fname").css("border", "1px solid red");
			$("#fname").focus();
			e.preventDefault();
		} 
		if(!email.val()) {
			$("#email").css("border", "1px solid red");
			$("#email").focus();
			e.preventDefault();
			
		} 

		if(!phone.val()) {
			$("#phone").css("border", "1px solid red");
			$("#phone").focus();
			e.preventDefault();
		} 
		
		if(!checkin.val()) {
			$("#checkin").css("border", "1px solid red");
			$("#checkin").focus();
			e.preventDefault();
		} 
		if(!checkout.val()) {
			$("#checkout").css("border", "1px solid red");
			$("#checkout").focus();
			e.preventDefault();
		} 
		if(!lastlocation.val()) {
			$("#lastlocation").css("border", "1px solid red");
			$("#lastlocation").focus();
			e.preventDefault();
		} 
		if(!nextlocation.val()) {
			$("#nextlocation").css("border", "1px solid red");
			$("#nextlocation").focus();
			e.preventDefault();
		} 
		if(!purpose.val()) {
			$(".purpose").css("border", "1px solid red");
			$(".purpose").focus();
			e.preventDefault();
		}

		if(fname.val()) {
			$("#fname").css("border", "");
		}
		
		if(email.val()) {
			$("#email").css("border", "");
		}

		if(phone.val()) {
			$("#phone").css("border", "");
		}

		if(checkin.val()) {
			$("#checkin").css("border", "");
		}

		if(checkout.val()) {
			$("#checkout").css("border", "");
		}

		if(lastlocation.val()) {
			$("#lastlocation").css("border", "");
		}
		if(nextlocation.val()) {
			$("#nextlocation").css("border", "");
		}
		if(purpose.val()) {
			$(".purpose").css("border", "");
			$("a[href="##"]").attr("href", "#");
		}


	});

	</script>
	<script type="text/javascript">
		$("a[id="submitform"]").click(function(){
			var room_number = $(this).attr("title");
			$.ajax({
				url : "insert_data.php?type=quickbooking&room_number="+room_number,
				type : "POST",
				data : $("form").serialize(),
				cache: false,
				success:function(data){
					if(data == "Error! All field are required."){

					}else if(data == "success"){
						window.location.reload();
					}else{
						alert(data);
					}
				}
			});
		});
	</script>

	<script type="text/javascript">
		$(".nametitle").change(function(){
			var nametitle = $(this).attr("value");
			if(nametitle == "Mrs" || nametitle == "Miss"){
				$(".gender").val("Female");
			}else {
				$(".gender").val("Male");
			}	
		});
	</script>
	<script type="text/javascript">
		$(".gender").change(function(){
			var gender = $(this).attr("value");
			if(gender == "Female"){
				$(".nametitle").val("Mrs");
			}else {
				$(".nametitle").val("Mr");
			}	
		});
	</script>

	<script type="text/javascript">
		$("#email,#phone,.purpose,#checkin,#checkout,#lastlocation,#nextlocation").click(function(){
			var formData =$("#checkin_form").serialize();
			$.ajax({
				type : "POST",
				url : "insert_data.php?type=save_formdata",
				data : formData,
				success:function(data){
				}
			});
			
		});
	</script>

	<script type="text/javascript">
	  $("a[data-toggle="modalrecheckin"]"").click(function(){
	  	var checkin_id = $(this).attr("id");
	  	$.ajax({
	      url : "recheckin.php?checkin_id="+checkin_id,
	      success:function(data){
	        $(".popup").show().html(data);
	      }
	    });
	  });
	</script>
	<script type="text/javascript">
		$("select.hotel").change(function(e){
			var $this = $(this);
			if(!$this.hasClass("active")){
				$this.addClass("active");
			}
			e.preventDefault();
		});
	</script>

</body>

</html>';?>



