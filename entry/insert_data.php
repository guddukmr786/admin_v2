<?php
include_once('../include/config.php');
require '../PHPMailer/src/PHPMailer.php';
error_reporting(E_ERROR | E_PARSE);

use PHPMailer\PHPMailer\PHPMailer;

$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];

$destination = 'upload/checkinimages/';
date_default_timezone_set('Asia/Kolkata');
$current_date_time = DATE_TIME;
if (isset($_REQUEST['checkin_details'])) {

	$serial = $_SESSION['serial'];
	$nametitle = $_SESSION['nametitle'];
	$fname = $_SESSION['fname'];
	$name = $nametitle[0] . ' ' . $fname[0];
	$gender = $_SESSION['gender'];
	$gender_insert = $gender[0];

	$email = $_SESSION['email'];
	$phone = $_SESSION['phone'];
	$fkcountry = $_SESSION['fkcountry'];
	$city = $_SESSION['city'];

	$idname = $_SESSION['idname'];
	if (isset($_SESSION['lastlocation'])) {
		$lastlocation = $_SESSION['lastlocation'];
	}

	if (isset($_SESSION['nextlocation'])) {
		$nextlocation = $_SESSION['nextlocation'];
	} else {
		$nextlocation = "";
	}


	$purpose = $_SESSION['purpose'];
	if (isset($_SESSION['ids'])) {
		$ids_name = $_SESSION['ids'];
	}


	$booking_via = $_SESSION['booking_via'];
	$bookingid = $_SESSION['bookingid'];
	$checkin = $_SESSION['checkin'];
	$checkout = $_SESSION['checkout'];

	$date_rep = str_replace('/', '-', $checkin);
	$check_ci = date('Y-m-d', strtotime($date_rep));

	$date_rep2 = str_replace('/', '-', $checkout);
	$checkout_cr = date('Y-m-d', strtotime($date_rep2));

	$nights = $_SESSION['nights'];
	$roomno = $_SESSION['roomno'];
	$adult = $_SESSION['adult'];
	$child = $_SESSION['child'];
	$num_of_person = $adult . '/' . $child;
	$b_amount = $_SESSION['b_amount'];
	if (isset($_SESSION['ex_ad_charges'])) {
		$ex_ad_charges = $_SESSION['ex_ad_charges'];
	}
	$meal_plan = $_SESSION['meal_plan'];
	$submit_by = $_POST['submitby'];
	$date1 = CURR_DATE1;
	if ($fname != "" && $email != "" && $phone != "") {
		if (isset($_SESSION['type']) && $_SESSION['type'] == 'update') {

			$checkin_id = $_SESSION['checkin_id'];
			$checkin_datess = $_SESSION['checkin_date'];
			$checkout_datess = $_SESSION['checkout_date'];
			$booking_nightsss = $_SESSION['booking_nights'];
			$query1 = "UPDATE check_in_details SET hotel_id = '$hotel_id',serial_number = '$serial', name = '$name', gender='$gender_insert', email = '$email', phone = '$phone', country = '$fkcountry', state ='$city',id_name='$idname',last_location = '$lastlocation', next_location ='$nextlocation', purpouse = '$purpose', booking_via = '$booking_via', booking_id = '$bookingid', checkin_date = '$checkin', checkout_date = '$checkout', booking_nights = '$nights',room_number = '$roomno', no_of_person = '$num_of_person', booking_amount='$b_amount', charge_per_adult= '$ex_ad_charges',meal_plan = '$meal_plan', inserted_by ='$submit_by',current_ci_date ='$check_ci',current_co_date ='$checkout_cr' WHERE checkin_id='$checkin_id' AND hotel_id='$hotel_id'";
			$db->execute($query1);

			/*
			$quer_arri = "SELECT booking_id FROM check_in_details WHERE checkin_id = '$checkin_id' AND hotel_id='$hotel_id'";
			$result_exe = $db->execute($quer_arri);
			$result = $db->getResult($result_exe);
			$b_id = $result['booking_id'];

			$db->execute("UPDATE arrival_booking_history SET booking_status = 'checkedin' WHERE booking_id = '$bookingid' AND hotel_id='$hotel_id'");*/

			if ($booking_via == "Direct") {
				//update summary table form walking guest price updation
				$query_chk = "SELECT * FROM day_book_entry WHERE expense_by = '$roomno' AND expense_type ='Room Rent' AND check_out_status =0 AND hotel_id ='$hotel_id' ";
				$query_exe = $db->execute($query_chk);
				$result = $db->getResult($query_exe);
				if (!empty($result['amount'])) {
					$db->execute("UPDATE day_book_entry SET `hotel_id`='$hotel_id', `summary_id`='1',`expense_type`='Room Rent',`receive_pay`='Receive', `expense_by`='$roomno', `amount`='$b_amount', `description`='Room Rent',`department`='Hotel' WHERE expense_by = '$roomno' AND expense_type ='Room Rent' AND check_out_status =0 AND hotel_id ='$hotel_id' ");
				} else {
					$db->execute("INSERT INTO day_book_entry( `hotel_id`, `summary_id`,`expense_type`,`receive_pay`, `expense_by`, `amount`, `description`,`department`, `date_of_expense`, `inserted_date`) 
					VALUES('$hotel_id','1','Room Rent','Receive','$roomno','$b_amount','Room Rent','Hotel','$date1', NOW())");
				}
			}

			if ($checkin_id > 0) {

				$check_query = $db->execute("SELECT * FROM echeckin_person_name WHERE checkin_id = '$checkin_id' AND checkin_date ='$checkin_datess'");
				$llcheck_num = $db->rowCount();
				$count = count($fname);
				if ($count > 1) {
					if ($llcheck_num > 0) {
						$db->execute("DELETE FROM echeckin_person_name WHERE checkin_id='$checkin_id' AND checkin_date ='$checkin_datess'");
						for ($i = 1; $i < $count; $i++) {
							$nametitle_s = $nametitle[$i];
							//$relation_ss = $relation_aa[$i];
							$name_s = $fname[$i];
							$gender_s = $gender[$i];
							$checkin = $checkin;
							$person_queries[] = "INSERT INTO echeckin_person_name(`checkin_id`,`name_title`, `name`,`gender`,`checkin_date`,`inserted_date`) VALUES('$checkin_id','$nametitle_s','$name_s','$gender_s','$checkin','$current_date_time')";
						}
						foreach ($person_queries as $person_query) {
							$db->execute($person_query);
						}
					} else {
						for ($i = 1; $i < $count; $i++) {
							$nametitle_s = $nametitle[$i];
							//$relation_ss = $relation_aa[$i];
							$name_s = $fname[$i];
							$gender_s = $gender[$i];
							$checkin = $checkin;
							$person_queries[] = "INSERT INTO echeckin_person_name(`checkin_id`,`name_title`, `name`, `gender`,`checkin_date`,`inserted_date`) VALUES('$checkin_id','$nametitle_s','$name_s','$gender_s','$checkin', '$current_date_time')";
						}
						foreach ($person_queries as $person_query) {
							$db->execute($person_query);
						}
					}
				}
				if (isset($ids_name)) {
					$count1 = count($ids_name);
					$check_query = $db->execute("SELECT * FROM guest_ids WHERE checkin_id = '$checkin_id'");
					$llcheck_num = $db->rowCount();
					$results = $db->getResult($check_query);
					if ($count1 > 0) {
						if ($llcheck_num > 0) {
							if (!empty($results['id_proof'])) {
								$db->execute("DELETE FROM guest_ids WHERE checkin_id = '$checkin_id'");
								unlink($destination . $results['id_proof']);
							}
							for ($i = 0; $i < $count1; $i++) {
								$ids_name_ll = $ids_name[$i];
								$checkin = $checkin;
								$ids_query1 = "INSERT INTO guest_ids(`checkin_id`,`id_proof`,`checkin_date`) VALUES('$checkin_id','$ids_name_ll','$checkin')";
								$db->execute($ids_query1);
							}
						} else {
							for ($i = 0; $i < $count1; $i++) {
								$ids_name_ll = $ids_name[$i];
								$checkin = $checkin;
								$ids_query2 = "INSERT INTO guest_ids(`checkin_id`,`id_proof`,`checkin_date`) VALUES('$checkin_id','$ids_name_ll','$checkin')";
								$db->execute($ids_query2);
							}
						}
					}
				}
			}


			//mail code start from here
			$hotels_query = $db->execute("SELECT hotel_name From hotels WHERE hotel_id = '$hotel_id' LIMIT 1");
			$ho_result = $db->getResult($hotels_query);
			//get booking from name
			$booking_from = $db->execute("SELECT category_name FROM booking_via WHERE booking_via_id ='$booking_via'");
			$company_name = $db->getResult($booking_from);
			$c_name = $company_name['category_name'];

			//$password = $result['password'];
			$subject = "Checked-in Guest Details of " . $ho_result['hotel_name'];
			//$last_name = $fname;
			// HTML email starts here
			$curr_date_time = DATE_TIME1;
			$message = '<div id="mailsub" class="notification" align="center">';

			$message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;">';
			$message .= '<tr>';
			$message .= '<td align="center" bgcolor="#eff3f8">';
			$message .= '<table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">';
			$message .= '<tr>';
			$message .= '<td>';

			$message .= '<div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>';
			$message .= '</td>';
			$message .= '</tr>';

			$message .= '<tr>';
			$message .= '<td align="center" bgcolor="#fbfcfd">';
			$message .= '<table width="90%" border="0" cellspacing="0" cellpadding="0">';
			$message .= '<tr>';
			$message .= '<td align="left">';

			$message .= '<div style="height: 30px; line-height: 30px; font-size: 10px;"> </div>';

			$message .= '<div style="line-height: 44px;text-align:center;">';
			$message .= '<font face="Arial, Helvetica, sans-serif" size="5" color="#57697e" style="font-size: 34px;">';
			$message .= '<h4>' . $ho_result['hotel_name'] . '</h4>';
			$message .= '</span>';
			$message .= '</font>';
			$message .= '<hr>';
			$message .= '</div>';

			$message .= '<div style="height: 20px; line-height: 20px; font-size: 10px;"> </div>';
			$message .= '<div style="float:left;"><strong>Date : ' . $curr_date_time . ' </strong></div>';

			$message .= '</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td align="left" style="margin-left: 100px;">';
			$message .= '<div style="line-height: 24px;">';
			$message .= '<font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">';
			$message .= '<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">';
			$i = 1;
			foreach ($fname as $name_itr) {

				$message .= '<p><strong>Guest ' . $i . '   :</strong> ' . $name_itr . '</p>';
				$i++;
			}
			$message .= '<p><strong>Email   : </strong>' . $email . '</p>
			                                                    <p><strong>Phone   : </strong>' . $phone . '</p>
			                                                    <p><strong>Country: </strong>' . $fkcountry . '<p>
			                                                    <p><strong>City : </strong>' . $city . '</p>
			                                                    <p><strong>Booking From : </strong>' . $c_name . ' </p>
			                                                    <p><strong>Booking ID    :</strong> ' . $bookingid . '</p>
			                                                    <p><strong>Checkin Date   : </strong>' . $checkin . '</p>
			                                                    <p><strong>Checkout Date   : </strong>' . $checkout . '</p>
			                                                    <p><strong>No. Of Nights : </strong>' . $nights . '<p>
			                                                    <p><strong>Room Number : </strong>' . $roomno . '</p>
			                                                    <p><strong>No. of Adults : </strong>' . $adult . ' </p> 
			                                                    <p><strong>Booking Amount (Rs.)  :</strong> ' . $b_amount . '</p>
			                                                    <p><strong>Coming From : </strong>' . $lastlocation . '<p>
			                                                    <p><strong>Next Location : </strong>' . $nextlocation . '</p>
			                                                    <p><strong>Checked-in By : </strong>' . $_SESSION['full_name'] . ' </p>';
			$message .= '</span>';
			$message .= '</font>';
			$message .= '</div>';
			$message .= '<div style="height: 40px; line-height: 40px; font-size: 10px;"> </div>';
			$message .= '</td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</td>';
			$message .= '</tr>';


			$message .= '<tr>';
			$message .= '<td class="iage_footer" align="center" bgcolor="#ffffff">';

			$message .= '<div style="height: 30px; line-height: 30px; font-size: 10px;"> </div>  ';

			$message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			$message .= '<tr>';
			$message .= '<td align="center">';
			$message .= '<font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">';
			$message .= '<span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
			                                            2017 © Checkinroom.com. ALL Rights Reserved.';
			$message .= '</span>';
			$message .= '</font>';
			$message .= '</td>';
			$message .= '</tr>';
			$message .= '</table>';

			$message .= '<div style="height: 30px; line-height: 30px; font-size: 10px;"> </div> ';
			$message .= '</td>';
			$message .= '</tr>';

			$message .= '<tr>';
			$message .= '<td>';

			$message .= '<div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>';
			$message .= '</td>';
			$message .= '</tr>';
			$message .= '</table>';

			$message .= '</td>';
			$message .= '</tr>';
			$message .= '</table>';

			$message .= '</div> ';

			$message .= '<br>';
			$message .= '<br>';
			$message .= '<center>';
			$message .= '<strong>Powered by <a href="http://j.mp/metronictheme" target="_blank">Digitalindiawebsloutions.com</a></strong>';
			$message .= '</center>';
			$message .= '<br>';
			$message .= '<br>';



			$mail = new PHPMailer();

			//$mail->IsSMTP();

			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = "booking@checkinroom.com";
			$mail->Password = "sushant@2016@";
			$mail->Port = 465;
			$mail->SMTPSecure = "ssl";
			$mail->isHTML(true);
			$mail->setFrom('booking@checkinroom.com', 'Check In Room');
			$mail->addAddress('support@checkinroom.com');
			//$mail->addBCC('guddukmr786@gmail.com');
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->AltBody = '';
			$mail->send();
		} else {
			$query = "SELECT * FROM check_in_details WHERE room_number = '$roomno' AND status=0 AND hotel_id = '$hotel_id'";
			$run_qurey = $db->execute($query);
			$num_of_rows = $db->rowCount();

			if ($num_of_rows > 0) {
				$_SESSION['error'] = "This room number " . $roomno . " is already booked so please provide another room number.";
				die("<script>window.location.href='index.php'</script>");
			} else {

				$query1 = "INSERT INTO check_in_details(`hotel_id`,`serial_number`,`name`,`gender`, `email`, `phone`, `country`, `state`, `id_name`,`last_location`, `next_location`, `purpouse`,`booking_via`, `booking_id`, `checkin_date`,`checkout_date`, `booking_nights`,`room_number`, `no_of_person`, `booking_amount`, `charge_per_adult`, `meal_plan`, `inserted_by`, `inserted_date`,`current_ci_date`,`current_co_date`)  
					VALUES('$hotel_id','$serial','$name','$gender_insert','$email','$phone','$fkcountry','$city','$idname',$lastlocation','$nextlocation','$purpose','$booking_via','$bookingid','$checkin','$checkout','$nights','$roomno','$num_of_person','$b_amount','$ex_ad_charges','$meal_plan','$submit_by','$current_date_time','$check_ci','$checkout_cr')";

				$exe_query = $db->execute($query1);
				$last_id = $db->LastId();

				/*
				$quer_arri = "SELECT booking_id FROM check_in_details WHERE checkin_id = '$last_id' AND hotel_id='$hotel_id'";
				$result_exe = $db->execute($quer_arri);
				$result = $db->getResult($result_exe);
				$b_id = $result['booking_id'];
				
				$db->execute("UPDATE arrival_booking_history SET booking_status = 'checkedin' WHERE booking_id = '$b_id' AND hotel_id='$hotel_id'");*/

				if ($booking_via == "Direct") {
					//update summary table form walking guest price updation
					$query_chk = "SELECT * FROM day_book_entry WHERE expense_by = '$roomno' AND expense_type ='Room Rent' AND check_out_status =0 AND hotel_id ='$hotel_id' ";
					$query_exe = $db->execute($query_chk);
					$result = $db->getResult($query_exe);

					$db->execute("INSERT INTO day_book_entry( `hotel_id`, `summary_id`,`expense_type`,`receive_pay`, `expense_by`, `amount`, `description`,`department`, `date_of_expense`, `inserted_date`) 
					VALUES('$hotel_id','1','Room Rent','Receive','$roomno','$b_amount','Room Rent','Hotel','$date1', NOW())");
				}

				if ($last_id > 0) {
					$query = "UPDATE room_details SET room_status ='booked' WHERE hotel_id = '$hotel_id' AND room_number = '$roomno'";
					$db->execute($query);
					$count = count($fname);
					if ($count > 1) {
						for ($i = 1; $i < $count; $i++) {
							$nametitle_s = $nametitle[$i];
							$name_s = $fname[$i];
							$gender_s = $gender[$i];
							$checkin = $checkin;

							$person_queries[] = "INSERT INTO echeckin_person_name(`checkin_id`,`name_title`, `name`, `gender`,`checkin_date`,`inserted_date`) VALUES('$last_id','$nametitle_s','$name_s','$gender_s','$checkin','$current_date_time')";
						}
						foreach ($person_queries as $person_query) {
							$db->execute($person_query);
						}
					}
					if (isset($ids_name)) {
						$count1 = count($ids_name);
						if ($count1 > 0) {
							for ($i = 0; $i < $count1; $i++) {
								$ids_name_ll = $ids_name[$i];
								$checkin = $checkin;
								$ids_query = "INSERT INTO guest_ids(`checkin_id`,`id_proof`,`checkin_date`) VALUES('$last_id','$ids_name_ll','$checkin')";
								$db->execute($ids_query);
							}
						}
					}
				}
			}
		}

		unset($_SESSION['checkin_id']);
		unset($_SESSION['checkin_date']);
		unset($_SESSION['checkout_date']);
		unset($_SESSION['booking_nights']);
		unset($_SESSION['type']);
		unset($_SESSION['nametitle']);
		unset($_SESSION['serial']);
		unset($_SESSION['fname']);

		unset($_SESSION['gender']);
		unset($_SESSION['no_gender']);

		unset($_SESSION['email']);

		unset($_SESSION['phone']);

		unset($_SESSION['fkcountry']);

		unset($_SESSION['city']);

		if (isset($_SESSION['pin'])) {

			unset($_SESSION['pin']);
		}

		unset($_SESSION['day']);

		unset($_SESSION['month']);

		unset($_SESSION['year']);

		unset($_SESSION['idname']);

		unset($_SESSION['idno']);

		if (isset($_SESSION['lastlocation'])) {

			unset($_SESSION['lastlocation']);
		}

		if (isset($_SESSION['nextlocation'])) {
			unset($_SESSION['nextlocation']);
		}

		unset($_SESSION['purpose']);
		if (isset($_SESSION['ids'])) {
			unset($_SESSION['ids']);
			unset($_SESSION['tmpids']);
		}
		unset($_SESSION['address']);
		if (isset($_SESSION['arrival_date'])) {
			unset($_SESSION['arrival_date']);
		}
		if (isset($_SESSION['arrlocation'])) {
			unset($_SESSION['arrlocation']);
		}
		if (isset($_SESSION['passport'])) {
			unset($_SESSION['passport']);
		}
		if (isset($_SESSION['passportexp'])) {
			unset($_SESSION['passportexp']);
		}

		if (isset($_SESSION['visa'])) {
			unset($_SESSION['visa']);
		}

		if (isset($_SESSION['visa_valid'])) {
			unset($_SESSION['visa_valid']);
		}
		unset($_SESSION['booking_via']);
		unset($_SESSION['bookingid']);
		unset($_SESSION['checkin']);
		unset($_SESSION['checkout']);
		unset($_SESSION['nights']);
		unset($_SESSION['roomno']);
		unset($_SESSION['adult']);
		unset($_SESSION['child']);
		unset($_SESSION['b_amount']);
		if (isset($_SESSION['ex_ad_charges'])) {
			unset($_SESSION['ex_ad_charges']);
		}
		unset($_SESSION['meal_plan']);
		$_SESSION['success'] = "Data has been saved successfully.";
		die("<script>window.location.href='index.php'</script>");
	} else {
		$_SESSION['error'] = "Please check required field.";
		die("<script>window.location.href='index.php'</script>");
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'add_summary') {
	$room_number = $_POST['room_number'];
	$query_ro00 = "SELECT checkin_id FROM check_in_details WHERE room_number = '$room_number' AND status = 0 AND hotel_id = '$hotel_id'";
	$query_ro = $db->execute($query_ro00);
	$result_ro = $db->getResult($query_ro);
	$checkin_id = $result_ro['checkin_id'];

	$bill_id = $_POST['bill_id'];
	$menu = $_POST['menu'];
	$qty = $_POST['qty'];
	$bill_amount = $_POST['bill_amount'];
	$total_amount = $_POST['total_amount'];
	$date1 = CURR_DATE1;
	if ($bill_id != "" && $menu != "" && $bill_amount != "" && $total_amount != "" && $room_number != "") {
		$num = count($bill_id);
		for ($i = 0; $i < $num; $i++) {
			$bill_id_b = $bill_id[$i];
			$menu_u = $menu[$i];
			$qty_y = $qty[$i];
			$bill_amount_m = $bill_amount[$i];
			$total_amount_t = $total_amount[$i];
			$summary_query[] = "INSERT INTO summary_details(`room_number`, `bill_id`, `checkin_id`, `hotel_id`, `menu`, `qty`,`bill_amount`, `total_amount`,`inserted_date`,`inserted_date_time`)
			VALUES ('$room_number','$bill_id_b','$checkin_id','$hotel_id','$menu_u','$qty_y','$bill_amount_m','$total_amount_t', '$date1', NOW())";
			$day_books[] = "INSERT INTO day_book_entry( `hotel_id`, `summary_id`,`expense_type`,`receive_pay`, `expense_by`, `amount`, `description`,`department`, `date_of_expense`, `inserted_date`) 
			VALUES('$hotel_id','1','Kitchen Cafe','Receive','$room_number','$total_amount_t','$description','Kitchen Cafe','$date1', NOW())";
		}
		foreach ($summary_query as $sumarry) {
			$db->execute($sumarry);
		}
		foreach ($day_books as $day_book) {
			$db->execute($day_book);
		}
		echo 2;
	} else {
		echo 3;
	}
}

//quick checkin
if (isset($_GET['type']) && $_GET['type'] == 'quickbooking') {
	if (isset($_GET['room_number'])) {
		$room_number = $_GET['room_number'];
	} else {
		$room_number = $_POST['roomno'];
	}
	if (!empty($_POST['arri_id'])) {
		$arrival_b_id = $_POST['arri_id'];
	}
	$serial = $_POST['serial'];
	$fname = $_POST['fname'];
	$gender = $_POST['gender'];
	$gender_insert = $gender[0];
	foreach ($gender as $gen) {
		if ($gen == 'Male') {
			$name_title[] = 'Mr';
		} else {
			$name_title[] = 'Mrs';
		}
	}

	$name = $name_title[0] . ' ' . $fname[0];
	$email = trim($_POST['email']);
	$phone = $_POST['phone'];
	$booking_via = isset($_POST['booking_via']) ? $_POST['booking_via'] : false;
	$bookingid = isset($_POST['bookingid']) ? $_POST['bookingid'] : false;
	$lastlocation = $_POST['lastlocation'];
	$nextlocation = isset($_POST['nextlocation']) ? $_POST['nextlocation'] : false;
	$checkin = $_POST['checkin'];
	$checkout = $_POST['checkout'];
	$date_rep = str_replace('/', '-', $checkin);
	$check_ci = date('Y-m-d', strtotime($date_rep));
	$date_rep2 = str_replace('/', '-', $checkout);
	$checkout_cr = date('Y-m-d', strtotime($date_rep2));
	$nights = $_POST['nights'];
	$noofguest = isset($_POST['noofguest']) ? $_POST['noofguest'] : false;
	$purpose = $_POST['purpose'];
	$booking_amount = $_POST['amount'];
	$e_adult_charge = isset($_POST['e_adult_charge']) ? $_POST['e_adult_charge'] : false;
	$h_tax = isset($_POST['h_tax']) ? $_POST['h_tax'] : false;
	$a_charge = isset($_POST['a_charge']) ? $_POST['a_charge'] : false;
	$g_comm = isset($_POST['g_comm']) ? $_POST['g_comm'] : false;
	$gst_18 = isset($_POST['gst_18']) ? $_POST['gst_18'] : false;
	$comm_inc_gst = isset($_POST['comm_inc_gst']) ? $_POST['comm_inc_gst'] : false;
	$pay_hotel = isset($_POST['pay_hotel']) ? $_POST['pay_hotel'] : false;
	$inserted_by = $_SESSION['full_name'];


	if ($serial != "" && $checkout != "" && $name != "" && $checkin != "" && $email != "" && $phone != "" && $lastlocation != "" && $nextlocation != "" &&  $purpose != "" && $room_number != "") {

		if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
			echo "email";
			die;
		}

		/*if(!preg_match("/^[1-9,_ -][0-9,_ -]*$/", $phone)){
				echo "phone";die;
			}*/

		$room_number_query1 = "SELECT * FROM room_details WHERE room_number = '$room_number' AND room_status ='empty' AND hotel_id = '$hotel_id'";
		$room_number_exe1 = $db->execute($room_number_query1);
		$noroom_nu_row1 = $db->rowCount();

		if ($noroom_nu_row1 > 0) {

			$query_dup = "SELECT * FROM check_in_details WHERE room_number = '$room_number' AND status = 0 AND hotel_id = '$hotel_id'";
			$execute_dup = $db->execute($query_dup);
			$no_of_data = $db->rowCount($execute_dup);
			if ($no_of_data > 0) {
				$query_up = "UPDATE check_in_details SET status = 1 WHERE room_number = '$room_number' AND hotel_id = '$hotel_id' AND status = 0";
				$execute_up = $db->execute($query_up);
			}

			$query_run = "INSERT INTO check_in_details(`hotel_id`,`serial_number`,`name`,`gender`,`email`,`phone`,`last_location`,`next_location`,`purpouse`,`booking_via`,`booking_id`,`checkin_date`,`checkout_date`,`booking_nights`,`room_number`,`no_of_person`,`booking_amount`,`charge_per_adult`, `hotel_tax`, `hotel_gross_charge`, `commission`, `gst_18`, `commission_gst`, `pay_to_hotel`,`inserted_by`,`inserted_date`,`current_ci_date`,`current_co_date`) VALUES('$hotel_id','$serial','$name','$gender_insert','$email','$phone','$lastlocation','$nextlocation','$purpose','$booking_via','$bookingid','$checkin','$checkout','$nights','$room_number','$noofguest','$booking_amount','$e_adult_charge','$h_tax','$a_charge','$g_comm','$gst_18','$comm_inc_gst','$pay_hotel','$inserted_by','$current_date_time','$check_ci','$checkout_cr')";
			$db->execute($query_run);
			$last_id = $db->LastId();

			$count = count($fname);
			if ($last_id > 0) {
				if ($count > 1) {
					for ($i = 1; $i < $count; $i++) {

						$nametitle_s = $name_title[$i];
						$name_s = $fname[$i];
						$gender_s = $gender[$i];
						$checkin_date = $checkin;
						$person_queries[] = "INSERT INTO echeckin_person_name(`checkin_id`,`name_title`, `name`,`gender`,`checkin_date`,`inserted_date`) VALUES('$last_id','$nametitle_s','$name_s','$gender_s','$checkin_date','$current_date_time')";
					}
					foreach ($person_queries as $person_query) {
						$db->execute($person_query);
					}
				}
				$db->execute("UPDATE room_details SET room_status='booked' WHERE room_number = '$room_number' AND hotel_id='$hotel_id'");
				if (!empty($arrival_b_id)) {
					$db->execute("UPDATE arrival_booking_history SET booking_status= 'checkedin' WHERE arrival_b_id = '$arrival_b_id' AND hotel_id = '$hotel_id'");
				} else {
					$query_up  = "UPDATE arrival_booking_history SET booking_status= 'checkedin' WHERE booking_id = '$bookingid' AND hotel_id='$hotel_id'";
					$db->execute($query_up);
				}

				//guest email start code here

				$hotels_query = $db->execute("SELECT * From hotels WHERE hotel_id = '$hotel_id' LIMIT 1");
				$ho_result = $db->getResult($hotels_query);
				//session data for welcome email template
				$hne = $ho_result['hotel_name'];
				$kext = $ho_result['kitchen_extension_no'];
				$rext = $ho_result['reception_extension_no'];
				//end templ

				$last_name = end(explode(" ", $name));
				$subject = "Welcome to " . $hne . " Dear, " . $last_name;

				// HTML email starts here
				$html = "";
				include('welcome-email-tpl.php');

				$mail = new PHPMailer();
				//$mail->IsSMTP();
				$mail->Host = "smtp.gmail.com";
				$mail->SMTPAuth = true;
				$mail->Username = "booking@checkinroom.com";
				$mail->Password = "Vijay#1174";
				$mail->Port = 465;
				$mail->SMTPSecure = "ssl";
				$mail->isHTML(true);
				$mail->setFrom('booking@checkinroom.com', 'Check In Room');
				$mail->addReplyTo('support@checkinroom.com');
				//$mail->addAddress($email_ss);
				$mail->addAddress($email);
				$mail->addBCC('support@checkinroom.com');
				//$mail->addBCC('vijaytiwari1700@gmail.com');

				$mail->addEmbeddedImage('images/quickchkimg/checkinroom-logo.png', 'logo');
				//$mail->addEmbeddedImage('images/quickchkimg/dial.png','dial');
				$mail->addEmbeddedImage('images/quickchkimg/sushant-travels-banner.jpg', 'susbanner');
				$mail->addEmbeddedImage('images/quickchkimg/Rajasthan-holiday-tour-packages.jpg', 'rajasthan-tour');
				$mail->addEmbeddedImage('images/quickchkimg/Himachal-Pradesh-tour-packages.jpg', 'himachal-tour');
				$mail->addEmbeddedImage('images/quickchkimg/hotel-nirmal-mahal.jpg', 'nirmal-mahal');
				$mail->addEmbeddedImage('images/quickchkimg/hotel-cabana.jpg', 'hotel-cabana');
				$mail->addEmbeddedImage('images/quickchkimg/hotel-all-iz-well.jpg', 'hotel-all-iz');
				$mail->addEmbeddedImage('images/quickchkimg/sayagata.gif', 'sayagata');
				$mail->addEmbeddedImage('images/quickchkimg/facebook.png', 'facebook');
				$mail->addEmbeddedImage('images/quickchkimg/twitter.png', 'twitter');
				$mail->addEmbeddedImage('images/quickchkimg/youtube.png', 'youtube');
				$mail->addEmbeddedImage('images/quickchkimg/linkedin.png', 'linkedin');
				$mail->addEmbeddedImage('images/quickchkimg/tumbl.png', 'tumblr');
				$mail->addEmbeddedImage('images/quickchkimg/pinterest.png', 'pinterest');
				$mail->addEmbeddedImage('images/quickchkimg/googleplus.png', 'googleplus');
				$mail->addEmbeddedImage('images/quickchkimg/instagram.png', 'instagram');

				$mail->Subject = $subject;

				$mail->Body = $html;

				$mail->AltBody = '';
				$mail->send();
				/*if(!$mail->send()){
						echo 'Message could not be sent.';
						echo 'Mailer Error: ' . $mail->ErrorInfo."<br>";
					}*/


				unset($_SESSION['nametitle']);
				unset($_SESSION['fname']);
				unset($_SESSION['serial']);
				unset($_SESSION['gender']);
				unset($_SESSION['email']);
				unset($_SESSION['phone']);
				unset($_SESSION['lastlocation']);
				//unset($_SESSION['nextlocation']);
				unset($_SESSION['checkin']);
				unset($_SESSION['checkout']);
				unset($_SESSION['nights']);
				unset($_SESSION['purpose']);
				unset($_SESSION['roomno']);
				unset($_SESSION['bookingid']);
				//unset tmplate data
				unset($_SESSION['hotel_name_email']);
				unset($_SESSION['kitchen_ext']);
				unset($_SESSION['reception_ext']);
				unset($_SESSION['guest_name']);

				$_SESSION['success'] = "Room number " . $room_number . " successfully booked by " . $name;
				echo "success";
			} else {
				$_SESSION['error'] = "Error in booking room number " . $room_number . " please try again.";
			}
		} else {
			echo 4;
			die;
		}
	} else {
		echo  "Error! All field are required.";
	}
}


if (isset($_GET['type']) && $_GET['type'] == 'quickbooking_direct') {
	if (isset($_GET['room_number'])) {
		$room_number = $_GET['room_number'];
	} else {
		$room_number = $_POST['roomno'];
	}
	if (!empty($_POST['arri_id'])) {
		$arrival_b_id = $_POST['arri_id'];
	}
	$serial = $_POST['serial'];
	$fname = $_POST['fname'];
	$gender = $_POST['gender'];
	$gender_insert = $gender[0];
	foreach ($gender as $gen) {
		if ($gen == 'Male') {
			$name_title[] = 'Mr';
		} else {
			$name_title[] = 'Mrs';
		}
	}

	$name = $name_title[0] . ' ' . $fname[0];
	$email = trim($_POST['email']);
	$phone = $_POST['phone'];
	$booking_via = isset($_POST['booking_via']) ? $_POST['booking_via'] : false;
	$bookingid = isset($_POST['bookingid']) ? $_POST['bookingid'] : false;
	$lastlocation = $_POST['lastlocation'];
	$nextlocation = isset($_POST['nextlocation']) ? $_POST['nextlocation'] : false;
	$checkin = $_POST['checkin'];
	$checkout = $_POST['checkout'];
	$date_rep = str_replace('/', '-', $checkin);
	$check_ci = date('Y-m-d', strtotime($date_rep));
	$date_rep2 = str_replace('/', '-', $checkout);
	$checkout_cr = date('Y-m-d', strtotime($date_rep2));
	$nights = $_POST['nights'];
	$noofguest = isset($_POST['noofguest']) ? $_POST['noofguest'] : false;
	$purpose = $_POST['purpose'];
	$booking_amount = $_POST['amount'];
	$e_adult_charge = isset($_POST['e_adult_charge']) ? $_POST['e_adult_charge'] : false;
	$h_tax = isset($_POST['h_tax']) ? $_POST['h_tax'] : false;
	$a_charge = isset($_POST['a_charge']) ? $_POST['a_charge'] : false;
	$g_comm = isset($_POST['g_comm']) ? $_POST['g_comm'] : false;
	$gst_18 = isset($_POST['gst_18']) ? $_POST['gst_18'] : false;
	$comm_inc_gst = isset($_POST['comm_inc_gst']) ? $_POST['comm_inc_gst'] : false;
	$pay_hotel = isset($_POST['pay_hotel']) ? $_POST['pay_hotel'] : false;
	$inserted_by = $_SESSION['full_name'];


	if ($serial != "" && $checkout != "" && $name != "" && $checkin != "" && $email != "" && $phone != "" && $lastlocation != "" && $nextlocation != "" &&  $purpose != "" && $room_number != "") {

		$room_number_query1 = "SELECT * FROM room_details WHERE room_number = '$room_number' AND room_status ='empty' AND hotel_id = '$hotel_id'";
		$room_number_exe1 = $db->execute($room_number_query1);
		$noroom_nu_row1 = $db->rowCount();

		if ($noroom_nu_row1 > 0) {

			$query_dup = "SELECT * FROM check_in_details WHERE room_number = '$room_number' AND status = 0 AND hotel_id = '$hotel_id'";
			$execute_dup = $db->execute($query_dup);
			$no_of_data = $db->rowCount($execute_dup);
			if ($no_of_data > 0) {
				$query_up = "UPDATE check_in_details SET status = 1 WHERE room_number = '$room_number' AND hotel_id = '$hotel_id' AND status = 0";
				$execute_up = $db->execute($query_up);
			}

			$query_run = "INSERT INTO check_in_details(`hotel_id`,`serial_number`,`name`,`gender`,`email`,`phone`,`last_location`,`next_location`,`purpouse`,`booking_via`,`booking_id`,`checkin_date`,`checkout_date`,`booking_nights`,`room_number`,`no_of_person`,`booking_amount`,`charge_per_adult`, `hotel_tax`, `hotel_gross_charge`, `commission`, `gst_18`, `commission_gst`, `pay_to_hotel`,`inserted_by`,`inserted_date`,`current_ci_date`,`current_co_date`) VALUES('$hotel_id','$serial','$name','$gender_insert','$email','$phone','$lastlocation','$nextlocation','$purpose','$booking_via','$bookingid','$checkin','$checkout','$nights','$room_number','$noofguest','$booking_amount','$e_adult_charge','$h_tax','$a_charge','$g_comm','$gst_18','$comm_inc_gst','$pay_hotel','$inserted_by','$current_date_time','$check_ci','$checkout_cr')";
			$db->execute($query_run);
			$last_id = $db->LastId();

			$count = count($fname);
			if ($last_id > 0) {
				if ($count > 1) {
					for ($i = 1; $i < $count; $i++) {

						$nametitle_s = $name_title[$i];
						$name_s = $fname[$i];
						$gender_s = $gender[$i];
						$checkin_date = $checkin;
						$person_queries[] = "INSERT INTO echeckin_person_name(`checkin_id`,`name_title`, `name`,`gender`,`checkin_date`,`inserted_date`) VALUES('$last_id','$nametitle_s','$name_s','$gender_s','$checkin_date','$current_date_time')";
					}
					foreach ($person_queries as $person_query) {
						$db->execute($person_query);
					}
				}
				$db->execute("UPDATE room_details SET room_status='booked' WHERE room_number = '$room_number' AND hotel_id='$hotel_id'");
				if (!empty($arrival_b_id)) {
					$db->execute("UPDATE arrival_booking_history SET booking_status= 'checkedin' WHERE arrival_b_id = '$arrival_b_id' AND hotel_id = '$hotel_id'");
				} else {
					$query_up  = "UPDATE arrival_booking_history SET booking_status= 'checkedin' WHERE booking_id = '$bookingid' AND hotel_id='$hotel_id'";
					$db->execute($query_up);
				}
				$_SESSION['success'] = "Room number " . $room_number . " successfully booked by " . $name;
				echo "success";
				//guest email start code here

				$hotels_query = $db->execute("SELECT * From hotels WHERE hotel_id = '$hotel_id' LIMIT 1");
				$ho_result = $db->getResult($hotels_query);
				//session data for welcome email template
				$hne = $ho_result['hotel_name'];
				$kext = $ho_result['kitchen_extension_no'];
				$rext = $ho_result['reception_extension_no'];
				//end templ


				$last_name = end(explode(" ", $name));
				$subject = "Welcome to " . $hne . " Dear, " . $last_name;

				// HTML email starts here
				$html = "";
				include('welcome-email-tpl.php');

				$mail = new PHPMailer();
				//$mail->IsSMTP();
				$mail->Host = "smtp.gmail.com";
				$mail->SMTPAuth = true;
				$mail->Username = "booking@checkinroom.com";
				$mail->Password = "Vijay#1174";
				$mail->Port = 465;
				$mail->SMTPSecure = "ssl";
				$mail->isHTML(true);
				$mail->setFrom('booking@checkinroom.com', 'Check In Room');
				$mail->addReplyTo('support@checkinroom.com');
				//$mail->addAddress($email_ss);
				$mail->addAddress($email);
				$mail->addBCC('support@checkinroom.com');
				//$mail->addBCC('guddukmr786@gmail.com');

				$mail->addEmbeddedImage('images/quickchkimg/checkinroom-logo.png', 'logo');
				//$mail->addEmbeddedImage('images/quickchkimg/dial.png','dial');
				$mail->addEmbeddedImage('images/quickchkimg/sushant-travels-banner.jpg', 'susbanner');
				$mail->addEmbeddedImage('images/quickchkimg/Rajasthan-holiday-tour-packages.jpg', 'rajasthan-tour');
				$mail->addEmbeddedImage('images/quickchkimg/Himachal-Pradesh-tour-packages.jpg', 'himachal-tour');
				$mail->addEmbeddedImage('images/quickchkimg/hotel-nirmal-mahal.jpg', 'nirmal-mahal');
				$mail->addEmbeddedImage('images/quickchkimg/hotel-cabana.jpg', 'hotel-cabana');
				$mail->addEmbeddedImage('images/quickchkimg/hotel-all-iz-well.jpg', 'hotel-all-iz');
				$mail->addEmbeddedImage('images/quickchkimg/sayagata.gif', 'sayagata');
				$mail->addEmbeddedImage('images/quickchkimg/facebook.png', 'facebook');
				$mail->addEmbeddedImage('images/quickchkimg/twitter.png', 'twitter');
				$mail->addEmbeddedImage('images/quickchkimg/youtube.png', 'youtube');
				$mail->addEmbeddedImage('images/quickchkimg/linkedin.png', 'linkedin');
				$mail->addEmbeddedImage('images/quickchkimg/tumbl.png', 'tumblr');
				$mail->addEmbeddedImage('images/quickchkimg/pinterest.png', 'pinterest');
				$mail->addEmbeddedImage('images/quickchkimg/googleplus.png', 'googleplus');
				$mail->addEmbeddedImage('images/quickchkimg/instagram.png', 'instagram');

				$mail->Subject = $subject;

				$mail->Body = $html;

				$mail->AltBody = '';
				$mail->send();
				/*if(!$mail->send()){
						echo 'Message could not be sent.';
						echo 'Mailer Error: ' . $mail->ErrorInfo."<br>";
					}*/


				unset($_SESSION['nametitle']);
				unset($_SESSION['fname']);
				unset($_SESSION['serial']);
				unset($_SESSION['gender']);
				unset($_SESSION['email']);
				unset($_SESSION['phone']);
				unset($_SESSION['lastlocation']);
				//unset($_SESSION['nextlocation']);
				unset($_SESSION['checkin']);
				unset($_SESSION['checkout']);
				unset($_SESSION['nights']);
				unset($_SESSION['purpose']);
				unset($_SESSION['roomno']);
				unset($_SESSION['bookingid']);
			} else {
				$_SESSION['error'] = "Error in booking room number " . $room_number . " please try again.";
			}
		} else {
			echo 4;
			die;
		}
	} else {
		echo  "Error! All field are required.";
	}
}


if (isset($_GET['email'])) {
	$email = $_GET['email'];
	$duplicat_email = $db->execute("SELECT cid.*, h.hotel_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.email = '$email'");
	$num_of_count = $db->rowCount();
	$results = $db->getResult($duplicat_email);
	$date_m = date_format(new DateTime($results['inserted_date']), 'd M Y');
	$checkin_id = $results['checkin_id'];
	if ($num_of_count > 0) {
		echo $results['name'] . " is already checked-in in " . $results['hotel_name'] . " since " . $date_m . "  <a href='entry_list.php?re_checkin_id=" . $checkin_id . "'>Click Here to Re-Checkin</a>";
	}
}

if (isset($_GET['type']) && $_GET['type'] == "recheckin") {
	$checkin_id = $_GET['checkin_id'];
	$serial = $_POST['serial'];
	//$nametitle = $_POST['nametitle'];
	$fname = $_POST['fname'];
	$gender = $_POST['gender'];

	foreach ($gender as $gen) {
		if ($gen == 'Male') {
			$nametitle[] = 'Mr';
		} else {
			$nametitle[] = 'Mrs';
		}
	}

	$booking_via = $_POST['booking_via'];
	$bookingid = $_POST['bookingid'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$lastlocation = $_POST['lastlocation'];
	$nextlocation = $_POST['nextlocation'];

	$checkin = $_POST['checkin'];
	$date_cc = str_replace('/', '-', $checkin);
	$checkindate = date('Y-m-d', strtotime($date_cc));

	$checkout = $_POST['checkout'];
	$date_cc2 = str_replace('/', '-', $checkout);
	$checkoutdate = date('Y-m-d', strtotime($date_cc2));

	$nights = $_POST['nights'];
	$purpose = $_POST['purpose'];
	$room_number = $_POST['roomno'];
	$b_amount = $_POST['b_amount'];
	$e_adult_charge = isset($_POST['e_adult_charge']) ? $_POST['e_adult_charge'] : false;
	$h_tax = isset($_POST['h_tax']) ? $_POST['h_tax'] : false;
	$a_charge = isset($_POST['a_charge']) ? $_POST['a_charge'] : false;
	$g_comm = isset($_POST['g_comm']) ? $_POST['g_comm'] : false;
	$gst_18 = isset($_POST['gst_18']) ? $_POST['gst_18'] : false;
	$comm_inc_gst = isset($_POST['comm_inc_gst']) ? $_POST['comm_inc_gst'] : false;
	$pay_hotel = isset($_POST['pay_hotel']) ? $_POST['pay_hotel'] : false;
	$inserted_by = $_SESSION['full_name'];
	$arrival_b_id = isset($_POST['arrival_b_id']) ? $_POST['arrival_b_id'] : false;
	if ($email != "" && $phone != "" && $lastlocation != "" && $nextlocation != "" && $checkin != "" && $checkout != "" && $room_number != "") {
		//for number of person and guest entry
		$count = count($fname);

		$query_recheckin = "UPDATE check_in_details SET hotel_id='$hotel_id', serial_number = '$serial', email = '$email', phone = '$phone', purpouse ='$purpose', last_location = '$lastlocation', next_location = '$nextlocation', booking_via = '$booking_via', booking_id = '$bookingid',checkin_date = '$checkin', checkout_date = '$checkout', final_checkout_date = '0000-00-00 00:00:00', booking_nights ='$nights', extended_days =0, room_number ='$room_number', no_of_person ='$count', booking_amount='$b_amount',  charge_per_adult='$e_adult_charge',  hotel_tax='$h_tax',  hotel_gross_charge='$a_charge',  commission='$g_comm',  gst_18='$gst_18',  commission_gst='$comm_inc_gst',  pay_to_hotel='$pay_hotel',  meal_plan='Only Room', status = 0, checkout_by='', inserted_by='$inserted_by', inserted_date=NOW(),current_ci_date='$checkindate',current_co_date='$checkoutdate' WHERE checkin_id = '$checkin_id' AND status = 1";
		$db->execute($query_recheckin);
		$update_id = $db->affectedRows();

		if ($update_id) {
			$db->execute("UPDATE room_details SET room_status ='booked' WHERE hotel_id = '$hotel_id' AND room_number = '$room_number'");
			if (!empty($arrival_b_id)) {
				$db->execute("UPDATE arrival_booking_history SET booking_status= 'checkedin' WHERE arrival_b_id = '$arrival_b_id' AND hotel_id = '$hotel_id'");
			}

			//update no of person details
			$query_per = "INSERT INTO echeckin_person_name_history(`person_id`, `checkin_id`, `name_title`, `name`, `gender`, `checkin_date`, `inserted_date`) SELECT * FROM checkin_person_name WHERE checkin_id = '$checkin_id'";
			$db->execute($query_per);

			if ($count > 1) {
				for ($i = 1; $i < $count; $i++) {
					$nametitle_s = $nametitle[$i];
					$name_s = $fname[$i];
					$gender_s = $gender[$i];
					$person_queries[] = "INSERT INTO echeckin_person_name(`checkin_id`,`name_title`, `name`, `gender`,`checkin_date`,`inserted_date`) VALUES('$checkin_id','$nametitle_s','$name_s','$gender_s','$checkin',NOW())";
				}
				foreach ($person_queries as $person_query) {
					$db->execute($person_query);
				}
			}

			echo "Re-Checked-In successfully";
		} else {
			echo "Opps...Somting is wrong please try again later";
		}
	} else {
		echo "All field are required.";
	}
}


if (isset($_GET['type']) && $_GET['type'] == 'extend_form_data') {
	$checkin_id = $_POST['checkin_id'];
	$booking_via = $_POST['booking_via'];
	$bookingid = $_POST['bookingid'];
	$checkin = $_POST['checkin'];
	$checkout = $_POST['checkout'];

	$date_rep = str_replace('/', '-', $checkin);
	$check_ci = date('Y-m-d', strtotime($date_rep));

	$date_rep2 = str_replace('/', '-', $checkout);
	$checkout_cr = date('Y-m-d', strtotime($date_rep2));

	$nights = $_POST['nights'];
	//$hotel_id = $_SESSION['hotel_id'];
	if (isset($_POST['b_amount'])) {
		$b_amount = $_POST['b_amount'];
	}

	if ($checkin_id != "" && $booking_via != "" && $bookingid != "" && $checkin != "" && $checkout != "" && $nights != "") {
		$extend_query = "INSERT INTO extended_booking_days(`checkin_id`, `hotel_id`, `booking_via`, `booking_id`, `checkin_date`, `checkout_date`, `booking_nights`, `booking_amount`, `current_ci_date`, `current_co_date`, `extended_date`)
		VALUES ('$checkin_id','$hotel_id','$booking_via','$bookingid','$checkin','$checkout','$nights','$b_amount', '$check_ci','$checkout_cr',NOW())";
		$db->execute($extend_query);
		$last_id = $db->LastId();

		/*if($booking_via == "Direct"){
			$query_chek = "SELECT room_number FROM check_in_details WHERE checkin_id = '$checkin_id' AND booking_via = 'Direct' AND status = 0 AND hotel_id='$hotel_id'";
			$query_run = $db->execute($query_chek);
			$result = $db->getResult($query_run);
			if($result['room_number']){
				$room_number = $result['room_number'];
				$db->execute("UPDATE day_book_entry SET amount = amount + '$b_amount' WHERE summary_id = '1' AND expense_by = '$room_number' AND check_out_status = 0");
			}
		}*/

		if ($last_id > 0) {
			$db->execute("UPDATE check_in_details SET extended_days = extended_days+'$nights' WHERE checkin_id = '$checkin_id' AND hotel_id='$hotel_id'");
			//$db->execute("UPDATE guest_checkin_history SET extended_days = extended_days+'$nights' WHERE checkin_id = '$checkin_id' AND hotel_id='$hotel_id'");
			$db->execute("UPDATE arrival_booking_history SET booking_status = 'checkedin' WHERE booking_id = '$bookingid' AND hotel_id='$hotel_id'");
		}
		unset($_SESSION['booking_via']);
		unset($_SESSION['bookingid']);
		unset($_SESSION['checkin']);
		unset($_SESSION['checkout']);
		unset($_SESSION['nights']);
		unset($_SESSION['b_amount']);
		echo "Ex success";
	} else {
		echo "Error";
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'arrival_booking') {

	if (isset($_POST['booking_id'])) {
		$booking_id = trim($_POST['booking_id']);
	} else {
		$booking_id = "";
	}
	$name = $_POST['name'];
	if (!empty($_POST['email'])) {
		$email = trim($_POST['email']);
		if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
			echo 4;
			die;
		}
	} else {
		$email = "";
	}
	$phone = trim($_POST['phone']);
	$fkcountry = $_POST['fkcountry'];
	$category = $_POST['category'];
	if (isset($_POST['mode'])) {
		$mode = $_POST['mode'];
	} else {
		$mode = "";
	}

	if (!empty($_POST['pickup'])) {
		$pickup = $_POST['pickup'];
	} else {
		$pickup = "No";
	}
	if (!empty($_POST['flight']) && $_POST['pickup'] == 'Yes') {
		$flight = $_POST['flight'];
	} else {
		$flight = "";
	}
	$company = $_POST['booking_via'];
	$checkin = $_POST['checkin'];
	$checkout = $_POST['checkout'];
	$ex_ch_time = $_POST['ex_ch_time'] ?? "";
	$noofguest = $_POST['noofguest'];

	$room_charge = $_POST['room_charge'];
	$e_adult_charge = $_POST['e_adult_charge'];
	$h_tax = $_POST['h_tax'];
	$a_charge = $_POST['a_charge'];
	$g_comm = $_POST['g_comm'];
	$gst_18 = $_POST['gst_18'];
	$comm_inc_gst = $_POST['comm_inc_gst'];
	$pay_hotel = $_POST['pay_hotel'];
	if ($_POST['noofroom']) {
		$noofroom = $_POST['noofroom'];
	}
	$status = "confirmed";
	$date_time = DATE_TIME;

	$inserted_by = $_COOKIE['full_name'];

	if ($hotel_id == "" || $name == "" || $phone == "" || $checkin == "" || $checkout == "" || $category == "" || $fkcountry == "" || $room_charge == "0" || $h_tax == "" || $g_comm == "" || $gst_18 == "" || $pay_hotel == "") {
		echo 1;
		die;
	} else {

		if (isset($_SESSION['type']) && $_SESSION['type'] == 'update_booking') {
			$arrival_b_id = $_POST['arrival_b_id'];
			$query_arrival = "UPDATE arrival_booking_history SET `hotel_id`='$hotel_id', `booking_id`='$booking_id', `guest_name`='$name', `guest_email`='$email',`guest_phone`='$phone', `country`='$fkcountry', `room_category`='$category', `booking_mode`='$mode', `pickup`='$pickup', `flight_details`='$flight',`booking_via`='$company', `checkin_date`='$checkin', `checkout_date`='$checkout',`ex_ch_time`='$ex_ch_time',`no_of_guest`='$noofguest',`noof_room`='$noofroom',`room_charge`='$room_charge',`e_adult_charge`='$e_adult_charge',`h_tax`='$h_tax',`a_charge`='$a_charge',`g_comm`='$g_comm',`gst_18`='$gst_18',`comm_inc_gst`='$comm_inc_gst',`pay_hotel`='$pay_hotel',`inserted_date`= '$date_time' WHERE arrival_b_id ='$arrival_b_id' AND hotel_id='$hotel_id'";
			$execute_arrival = $db->execute($query_arrival);
			unset($_SESSION['booking_id']);
			unset($_SESSION['name']);
			unset($_SESSION['category']);
			unset($_SESSION['mode']);
			unset($_SESSION['company']);
			unset($_SESSION['pickup']);
			unset($_SESSION['flight']);
			unset($_SESSION['email']);
			unset($_SESSION['phone']);
			unset($_SESSION['fkcountry']);
			unset($_SESSION['checkin']);
			unset($_SESSION['checkout']);
			unset($_SESSION['type']);
			unset($_SESSION['noofguest']);
			unset($_SESSION['noofroom']);
			//unset($_SESSION['b_amount']);
			echo 3;
		} else {
			$booking_idquery = $db->execute("SELECT * FROM arrival_booking_history WHERE booking_id = '$booking_id'");
			$numofrow = $db->rowCount($booking_idquery);
			if ($numofrow > 0) {
				echo 2;
			} else {

				$query_arrival = "INSERT INTO arrival_booking_history(`hotel_id`, `booking_id`, `guest_name`, `guest_email`, `guest_phone`, `country`, `room_category`, `booking_mode`, `pickup`, `flight_details`, `booking_via`, `checkin_date`, `checkout_date`,`ex_ch_time`,`no_of_guest`, `noof_room`,`room_charge`, `e_adult_charge`, `h_tax`, `a_charge`, `g_comm`, `gst_18`, `comm_inc_gst`, `pay_hotel`,`inserted_by`,`inserted_date`,`booking_status`) 
				VALUES('$hotel_id','$booking_id','$name','$email','$phone','$fkcountry','$category','$mode','$pickup','$flight','$company','$checkin','$checkout','$ex_ch_time','$noofguest','$noofroom','$room_charge','$e_adult_charge','$h_tax','$a_charge','$g_comm','$gst_18','$comm_inc_gst','$pay_hotel','$inserted_by','$date_time','$status')";

				$execute_arrival = $db->execute($query_arrival);

				//Guest Confirmation email
				if ($hotel_id == 14) {
					$hotels_query = $db->execute("SELECT hotel_name From hotels WHERE hotel_id = '$hotel_id' LIMIT 1");
					$ho_result = $db->getResult($hotels_query);
					$subject = "Welcome to " . $ho_result['hotel_name'];
					$last_name = end(explode(" ", $name));
					// HTML email starts here
					$curr_date_time = MODIFIED_DATE;

					$message .= '<body style="line-height:24px;font-size:16px;font-family:sans-serif;">';
					$message .= '<div style="margin-right: auto;	margin-left: auto;	padding-left: 15px;	padding-right: 15px; width:90%">';
					$message .= '<h1 style="font-size:24px;">Dear Sir,</h1>';
					$message .= '<h3 style="line-height:28px;font-size:20px;">Thank you for choosing Hotel All Iz Well for your stay in New Delhi. We are glad to inform you that your <strong>booking has been confirmed</strong></h3>';
					$message .= '<p style="margin-top:20px;"><strong>Please Note:</strong> Some taxi drivers are paid commission to take guests to the wrong hotel. To make sure you reach the hotel without hassles. We request you to call us on our hotel line number <strong>091-9999331174</strong>. Do NOT let the taxi driver dial this number; they will make excuses in the middle of the way that they don’t know the way or the road is closed so will suggest you fake tourist information agencies Where they call their friends who will tell you that the hotel is closed for whatever reason. If at all you are caught in this situation. Tell them you have the car registration number and you are going to call the police. Police helpline # 100</p>

						<p style="margin-top:20px;">As per Delhi Government guidelines, every guest has to present valid id proofs like Passport, Driving License, Voter Card, Aadhar Card at the time of check-in, and No Delhi NCR local guest will be entertained without proper verification from Hotel Team and local police station( only for localities of Delhi NCR)</p>

						<p style="margin-top:20px;">The hotel has own Travel Agency in the name of  <a href="http://www.sushanttravels.com" target="_blank"><strong>Sushant Travels</strong> </a>So, If you need any Travel Information or Tour Packages related information you can frequently E-mail us on <a href="mailto:booking@sushanttravels.com" target="_blank"><strong>booking@sushanttravels.com</strong></a>.
						The hotel also provides Airport Pickup/Drop Facility on demand. For any other assistance, kindly do let us know, we would be glad to hear from you.</p>';
					$message .= '<h2 style="font-weight:900;font-family:georgia;font-style:italic;margin-bottom:20px;">Experience The Excitement with Sushant Travels</h2>';
					$message .= '<div class="col-lg-12">';

					$message .= '<div class="row">';
					$message .= '<div style="position: relative;min-height: 1px; float:left;width:100%;">';
					$message .= '<div style="position: relative;min-height: 1px; float:left;width:25%;">';
					$message .= '<div style=" overflow: hidden;text-align: center;margin-top: 0px;  border: 5px solid #fff;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1); box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);">';
					$message .= '<a href="https://www.sushanttravels.com/rajasthan-tour-packages-rajasthan-toursim.html" target="_blank"><img src="cid:rajasthan" class="img-responsive" alt="Rajasthan" />';
					$message .= '<p style="position:absolute;background:#333;color:#fff;bottom:0px;padding:5px 15px;right:5px;font-size:18px;font-weight:600;">Rajasthan</p>';
					$message .= '</a>';
					$message .= '</div>';
					$message .= '</div>';

					$message .= '<div style="position: relative;min-height: 1px; float:left;width:25%;">';
					$message .= '<div style=" overflow: hidden;text-align: center;margin-top: 0px;  border: 5px solid #fff;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);">';
					$message .= '<a href="https://www.sushanttravels.com/tour-package-Uttarakhand-Tour-Packages.html" target="_blank"><img src="cid:uttrakhand" class="img-responsive" alt="Uttrakhand" />';
					$message .= '<p style="position:absolute;background:#333;color:#fff;bottom:0px;padding:5px 15px;right:5px;font-size:18px;font-weight:600;">Uttrakhand</p>';
					$message .= '</a>';
					$message .= '</div>';
					$message .= '</div>';

					$message .= '<div style="position: relative;min-height: 1px; float:left;width:25%;">';
					$message .= '<div style=" overflow: hidden;text-align: center;margin-top: 0px;  border: 5px solid #fff;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);">';
					$message .= '<a href="https://www.sushanttravels.com/tour-package-Uttar-Pradesh-Tour-Packages.html" target="_blank"><img src="cid:pradesh" class="img-responsive" alt="Uttar Pradesh" />';
					$message .= '<p style="position:absolute;background:#333;color:#fff;bottom:0px;padding:5px 15px;right:5px;font-size:18px;font-weight:600;">Uttar Pradesh</p>';
					$message .= '</a>';
					$message .= '</div>';
					$message .= '</div>';

					$message .= '<div style="position: relative;min-height: 1px; float:left;width:25%;">';
					$message .= '<div style=" overflow: hidden;text-align: center;margin-top: 0px;  border: 5px solid #fff;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);">';
					$message .= '<a href="https://www.sushanttravels.com/tour-package-Himachal-Pradesh-Tour-Packages.html" target="_blank"><img src="cid:himachal" class="img-responsive" alt="Himachal" />';
					$message .= '<p style="position:absolute;background:#333;color:#fff;bottom:0px;padding:5px 15px;right:5px;font-size:18px;font-weight:600;">Himachal</p>';

					$message .= '</a>';
					$message .= '</div>';
					$message .= '</div>';


					$message .= '<div style="clear:both;float:left;width:100%;margin-top:30px;"></div>';
					$message .= '<div style="width:240px;height:40px;margin:0px auto;">';
					$message .= '<div class="clear"></div>';
					$message .= '<a href="http://www.sushanttravels.com" target="_blank" style="margin:30px auto;width:100%;height:40px;background:#cc0000;color:#fff;padding:10px 40px; border-radius:4px;margin-bottom:20px;text-decoration:none;">Book Now</a>';
					$message .= '<div class="clear"></div>';
					$message .= '</div>';
					$message .= '<p style="margin-top:20px;width:100%;float:left;">&nbsp;</p>';
					$message .= '</div>';
					$message .= '</div>';
					$message .= '</body>';


					$mail = new PHPMailer();

					//$mail->IsSMTP();
					$mail->Host = "smtp.gmail.com";
					$mail->SMTPAuth = true;
					$mail->Username = "booking@checkinroom.com";
					$mail->Password = "Checkin*55";
					$mail->Port = 465;
					$mail->SMTPSecure = "ssl";
					$mail->isHTML(true);
					$mail->setFrom('booking@checkinroom.com', 'Check In Room');

					//$mail->addAddress($email_ss);
					$mail->addAddress('guddukmr786@gmail.com');
					//$mail->addBCC('guddukmr786@gmail.com');
					//$mail->addBCC('vijay.tiwari@budgettravelindia.com');

					$mail->addEmbeddedImage('images/rajasthan.jpg', 'rajasthan');
					$mail->addEmbeddedImage('images/uttrakhand.jpg', 'uttrakhand');
					$mail->addEmbeddedImage('images/uttar-pradesh.jpg', 'pradesh');
					$mail->addEmbeddedImage('images/himachal.jpg', 'himachal');
					$mail->Subject = $subject;

					$mail->Body = $message;

					$mail->AltBody = '';

					if (!$mail->send()) {
						echo 'Mailer Error: ' . $mail->ErrorInfo;
					}
				}
				//echo $query_arrival;die;

				unset($_SESSION['booking_id']);
				unset($_SESSION['name']);
				unset($_SESSION['category']);
				unset($_SESSION['mode']);
				unset($_SESSION['company']);
				unset($_SESSION['pickup']);
				unset($_SESSION['flight']);
				unset($_SESSION['email']);
				unset($_SESSION['phone']);
				unset($_SESSION['fkcountry']);
				unset($_SESSION['checkin']);
				unset($_SESSION['checkout']);
				unset($_SESSION['noofguest']);
				unset($_SESSION['noofroom']);
				//unset($_SESSION['b_amount']);
				echo 0;
			}
		}
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'arrival_booking_dashboard') {
	//code for updateting arrival booking from checkinroom.in dashboard

	if (isset($_POST['hotel_name'])) {
		$hotel_name = $_POST['hotel_name'];
		$hotels_query = $db->execute("SELECT hotel_id FROM hotels WHERE hotel_name ='$hotel_name'");

		$hotels = $db->getResult($hotels_query);
		$hotel_id = $hotels['hotel_id'];
	}


	if (isset($_POST['booking_id'])) {
		$booking_id = trim($_POST['booking_id']);
	} else {
		$booking_id = "";
	}
	$name = $_POST['name'];
	if (!empty($_POST['email'])) {
		$email = trim($_POST['email']);
	} else {
		$email = "";
	}
	$phone = trim($_POST['phone']);
	$fkcountry = $_POST['fkcountry'] ?? "";
	$category = $_POST['category'] ?? "";

	$mode = "Pay at hotel";

	if (!empty($_POST['pickup'])) {
		$pickup = $_POST['pickup'];
	} else {
		$pickup = "No";
	}
	if (!empty($_POST['flight']) && $_POST['pickup'] == 'Yes') {
		$flight = $_POST['flight'];
	} else {
		$flight = "";
	}
	$company = $_POST['booking_via'];

	$checkin1 = date('d-m-Y', strtotime($_POST['checkin']));
	$checkout1 = date('d-m-y', strtotime($_POST['checkout']));

	$checkin = str_replace('-', '/', $checkin1);
	$checkout = str_replace('-', '/', $checkout1);

	$ex_ch_time = $_POST['ex_ch_time'] ?? "";
	$noofguest = $_POST['noofguest'];

	$room_charge = $_POST['room_charge'];
	$e_adult_charge = $_POST['e_adult_charge'] ?? "";
	$h_tax = $_POST['h_tax'] ?? "";
	$a_charge = $_POST['a_charge'] ?? "";
	$g_comm = $_POST['g_comm'] ?? "";
	$gst_18 = $_POST['gst_18'];
	$comm_inc_gst = $_POST['comm_inc_gst'] ?? "";
	$pay_hotel = $_POST['pay_hotel'];
	if (isset($_POST['noofroom'])) {
		$noofroom = $_POST['noofroom'];
	}
	$status = "confirmed";
	$date_time = DATE_TIME;

	$inserted_by = $_COOKIE['full_name'];

	if ($hotel_id != "" || $name != "" || $phone != "" || $checkin != "" || $checkout != "" || $room_charge != "0" ||  $gst_18 != "" || $pay_hotel != "") {

		$booking_idquery = $db->execute("SELECT * FROM arrival_booking_history WHERE booking_id = '$booking_id'");
		$numofrow = $db->rowCount($booking_idquery);
		if ($numofrow > 0) {
			echo 2;
		} else {

			$query_arrival = "INSERT INTO arrival_booking_history(`hotel_id`, `booking_id`, `guest_name`, `guest_email`, `guest_phone`, `country`, `room_category`, `booking_mode`, `pickup`, `flight_details`, `booking_via`, `checkin_date`, `checkout_date`,`ex_ch_time`,`no_of_guest`, `noof_room`,`room_charge`, `e_adult_charge`, `h_tax`, `a_charge`, `g_comm`, `gst_18`, `comm_inc_gst`, `pay_hotel`,`inserted_by`,`inserted_date`,`booking_status`) 
			VALUES('$hotel_id','$booking_id','$name','$email','$phone','$fkcountry','$category','$mode','$pickup','$flight','$company','$checkin','$checkout','$ex_ch_time','$noofguest','$noofroom','$room_charge','$e_adult_charge','$h_tax','$a_charge','$g_comm','$gst_18','$comm_inc_gst','$pay_hotel','$inserted_by','$date_time','$status')";
			$execute_arrival = $db->execute($query_arrival);
			echo 0;
		}
	} else {
		echo "error plase fill all required filed!";
	}
}


//Save temporary data of checkin form
if (isset($_GET['type']) && $_GET['type'] == 'save_formdata') {
	$_SESSION['nametitle'] = $_POST['nametitle'];
	$_SESSION['gender'] = $_POST['gender'];
	$_SESSION['fname'] = $_POST['fname'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['phone'] = $_POST['phone'];
	$_SESSION['nights'] = $_POST['nights'];
	$_SESSION['purpose'] = $_POST['purpose'];
	$_SESSION['checkin'] = $_POST['checkin'];
	$_SESSION['checkout'] = $_POST['checkout'];
	$_SESSION['lastlocation'] = $_POST['lastlocation'];
	$_SESSION['nextlocation'] = $_POST['nextlocation'];
}
if (isset($_GET['type']) && $_GET['type'] == 'checkout_name_locaion') {
	$_SESSION['checkout_by'] = $_GET['checkout_by'];
	$_SESSION['nextlocation'] = $_GET['nextlocation'];
}
//Save temporary data of extended booking form
if (isset($_GET['type']) && $_GET['type'] == 'save_formdata_extended') {
	$checkin_id = $_SESSION['checkin_id'];
	$_SESSION['booking_via'] = $_POST['booking_via'];
	$_SESSION['bookingid'] = $_POST['bookingid'];
	$_SESSION['checkin'] = $_POST['checkin'];
	$_SESSION['checkout'] = $_POST['checkout'];
	$_SESSION['nights'] = $_POST['nights'];
	$_SESSION['b_amount'] = $_POST['b_amount'];
}

//Save temporary data of entry form

if (isset($_GET['type']) && $_GET['type'] == 'save_entry_formdata') {
	if (!empty($_POST['serial'])) {
		$_SESSION['serial'] = $_POST['serial'];
	}
	if (!empty($_POST['nametitle'])) {
		$_SESSION['nametitle'] = $_POST['nametitle'];
	}
	if (!empty($_POST['fname'])) {
		$_SESSION['fname'] = $_POST['fname'];
	}

	if (!empty($_POST['gender'])) {
		$_SESSION['gender'] = $_POST['gender'];
	}

	if (!empty($_POST['email'])) {
		$_SESSION['email'] = $_POST['email'];
	}
	if (!empty($_POST['phone'])) {
		$_SESSION['phone'] = $_POST['phone'];
	}
	if (!empty($_POST['fkcountry'])) {
		$_SESSION['fkcountry'] = $_POST['fkcountry'];
	}
	if (!empty($_POST['city'])) {
		$_SESSION['city'] = $_POST['city'];
	}
	if (isset($_POST['pin'])) {
		$_SESSION['pin'] = $_POST['pin'];
	}
	if (!empty($_POST['day'])) {
		$_SESSION['day'] = $_POST['day'];
	}
	if (!empty($_POST['month'])) {
		$_SESSION['month'] = $_POST['month'];
	}
	if (!empty($_POST['year'])) {
		$_SESSION['year'] = $_POST['year'];
	}
	if (!empty($_POST['idname'])) {
		$_SESSION['idname'] = $_POST['idname'];
	}
	if (!empty($_POST['idno'])) {
		$_SESSION['idno'] = $_POST['idno'];
	}
	if (isset($_POST['lastlocation'])) {
		$_SESSION['lastlocation'] = $_POST['lastlocation'];
	}
	if (isset($_POST['nextlocation'])) {
		$_SESSION['nextlocation'] = $_POST['nextlocation'];
	}
	if (!empty($_POST['purpose'])) {
		$_SESSION['purpose'] = $_POST['purpose'];
	}

	if (!empty($_POST['address'])) {
		$_SESSION['address'] = $_POST['address'];
	}
	if (isset($_POST['arrival_date'])) {
		$_SESSION['arrival_date'] = $_POST['arrival_date'];
	}
	if (isset($_POST['arrlocation'])) {
		$_SESSION['arrlocation'] = $_POST['arrlocation'];
	}

	if (isset($_POST['passport'])) {
		$_SESSION['passport'] = $_POST['passport'];
	}

	if (isset($_POST['passportexp'])) {
		$_SESSION['passportexp'] = $_POST['passportexp'];
	}

	if (isset($_POST['visa'])) {
		$_SESSION['visa'] = $_POST['visa'];
	}

	if (isset($_POST['visa_valid'])) {
		$_SESSION['visa_valid'] = $_POST['visa_valid'];
	}

	if (!empty($_POST['booking_via'])) {
		$_SESSION['booking_via'] = $_POST['booking_via'];
	}
	if (!empty($_POST['bookingid'])) {
		$_SESSION['bookingid'] = $_POST['bookingid'];
	}
	if (isset($_POST['checkin'])) {
		$_SESSION['checkin'] = $_POST['checkin'];
	}
	if (isset($_POST['checkout'])) {
		$_SESSION['checkout'] = $_POST['checkout'];
	}
	if (isset($_POST['nights'])) {
		$_SESSION['nights'] = $_POST['nights'];
	}

	if (!empty($_POST['roomno'])) {
		$_SESSION['roomno'] = $_POST['roomno'];
	}
	if (!empty($_POST['adult'])) {
		$_SESSION['adult'] = $_POST['adult'];
	}
	if (!empty($_POST['child'])) {
		$_SESSION['child'] = $_POST['child'];
	}
	if (!empty($_POST['b_amount'])) {
		$_SESSION['b_amount'] = $_POST['b_amount'];
	}
	if (isset($_POST['ex_ad_charges'])) {
		$_SESSION['ex_ad_charges'] = $_POST['ex_ad_charges'];
	}
	if (!empty($_POST['meal_plan'])) {
		$_SESSION['meal_plan'] = $_POST['meal_plan'];
	}

	if (!empty($_POST['booking_id'])) {
		$_SESSION['booking_id'] = $_POST['booking_id'];
	}
	if (!empty($_POST['name'])) {
		$_SESSION['name'] = $_POST['name'];
	}
	if (!empty($_POST['category'])) {
		$_SESSION['category'] = $_POST['category'];
	}
	if (!empty($_POST['mode'])) {
		$_SESSION['mode'] = $_POST['mode'];
	}
	if (isset($_POST['company'])) {
		$_SESSION['company'] = $_POST['company'];
	}
	if (!empty($_POST['pickup'])) {
		$_SESSION['pickup'] = $_POST['pickup'];
	}
	if (!empty($_POST['flight'])) {
		$_SESSION['flight'] = $_POST['flight'];
	}
	if (!empty($_POST['noofguest'])) {
		$_SESSION['noofguest'] = $_POST['noofguest'];
	}
	if (!empty($_POST['noofroom'])) {
		$_SESSION['noofroom'] = $_POST['noofroom'];
	}
}
if (isset($_GET['type']) && $_GET['type'] == 'save_day_book_data') {
	if (isset($_POST['exp_type'])) {
		$_SESSION['exp_type'] = $_POST['exp_type'];
	}
	if (!empty($_POST['receive'])) {
		$_SESSION['receive'] = $_POST['receive'];
	}
	if (!empty($_POST['exp_by'])) {
		$_SESSION['exp_by'] = $_POST['exp_by'];
	}
	if (!empty($_POST['amount'])) {
		$_SESSION['amount'] = $_POST['amount'];
	}
	if (!empty($_POST['description'])) {
		$_SESSION['description'] = $_POST['description'];
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'reset_day_book') {
	unset($_SESSION['exp_type']);
	unset($_SESSION['receive']);
	unset($_SESSION['exp_by']);
	unset($_SESSION['amount']);
	unset($_SESSION['description']);
	echo "success";
}

if (isset($_GET['type']) && $_GET['type'] == 'reset') {
	unset($_SESSION['serial']);
	unset($_SESSION['nametitle']);
	unset($_SESSION['fname']);
	unset($_SESSION['gender']);
	unset($_SESSION['email']);
	unset($_SESSION['phone']);
	unset($_SESSION['fkcountry']);
	unset($_SESSION['city']);
	unset($_SESSION['pin']);
	unset($_SESSION['day']);
	unset($_SESSION['month']);
	unset($_SESSION['year']);
	unset($_SESSION['idname']);
	unset($_SESSION['idno']);
	unset($_SESSION['lastlocation']);
	unset($_SESSION['nextlocation']);
	unset($_SESSION['purpose']);
	unset($_SESSION['address']);
	unset($_SESSION['arrival_date']);
	unset($_SESSION['arrlocation']);
	unset($_SESSION['passport']);
	unset($_SESSION['passportexp']);
	unset($_SESSION['visa']);
	unset($_SESSION['visa_valid']);
	unset($_SESSION['booking_via']);
	unset($_SESSION['bookingid']);
	unset($_SESSION['checkin']);
	unset($_SESSION['checkout']);
	unset($_SESSION['nights']);
	unset($_SESSION['roomno']);
	unset($_SESSION['adult']);
	unset($_SESSION['child']);
	unset($_SESSION['b_amount']);
	unset($_SESSION['ex_ad_charges']);
	unset($_SESSION['meal_plan']);
	unset($_SESSION['booking_id']);
	unset($_SESSION['name']);
	unset($_SESSION['category']);
	unset($_SESSION['mode']);
	unset($_SESSION['company']);
	unset($_SESSION['pickup']);
	unset($_SESSION['flight']);
	unset($_SESSION['noofguest']);
	echo "success";
}

if (isset($_GET['type']) && $_GET['type'] == 'unset_flight') {
	unset($_SESSION['flight']);
}
//Check checkin dat and checkout date not be same 
if (isset($_GET['type']) && $_GET['type'] == 'duplication_checkindate') {
	$checkin_id = $_SESSION['checkin_id'];
	$checkin = $_POST['checkin_date'];

	/*$chekin_query1 = "SELECT checkin_date FROM check_in_details WHERE checkin_id = '$checkin_id' AND checkin_date = '$checkin'";
	$query_checkin = $db->execute($chekin_query1);
	$no_of_rows1 = $db->rowCount();*/

	$chekin_query2 = "SELECT checkin_date FROM extended_booking_days WHERE checkin_id = '$checkin_id' AND checkin_date = '$checkin' AND hotel_id = '$hotel_id'";
	$query_checkin = $db->execute($chekin_query2);
	$no_of_rows2 = $db->rowCount();

	if ($no_of_rows2 > 0) {
		echo 1;
	} else {
		echo 0;
	}
}
if (isset($_GET['type']) && $_GET['type'] == 'duplication_checkoutdate') {
	$checkin_id = $_SESSION['checkin_id'];
	$checkout = $_POST['checkout_date'];
	/*$chekin_query1 = "SELECT checkout_date FROM check_in_details WHERE checkin_id = '$checkin_id' AND checkout_date = '$checkout'";
	$query_checkin = $db->execute($chekin_query1);
	$no_of_rows1 = $db->rowCount();*/

	$chekin_query2 = "SELECT checkout_date FROM extended_booking_days WHERE checkin_id = '$checkin_id' AND checkout_date = '$checkout' AND hotel_id = '$hotel_id'";
	$query_checkin = $db->execute($chekin_query2);
	$no_of_rows2 = $db->rowCount();

	if ($no_of_rows2 > 0) {
		echo 1;
	} else {
		echo 0;
	}
}

if (!empty($_GET['room_avi'])) {
	$room_number = $_GET['room_avi'];
	$query = "SELECT * FROM check_in_details WHERE room_number = '$room_number' AND status=0 AND hotel_id = '$hotel_id'";
	$run_qurey = $db->execute($query);
	$num_of_rows = $db->rowCount();
	if ($num_of_rows > 0) {
		echo 1;
	} else {
		echo 0;
	}
}

//Insret day book entry
if (isset($_GET['type']) && $_GET['type'] == "day_book") {
	$exp_type = $_POST['exp_type'];

	$receive = $_POST['receive'];

	$exp_by = $_POST['exp_by'];

	$amount = $_POST['amount'];

	if (isset($_POST['description'])) {
		$description = $_POST['description'];
	} else {
		$description = "";
	}
	if (isset($_POST['checkin'])) {
		$expense_datess = str_replace('/', '-', $_POST['checkin']);
		$expense_date = date('Y-m-d', strtotime($expense_datess));
	}
	if ($exp_type != "" && $receive != "" && $exp_by != "" && $amount != "" && $_POST['checkin'] != "") {
		$query = "INSERT INTO day_book_entry( `hotel_id`,`expense_type`,`receive_pay`, `expense_by`, `amount`, `description`,`department`, `date_of_expense`, `inserted_date`) 
		VALUES('$hotel_id','$exp_type','$receive','$exp_by','$amount','$description','$exp_type','$expense_date', NOW())";
		//echo $query;die;
		$db->execute($query);
		unset($_SESSION['checkin']);
		unset($_SESSION['exp_type']);
		unset($_SESSION['receive']);
		unset($_SESSION['exp_by']);
		unset($_SESSION['amount']);
		if (isset($_SESSION['description'])) {
			unset($_SESSION['description']);
		}
		echo 0;
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'update_day_book') {
	$day_b_id = $_GET['d_book_id'];
	if (isset($_POST['entry_date'])) {
		$entry_date = str_replace('/', '-', $_POST['entry_date']);
		$exp_date = date('Y-m-d', strtotime($entry_date));
	}

	$exp_type = $_POST['exp_type'];

	$receive = $_POST['receive'];

	$exp_by = $_POST['exp_by'];

	$amount = $_POST['amount'];

	if (isset($_POST['description'])) {
		$description = $_POST['description'];
	} else {
		$description = "";
	}
	if ($exp_type != "" && $exp_type != "" && $receive != "" && $exp_by != "" && $amount != "" && $_POST['entry_date'] != "") {
		$query = "UPDATE day_book_entry SET expense_type ='$exp_type', receive_pay ='$receive', expense_by ='$exp_by', amount ='$amount', description ='$description', department ='$exp_type', date_of_expense = '$exp_date' WHERE day_b_id ='$day_b_id' AND hotel_id ='$hotel_id' ";
		$execute = $db->execute($query);
		echo 0;
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'add_room_advance') {

	$amount = $_POST['amount'];

	$room_num = $_POST['room_num'];
	$date1 = CURR_DATE1;
	if ($amount != "" && $room_num != "") {
		$query = "INSERT INTO day_book_entry( `hotel_id`, `expense_type`,`receive_pay`, `expense_by`, `amount`, `description`, `department`, `date_of_expense`, `inserted_date`) 
		VALUES('$hotel_id','Room Advance','Receive','$room_num','$amount','Room Advance','Hotel','$date1', NOW())";
		$execute = $db->execute($query);
		echo 0;
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'arrival_booking_transfer') {
	$hotel_id1 = $_GET['h_id'];

	$id = $_GET['id'];
	if ($id != "" && $hotel_id1 != "") {
		$query = "SELECT * FROM arrival_booking_history WHERE arrival_b_id = '$id' AND hotel_id = '$hotel_id' AND status=0 LIMIT 1";
		$execute = $db->execute($query);
		$result = $db->getResult($execute);

		$booking_id = $result['booking_id'];
		$guest_name = $result['guest_name'];
		$guest_email = $result['guest_email'];
		$guest_phone = $result['guest_phone'];
		$country = $result['country'];
		$room_category = $result['room_category'];
		$booking_mode = $result['booking_mode'];
		$pickup = $result['pickup'];
		$flight_details = $result['flight_details'];
		$booking_via = $result['booking_via'];
		$checkin_date = $result['checkin_date'];
		$checkout_date = $result['checkout_date'];
		$no_of_guest = $result['no_of_guest'];
		$noof_room = $result['noof_room'];
		$booking_amount = $result['room_charge'];
		$e_adult_charge = $result['e_adult_charge'];
		$h_tax = $result['h_tax'];
		$a_charge = $result['a_charge'];
		$g_comm = $result['g_comm'];
		$gst_18 = $result['gst_18'];
		$comm_inc_gst = $result['comm_inc_gst'];
		$pay_hotel = $result['pay_hotel'];
		$current_data = DATE_TIME;
		$booking_status = $result['booking_status'];

		$query1 = "INSERT INTO arrival_booking_history (`hotel_id`,`booking_id`, `guest_name`, `guest_email`, `guest_phone`, `country`, `room_category`, `booking_mode`, `pickup`, `flight_details`, `booking_via`, `checkin_date`, `checkout_date`, `no_of_guest`, `noof_room`,`room_charge`, `e_adult_charge`, `h_tax`, `a_charge`, `g_comm`, `gst_18`, `comm_inc_gst`, `pay_hotel`,`inserted_date`,`booking_status`) 
		VALUES ('$hotel_id1','$booking_id','$guest_name','$guest_email','$guest_phone','$country','$room_category','$booking_mode','$pickup','$flight_details','$booking_via','$checkin_date','$checkout_date','$no_of_guest','$noof_room','$booking_amount','$e_adult_charge','$h_tax','$a_charge','$g_comm','$gst_18','$comm_inc_gst','$pay_hotel','$current_data','confirmed')";

		$execute1 = $db->execute($query1);

		$query2 = "UPDATE arrival_booking_history SET booking_status = 'transfered', transfer_to = '$hotel_id1', transfer_date = '$current_data' WHERE arrival_b_id ='$id' AND hotel_id = '$hotel_id'";
		$execute2 = $db->execute($query2);
		echo 0;
	} else {
		echo 1;
	}
}



//Insret Employees Details
if (isset($_GET['type']) && $_GET['type'] == "Employees_Details") {
	$fname = $_POST['fname'];
	$qualification = $_POST['qualification'];
	$father_name = $_POST['father_name'];
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	} else {
		$email = "";
	}

	$phone = $_POST['phone'];
	$home_contact = $_POST['home_contact'];
	$ref_contact = $_POST['ref_contact'];
	$salary = $_POST['salary'];
	$convenience = $_POST['convenience'];
	$total = $_POST['total'];
	$depart = $_POST['depart'];

	$expense_datess = str_replace('/', '-', $_POST['checkin']);
	$join_date = date('Y-m-d', strtotime($expense_datess));

	$current_address = $db->realEscape($_POST['current_address']);

	if (isset($_POST['address'])) {
		$address = $db->realEscape($_POST['address']);
	} else {
		$address = "";
	}

	if (isset($_POST['remark'])) {
		$remark = $db->realEscape($_POST['remark']);
	} else {
		$remark = "";
	}

	if ($fname != "" && $father_name != "" && $salary != "" && $convenience != "" && $phone != ""  && $home_contact != "" && $ref_contact != "") {
		$query = "INSERT INTO employees(`hotel_id`, `name`,`qualification`, `father_name`, `phone`, `home_contact`, `ref_contact`, `email`,  `salary`, `convenience`,  `total`, `current_address`, `address`,`remark`,`date_of_join`, `department`, `inserted_date`, `inserted_date_time`) 
		VALUES('$hotel_id','$fname','$qualification','$father_name','$phone','$home_contact','$ref_contact','$email','$salary','$convenience','$total','$current_address','$address','$remark','$join_date','$depart',NOW(),NOW())";

		$db->execute($query);

		$last_id = $db->LastId();

		if (isset($last_id)) {
			if ($_FILES['picture']['size'][0] > 0) {
				$ids_name = $_FILES['picture']['name'];

				$destination = 'upload/employees_ids/';

				$allowed_ext = array('jpg', 'jpeg');

				$count = count($ids_name);

				for ($i = 0; $i < $count; $i++) {
					if ($_FILES['picture']['size'][$i] < 4000000) {
						$realfilename = str_replace(' ', '_', $_FILES['picture']['name'][$i]);
						$final_image_nm = mt_rand() . $realfilename;

						$filename = $final_image_nm;
						$image_name[] = $filename;

						$filetempname = $_FILES['picture']['tmp_name'][$i];



						$fileext = pathinfo($filename, PATHINFO_EXTENSION);

						$fileext = strtolower($fileext);

						//$file_name = mt_rand().

						if (in_array($fileext, $allowed_ext)) {

							move_uploaded_file($filetempname, $destination . $filename);

							$imagepath = $filename;

							//compression code start

							$file = $destination . $imagepath; //This is the original file

							list($width, $height) = getimagesize($file);

							$modwidth = 900;

							$diff = $width / $modwidth;

							$modheight = 500;
							$tn = imagecreatetruecolor($modwidth, $modheight);
							$image = imagecreatefromjpeg($file);
							imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);

							imagejpeg($tn, $file, 90);

							$query = "INSERT INTO employee_ids(employee_id, hotel_id, images) VALUES('$last_id','$hotel_id','$filename') ";
							$db->execute($query);
						} else {
							echo 2;
							die;
						}
					} else {
						echo 3;
						die;
					}
				}
			}
		}
		unset($_SESSION['fname']);
		if (isset($_SESSION['email'])) {
			unset($_SESSION['email']);
		}
		unset($_SESSION['phone']);
		unset($_SESSION['join_date']);
		unset($_SESSION['depart']);
		echo 00;
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'update_employee_details') {
	$employee_id = $_GET['employee_id'];

	$fname = $_POST['fname'];
	$qualification = $_POST['qualification'];
	$father_name = $_POST['father_name'];
	$salary = $_POST['salary'];
	$convenience = $_POST['convenience'];
	$total = $_POST['total'];

	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	} else {
		$email = "";
	}

	$phone = $_POST['phone'];
	$home_contact = $_POST['home_contact'];
	$ref_contact = $_POST['ref_contact'];

	$depart = $_POST['depart1'];

	if (isset($_POST['checkin'])) {
		$entry_date = str_replace('/', '-', $_POST['checkin']);
		$date_of_join = date('Y-m-d', strtotime($entry_date));
	}
	if (isset($_POST['address'])) {
		$address = $db->realEscape($_POST['address']);
	} else {
		$address = "";
	}
	$current_address = $db->realEscape($_POST['current_address']);

	if (isset($_POST['remark'])) {
		$remark = $db->realEscape($_POST['remark']);
	} else {
		$remark = "";
	}
	if ($fname != "" && $father_name != "" && $salary != "" && $convenience != "" && $phone != ""  && $home_contact != "" && $ref_contact != "") {
		$query = "UPDATE employees SET name ='$fname', qualification ='$qualification', father_name ='$father_name', phone ='$phone', home_contact ='$home_contact', ref_contact ='$ref_contact', salary='$salary', convenience='$convenience', total='$total' , email ='$email', current_address ='$current_address', address = '$address' ,remark = '$remark', department ='$depart', date_of_join = '$date_of_join' WHERE employee_id ='$employee_id' AND hotel_id ='$hotel_id' ";

		$execute = $db->execute($query);

		if ($_FILES['picture']['size'][0] > 0) {
			$destination = 'upload/employees_ids/';
			$del_query = "SELECT * FROM employee_ids WHERE employee_id = '$employee_id' AND hotel_id ='$hotel_id'";
			$del_execute = $db->execute($del_query);
			$del_results = $db->getResults($del_execute);
			$row_count = $db->rowCount($del_execute);
			if ($row_count > 0) {
				foreach ($del_results as $del_result) {
					$del_img = $destination . $del_result['images'];
					unlink($del_img);
				}
				$row_del = $db->execute("DELETE FROM employee_ids WHERE employee_id = '$employee_id' AND hotel_id = '$hotel_id'");
			}

			$ids_name = $_FILES['picture']['name'];

			$allowed_ext = array('jpg', 'png', 'jpeg', 'gif', 'bmp');

			$count = count($ids_name);

			for ($i = 0; $i < $count; $i++) {

				if ($_FILES['picture']['size'][$i] < 4000000) {
					$realfilename = str_replace(' ', '_', $_FILES['picture']['name'][$i]);
					$final_image_nm = mt_rand() . $realfilename;

					$filename = $final_image_nm;

					$filetempname = $_FILES['picture']['tmp_name'][$i];

					$fileext = pathinfo($filename, PATHINFO_EXTENSION);

					$fileext = strtolower($fileext);

					//$file_name = mt_rand().

					if (in_array($fileext, $allowed_ext)) {

						move_uploaded_file($filetempname, $destination . $filename);
						$imagepath = $filename;
						//compression code start
						$file = $destination . $imagepath; //This is the original file
						list($width, $height) = getimagesize($file);
						$modwidth = 1400;

						$diff = $width / $modwidth;

						$modheight = 1000;
						$tn = imagecreatetruecolor($modwidth, $modheight);
						$image = imagecreatefromjpeg($file);
						imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);

						imagejpeg($tn, $file, 90);

						$query1 = "INSERT INTO employee_ids(employee_id, hotel_id, images) VALUES('$employee_id','$hotel_id','$filename')";
						$db->execute($query1);
					} else {
						echo 2;
						die;
					}
				} else {
					echo 3;
					die;
				}
			}
		}
		echo 0;
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'employee_transfer') {
	$hotel_id1 = $_GET['h_id'];
	$id = $_GET['empid'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$date1 = CURR_DATE1;
	$date_time1 = DATE_TIME;

	if ($id != "" && $hotel_id1 != "") {
		//transfer to hotel name
		$query_h = "SELECT hotel_name FROM hotels WHERE hotel_id = '$hotel_id1'";
		$exe_query = $db->execute($query_h);
		$hotel_result = $db->getResult($h_query);
		$transfer_to = $hotel_result['hotel_name'];

		//query for transfer_from hotel name 
		$exe_query_from = $db->execute("SELECT hotel_name FROM hotels WHERE hotel_id = '$hotel_id'");
		$result_fr = $db->getResult($exe_query_from);
		$transfer_from = $result_fr['hotel_name'];

		//get all data to insert 
		$query = "SELECT * FROM employees WHERE employee_id = '$id' AND hotel_id = '$hotel_id' LIMIT 1";
		$execute = $db->execute($query);
		$result = $db->getResult($execute);
		$date_of_join = $result['date_of_join'];

		//check this employee already inserted transfer to hotel
		$chk_query_ex = $db->execute("SELECT * FROM employees WHERE name = '$name' AND phone = '$phone' AND hotel_id = '$hotel_id1'");
		$result_chk = $db->getResult($chk_query_ex);
		if (!empty($result_chk)) {
			$emp_id = $result_chk['employee_id'];

			$db->execute("UPDATE employees SET transfer_to = '', transfer_from = '$transfer_from', emp_status = '' WHERE employee_id = '$emp_id' AND hotel_id='$hotel_id1'");

			$db->execute("UPDATE employees SET transfer_to = '$transfer_to', transfer_from = '', emp_status = 'Transferred' WHERE employee_id = '$id' AND hotel_id='$hotel_id'");
		} else {

			$name = $result['name'];
			$father_name = $result['father_name'];
			$phone = $result['phone'];
			$home_contact = $result['home_contact'];
			$ref_contact = $result['ref_contact'];
			$email = $result['email'];
			$salary = $result['salary'];
			$convenience = $result['convenience'];
			$total = $result['total'];
			$current_address = $result['current_address'];
			$address = $result['address'];
			$remark = $result['remark'];
			//$date_of_join = $result['date_of_join'];
			$department = $result['department'];

			$query1 = "INSERT INTO employees (`hotel_id`, `name`, `father_name`, `phone`, `home_contact`, `ref_contact`, `email`, `salary`, `convenience`, `total`, `current_address`, `address`, `remark`, `date_of_join`, `department`, `transfer_date`, `transfer_from`, `inserted_date`, `inserted_date_time`) VALUES ('$hotel_id1','$name','$father_name','$phone','$home_contact','$ref_contact','$email','$salary','$convenience','$total','$current_address','$address','$remark','$date_of_join','$department','$date_time1','$transfer_from',NOW(),NOW())";
			$execute1 = $db->execute($query1);

			//update in which hotel u going to transfer employee
			$db->execute("UPDATE employees SET transfer_to = '$transfer_to', emp_status = 'Transferred' WHERE employee_id = '$id' AND hotel_id='$hotel_id'");
		}

		//employees history
		$inserted = $db->execute("SELECT * FROM employees_history WHERE `employee_id` = '$id' ORDER BY history_id DESC LIMIT 1");
		$result_hs = $db->getResult($inserted);
		if (isset($result_hs)) {
			$join_date = $result_hs['end_date'];
		} else {
			$join_date = $date_of_join;
		}

		$query2 = "INSERT INTO employees_history ( `employee_id`, `start_date`, `end_date`, `transfer_date`, `hotel_name`) VALUES ('$id','$join_date','$date1','$date_time1','$transfer_from')";
		$execute2 = $db->execute($query2);
		echo 0;
	} else {
		echo 1;
	}
}


if (isset($_GET['mailid'])) {
	$email = $_GET['mailid'];
	$duplicat_email = $db->execute("SELECT * FROM travel_details WHERE mailid = '$email'");
	$num_of_count = $db->rowCount();
	$results = $db->getResult($duplicat_email);

	if ($num_of_count > 0) {

		echo $results['name'] . " is already in your database you can't insert duplicate data.";
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'travel_agent') {

	$name = $_POST['name'];

	$contp = $_POST['contp'];

	$maillist = str_replace(',', '<br>', $_POST['maillist']);

	$contactno = $_POST['contactno'];

	$contact_p_desi = isset($_POST['cont_desi']) ? $_POST['cont_desi'] : false;
	$address = $_POST['address'];
	$city = isset($_POST['city']) ? $_POST['city'] : false;
	$state = $_POST['state'];
	$country = $_POST['country'];
	$pincode = isset($_POST['pincode']) ? $_POST['pincode'] : false;
	//$location = $address .','. $city .','. $state .','. $pincode;

	$website = isset($_POST['website']) ? $_POST['website'] : false;

	$id = $_POST['id'];


	if ($name != "" && $contp != "" && $maillist != "" && $contactno != "" && $address != "" && $address != "" && $state != "" && $country != "") {

		if (!empty($id) && $id != "") {

			$query = "UPDATE travel_details SET name = '" . $name . "', contp = '" . $contp . "',contact_p_desi = '" . $contact_p_desi . "', mailid = '" . $maillist . "', contactno = '" . $contactno . "', location = '" . $address . "', city = '" . $city . "',state = '" . $state . "',pincode = '" . $pincode . "',country = '" . $country . "', website = '" . $website . "' WHERE id = '" . $id . "'";

			$db->execute($query);

			echo 2;
		} else {

			$duplicat_email = $db->execute("SELECT * FROM travel_details WHERE mailid = '$mailid'");
			$num_of_count = $db->rowCount();
			$results = $db->getResult($duplicat_email);
			if ($num_of_count > 0) {

				echo $results['name'] . " is already in your database you can't insert duplicate data.";
				die;
			} else {

				$query = "INSERT INTO travel_details(`name`, `contp`,`contact_p_desi`,`mailid`,`contactno`,`location`,`city`,`state`,`pincode`,`country`,`website`,`inserted_date`) VALUES('$name','$contp','$contact_p_desi','$maillist','$contactno','$address','$city','$state','$pincode','$country','$website',NOW())";

				$db->execute($query);

				echo 0;
			}
		}
	} else {

		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'hotel_details') {

	$name = $_POST['h_name'];

	$contp = $_POST['contp'];

	$maillist = str_replace(',', '<br>', $_POST['maillist']);

	$contactno = $_POST['contactno'];

	$contact_p_desi = isset($_POST['cont_desi']) ? $_POST['cont_desi'] : false;
	$address = $_POST['address'];
	$city = isset($_POST['city']) ? $_POST['city'] : false;
	$state = $_POST['state'];
	$country = $_POST['country'];
	$pincode = isset($_POST['pincode']) ? $_POST['pincode'] : false;
	//$location = $address .','. $city .','. $state .','. $pincode;

	$website = isset($_POST['website']) ? $_POST['website'] : false;

	$id = $_POST['id'];


	if ($name != "" && $contp != "" && $maillist != "" && $contactno != "" && $address != "" && $address != "" && $state != "" && $country != "") {

		if (!empty($id) && $id != "") {

			$query = "UPDATE hotel_details SET hotel_name = '$name', contact_person = '$contp',designation = '$contact_p_desi', email = '$maillist', phone = '$contactno', address = '$address', city = '$city',state = '$state',pincode = '$pincode',country = '$country', website = '$website' WHERE hotel_details_id = '$id'";

			$db->execute($query);

			echo 2;
		} else {

			/*$duplicat_email = $db->execute("SELECT * FROM hotel_details WHERE mailid = '$mailid'");
				$num_of_count = $db->rowCount();
				$results = $db->getResult($duplicat_email);
				if($num_of_count > 0){

					echo $results['name']." is already in your database you can't insert duplicate data.";die;
				}else{*/

			$query = "INSERT INTO hotel_details(`hotel_name`, `contact_person`, `designation`, `email`, `phone`, `address`, `city`, `state`, `pincode`, `country`, `website`, `inserted_date`) VALUES('$name','$contp','$contact_p_desi','$maillist','$contactno','$address','$city','$state','$pincode','$country','$website',NOW())";

			$db->execute($query);
			echo 0;
		}
	} else {

		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == "Add-User") {

	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = '';

	$f_name = $_POST['f_name'];
	$last_name = isset($_POST['last_name']) ? strip_tags($_POST['last_name']) : false;
	$name = $f_name . " " . $last_name;
	$user_name = isset($_POST['user_name']) ? strip_tags($_POST['user_name']) : false;
	$password = isset($_POST['password']) ? md5($_POST['password']) : false;
	$c_password = isset($_POST['c_password']) ? md5($_POST['c_password']) : false;
	$email = $_POST['email'];
	$user_type = $_POST['user_type'];
	if (isset($_POST['hotel_name'])) {
		$hotel_id = $_POST['hotel_name'];
	} else {
		$hotel_id = 1;
	}
	if (isset($_POST['previleges'])) {
		$previleges = implode('|', $_POST['previleges']);
	} else {
		$previleges = "Default";
	}

	if (isset($_POST['id'])) {
		$user_id = $_POST['id'];
	}
	if ($password != $c_password) {
		echo 2;
		die;
	}

	$createdDate = DATE_TIME;


	if (isset($user_id)) {
		if ($f_name != "" && $user_name != "" && $user_type != "") {
			$query = "UPDATE admin_login SET `name` = '$name', `user_name`='$user_name', `email` = '$email'";
			if (isset($ipaddress)) {
				$query .= ", `ip_address` ='$ipaddress'";
			}

			$query .= ", `hotel_id` = '$hotel_id', `user_type_hai` = '$user_type', `previleges`='$previleges' WHERE admin_id = '$user_id'";
			$execute = $db->execute($query);
			echo 3;
		} else {
			echo 1;
		}
	} else {
		if ($f_name != "" && $user_name != "" && $email != "" && $password != "" && $user_type != "") {
			$query = "INSERT INTO admin_login( `name`, `user_name`, `email`, `password`, `ip_address`, `hotel_id`, `user_type_hai`, `previleges`,`created_date`) 
				VALUES('$name','$user_name','$email','$password','$ipaddress','$hotel_id','$user_type','$previleges','$createdDate')";

			$db->execute($query);

			$last_id = $db->LastId();
			echo 0;
		} else {
			echo 1;
		}
	}
}


if (isset($_GET['type']) && $_GET['type'] == 'change_password') {

	$password_ss = isset($_POST['password']) ? $_POST['password'] : false;
	$c_password_ss = isset($_POST['c_password']) ? $_POST['c_password'] : false;
	$id = $_POST['id'];

	if ($password_ss == "" || $c_password_ss == "") {
		echo 1;
	} else {

		if ($password_ss == $c_password_ss) {
			$password = md5($password_ss);
			$query = "UPDATE admin_login SET password = '" . $password . "' WHERE admin_id = '" . $id . "'";
			$db->execute($query);
			echo 0;
		} else {
			echo 2;
		}
	}
}


//Insret travel Details
if (isset($_GET['type']) && $_GET['type'] == "generate_invoice") {

	$party = isset($_POST['party']) ? $_POST['party'] : false;
	$tax = $_POST['tax'];
	$booking = $_POST['booking'];
	$name = $_POST['name'];
	$email = isset($_POST['email']) ? $_POST['email'] : false;
	$contact = $_POST['contact'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$gstin = isset($_POST['gstin']) ? strtoupper($_POST['gstin']) : false;
	$invoice_date = isset($_POST['invoice_date']) ? $_POST['invoice_date'] : false;
	$checkin = isset($_POST['checkin']) ? $_POST['checkin'] : false;
	$checkout = isset($_POST['checkout']) ? $_POST['checkout'] : false;
	$description = $_POST['description'];
	$hsncode = $_POST['hsncode'];
	$qty = $_POST['qty'];
	$unit = $_POST['unit'];
	$price = $_POST['price'];
	$amount = $_POST['amount'];
	$subTotal = $_POST['subtotal'];
	$cgst = isset($_POST['cgst']) ? $_POST['cgst'] : false;
	$sgst = isset($_POST['sgst']) ? $_POST['sgst'] : false;
	$igst = isset($_POST['igst']) ? $_POST['igst'] : false;
	$comm = isset($_POST['comm']) ? $_POST['comm'] : false;
	$cgstcm = isset($_POST['cgstcm']) ? $_POST['cgstcm'] : false;
	$sgstcm = isset($_POST['sgstcm']) ? $_POST['sgstcm'] : false;
	$total = $_POST['total'];
	$travel_id = isset($_POST['travel_id']) ? $_POST['travel_id'] : false;

	if ($name != "" && $contact != "" && $city != "" && $country != "" && $amount != "" && $total != "" && $comm != "") {
		if (!empty($travel_id)) {

			$query = "UPDATE invoice_details SET `party_id` = '$party',`tax` = '$tax',`booking_id` = '$booking',`name` = '$name', `invoice_date`='$invoice_date', `email`='$email',`contact`='$contact', `city`='$city', `country`='$country',`gstin`='$gstin', `cgst`='$cgst',  `sgst`='$sgst', `igst`='$igst',`commission`='$comm',`cgst_comm`='$cgstcm', `sgst_comm`='$sgstcm', `sub_total` ='$subTotal',`total_amount`='$total' WHERE travel_id = '$travel_id' AND hotel_id = '$hotel_id'";
			$db->execute($query);
			$db->execute("DELETE FROM invoice_desc WHERE travel_id ='$travel_id' ");

			$num = count($description);
			$sn = 1;
			for ($i = 0; $i < $num; $i++) {
				$description_d = $description[$i];
				$checkin_c = $checkin[$i];
				$checkout_c = $checkout[$i];
				$hsncode_u = $hsncode[$i];
				$qty_y = $qty[$i];
				$unit_u = $unit[$i];
				$price_p = $price[$i];
				$amount_a = $amount[$i];

				$traveler[] = "INSERT INTO invoice_desc(`travel_id`,`sn`, `description`, `checkin_date`, `checkout_date`, `hsn_code`, `qty`, `unit`, `price`,`amount`)
				VALUES ('$travel_id','$sn','$description_d','$checkin_c','$checkout_c','$hsncode_u','$qty_y','$unit_u','$price_p','$amount_a')";
				$sn++;
			}
			foreach ($traveler as $value) {
				$db->execute($value);
			}

			echo 0;
		} else {
			//`travel_id`, `hotel_id`, `party_id`, `booking_id`, `name`, `dob`, `email`, `contact`, `city`, `country`, `checkin_date`, `checkout_date`, `gstin`, `cgst`, `sgst`, `commission`, `cgst_comm`, `sgst_comm`, `total_amount`, `inserted_date`

			$query = "INSERT INTO invoice_details(`hotel_id`,`party_id`, `tax`, `booking_id`, `name`, `invoice_date`, `email`, `contact`, `city`, `country`, `gstin`, `cgst`, `sgst`,`igst`, `commission`, `cgst_comm`, `sgst_comm`,`sub_total`, `total_amount`, `inserted_date`) 
			VALUES('$hotel_id','$party','$tax','$booking','$name','$invoice_date','$email','$contact','$city','$country','$gstin','$cgst','$sgst','$igst','$comm','$cgstcm','$sgstcm','$subTotal','$total',NOW())";
			$db->execute($query);
			$last_id = $db->LastId();
			$num = count($description);
			if (isset($last_id)) {
				$sn = 1;
				for ($i = 0; $i < $num; $i++) {
					$description_d = $description[$i];
					$checkin_c = $checkin[$i];
					$checkout_c = $checkout[$i];
					$hsncode_u = $hsncode[$i];
					$qty_y = $qty[$i];
					$unit_u = $unit[$i];
					$price_p = $price[$i];
					$amount_a = $amount[$i];
					$traveler[] = "INSERT INTO invoice_desc(`travel_id`,`sn`, `description`, `checkin_date`, `checkout_date`, `hsn_code`, `qty`, `unit`, `price`,`amount`)
						VALUES ('$last_id','$sn','$description_d','$checkin_c','$checkout_c','$hsncode_u','$qty_y','$unit_u','$price_p','$amount_a')";
					$sn++;
				}

				foreach ($traveler as $value) {
					$db->execute($value);
				}
			}

			echo 0;
		}
	} else {
		echo 1;
	}
}

//Insert Party Details
if (isset($_GET['type']) && $_GET['type'] == "party_details") {
	$name = $_POST['name'];
	$phone = isset($_POST['phone']) ? $_POST['phone'] : false;
	$mailid = isset($_POST['mailid']) ? $_POST['mailid'] : false;
	$gstin = isset($_POST['gstin']) ? strtoupper($_POST['gstin']) : false;
	$addressl1 = isset($_POST['addressl1']) ? $_POST['addressl1'] : false;
	$addressl2 = isset($_POST['addressl2']) ? $_POST['addressl2'] : false;
	$addressl3 = isset($_POST['addressl3']) ? $_POST['addressl3'] : false;
	$addressl4 = isset($_POST['addressl4']) ? $_POST['addressl4'] : false;
	$state = isset($_POST['state']) ? $_POST['state'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;
	//id=&name=&phone=&mailid=&gstin=&addressl1=&addressl2=&addressl3=&addressl4=
	//`party_id`, `name`, `phone`, `email`, `gstin`, `addressl1`, `addressl2`, `addressl3`, `addressl4`
	if (!empty($id)) {
		if ($name != "") {
			$query = "UPDATE booking_via SET `category_name` = '$name', `phone`='$phone', `email` = '$mailid',`gstin` = '$gstin', `addressl1`='$addressl1', `addressl2` = '$addressl2', `addressl3`='$addressl3',`state` = '$state' WHERE booking_via_id = '$id'";
			$execute = $db->execute($query);
			echo 2;
		} else {
			echo 1;
		}
	} else {
		if ($name != "") {
			$query = "INSERT INTO booking_via(`category_name`, `phone`, `email`, `gstin`, `addressl1`, `addressl2`, `addressl3`,`state`) 
			VALUES('$name','$phone','$mailid','$gstin','$addressl1','$addressl2','$addressl3','$state')";
			$db->execute($query);
			echo 0;
		} else {
			echo 1;
		}
	}
}

//Insret travel Details
if (isset($_GET['type']) && $_GET['type'] == "generate_sushant_invoice") {

	$name = $_POST['name'];
	$tax = $_POST['tax'];
	$email = isset($_POST['email']) ? $_POST['email'] : false;
	$contact = $_POST['contact'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$gstin = isset($_POST['gstin']) ? strtoupper($_POST['gstin']) : false;
	$invoice_date = isset($_POST['invoice_date']) ? $_POST['invoice_date'] : false;
	$passport_details = isset($_POST['passport']) ? $_POST['passport'] : false;
	$inclusion = isset($_POST['inc']) ? $_POST['inc'] : false;
	$exclusion = isset($_POST['exc']) ? $_POST['exc'] : false;

	$checkin = isset($_POST['checkin']) ? $_POST['checkin'] : false;
	$description = $_POST['description'];
	$hsncode = $_POST['hsncode'];
	$amount = $_POST['amount'];
	$subTotal = $_POST['subtotal'];
	$cgst = isset($_POST['cgst']) ? $_POST['cgst'] : false;
	$sgst = isset($_POST['sgst']) ? $_POST['sgst'] : false;
	$igst = isset($_POST['igst']) ? $_POST['igst'] : false;
	$total = $_POST['total'];
	$s_invoice_id = isset($_POST['s_invoice_id']) ? $_POST['s_invoice_id'] : false;

	if ($name != "" && $contact != "" && $city != "" && $country != "" && $amount != "" && $total != "") {
		if (!empty($s_invoice_id)) {

			$query = "UPDATE invoice_sushant_travels SET `name` = '$name', `tax` = '$tax',`email`='$email',`contact`='$contact', `city`='$city', `country`='$country',`gstin`='$gstin',`invoice_date`='$invoice_date',  `passport_details`='$passport_details',  `inclusion`='$inclusion', `exclusion`='$exclusion',`sub_total`='$subTotal',`cgst`='$cgst', `sgst`='$sgst', `igst` ='$igst',`total_amount`='$total' WHERE s_invoice_id = '$s_invoice_id'";
			$db->execute($query);

			$db->execute("DELETE FROM invoice_desc_sushant WHERE s_invoice_id ='$s_invoice_id' ");
			$num = count($description);
			$sn = 1;
			for ($i = 0; $i < $num; $i++) {
				$description_d = $description[$i];
				$checkin_c = $checkin[$i];
				$hsncode_u = $hsncode[$i];
				$amount_a = $amount[$i];
				//`sd_invoice_id`, `days`, `desc`, `hsn code`, `amount`, `sn`

				$traveler[] = "INSERT INTO invoice_desc_sushant(`s_invoice_id`,`days`,`description`,`hsn_code`,`amount`,`sn`)VALUES ('$s_invoice_id','$checkin_c','$description_d','$hsncode_u','$amount_a','$sn')";
				$sn++;
			}
			foreach ($traveler as $value) {

				$db->execute($value);
			}

			if ($_FILES['image']['size'][0] > 0) {
				$destination = 'upload/sushanttravels_invoiceID/';
				$del_query = "SELECT * FROM invoice_idproof WHERE s_invoice_id = '$s_invoice_id'";
				$del_execute = $db->execute($del_query);
				$del_results = $db->getResults($del_execute);
				$row_count = $db->rowCount($del_execute);
				if ($row_count > 0) {
					foreach ($del_results as $del_result) {
						$del_img = $destination . $del_result['image'];
						unlink($del_img);
					}
					$row_del = $db->execute("DELETE FROM invoice_idproof WHERE s_invoice_id = '$s_invoice_id'");
				}

				$ids_name = $_FILES['image']['name'];

				$allowed_ext = array('jpg', 'png', 'jpeg', 'gif', 'bmp');

				$count = count($ids_name);

				for ($i = 0; $i < $count; $i++) {

					if ($_FILES['image']['size'][$i] < 4000000) {
						$realfilename = str_replace(' ', '_', $_FILES['image']['name'][$i]);
						$final_image_nm = mt_rand() . $realfilename;

						$filename = $final_image_nm;

						$filetempname = $_FILES['image']['tmp_name'][$i];

						$fileext = pathinfo($filename, PATHINFO_EXTENSION);

						$fileext = strtolower($fileext);

						//$file_name = mt_rand().

						if (in_array($fileext, $allowed_ext)) {

							move_uploaded_file($filetempname, $destination . $filename);
							$query1 = "INSERT INTO invoice_idproof(s_invoice_id, image) VALUES('$s_invoice_id','$filename')";
							$db->execute($query1);
						} else {
							echo 2;
							die;
						}
					} else {
						echo 3;
						die;
					}
				}
			}
			echo 0;
		} else {
			//`s_invoice_id`, `name`, `tax`, `email`, `contact`, `city`, `country`, `gstin`, `invoice_date`, `passport_details`, `inclusion`, `exclusion`, `sub_total`, `cgst`, `sgst`, `igst`, `total_amount`, `status`

			$query = "INSERT INTO invoice_sushant_travels(`name`, `tax`, `email`, `contact`, `city`, `country`, `gstin`, `invoice_date`, `passport_details`, `inclusion`, `exclusion`, `sub_total`, `cgst`, `sgst`, `igst`, `total_amount`, `inserted_date`) 
			VALUES('$name','$tax','$email','$contact','$city','$country','$gstin','$invoice_date','$passport_details','$inclusion','$exclusion','$subTotal','$cgst','$sgst','$igst','$total',NOW())";
			$db->execute($query);
			$last_id = $db->LastId();
			$num = count($description);
			if (isset($last_id)) {
				$sn = 1;
				for ($i = 0; $i < $num; $i++) {
					$description_d = $description[$i];
					$checkin_c = $checkin[$i];
					$hsncode_u = $hsncode[$i];
					$amount_a = $amount[$i];
					//`sd_invoice_id`, `days`, `desc`, `hsn_code`, `amount`, `sn`

					$traveler[] = "INSERT INTO invoice_desc_sushant(`s_invoice_id`,`days`,`description`,`hsn_code`,`amount`,`sn`)
				VALUES ('$last_id','$checkin_c','$description_d','$hsncode_u','$amount_a','$sn')";
					$sn++;
				}

				foreach ($traveler as $value) {
					$db->execute($value);
				}
			}

			if ($_FILES['image']['size'][0] > 0) {
				$destination = 'upload/sushanttravels_invoiceID/';

				$ids_name = $_FILES['image']['name'];

				$allowed_ext = array('jpg', 'png', 'jpeg', 'gif', 'bmp');

				$count = count($ids_name);

				for ($i = 0; $i < $count; $i++) {

					if ($_FILES['image']['size'][$i] < 4000000) {
						$realfilename = str_replace(' ', '_', $_FILES['image']['name'][$i]);
						$final_image_nm = mt_rand() . $realfilename;

						$filename = $final_image_nm;

						$filetempname = $_FILES['image']['tmp_name'][$i];

						$fileext = pathinfo($filename, PATHINFO_EXTENSION);

						$fileext = strtolower($fileext);

						//$file_name = mt_rand().

						if (in_array($fileext, $allowed_ext)) {

							move_uploaded_file($filetempname, $destination . $filename);
							$query1 = "INSERT INTO invoice_idproof(s_invoice_id, image) VALUES('$last_id','$filename')";
							$db->execute($query1);
						} else {
							echo 2;
							die;
						}
					} else {
						echo 3;
						die;
					}
				}
			}

			echo 0;
		}
	} else {
		echo 1;
	}
}

if (isset($_GET['type']) && $_GET['type'] == 'edit_cir_hotel') {

	$name = $_POST['h_name'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$address1 = $_POST['address1'];
	$address2 = isset($_POST['address2']) ? $_POST['address2'] : false;
	$star = $_POST['star'];
	$id = $_POST['id'];

	if ($name != "" && $email != "" && $contact != "" && $address1 != "" && $star != "") {

		if (!empty($id) && $id != "") {
			//`hotel_id`, `hotel_name`, `hotel_email`, `hotel_phone`, `hotel_address`, `hotel_address1`, `hotel_star`, `status`, `added_date`
			$query = "UPDATE hotels SET hotel_name = '$name', hotel_email = '$email',hotel_phone = '$contact', hotel_address = '$address1', hotel_address1 = '$address2', hotel_star = '$star' WHERE hotel_id = '$id'";
			$db->execute($query);
			echo 2;
		} else {

			$query = "INSERT INTO hotels(`hotel_name`, `hotel_email`, `hotel_phone`, `hotel_address`, `hotel_address1`, `hotel_star`) VALUES('$name','$email','$contact','$address1','$address2','$star'";
			$db->execute($query);
			echo 0;
		}
	} else {
		echo 1;
	}
}


if (isset($_GET['type']) && $_GET['type'] == 'cir_oyo_booking') {
	//code for updateting arrival booking from checkinroom.in dashboard

	if (isset($_POST['hotel_name'])) {
		$hotel_name = $_POST['hotel_name'];
		$hotels_query = $db->execute("SELECT hotel_id FROM hotels WHERE hotel_name ='$hotel_name'");

		$hotels = $db->getResult($hotels_query);
		$hotel_id = $hotels['hotel_id'];
	}

	if (isset($_POST['booking_id1'])) {
		$booking_id1 = trim(strtoupper($_POST['booking_id1']));
	} else {
		$booking_id1 = "";
	}
	if (isset($_POST['booking_id2'])) {
		$booking_id2 = trim($_POST['booking_id2']);
	} else {
		$booking_id2 = "";
	}

	$name = $_POST['guest_name'] ?? "";
	$email = $_POST['guest_email'] ?? "";
	$phone = $_POST['guest_phone'] ?? "";

	$category = $_POST['room_category'] ?? "";

	$checkin1 = date('d-m-Y', strtotime($_POST['checkin_date']));
	$checkout1 = date('d-m-Y', strtotime($_POST['checkout_date']));

	$checkin = str_replace('-', '/', $checkin1);
	$checkout = str_replace('-', '/', $checkout1);

	$noofguest = $_POST['no_of_adults'] + $_POST['no_of_childs'];

	$room_charge = $_POST['room_charge'];
	$gst_18 = $_POST['gst_charge'];
	$pay_hotel = $_POST['pay_now'];

	$noofroom = $_POST['no_of_rooms'] ?? "";

	$noofnight = $_POST['no_of_nights'] ?? "";
	$status = "confirmed";
	$date_time = DATE_TIME;

	//$inserted_by = $_COOKIE['full_name'];

	if ($hotel_id != "" || $name != "" || $phone != "" || $checkin != "" || $checkout != "" || $room_charge != "0" ||  $gst_18 != "" || $pay_hotel != "") {

		$booking_idquery = $db->execute("SELECT * FROM cir_booking_oyo WHERE booking_id = '$booking_id1'");
		$numofrow = $db->rowCount($booking_idquery);
		if ($numofrow > 0) {
			echo 2;
		} else {

			$query_arrival = "INSERT INTO cir_booking_oyo(`hotel_id`, `booking_id1`, `booking_id2`, `guest_name`, `guest_phone`, `guest_email`, `checkin_date`, `checkout_date`, `no_of_adults`, `no_of_rooms`, `no_of_nights`, `room_category`, `room_charge`, `gst_charge`, `pay_now`, `booking_status`, `inserted_date`) 

			VALUES('$hotel_id','$booking_id1','$booking_id2','$name','$phone','$email','$checkin','$checkout','$noofguest','$noofroom','$noofnight','$category','$room_charge','$gst_18','$pay_hotel','$status','$date_time')";
			$execute_arrival = $db->execute($query_arrival);
			echo 0;
		}
	} else {
		echo "error plase fill all required filed!";
	}
}


if (isset($_GET['type']) && $_GET['type'] == 'update_voucher_oyo') {
	//code for updateting arrival booking from checkinroom.in dashboard

	$booking_id1 = trim($_POST['booking_id1']) ?? "";
	$invoic_location = $_POST['invoice_location'] ?? "";

	if ($booking_id1 != "" && $invoic_location != "") {
		$query = "UPDATE cir_booking_oyo SET invoice_location = '$invoic_location' WHERE booking_id1 = '$booking_id1'";
		$db->execute($query);
		return $db->affectedRows();
	} else {
		echo "error plase fill all required filed!";
	}
}
