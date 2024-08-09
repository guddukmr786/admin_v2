<?php 
include('../include/header.php');
include('is_login.php');
$countries = $obj->getCountries();
if(isset($_GET['room_number'])){
	$room_number = $_GET['room_number'];
}

$booking_vias = $obj->getAllBookingViaCategories();

//Updation code here
if(!empty($_GET['checkin_id']) && !empty($_GET['type'])){
	$checkin_id = $_SESSION['checkin_id'] = $_GET['checkin_id'];
	$_SESSION['type'] = $_GET['type'];
	$room_number = $_GET['room_number'];
	$unset_session = $obj->unsetEntryFormSession();
	
	$update_checkin_details = $obj->getCheckinDetailForUpdate($checkin_id, $hotel_id);
	
	$_SESSION['checkin_date'] = $checkin_date = $update_checkin_details['checkin_date'];
	$update_person_name = $obj->getCheckinPersonById($checkin_id, $checkin_date);
	$dateob = explode('-', $update_checkin_details['date_of_birth']);
	$_SESSION['checkout_date'] = $update_checkin_details['checkout_date'];
	$_SESSION['booking_nights'] = $update_checkin_details['booking_nights'];

	$day = $dateob[0];
	if(isset($dateob[1])){
		$month = $dateob[1];
	}
	if(isset($dateob[2])){
		$year = $dateob[2];
	}
	$noofperson = explode('/', $update_checkin_details['no_of_person']);
	$adult = $noofperson[0];
	if(isset($noofperson[1])){
		$child = $noofperson[1];
	}

	
}

?>
<style>
.preview {
    background-color: #f34343;
    border: none;
    color: white;
    padding: 7px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 2px 2px;
    cursor: pointer;
}
</style>

