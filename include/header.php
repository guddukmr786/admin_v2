<?php 
include_once('../lib/fetch_values.php');

$obj = new FetchValues();


$hotel_id = $_COOKIE['hotel_id'];

$hotels = $obj->getHotelDetailsById($hotel_id); 

$all_hotels = $obj->getAllHotelDetails();


//temp data
$hotel = $hotels['hotel_name'];

?>
<!DOCTYPE html>
<html lang="en">
	<!--
	<![endif]-->
<head>
	<title>Check In Room Login Pannel</title>
	<!--Custom Theme files-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Call Us on +91-9999331194 to book Paharganj Budget Hotel at best offered price,New Delhi Hotels at lowest price , highly recommended by Lonely Planet. special offers Hotel in delhi,Lowest Price Guaranteed Hotel in Paharganj.">
	<meta name="keywords" content="Budget Hotel In Paharganj, Cheap Hotels In delhi,3 Star Hotels In Delhi, Delhi Hotels,Budget Hotel">
	<link rel="stylesheet" href="../entry/css/jquery.idealforms.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="../entry/css/other.css"  rel="stylesheet"/>
	<link href="../entry/css/date_time_picker.css"  rel="stylesheet"/>
	<script src="../entry/js/modernizr.custom.63321.js" type="text/javascript"></script>
	<link href="../entry/css/styleResp.css" rel="stylesheet" type="text/css" />
	<!--Css pannel contact-->
	<link href="../entry/css/stylesContact.css" rel="stylesheet" type="text/css" />
	<!--End Css pannel contact-->
	<!--<link href="font-awesome-4.5.0/css/font-awesome.css"  rel="stylesheet"/>-->
