<?php
require_once '../include/config.php';

$db = new Database();

$search_string = trim($_POST['query']);

if (strlen($search_string) >= 1 && $search_string !== ' ') {

	$hotel_id = $_COOKIE['hotel_id'];
	
	$query = 'SELECT * FROM arrival_booking_history WHERE hotel_id = "'.$hotel_id.'" AND CONCAT(guest_name,"|",guest_email,"|",booking_id,"|",guest_phone) LIKE "%'.$search_string.'%"';
	$result = $db->execute($query);

	$result_array = $db->getResults($result);
	
	if (!empty($result_array)) {

		$i=1;

		foreach ($result_array as $result) {


			$date1 = $result['checkin_date'];
            $date2 = $result['checkout_date'];
            $date1 = DateTime::createFromFormat('d/m/Y', $date1);
            $date2 = DateTime::createFromFormat('d/m/Y', $date2);

            $ci_date = $date1->format('Y-m-d');
            $co_date = $date2->format('Y-m-d');

            $diff = abs(strtotime($co_date) - strtotime($ci_date));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            
            $party_id = $result['booking_via'];
            $query_cc= "SELECT name FROM party_details WHERE party_id = '".$party_id."' LIMIT 1";
			$query_dd = $db->execute($query_cc);
			$company = $db->getResult($query_dd);

			// Output HTML formats

			$html = '<tr>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;" >iii</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;" >bookingIdString</td>';

			if($result['pickup'] == 'Yes'){ 
			$html .= '<td class="small" style="width:150px;overflow:hidden;background-color:#EED7C1;">nameString</td>';
			} else {
			$html .= '<td class="small" style="width:150px;overflow:hidden;">nameString</td>';
			}
			$html .= '<td class="small" style="width:150px;overflow:hidden;">emailString<br>phoneString</td>';

			$html .= '<td class="small" style="width:100px;overflow:hidden;">noOfGuest</td>';

			$html .= '<td class="small" style="width:100px;overflow:hidden;">noofRoom</td>';

			$html .= '<td class="name"  style="width:25px;overflow:hidden;">countryString</td>';

			$html .= '<td class="name"  style="width:25px;overflow:hidden;">roomCatString</td>';

			$html .= '<td class="name" style="width:50px;overflow:hidden;">bookingModeString</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">bookingAmount</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">company</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">days</td>';
			
			if(isset($result['checkin_date']) && $result['checkin_date'] == CURR_DATE && $result['booking_status'] != 'checkedin'){

			$html .= '<td class="name" style="width:60px;overflow:hidden;background-color:#FF4646!important;color:#ffffff!important;">checkinString</td>';
			} elseif(!empty($result['booking_status']) && $result['booking_status'] == 'checkedin') { 
			$html .= '<td class="name" style="width:60px;overflow:hidden;background-color:#499f4d!important;color:#ffffff!important;">checkinString</td>';
			} else {

			$html .= '<td class="name" style="width:100px;overflow:hidden;">checkinString</td>';

			}

			$html .= '<td class="name" style="width:100px;overflow:hidden;">checkoutString</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">bookingDate</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;"><a href="view_arrival_booking_list.php?arrival_b_id=idString" class="btn">View</a></td>';

			/*$html .= '<td class="name"><a href="#checkin" data-toggle="modalcheckin" id="idString" class="btn">Checkin</a></td>';*/

			if(!empty($result['booking_status']) && $result['booking_status'] == 'confirmed') { 

			$html .= '<td class="name" style="width:20px;overflow:hidden!important;"><a style="color:#fff!important;background-color:#ECBC0D!important;"href="#empty" data-toggle="modal_quick_checkin" id="idString" class="btn">Check-In</a></td>';
			} elseif(!empty($result['booking_status']) && $result['booking_status'] == 'checkedin'){

			$html .= '<td class="name" style="width:10px;overflow:hidden!important;"><a style="" class="btn">Checked-In</a>';
			
			} elseif (!empty($result['booking_status']) && $result['booking_status'] == 'cancelled') {

			$html .= '<td class="name" style="width:10px;overflow:hidden!important;"><a class="rejected_booking">Cancelled</a></td>';	

			} elseif (!empty($result['booking_status']) && $result['booking_status'] == 'transfered') {

			$html .= '<td class="name" style="width:10px;overflow:hidden!important;"><a class="rejected_booking">Transferred</a></td>';	

			} 

			$html .= '</tr>';



			// Output strings and highlight the matches

			$booking_id = $result['booking_id'];

			$d_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['guest_name']);

			$d_phone = $result['guest_phone'];

			$d_email = $result['guest_email'];

			$d_no_guest = $result['no_of_guest'];

			$d_noof_room = $result['noof_room'];

			$d_country = $result['country'];

			$d_room_category = $result['room_category'];

			$d_booking_mode = $result['booking_mode'];

			$d_booking_amount = $result['room_charge'];

			$d_checkin_date = $result['checkin_date'];

			$d_checkout_date = $result['checkout_date'];

			$d_bookingDate = $result['inserted_date'];

			$d_arrival_b_id = $result['arrival_b_id'];
			$name = $company['name'];

			// Replace the items into above HTML


			$o = str_replace('iii', $i++, $html);

			$o = str_replace('bookingIdString', $booking_id, $o);

			$o = str_replace('nameString', $d_name, $o);

			$o = str_replace('phoneString', $d_phone, $o);

			$o = str_replace('emailString', $d_email, $o);

			$o = str_replace('noOfGuest', $d_no_guest, $o);

			$o = str_replace('noofRoom', $d_noof_room, $o);

			$o = str_replace('countryString', $d_country, $o);

			$o = str_replace('roomCatString', $d_room_category, $o);

			$o = str_replace('bookingModeString', $d_booking_mode, $o);

			$o = str_replace('bookingAmount', $d_booking_amount, $o);

			$o = str_replace('company', $name, $o);

			$o = str_replace('days', $days, $o);

			$o = str_replace('checkinString', $d_checkin_date, $o);

			$o = str_replace('checkoutString', $d_checkout_date, $o);

			$o = str_replace('bookingDate', $d_bookingDate, $o);

			$o = str_replace('idString', $d_arrival_b_id, $o);

			// Output it

			echo($o);



  		}

	} else {

		echo '<td colspan="16">
				<h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
				<br/>
				<p>Only Guest name/ phone number/ booking id are accepted search field</p>
			</td>';

	}

}

echo '
  	<script type="text/javascript">
		$("a[data-toggle=modalcheckin]").click(function(){
			var arrival_b_id = $(this).attr("id");
			$.ajax({
			    url : "checkin.php?arrival_b_id="+arrival_b_id,
			    success:function(data){
			      $(".popup1").show().html(data);
			    }
			});
		});
	</script>
';
?>