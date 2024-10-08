<?php 
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include('../include/header.php');
include('is_login.php');

$_SESSION['PAGE_TITLE'] = "Entry form preview";


if(isset($_REQUEST['preview'])){
	$hotel_id = $_COOKIE['hotel_id'];
	
	$serial = $_SESSION['serial'] = $_POST['serial'];

	$fname = $_SESSION['fname'] = $_POST['fname'];
	$gender = $_SESSION['gender'] = $_POST['gender'];
	
	foreach ($gender as $gen) {
		if($gen == 'Male'){
			$nametitle[] = 'Mr';
		}else{
			$nametitle[] = 'Mrs';
		}
	}
	$_SESSION['nametitle'] = $nametitle ;
	
	$_SESSION['no_gender']= count($gender);

	/*if(isset($_POST['relation'])){

		$relation = $_SESSION['relation'] = $_POST['relation'];

	}*/

	$email = $_SESSION['email'] = $_POST['email'];

	$phone = $_SESSION['phone'] = $_POST['phone'];

	$fkcountry = $_SESSION['fkcountry'] = $_POST['fkcountry'];
	if(isset($_POST['city'])){
		$city = $_SESSION['city'] = $_POST['city'];
	}else{
		$city = "";
	}
	

	if(isset($_POST['pin'])){
		$pin = $_SESSION['pin'] = $_POST['pin'];
	}else{
		$pin = "";
	}
	if(isset($_POST['day'])){
		$day = $_SESSION['day'] = $_POST['day'];
	}else{
		$day = "";
	}
	if(isset($_POST['month'])){
		$month = $_SESSION['month'] = $_POST['month'];
	}else{
		$month =  "";
	}
	if(isset($_POST['year'])){
		$year = $_SESSION['year'] = $_POST['year'];
	}else{
		$year = "";
	}

	$idname = $_SESSION['idname'] = $_POST['idname'];

	if(isset($_POST['idno'])){
		$idno = $_SESSION['idno'] = $_POST['idno'];
	}else{
		$idno = "";
	}

	if(isset($_POST['lastlocation'])){

		$lastlocation = $_SESSION['lastlocation'] = $_POST['lastlocation'];
	}else{
		$lastlocation =  "";
	}

	if(isset($_POST['nextlocation'])){

		$nextlocation = $_SESSION['nextlocation'] = $_POST['nextlocation'];
	}else{
		$nextlocation = "";
	}

	$purpose = $_SESSION['purpose'] = $_POST['purpose']; 
	
	if($_FILES['picture']['error'][0] == 0){
		
		$ids_name = $_FILES['picture']['name'];
		//$ids_temp_ame =$_SESSION['tmpids'] = $_FILES['picture']['tmp_name'];
		$destination = 'upload/checkinimages/';
		
		$allowed_ext = array('jpg','jpeg');

		$count = count($ids_name);

		for ($i=0; $i< $count ;  $i++ ) {
			
			if($_FILES['picture']['size'][$i] < 4000000){
				
				$realfilename = str_replace(' ','_', $_FILES['picture']['name'][$i]);
				$final_image_nm = mt_rand().$realfilename;
				
				$filename = $final_image_nm;
				$image_name[] =$filename;

				$filetempname = $_FILES['picture']['tmp_name'][$i];
				
				$fileext = pathinfo($filename, PATHINFO_EXTENSION);

				$fileext = strtolower($fileext);

				//$file_name = mt_rand().

				if(in_array($fileext, $allowed_ext)){

				  	move_uploaded_file($filetempname, $destination.$filename);
				    
				    if($_FILES['picture']['size'][$i] > 200000){
				    	$imagepath = $filename;

					  	//compression code start
			          	$file = $destination.$imagepath; //This is the original file

			          	list($width, $height) = getimagesize($file) ; 

			          	$modwidth = 700; 

			          	$diff = $width / $modwidth;

			          	$modheight = 900; 
			          	$tn = imagecreatetruecolor($modwidth, $modheight) ; 
			          	$image = imagecreatefromjpeg($file) ; 
			          	imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

			          	imagejpeg($tn, $file, 90) ;
				    }
				   	
				}else{
					$_SESSION['error'] = "Invalid file Formate! You can upload only (jpg|jpeg) format file.";
					die("<script>location.href = 'index.php'</script>");
				}
			}else{
	        	$_SESSION['error'] = "Error...Please select file < 4 mb.";
				die("<script>location.href = 'index.php'</script>");
	        }
		}
		$_SESSION['ids'] = $image_name;

	}
	
	if(isset($_POST['address'])){
		$address = $_SESSION['address'] = $_POST['address'];
	}else{
		$address =  "";
	}

	if(isset($_POST['arrival_date'])){

		$arrival_date = $_SESSION['arrival_date'] = $_POST['arrival_date'];

	}

	if(isset($_POST['arrlocation'])){

		$arrlocation = $_SESSION['arrlocation'] = $_POST['arrlocation'];

	}

	if(isset($_POST['passport'])){

		$passport = $_SESSION['passport'] = $_POST['passport'];

	}

	if(isset($_POST['passportexp'])){

		$passportexp = $_SESSION['passportexp'] = $_POST['passportexp'];

	}

	if(isset($_POST['visa'])){

		$visa = $_SESSION['visa'] = $_POST['visa'];

	}

	if(isset($_POST['visa_valid'])){

		$visa_valid = $_SESSION['visa_valid'] = $_POST['visa_valid'];

	}

	$booking_via = $_SESSION['booking_via'] = $_POST['booking_via'];
	$bookingid = $_SESSION['bookingid'] = $_POST['bookingid'];
	if(isset($_POST['checkin'])){
		$checkin = $_SESSION['checkin'] = $_POST['checkin'];
	}
	if(isset($_POST['checkout'])){
		$checkout = $_SESSION['checkout'] = $_POST['checkout'];
	}
	if(isset($_POST['nights'])){
		$nights = $_SESSION['nights'] = $_POST['nights'];
	}

	$roomno = $_SESSION['roomno'] = $_POST['roomno'];
	$adult = $_SESSION['adult'] = $_POST['adult'];
	$child = $_SESSION['child'] = $_POST['child'];
	$b_amount = $_SESSION['b_amount'] = $_POST['b_amount'];

	if(isset($_POST['ex_ad_charges'])){
		$ex_ad_charges = $_SESSION['ex_ad_charges'] = $_POST['ex_ad_charges'];
	}
	$meal_plan = $_SESSION['meal_plan'] = $_POST['meal_plan'];
}