</head>
<!--<body onLoad="document.forms.search.part.focus()">-->
<?php if(isset($_COOKIE['user_type']) && $_COOKIE['user_type'] == "Super Admin"){ ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-md-2" style="">
				<img src="../images/checkinroom-logo.png">
			</div>
			<div class="col-md-" style="margin-left:500px">
				<div class="field">
					<label class="main1">Select Hotel</label>
					<select name="hotel" id="selectt" class="hotel">
						<?php
						foreach ($all_hotels as $all_hotel) {
							if(isset($_COOKIE['hotel_id'])){ 
						?>
						<option value="
							<?php echo $all_hotel['hotel_id'];?>"
							<?php if($_COOKIE['hotel_id'] == $all_hotel['hotel_id']) echo 'selected="selected"';?>>
							<?php echo $all_hotel['hotel_name'];?>
						</option>
						<?php } else {?>
						<option value="
							<?php echo $all_hotel['hotel_id'];?>">
							<?php echo $all_hotel['hotel_name'];?>
						</option>
						<?php } } ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-12" style="padding-left:0px!important;padding-right:0px!important;">
	<a id="touch-menu" class="mobile-menu" href="#">
		<i class="icon-reorder"></i>Menu
	</a>
	<nav>
		<ul class="menu">
			<li>
				<a href="room_view.php">Room View</a>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">CIR Guest</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="index.php">Guest Entry Form</a>
						<a style="color:#35c8ff;padding-left:0px;" href="entry_list.php">Guest Entry List</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">CIR Arrival Booking</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="arrival_booking_entry.php">Arrival Booking Form</a>
						<a style="color:#35c8ff;padding-left:0px;" href="arrival_booking_list.php">Arrival Booking List</a>
						<a style="color:#35c8ff;padding-left:0px;" href="http://checkinroom.in/HotelDetails/offlineBooking?hotel_id=<?php echo trim($hotel);?>" target="_blank">Manage Booking</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Day Book</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="day_book.php">Entry Day Book</a>
						<a style="color:#35c8ff;padding-left:0px;" href="view_day_book.php">View Day Book</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Employees</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="add_employee_details.php">Add Employee Details</a>
						<a style="color:#35c8ff;padding-left:0px;" href="view_employee_details.php">View Employee Details</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Hotels</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="view_hotels.php">CIR Hotels</a>
						<a style="color:#35c8ff;padding-left:0px;" href="add_user.php">Add User</a>
						<a style="color:#35c8ff;padding-left:0px;" href="view_user.php">View User</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Travels</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="hotel-details.php">Hotel Details</a>
						<a style="color:#35c8ff;padding-left:0px;" href="travelagent.php">Travel Agent</a>
						<a style="color:#35c8ff;padding-left:0px;" href="party.php">Add Party</a>
						<a style="color:#35c8ff;padding-left:0px;" href="generate_invoice.php">Generate Invoice</a>
						<a style="color:#35c8ff;padding-left:0px;" href="view_invoice.php">View Invoice</a>
						<a style="color:#35c8ff;padding-left:0px;" href="generate_sushant_invoice.php">Sushant Travels Invoice</a>
						<a style="color:#35c8ff;padding-left:0px;" href="view_sushant_invoice.php">View Sushant Travels Invoice</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<button class="dropbtn">Report</button>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="report.php">View Report</a>
						<a style="color:#35c8ff;padding-left:0px;" href="date_wise_checkin_details.php">Date Wise Checkin Details</a>
					</div>
				</div>
			</li>
			<li>
				<div class="dropdown">
					<?php if(!empty($_COOKIE['full_name'])){ ?>
					<button class="dropbtn"><?php echo "Welcome ".ucwords($_COOKIE['full_name']);?></button>
					<?php } else { ?>
	                <button class="dropbtn">Profile</button>
	                <?php } ?>
					<div class="dropdown-content">
						<a style="color:#35c8ff;padding-left:0px;" href="change_pass.php">Change Password</a>
						<a style="color:#35c8ff;padding-left:0px;" href="logout.php">Sign Out</a>
					</div>
				</div>
			</li>
		</ul>
	</nav>
</div>
<?php } elseif(isset($_COOKIE['user_type']) && $_COOKIE['user_type'] == "Admin"){ ?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-md-2" style="">
				<img src="../images/checkinroom-logo.png">
			</div>
				<div class="col-md-" style="margin-left:500px">
					<div class="field">
						<label class="main1">Select Hotel</label>
						<select name="hotel" id="selectt" class="hotel">
							
							<?php
							foreach ($all_hotels as $all_hotel) {
								if(isset($_COOKIE['hotel_id'])){ 
							?>
							<option value="
								<?php echo $all_hotel['hotel_id'];?>"
								<?php if($_COOKIE['hotel_id'] == $all_hotel['hotel_id']) echo 'selected="selected"';?>>
								<?php echo $all_hotel['hotel_name'];?>
							</option>
							<?php } else {?>
							<option value="
								<?php echo $all_hotel['hotel_id'];?>">
								<?php echo $all_hotel['hotel_name'];?>
							</option>
							<?php } } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-12" style="padding-left:0px!important;padding-right:0px!important;">
		<a id="touch-menu" class="mobile-menu" href="#">
			<i class="icon-reorder"></i>Menu
		</a>
		<nav>
			<ul class="menu">
				<?php $previleages = explode('|',$_COOKIE['previleges']);
	         	if (in_array('Room View', $previleages)) {
	         	?>
				<li>
					<a href="room_view.php">Room View</a>
				</li>
				<?php } ?>
	            <?php if(in_array('CIR Guest', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">CIR Guest</button>
						<div class="dropdown-content">
							<?php if(in_array('Guest Entry Form', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="index.php">Guest Entry Form</a>
							<?php } if(in_array('Guest Entry List', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="entry_list.php">Guest Entry List</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('CIR Arrival Booking', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">CIR Arrival Booking</button>
						<div class="dropdown-content">
							<?php if(in_array('Arrival Booking Form', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="arrival_booking_entry.php">Arrival Booking Form</a>
							<?php } if(in_array('Arrival Booking List', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="arrival_booking_list.php">Arrival Booking List</a>
							<a style="color:#35c8ff;padding-left:0px;" href="http://checkinroom.in/HotelDetails/offlineBooking?hotel_id=<?php echo trim($hotel);?>" target="_blank">Manage Booking</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Day Book', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Day Book</button>
						<div class="dropdown-content">
							<?php if(in_array('Entry Day Book', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="day_book.php">Entry Day Book</a>
							<?php } if(in_array('View Day Book', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_day_book.php">View Day Book</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Employees', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Employees</button>
						<div class="dropdown-content">
							<?php if(in_array('Add Employees Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="add_employee_details.php">Add Employee Details</a>
							<?php } if(in_array('View Employees Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_employee_details.php">View Employee Details</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Travels', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Travels</button>
						<div class="dropdown-content">
							
							<?php if(in_array('Hotel Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="hotel-details.php">Hotel Details</a>
							<?php } if(in_array('Travel Agents', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="travelagent.php">Travel Agent</a>
							<?php } if(in_array('Add Party', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="party.php">Add Party</a>
							<?php } if(in_array('Generate Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="generate_invoice.php">Generate Invoice</a>
							<?php } if(in_array('View Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_invoice.php">View Invoice</a>
							<?php } if(in_array('Sushant Travels Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="generate_sushant_invoice.php">Sushant Travels Invoice</a>
							<?php } if(in_array('View Sushant Travels Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_sushant_invoice.php">View Sushant Travels Invoice</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Reports', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Report</button>
						<div class="dropdown-content">
							<?php if(in_array('View Reports', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="report.php">View Report</a>
							<?php } if(in_array('Date Wise Checkin Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="date_wise_checkin_details.php">Date Wise Checkin Details</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
				
				<li>
					<div class="dropdown">
						<?php if(!empty($_COOKIE['full_name'])){ ?>
						<button class="dropbtn"><?php echo "Welcome ".ucwords($_COOKIE['full_name']);?></button>
						<?php } else { ?>
						<button class="dropbtn">Profile</button>
						<?php } ?>
						<div class="dropdown-content">
							<a style="color:#35c8ff;padding-left:0px;" href="change_pass.php">Change Password</a>
							<a style="color:#35c8ff;padding-left:0px;" href="logout.php">Sign Out</a>
						</div>
					</div>
				</li>
			</ul>
		</nav>
	</div>
	<?php } else { ?>
	<div class="col-md-6" style="float:right;">
		<h1 style="text-align:center;color:#0e3070;font-weight:600;margin:30px 309px 0px 0px;font-size: 30px;"><?php echo $hotels['hotel_name']; ?></h1>
	</div>
	<div class="col-md-6">
		<a target="_blank" href="http://www.checkinroom.com"><img style="padding-left:200px;height:50px;padding-top:2px;" src="images/logo.png"></a>
	</div>

   <div class="col-lg-12" style="padding-left:0px!important;padding-right:0px!important;">
		<a id="touch-menu" class="mobile-menu" href="#">
			<i class="icon-reorder"></i>Menu
		</a>
		<nav>
			<ul class="menu">
				<?php $previleages = explode('|',$_COOKIE['previleges']);
	         	if (in_array('Room View', $previleages)) {
	         	?>
				<li>
					<a href="room_view.php">Room View</a>
				</li>
				<?php } ?>
	            <?php if(in_array('CIR Guest', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">CIR Guest</button>
						<div class="dropdown-content">
							<?php if(in_array('Guest Entry Form', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="index.php">Guest Entry Form</a>
							<?php } if(in_array('Guest Entry List', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="entry_list.php">Guest Entry List</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('CIR Arrival Booking', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">CIR Arrival Booking</button>
						<div class="dropdown-content">
							<?php if(in_array('Arrival Booking Form', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="arrival_booking_entry.php">Arrival Booking Form</a>
							<?php } if(in_array('Arrival Booking List', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="arrival_booking_list.php">Arrival Booking List</a>
							<a style="color:#35c8ff;padding-left:0px;" href="http://checkinroom.in/HotelDetails/offlineBooking?hotel_id=<?php echo trim($hotel);?>" target="_blank">Manage Booking</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Day Book', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Day Book</button>
						<div class="dropdown-content">
							<?php if(in_array('Entry Day Book', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="day_book.php">Entry Day Book</a>
							<?php } if(in_array('View Day Book', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_day_book.php">View Day Book</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Employees', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Employees</button>
						<div class="dropdown-content">
							<?php if(in_array('Add Employees Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="add_employee_details.php">Add Employee Details</a>
							<?php } if(in_array('View Employees Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_employee_details.php">View Employee Details</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Travels', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Travels</button>
						<div class="dropdown-content">
							
							<?php if(in_array('Hotel Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="hotel-details.php">Hotel Details</a>
							<?php } if(in_array('Travel Agents', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="travelagent.php">Travel Agent</a>
							<?php } if(in_array('Add Party', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="party.php">Add Party</a>
							<?php } if(in_array('Generate Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="generate_invoice.php">Generate Invoice</a>
							<?php } if(in_array('View Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_invoice.php">View Invoice</a>
							<?php } if(in_array('Sushant Travels Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="generate_sushant_invoice.php">Sushant Travels Invoice</a>
							<?php } if(in_array('View Sushant Travels Invoice', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="view_sushant_invoice.php">View Sushant Travels Invoice</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
	            <?php if(in_array('Reports', $previleages)){ ?>
				<li>
					<div class="dropdown">
						<button class="dropbtn">Report</button>
						<div class="dropdown-content">
							<?php if(in_array('View Reports', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="report.php">View Report</a>
							<?php } if(in_array('Date Wise Checkin Details', $previleages)){ ?>
							<a style="color:#35c8ff;padding-left:0px;" href="date_wise_checkin_details.php">Date Wise Checkin Details</a>
							<?php } ?>
						</div>
					</div>
				</li>
				<?php } ?>
				
				<li>
					<div class="dropdown">
						<?php if(!empty($_COOKIE['full_name'])){ ?>
						<button class="dropbtn"><?php echo "Welcome ".ucwords($_COOKIE['full_name']);?></button>
						<?php } else { ?>
						<button class="dropbtn">Profile</button>
						<?php } ?>
						<div class="dropdown-content">
							<a style="color:#35c8ff;padding-left:0px;" href="change_pass.php">Change Password</a>
							<a style="color:#35c8ff;padding-left:0px;" href="logout.php">Sign Out</a>
						</div>
					</div>
				</li>
			</ul>
		</nav>
	</div>
	<?php } ?>