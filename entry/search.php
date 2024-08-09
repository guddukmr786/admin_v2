<?php
require_once '../include/config.php';
$db = new Database();

$search_string =  trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$hotel_id = $_COOKIE['hotel_id'];
	//$query = 'SELECT * FROM check_in_details WHERE hotel_id = "'.$hotel_id.'" AND name LIKE "%'.$search_string.'%" OR email LIKE "%'.$search_string.'%" OR booking_id LIKE "%'.$search_string.'%" limit 40 ';
	$query = 'SELECT * FROM check_in_details WHERE CONCAT(name,"|",email,"|",booking_id,"|",phone) LIKE "%'.$search_string.'%" LIMIT 20';
	$result = $db->execute($query);
	$result_array = $db->getResults($result);
	if (!empty($result_array)) {
		$i=1;
		foreach ($result_array as $result) {
			// Output HTML formats
			$html = '<tr>';

			$html .= '<td style="width:10px!important;">idIncrement</td>';
			$html .= '<td class="name" style="width:10px;overflow:hidden;" >snString</td>';
			$html .= '<td class="name" style="width:150px;overflow:hidden;">nameString</td>';
			$html .= '<td class="name" style="width:100px;overflow:hidden;">phoneString</td>';
			$html .= '<td class="name" style="width:150px;overflow:hidden;">emailString</td>';
			$html .= '<td class="name" style="width:25px;overflow:hidden;">roomnoString</td>';
			$html .= '<td class="name" style="width:25px;overflow:hidden;">amountString</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">countryString</td>';
			$html .= '<td class="name" style="width:90px;overflow:hidden;">bookingviaString</td>';
			$html .= '<td class="name" style="width:10px;overflow:hidden;">hotelString</td>';

			$html .= '<td class="name" style="width:40px;"><a href="view.php?checkin_id=idString" class="btn">View</a></td>';
			if($result['final_checkout_date'] != "0000-00-00 00:00:00" && $result['status'] == 1){
				$html .= '<td class="name" style="width:80px;"><a href="#recheckin" data-toggle="modalrecheckin" id="idString" class="btn">Re-Checkin</a></td>';
			}else {
				$html .= '<td class="name" style="width:80px;"><a href="bill.php?checkin_id=idString" class="btn_r">Checkout</a></td>';
			}
			$html .= '<td class="name" style="width:95px;"><a href="add_summary.php?checkin_id=idString" class="btn">Add Summary</a></td>';
			$html .= '</tr>';
			$date1 = CURR_DATE;
	        $date2 = $result['date_of_birth'];
	        $date_diff = abs(strtotime($date1) - strtotime($date2));
	        $age = floor($date_diff/(360*60*60*24));
			// Output strings and highlight the matches
			$query_hname = $db->execute("SELECT hotel_name FROM hotels WHERE hotel_id = '$hotel_id'");
			$hotels = $db->getResult($query_hname);
			$hotel_name = $hotels['hotel_name'];

			$booking_id = $result['booking_id'];
			$d_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);
			$d_phone = $result['phone'];
			$d_email = $result['email'];
			$d_room_number = $result['room_number'];
			$amount = $result['booking_amount'];
			$d_country = $result['country'];
			$d_booking_via = $result['booking_via'];
			$d_checkin_id = $result['checkin_id'];
			// Replace the items into above HTML
			$o = str_replace('idIncrement', $i++, $html);
			$o = str_replace('snString', $booking_id, $o);
			$o = str_replace('nameString', $d_name, $o);
			$o = str_replace('phoneString', $d_phone, $o);
			$o = str_replace('emailString', $d_email, $o);
			$o = str_replace('roomnoString', $d_room_number, $o);
			$o = str_replace('amountString', $amount, $o);
			$o = str_replace('countryString', $d_country, $o);
			$o = str_replace('bookingviaString', $d_booking_via, $o);
			$o = str_replace('hotelString', $hotel_name, $o);
			$o = str_replace('idString', $d_checkin_id, $o);
			// Output it
			echo($o);

  		}
  		echo '
  		<script type="text/javascript">
			$("a[data-toggle=modalrecheckin]").click(function(){
			  var checkin_id = $(this).attr("id");
			  $.ajax({
			    url : "recheckin.php?checkin_id="+checkin_id,
			    success:function(data){
			      $(".popup1").show().html(data);
			    }
			  });
			});
			</script>
  		';
	} else {
			echo '<td colspan="12">
				<h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
				<br/>
				<p>Only Guest name/ phone number/ booking id are accepted search field</p>
			</td>';
	}
}
?>