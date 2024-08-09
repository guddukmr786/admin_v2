<?php
require_once('../include/config.php');
$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];
if((!empty($_GET['date']))) {
	$date = date('d/m/Y',strtotime($_GET['date']));
	
	$query_ff= "SELECT * FROM guest_checkin_history WHERE checkin_date = '".$date."' AND hotel_id = '".$hotel_id."'";
	$query = $db->execute($query_ff);
	$num_rows = $db->rowCount($query);
	$results = $db->getResults($query);
	if($num_rows > 0){
		$i=1;
		foreach ($results as $result) {

			$html = '<tr>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;" >'.$i++.'</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;" >'.$result['booking_id'].'</td>';

			$html .= '<td class="small" style="width:150px;overflow:hidden;">'.$result['name'].'</td>';
			
			$html .= '<td class="small" style="width:100px;overflow:hidden;">'.$result['phone'].'</td>';

			$html .= '<td class="small" style="width:150px;overflow:hidden;">'.$result['email'].'</td>';

			$html .= '<td class="small" style="width:100px;overflow:hidden;">'.$result['room_number'].'</td>';

			$html .= '<td class="name"  style="width:25px;overflow:hidden;">'.$result['country'].'</td>';

			$html .= '<td class="name" style="width:50px;overflow:hidden;">'.$result['booking_amount'].'</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">'.date('d-M-Y, D',strtotime(str_replace('/', '-',$result['checkin_date']))).'</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">'.date('d-M-Y, D',strtotime(str_replace('/', '-',$result['checkout_date']))).'</td>';

			$html .= '<td class="name" style="width:100px;overflow:hidden;">'.$result['inserted_by'].'</td>';

			$html .= '<td class="name" style="width:10px;overflow:hidden;"><a href="view_date_wise_checkin_details.php?checkin_id='. $result['checkin_history_id'] .'" class="btn">View</a></td>';

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