?>

<div class="content">
	<div class="idealsteps-container">
		<nav class="idealsteps-nav"></nav>
		<form action="insert_data.php" class="idealforms" method="post" id="checkin_form">
			<div class="idealsteps-wrap">
				<section class="idealsteps-step1" id="id3">
					<div class="form-wizard">
						<div class="row">
							<div class="col-md-8 col-sm-7">
								<div class="data-container">
									<h3>Customer Personal Information</h3>
									<dl>
										<dt>Serial Number</dt>
										<?php if(!empty($serial)){ ?>
										<dd><?php echo $serial; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Full Name</dt>
										<?php 
										if(!empty($fname)){ 
										$count = count($fname);
										for($i=0; $i < $count ; $i++){ 
										?>
										<dd><?php echo $nametitle[$i].' '.$fname[$i];?></dd>
										<?php } } ?>
									</dl>
									<dl>
										<dt>Gender</dt>
										<?php 
										if(!empty($gender)){ 
										$count = count($gender);
										for($i=0; $i < $count ; $i++){ 
										?>
										<dd><?php echo $gender[$i]; ?></dd>
										<?php } } ?>
									</dl>

									<dl>
										<dt>Email Id</dt>
										<?php if(!empty($email)){ ?>
										<dd><?php echo $email; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Phone No</dt>
										<?php if(!empty($phone)){ ?>
										<dd><?php echo $phone; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Country</dt>
										<?php if(!empty($fkcountry)){ ?>
										<dd><?php echo $fkcountry; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>City</dt>
										<?php if(!empty($city)){ ?>
										<dd><?php echo $city; ?></dd>
										<?php } ?>
									</dl>
									
									<?php /*?><dl>
										<dt>Pin Code</dt>
										<?php if(!empty($pin)){ ?>
										<dd><?php echo $pin; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Date of Birth</dt>
										<?php if(!empty($day) && !empty($month) && !empty($year)){ ?>
										<dd><?php echo $day.' - '.$month.' - '.$year; ?></dd>
										<?php } ?>
									</dl><?php */?>
									<dl>
										<dt>Id Name</dt>
										<?php if(!empty($idname)){ ?>
										<dd><?php echo $idname; ?></dd>
										<?php } ?>
									</dl>
									<?php /*?><dl>
										<dt>Id Number</dt>
										<?php if(!empty($idno)){ ?>
										<dd><?php echo $idno; ?><dd>
										<?php } ?>
									</dl><?php */?>
									
									<dl>
										<dt>Last Location</dt>
										<?php if(!empty($lastlocation)){ ?>
										<dd><?php echo $lastlocation; ?><dd>
										<?php } ?>
									</dl>
								
									<?php if(isset($nextlocation)){ ?>
									<dl>
										<dt>Next Location</dt>
										<?php if(!empty($nextlocation)){  ?>
										<dd><?php echo $nextlocation; ?><dd>
										<?php } ?>
									</dl>
									<?php } ?>
									
									<dl>
										<dt>Purpouse</dt>
										<?php if(!empty($purpose)){  ?>
										<dd><?php echo $purpose; ?><dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Id Proof</dt>
										<?php
										if(isset($image_name)){
										foreach ($image_name as $id_name) { ?>
										<dd><?php echo $id_name; ?><dd>
										<?php } } ?>
									</dl>
									<?php /*?><dl>
										<dt>Address</dt>
										<?php if(!empty($address)){  ?>
										<dd><?php echo $address; ?></dd>
										<?php } ?>
									</dl><?php */?>

									<?php /*?><?php if(isset($arrival_date)){ ?>
										<dl>
											<dt>Arrival Date</dt>
											<?php if(isset($arrival_date)) { ?>
											<dd><?php echo $arrival_date; ?><dd>
											<?php } ?>
										</dl>

										
										<dl>
											<dt>Arrival Location</dt>
											<?php if(isset($arrlocation)) { ?>
											<dd><?php echo $arrlocation; ?><dd>
											<?php } ?>
										</dl>
										
										<dl>
											<dt>Passport No</dt>
											<?php  if(isset($passport)) { ?>
											<dd><?php echo $passport; ?></dd>
											<?php } ?>
										</dl>
										
										<dl>     
											<dt>Passport Valid upto</dt>
											<?php if(isset($passportexp)) { ?>
											<dd><?php echo $passportexp; ?></dd>
											<?php } ?>
										</dl>
										
										<dl>
											<dt>Visa No</dt>
											<?php if(isset($visa)) { ?>
											<dd><?php echo $visa; ?></dd>
											<?php } ?>
										</dl>
										
										<dl>
											<dt>Visa Valid upto</dt>
											<?php if(isset($visa_valid)) { ?>
											<dd><?php echo $visa_valid; ?></dd>
											<?php } ?>
										</dl>
									<?php } ?><?php */?>

									<hr>
									<h3>Customer Booking Information</h3>
									<dl>
										<dt>Booking Via</dt>
										<?php if(isset($booking_via)) { ?>
										<dd><?php echo $booking_via; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Booking ID</dt>
										<?php if(isset($booking_via)) { ?>
										<dd><?php echo $bookingid; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Check In Date</dt>
										<?php if(isset($checkin)){ ?>
										<dd><?php echo $checkin; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Check Out Date</dt>
										<?php if(isset($checkout)){ ?>
										<dd><?php echo $checkout; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Number of Nights</dt>
										<?php if(isset($nights)){ ?>
										<dd><?php echo $nights; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Extended Days</dt>
										<?php if(isset($edays)){ ?>
										<dd><?php echo $edays; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Room Number</dt>
										<?php if(isset($roomno)){ ?>
										<dd><?php echo $roomno; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Adult/Child</dt>
										<?php if(isset($adult)){ ?>
										<dd><?php echo $adult .'/'. $child; ?></dd>
										<?php } ?>
									</dl>
									<dl>
										<dt>Book Amount</dt>
										<?php if(!empty($b_amount)){ ?>
										<dd><?php echo $b_amount; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Extra Person Charge</dt>
										<?php if(!empty($ex_ad_charges)) { ?>
										<dd><?php echo $ex_ad_charges; ?></dd>
										<?php } ?>
									</dl>
									
									<dl>
										<dt>Meal Plan</dt>
										<?php if(!empty($meal_plan)) { ?>
										<dd><?php echo $meal_plan; ?></dd>
										<?php } ?>
									</dl>
								</div><!--/ .data-container-->
							</div>
						</div><!--/ .row-->
						<div class="field">
							<label class="main">Submit By<span style="color:red;"> * </span>:</label>
							<input name="submitby" id="valid" type="text" class="ipt"  placeholder="Enter Name">
						</div>
					</div>
					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<a href="index.php" style="text-decoration:none;">
								<input type="button" class="prev" value="&larr; Prev" />
							</a>
							<input type="submit" class="next" value="Submit" name="checkin_details"/>
						</div>
					</div>
				</section>
			</div>
		</form>
	</div>
</div> 
<?php include('../include/footer.php');?>
<script>
$('form.idealforms').idealforms('addRules', {
	'comments': 'required minmax:50:200'
});

$('.prev').on('click',function(){
	$('.prev').show();
	$('form.idealforms').idealforms('prevStep');
});

$(document).ready(function(){
 	$('#valid').click(function(){
 		$('#valid').css('border','');
 	});
 	$("input[type=submit]").click(function(){
 		var valid = $('#valid').val();
 		if(!valid){
 			$('#valid').css('border' , '1px solid red');
 			$('#valid').focus();
 			return false;
 		}

 		if(valid){
 			$('#valid').css('border', '');
 		}
 	});
 });
</script>



