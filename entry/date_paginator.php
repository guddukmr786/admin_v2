<?php
require_once('../include/config.php');
$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];
if((!empty($_GET['date']))) {
	$date = date('d/m/Y',strtotime($_GET['date']));
	//echo $date;die;
	//$con = mysqli_connect('127.0.0.1', 'root', '','paginator') or die("Unable to connect to MySQL");
	
	//$result = mysqli_query($con,'SELECT * from messages where date = "'.$date.'"');
	//$num_rows = mysqli_num_rows($result);
	$query_ff= "SELECT * FROM arrival_booking_history WHERE checkin_date = '".$date."' AND hotel_id = '".$hotel_id."'";
	$query = $db->execute($query_ff);
	$num_rows = $db->rowCount($query);
	$results = $db->getResults($query);
	if($num_rows > 0){
		$i=1;
		foreach ($results as $result) {

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

			$html = '<tr>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;">'.$i++.'</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;">'.$result['booking_id'].'</td>';

			if($result['pickup'] == 'Yes'){ 
			$html .= '<td class="small" style="width:150px;overflow:hidden;background-color:#EED7C1;">'.$result['guest_name'].'</td>';
			} else {
			$html .= '<td class="small" style="width:150px;overflow:hidden;">'.$result['guest_name'].'</td>';
			}
			$html .= '<td class="small" style="width:150px;overflow:hidden;">'.$result['guest_email'].'<br>'.$result['guest_phone'].'</td>';

			$html .= '<td class="small" style="width:100px;overflow:hidden;">'.$result['no_of_guest'].'</td>';

			$html .= '<td class="small" style="width:100px;overflow:hidden;">'.$result['noof_room'].'</td>';

			$html .= '<td class="name"  style="width:25px;overflow:hidden;">'.$result['country'].'</td>';

			$html .= '<td class="name"  style="width:25px;overflow:hidden;">'.$result['room_category'].'</td>';

			$html .= '<td class="name" style="width:50px;overflow:hidden;">'.$result['booking_mode'].'</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">'.$result['room_charge'].'</td>';

			$html .= '<td class="name" style="width:50px;overflow:hidden;">'.$company['name'].'</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">'.$days.'</td>';

			if(isset($result['checkin_date']) && $result['checkin_date'] == CURR_DATE && $result['booking_status'] != 'checkedin'){

			$html .= '<td class="name" style="width:60px;overflow:hidden;background-color:#FF4646!important;color:#ffffff!important;">'.$result['checkin_date'].'</td>';
			} elseif(!empty($result['booking_status']) && $result['booking_status'] == 'checkedin') { 
			$html .= '<td class="name" style="width:60px;overflow:hidden;background-color:#499f4d!important;color:#ffffff!important;">'.$result['checkin_date'].'</td>';
			} else {

			$html .= '<td class="name" style="width:100px;overflow:hidden;">'.$result['checkin_date'].'</td>';

			}

			$html .= '<td class="name" style="width:100px;overflow:hidden;">'.$result['checkout_date'].'</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">'.$result['inserted_date'].'</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;"><a href="view_arrival_booking_list.php?arrival_b_id='. $result['arrival_b_id'] .'" class="btn">View</a></td>';

			/*$html .= '<td class="name"><a href="#checkin" data-toggle="modalcheckin" id="idString" class="btn">Checkin</a></td>';*/
			if(!empty($result['booking_status']) && $result['booking_status'] == 'confirmed' && $result['checkin_date'] == CURR_DATE){
			$html .= '<td class="name" style="width:20px;overflow:hidden!important;"><a style="color:#fff!important;background-color:#ECBC0D!important;"href="#empty" data-toggle="modal_quick_checkin" id="'. $result['arrival_b_id'] .'" class="btn">Check-In</a></td>';
			}elseif(!empty($result['booking_status']) && $result['booking_status'] == 'confirmed') { 
			
			$html .= '<td class="name" style="width:20px;overflow:hidden!important;"><a style="color:#fff!important;background-color:#ECBC0D!important;"href="#empty" data-toggle="modal_quick_checkin" id="'. $result['arrival_b_id'] .'" class="btn" disabled>Check-In</a></td>';
			} elseif(!empty($result['booking_status']) && $result['booking_status'] == 'checkedin'){

			$html .= '<td class="name" style="width:10px;overflow:hidden!important;"><a style="" class="btn">Checked-In</a>';
			
			} elseif (!empty($result['booking_status']) && $result['booking_status'] == 'cancelled') {

			$html .= '<td class="name" style="width:10px;overflow:hidden!important;"><a class="rejected_booking">Cancelled</a></td>';	

			} elseif (!empty($result['booking_status']) && $result['booking_status'] == 'transfered') {

			$html .= '<td class="name" style="width:10px;overflow:hidden!important;"><a class="rejected_booking">Transferred</a></td>';	

			} 
			
			$html .= '</tr>';

			echo $html;
		}
		?>
			<script type="text/javascript">
				
			  	$("a[data-toggle=modal_quick_checkin]").click(function(){
			    	var arrival_b_id = $(this).attr("id");
			    	$.ajax({
			      		url : "quick_check_in.php?arrival_b_id="+arrival_b_id,
			      		success:function(data){
			        	$(".popup1").show().html(data);
			      		}
			    	});
			  	});

			</script>
	
		<?php
	}else{
		echo '<tr><td colspan="16" style="color:#31708F;"><h3>No record found.</h3></td></tr>';	
	}

} else{
	echo '<tr><td colspan="16" style="color:#31708F;"><h3>No record found.</h3></td></tr>';
}
?>