<div class="content">
		<div class="idealsteps-container">
			<nav class="idealsteps-nav"></nav>
			<form action="preview.php" class="idealforms" id="checkin_form" enctype="multipart/form-data" method="post" role="form" name="checkin_form" >
				<?php if(isset($_SESSION['success'])){ ?>
				<div align="center" style="color:green"><?php echo $_SESSION['success']; unset($_SESSION['success']);?>
				</div>	
				<?php } elseif(isset($_SESSION['error'])){  ?>
				<div align="center" style="color:red"><?php echo $_SESSION['error']; unset($_SESSION['error']);?>
				</div>
				<?php } ?>
				<div class="idealsteps-wrap">
					<!-- Step 1 -->
					<section class="idealsteps-step" data-step="0">
						<h3>Customer Personal Information</h3>
						<div class="field">
							<label class="main">R. Entry Number<span style="color:red;"> * </span>:</label>
							<?php if(isset($_SESSION['serial'])) { ?>
							<input name="serial" id="serial" type="text" value="<?php echo $_SESSION['serial'];?>" class="ipt"  placeholder="Enter serial number"></br>
							<?php } else { ?>
							<input name="serial" id="serial" type="text" value="<?php if(isset($update_checkin_details['serial_number'])) echo $update_checkin_details['serial_number']; ?>" class="ipt"  placeholder="Enter serial number"></br>
							<?php } ?>
								
						</div>
						<div class="clear"></div>
						<div class="wrapagain">
							<span id="wrapelement0">
								<div class="field">
									<label class="main">Full Name<span style="color:red;"> * </span>:</label>

									<?php if(isset($_SESSION['fname'])){ ?>
									<input name="fname[]" id="fname" value="<?php echo $_SESSION['fname'][0];?>" class="ipt" type="text" placeholder="Enter Your Full Name" >
									<?php  } else { ?>
									<input name="fname[]" id="fname" value="<?php if(isset($update_checkin_details['name'])) { $array_fname =explode(' ', $update_checkin_details['name']); echo $array_fname[1]; if(isset($array_fname[2])){ echo ''.' '.$array_fname[2];} if(isset($array_fname[3])){ echo ''.' '.$array_fname[3];}}?>" class="ipt" type="text" placeholder="Enter Your Full Name" >
									<?php } ?>
								</div>
								<div class="field">
									<label class="main">Gender:</label>
									<select name="gender[]" id="selectt" class="gender">
										<?php $genders = array('Male','Female','Other');

											foreach ($genders as $gender) {
												if(isset($_SESSION['gender'])) {
													//foreach ( $_SESSION['gender'] as $SSgender ) {
										?>
										<option value="<?php echo $gender;?>" <?php if($gender == $_SESSION['gender'][0]) echo 'selected="selected"';?>><?php echo $gender;?></option>
										
										<?php  } elseif (isset($update_checkin_details['gender'])) { ?>

										<option value="<?php echo $gender;?>" <?php if($gender == $update_checkin_details['gender'][0]) echo 'selected="selected"';?>><?php echo $gender;?></option>
										<?php } else { ?>
										<option value="<?php echo $gender;?>"><?php echo $gender;?></option>
										<?php } }  ?>
									</select>
								</div>
								
							</span>	
							<div class="clear"></div>
							<!-- here code for updade only -->
							<?php 
							if(isset($_SESSION['fname'])){
								$i=1;
								$count = count($_SESSION['fname']);
								if($count > $i){
									for ($y=1; $y < $count; $y++) {  ?>
										<span id="wrapelement<?php echo $i;?>">
										<div class="field">
											<label class="main">Full Name<span style="color:red;"> * </span>:</label>
											
											<?php if(isset($_SESSION['fname'])){ ?>
											<input name="fname[]" id="fname" value="<?php echo $_SESSION['fname'][$i];?>" class="ipt" type="text" placeholder="Enter Your Full Name" >
											<?php  } else { ?>
											<input name="fname[]" id="fname" value="" class="ipt" type="text" placeholder="Enter Your Full Name" >
											<?php } ?>
										</div>
										<div class="field">
											<label class="main">Gender:</label>
											<select name="gender[]" id="selectt" class="gender">
												<?php $genders = array('Male','Female','Other');

													foreach ($genders as $gender) {
														if(isset($_SESSION['gender'])) {
															//foreach ( $_SESSION['gender'] as $SSgender ) {
												?>
												<option value="<?php echo $gender;?>" <?php if($gender == $_SESSION['gender'][$i]) echo 'selected="selected"';?>><?php echo $gender;?></option>
												<?php } else { ?>
												<option value="<?php echo $gender;?>"><?php echo $gender;?></option>
												<?php } }  ?>
											</select>
										</div>
										
									</span>
									<?php ++$i;?>
									<?php } ?>
									<div class="clear"></div>
									<span id="wrapelement<?php echo $i;?>"></span>

									<input type="hidden" id="i" value="<?php echo $i; ?>" >
							<?php } } ?>
							<?php 
							if(!empty($update_person_name)){
							$i=1;
							foreach ($update_person_name as $update_person) {
							?>

								<span id="wrapelement<?php echo $i;?>">
									<div class="field">
										<label class="main">Full Name<span style="color:red;"> * </span>:</label>
										
										<input name="fname[]" id="fname" value="<?php if(isset($update_person['name'])) echo $update_person['name'];?>" class="ipt" type="text" placeholder="Enter Your Full Name" >
									</div>
									<div class="field">
										<label class="main">Gender:</label>
										<select name="gender[]" id="selectt" class="gender">
											<?php $genders = array('Male','Female','Other');

												foreach ($genders as $gender) {
												if (isset($update_checkin_details['gender'])) { 
											?>
											<option value="<?php echo $gender;?>" <?php if($gender == $update_person['gender']) echo 'selected="selected"';?>><?php echo $gender;?></option>
											<?php } else { ?>
											<option value="<?php echo $gender;?>"><?php echo $gender;?></option>
											<?php } }  ?>
										</select>
									</div>
									
								</span>
							<?php ++$i;?>
							<div class="clear"></div>
							<?php } ?>
							<div class="clear"></div>
							<span id="wrapelement<?php echo $i;?>"></span>
							<input type="hidden" id="i" value="<?php echo $i; ?>" >
							<?php } elseif (empty($_SESSION['fname']) && empty($update_person_name)) { ?>
							<div class="clear"></div>
							<span id="wrapelement1"></span>
							<?php } ?>
						</div>
						
						<!-- Button-->
						<div style="float:right;margin-right:85px;" class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" id="add_row" value="Add Person" class="add_person">
							<input type="button" id="delete_row" value="Delete Person" class="delete_person">
						</div>
						
						<div class="clear"></div>
						
						<div class="field">
							<label class="main">E-Mail<span style="color:red;"> * </span>:</label>
							<?php if(isset($_SESSION['email'])) { ?>
							<input name="email" id="email"  value="<?php echo $_SESSION['email'];?>" type="text" class="ipt"  placeholder="Enter your Email ID"></br>
							<?php } else { ?>
							<input name="email" id="email" type="text" value="<?php if(isset($update_checkin_details['email'])) echo $update_checkin_details['email']; ?>" class="ipt"  placeholder="Enter your Email ID"></br>
							<?php } ?>
						<span id="email_msg"></span>
						</div>

						<div class="field">
							<label class="main">Phone No<span style="color:red;"> * </span>:</label>
							<?php if(isset($_SESSION['phone'])) { ?>
							<input name="phone" id="phone" value="<?php echo $_SESSION['phone'];?>" type="text" class="ipt"  placeholder="Enter your Phone Number">
							<?php } else { ?>
							<input name="phone" id="phone" value="<?php if(isset($update_checkin_details['phone'])) echo $update_checkin_details['phone']; ?>" type="text" class="ipt"  placeholder="Enter your Phone Number">
							<?php } ?>
						</div>
						<div class="clear"></div>
						<div class="field">
							<label class="main">Country<span style="color:red;"> * </span>:</label>
							<select name="fkcountry" id="selectt" class="fkcountry">
								<option value="">Select Country</option>
								<?php foreach ($countries as $country) { 
									if(isset($_SESSION['fkcountry'])) {
								?>
								<option value="<?php echo $country['country_name']?>"<?php if($country['country_name'] == $_SESSION['fkcountry']) echo 'selected="selected"';?>><?php echo $country['country_name']?></option>
								
								<?php } elseif (isset($update_checkin_details['country'])) { ?>

								<option value="<?php echo $country['country_name']?>"<?php if($country['country_name'] == $update_checkin_details['country']) echo 'selected="selected"';?>><?php echo $country['country_name']?></option>
								<?php } else { ?>
								<option value="<?php echo $country['country_name']?>"><?php echo $country['country_name']?></option>
								<?php } } ?>
							</select>
						</div>
						<div class="field">
							<label class="main">City name:</label>
							<?php if(isset($_SESSION['city'])) { ?>
							<input name="city" id="city" value="<?php echo $_SESSION['city'];?>" type="text" class="ipt"  placeholder="Enter City Name">
							<?php } else { ?>
							<input name="city" id="city" value="<?php if(isset($update_checkin_details['state'])) echo $update_checkin_details['state']; ?>" type="text" class="ipt"  placeholder="Enter City Name">
							<?php } ?>
						</div>
						
									<div class="clear"></div>
									<div class="field">
										<label class="main">ID Name<span style="color:red;"> * </span>:</label>
										<select name="idname" class="idname" id="selectt">
											<option value="">Select an id proof</option>
											<?php 
											$id_names = array('Aadhar card','Driving License','Passport','Voter ID','Residential Proof (Govt. Issued)','Bank Passbook','Other');
											foreach ($id_names as $id_name) {
												if(isset($_SESSION['idname'])){
											?>
											<option value="<?php echo $id_name;?>"<?php if($id_name == $_SESSION['idname']) echo 'selected="selected"';?>><?php echo $id_name;?></option>
											<?php } elseif (isset($update_checkin_details['id_name'])) { ?>
											<option value="<?php echo $id_name;?>"<?php if($id_name == $update_checkin_details['id_name']) echo 'selected="selected"';?>><?php echo $id_name;?></option>
											<?php } else { ?>
											<option value="<?php echo $id_name;?>"><?php echo $id_name;?></option>
											<?php } } ?>
										</select>
									</div>

									<div class="field"> 
										<label class="main">ID's<span style="color:red;"> * </span>:</label>
										<input id="picture" name="picture[]" class="ipt"  type="file" placeholder="Select Multiple Id's using press CTRL and hold it."  multiple >
										<p style="font-size:10px;padding-left:5px;padding-left: 120px;">Select Multiple Id's using press CTRL and hold it.</p>
									</div>
									<div class="clear"></div>
									<div class="field">
										<label class="main">Coming From:<br>(Last Location)</label>
										<?php if(isset($_SESSION['lastlocation'])){ ?>
										<input id="lastlocation" name="lastlocation" value="<?php echo $_SESSION['lastlocation'];?>" class="ipt"  type="text" placeholder="Your Last Location"   >
										<?php } else { ?>
										<input id="lastlocation" name="lastlocation" value="<?php if(isset($update_checkin_details['last_location'])) echo $update_checkin_details['last_location']; ?>" class="ipt"  type="text" placeholder="Your Last Location"   >
										<?php } ?>
									</div>
									<div class="field">
										<label class="main">Going To:<br>(Next Location)</label>
										<?php if(isset($_SESSION['nextlocation'])){ ?>
										<input id="nextlocation" name="nextlocation" value="<?php echo $_SESSION['nextlocation'];?>" class="ipt"  type="text" placeholder="Your Next Location"   >
										<?php } else { ?>
										<input id="nextlocation" name="nextlocation"  value="<?php if(isset($update_checkin_details['next_location'])) echo $update_checkin_details['next_location']; ?>" class="ipt"  type="text" placeholder="Your Next Location"   >
										<?php } ?>
									</div>
									<div class="field">
										<label class="main">Purpouse<span style="color:red;"> * </span>:</label>
										<select name="purpose" id="selectt" class="purpose">
											<option value="">Select an purpouse</option>
											<?php
											$purpouses = array('Tourist','Official/Bussiness','Medical','Exam','Interview','Other');
											foreach ($purpouses as $purpouse) {
												if(isset($_SESSION['purpose'])) { 
											?>
											<option value="<?php echo $purpouse;?>"<?php if($purpouse == $_SESSION['purpose']) echo 'selected="selected"';?>><?php echo $purpouse;?></option>
											
											<?php } elseif (!empty($update_checkin_details['purpouse'])) { ?>

											<option value="<?php echo $purpouse;?>"<?php if($purpouse == $update_checkin_details['purpouse']) echo 'selected="selected"';?>><?php echo $purpouse;?></option>
											
											<?php } else { ?>
											<option value="<?php echo $purpouse;?>"><?php echo $purpouse;?></option>
											<?php } } ?>
										</select>
									</div>
									
									<div class="clear"></div>
									<div class="footer">
										<div class="field buttons">
											<label class="main">&nbsp;</label>
											<input type="button" class="reset" id="reset" value="Reset" />
											<input type="button" id="next" class="next" value="Next &rarr;" />
										</div>
									
									</div>
								</section>

								<!-- Step 2 -->

								<section class="idealsteps-step" data-step="1">
									<h3>Customer Booking Information</h3>

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
										<label class="main">Booking Nights<span style="color:red;"> * </span>:</label>
										<?php if(isset($_SESSION['nights'])){ ?>
										<input name="nights" id="nights" value="<?php echo $_SESSION['nights'];?>" type="number" class="ipt"  placeholder="Enter Booking Nights">
										<?php } elseif (isset($update_checkin_details['booking_nights'])) { ?>
										<input name="nights" id="nights" value="<?php echo $update_checkin_details['booking_nights']; ?>" type="number" class="ipt"  placeholder="Enter Booking Nights" >
										<?php } else { ?>
										<input name="nights" id="nights" type="number" class="ipt"  placeholder="Enter Booking Nights">
										<?php } ?>
									</div>
									<div class="field">
										<label class="main">Room Number<span style="color:red;"> * </span>:</label>
										<?php if(isset($_SESSION['roomno'])){ ?>
										<input name="roomno" id="roomno" value="<?php echo $_SESSION['roomno'];?>" type="text" class="ipt"  placeholder="Enter Room Number">
										<?php } else { ?>
										<input name="roomno" id="roomno" type="text" class="ipt" value="<?php if(isset($room_number)) echo $room_number;?>" placeholder="Enter Room Number">
										<?php } ?>
									</div>
									<div class="field">
										<label class="main">Booking Amount:</label>
										<?php if(isset($_SESSION['b_amount'])){ ?>
										<input name="b_amount" id="b_amount" value="<?php echo $_SESSION['b_amount'];?>" type="text" class="ipt"  placeholder="Booking Amount">
										<?php } else { ?>
										<input name="b_amount" id="b_amount" value="<?php if(isset($update_checkin_details['booking_amount'])) echo $update_checkin_details['booking_amount']; ?>" type="text" class="ipt"  placeholder="Booking Amount">
										<?php } ?>
									</div>

									<div class="field">
										<label class="main">Adult:</label>
										<div class="col-md-4">
											<select name="adult" class="adult" id="small_select">
												<?php 
													for ($i=1; $i <= 10; $i++) { 
														if($i < 10){
															$adult_array[] = '0'.$i;
														}else{
															$adult_array[] = $i;
														}
													}
													foreach ($adult_array as $adult_arr) {
													if(isset($_SESSION['adult'])){
												?>
												<option value="<?php echo $adult_arr;?>"<?php if($adult_arr == $_SESSION['adult']) echo 'selected="selected"' ;?>><?php echo $adult_arr;?></option>
												<?php } elseif (isset($adult)) { ?>
												<option value="<?php echo $adult_arr;?>"<?php if($adult_arr == $adult) echo 'selected="selected"' ;?>><?php echo $adult_arr;?></option>
												<?php } else { ?>
												<option value="<?php echo $adult_arr;?>"><?php echo $adult_arr;?></option>
												<?php } }?>
											</select>
											<label>Adults</label>
										</div>
	
										<div class="col-md-4"> 
											<select name="child" class="child" id="small_select">
												<?php
												for ($i=0; $i <= 10; $i++) { 
														if($i < 10){
															$child_array[] = '0'.$i;
														}else{
															$child_array[] = $i;
														}
													} 
													foreach ($child_array as $child_arr) {
												if(isset($_SESSION['child'])){
												?>
												<option value="<?php echo $child_arr;?>"<?php if($child_arr == $_SESSION['child']) echo 'selected="selected"' ;?>><?php echo $child_arr;?></option>
												<?php } elseif (isset($child)) { ?>
												<option value="<?php echo $child_arr;?>"<?php if($child_arr == $child) echo 'selected="selected"' ;?>><?php echo $child_arr;?></option>
												<?php } else { ?>
												<option value="<?php echo $child_arr;?>"><?php echo $child_arr;?></option>
												<?php } } ?>
											</select>
											<label>Children</label>
										</div>
									</div>

									
									<div class="field">
										<label class="main">Extra Adult Charges:</label>
										<?php if(isset($_SESSION['ex_ad_charges'])) { ?>
										<input name="ex_ad_charges" id="ex_ad_charges" value="<?php echo $_SESSION['ex_ad_charges'];?>" type="text" class="ipt"  placeholder="Extra Persons Charges">
										<?php } else { ?>
										<input name="ex_ad_charges" id="ex_ad_charges" value="<?php if(isset($update_checkin_details['charge_per_adult'])) echo $update_checkin_details['charge_per_adult']; ?>" type="text" class="ipt"  placeholder="Extra Persons Charges">
										<?php } ?>
									</div>

									<div class="field">
										<label class="main">Meal Plan:</label>
										<select name="meal_plan" class="meal_plan" id="selectt">
											<?php 
											$meals = array('Only Room','With Breakfast');
											foreach ($meals as $meal) {
												if(isset($_SESSION['meal_plan'])){
											?>
											<option value="<?php echo $meal;?>"<?php if($meal == $_SESSION['meal_plan']) echo 'selected="selected"';?>><?php echo $meal;?></option>
											<?php } elseif (isset($update_checkin_details['meal_plan'])) { ?>
											<option value="<?php echo $meal;?>"<?php if($meal == $update_checkin_details['meal_plan']) echo 'selected="selected"';?>><?php echo $meal;?></option>
											<?php } else { ?>
											<option value="<?php echo $meal;?>"><?php echo $meal;?></option>
											<?php } } ?>

										</select>

									</div>
									<div class="footer">
										<div class="field buttons">
											<label class="main">&nbsp;</label>
											<!--<input type="button" class="prev" id="reset" value="Reset" />-->
											<input type="button" class="prev" value="&larr; Prev" />
											<input type="submit" id="preview" class="preview" name="preview" value="Preview">
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>       
				<?php include('../include/footer.php');?>
				<script src="js/jquery.validate.min.js"></script>
				<script type="text/javascript" src="js/formvalidation.js"></script>
				<script type="text/javascript" src="js/save_entry_fromdata.js"></script>
				<script src="js/quantity-bt.js"></script>
				<script src="js/bootstrap-datepicker.js"></script>
				<script>

					$('form.idealforms').idealforms('addRules', {
						'comments': 'required minmax:50:200'
					});
					$('.next').click(function(){
						var purpose = $(".purpose").val();
						var fkcountry = $(".fkcountry").val();
						var idname = $(".idname").val();
						var email = $("#email").val();
						var phone = $("#phone").val();
						
						if(email && phone && fkcountry && idname && purpose){
							$('.next').show();
							$('form.idealforms').idealforms('nextStep');
						}
					});
					$('.prev').on('click',function(){
						$('.prev').show();
						$('form.idealforms').idealforms('prevStep');
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

				<script>
					$(document).ready(function(){
						var var_i = $('#i');
						if(var_i.val()){
							var i= var_i.val();
							$("#delete_row").show();
						} else {
							var i=1;
							$("#delete_row").hide();
						}
						 
						$("#add_row").click(function(){
							$('#wrapelement'+i).html('<div class="field"><label class="main">Full Name:</label><input name="fname[]" id="fname" class="ipt" type="text" placeholder="Enter Your Full Name" ></div><div class="field"><label class="main">Gender:</label><select name="gender[]" id="selectt" class="gender"><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div>');
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
					$(".hotel").change(function(){
					   	var hotel_id = $(this).attr("value");
					    $.ajax({
					      	url : "save_hotel_id.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
					      	success:function(data){
					        	window.location.href='index.php';
					      	}
					    });
					 });
				</script>

				<script type="text/javascript">


				//Email Validation here
					$("#email").keyup(function(){
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
					$("#email").click(function(){
						var email = $("#email").val();
						if(email){
							$.ajax({
								url : 'validate.php?email='+email,
								success:function(data){
									if(data == 1){
										$("#email_msg").show().html("<span style margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
										return false;
									}else{
										$("#email_msg").hide();
									}
								}
							});
						}
					});
					</script>
			
			</body>
			</html>
