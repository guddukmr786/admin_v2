<?php
require_once '../include/config.php';

$db = new Database();

$search_string = trim($_POST['query']);

if (strlen($search_string) >= 1 && $search_string !== ' ') {

	$hotel_id = $_COOKIE['hotel_id'];

	$query = 'SELECT * FROM guest_checkin_history WHERE hotel_id = "'.$hotel_id.'" AND CONCAT(name,"|",email,"|",booking_id,"|",phone) LIKE "%'.$search_string.'%"';

	$result = $db->execute($query);

	$result_array = $db->getResults($result);

	if (!empty($result_array)) {

		$i=1;

		foreach ($result_array as $result) {

			// Output HTML formats

			$html = '<tr>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;" >iii</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;" >bookingIdString</td>';

			$html .= '<td class="small" style="width:150px;overflow:hidden;">nameString</td>';
			
			$html .= '<td class="small" style="width:100px;overflow:hidden;">phoneString</td>';

			$html .= '<td class="small" style="width:150px;overflow:hidden;">emailString</td>';

			$html .= '<td class="small" style="width:100px;overflow:hidden;">Roomno</td>';

			$html .= '<td class="name"  style="width:25px;overflow:hidden;">countryString</td>';

			$html .= '<td class="name" style="width:50px;overflow:hidden;">bookingAmount</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">checkinString</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">checkoutString</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">insertedBy</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;"><a href="view_date_wise_checkin_details.php?checkin_id=idString" class="btn">View</a></td>';

			$html .= '</tr>';



			// Output strings and highlight the matches

			$booking_id = $result['booking_id'];

			$d_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);

			$d_phone = $result['phone'];

			$d_email = $result['email'];

			$room_number = $result['room_number'];

			$d_country = $result['country'];

			$booking_amount = $result['booking_amount'];

			$d_checkin_date = date('d-M-Y, D',strtotime(str_replace('/', '-',$result['checkin_date'])));

			$d_checkout_date = date('d-M-Y, D',strtotime(str_replace('/', '-',$result['checkout_date'])));

			$inserted_by = $result['inserted_by'];

			$checkin_id = $result['checkin_history_id'];

			// Replace the items into above HTML

       
			$o = str_replace('iii', $i++, $html);

			$o = str_replace('bookingIdString', $booking_id, $o);

			$o = str_replace('nameString', $d_name, $o);

			$o = str_replace('honeString', $d_phone, $o);

			$o = str_replace('emailString', $d_email, $o);

			$o = str_replace('Roomno', $room_number, $o);

			$o = str_replace('countryString', $d_country, $o);

			$o = str_replace('bookingAmount', $booking_amount, $o);

			$o = str_replace('checkinString', $d_checkin_date, $o);
			$o = str_replace('checkoutString', $d_checkout_date, $o);

			$o = str_replace('insertedBy', $inserted_by, $o);
			
			$o = str_replace('idString', $checkin_id, $o);

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

?>