<?php
require_once '../include/config.php';
$db = new Database();

$search_string =  trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$hotel_id = $_SESSION['report_hotel_id'];
	//$query = 'SELECT * FROM check_in_details WHERE name LIKE "%'.$search_string.'%" OR email LIKE "%'.$search_string.'%" OR phone LIKE "%'.$search_string.'%" AND hotel_id = "'.$hotel_id.'" ';
	$query = 'SELECT * FROM guest_checkin_history WHERE hotel_id = "'.$hotel_id.'" AND CONCAT(name,"|",email,"|",booking_id,"|",phone) LIKE "%'.$search_string.'%" LIMIT 20';
	$result = $db->execute($query);
	$result_array = $db->getResults($result);

	if (!empty($result_array)) {
		$i=1;
		foreach ($result_array as $result) {

			$checkin_id = $result['checkin_id'];

			$query_ex = $db->execute("SELECT SUM(booking_amount) as sum_ext_amount FROM extended_booking_days WHERE checkin_id = '$checkin_id'");
            $ext_amount = $db->getResult($query_ex);
           
            if(!empty($ext_amount['sum_ext_amount'])){
                $amout_ext = $result['booking_amount'] + $ext_amount['sum_ext_amount'];
            }else{
            	$amout_ext = $result ['booking_amount'];
            }
            
            $no_of_night = $result['booking_nights'] + $result['extended_days'];

			// Output HTML formats
			$html = '<tr>';
			$html .= '<td class="name" style="width:10px;overflow:hidden;" >snString</td>';
			$html .= '<td class="name" style="width:150px;overflow:hidden;">nameString</td>';
			
			$html .= '<td class="name" style="width:150px;overflow:hidden;">emailString</td>';
			$html .= '<td class="name" style="width:100px;overflow:hidden;">phoneString</td>';
			$html .= '<td class="name" style="width:25px;overflow:hidden;">roomnoString</td>';
			$html .= '<td class="name" style="width:25px;overflow:hidden;">nightsString</td>';

			$html .= '<td class="name" style="width:25px;overflow:hidden;">amountString</td>';

			$html .= '<td class="name" style="width:50px;overflow:hidden;">countryString</td>';
			$html .= '<td class="name" style="width:100px;overflow:hidden;">bookingviaString</td>';
			$html .= '<td style="width:50px;overflow:hidden;">insertedDate</td>';
			$html .= '<td style="width:100px;overflow:hidden;">FinalCheckout</td>';
			$html .= '<td class="name" style="width:40px;"><a target="_blank" href="view.php?checkin_id=idString" class="btn">View</a></td>';
			$html .= '</tr>';
			$date1 = CURR_DATE;
	        $date2 = $result['date_of_birth'];
	        $date_diff = abs(strtotime($date1) - strtotime($date2));
	        $age = floor($date_diff/(360*60*60*24));
			// Output strings and highlight the matches
			$booking_id = $result['booking_id'];
			$d_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);
			$d_phone = $result['phone'];
			$d_email = $result['email'];
			$d_room_number = $result['room_number'];
			//$amount = $result['booking_amount'];

			//$booking_nights = $result['booking_nights'];
			$extended_days = $result['extended_days'];
			$d_country = $result['country'];
			$d_booking_via = $result['booking_via'];
			$d_checkin_id = $result['checkin_id'];
			$insertedDate = $result['current_ci_date'];
			$FinalCheckout = $result['final_checkout_date'];
			// Replace the items into above HTML

			$o = str_replace('snString', $booking_id, $html);
			$o = str_replace('nameString', $d_name, $o);
			$o = str_replace('phoneString', $d_phone, $o);
			$o = str_replace('emailString', $d_email, $o);
			$o = str_replace('roomnoString', $d_room_number, $o);
			$o = str_replace('nightsString', $no_of_night, $o);
			//$o = str_replace('exNightString', $extended_days, $o);
			$o = str_replace('amountString', $amout_ext, $o);
			$o = str_replace('countryString', $d_country, $o);
			$o = str_replace('bookingviaString', $d_booking_via, $o);
			$o = str_replace('idString', $d_checkin_id, $o);
			$o = str_replace('insertedDate', $insertedDate, $o);
			$o = str_replace('FinalCheckout', $FinalCheckout, $o);
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