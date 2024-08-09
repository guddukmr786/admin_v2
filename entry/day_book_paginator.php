<?php
require_once('../include/config.php');
$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];
if((!empty($_GET['date']))) {
	$date = date('Y-m-d',strtotime($_GET['date']));

	$query_ff= "SELECT * FROM day_book_entry WHERE date_of_expense = '".$date."' AND hotel_id = '".$hotel_id."' ORDER BY expense_type DESC";
	$query = $db->execute($query_ff);
	$num_rows = $db->rowCount($query);
	$results = $db->getResults($query);
	//Opeing balance code
	$query_op = "SELECT closing_balance FROM closing_balance_table WHERE hotel_id = '".$hotel_id."' AND closing_date < '".$date."' ORDER BY closing_date DESC LIMIT 1";
	$exe_op = $db->execute($query_op);
	$opening_balance = $db->getResult($exe_op);
	//end
	if($num_rows > 0){
		$i = 1;
		$receive_value = 0;
		$pay_value = 0;
		foreach ($results as $result) {
			$rec_pay = $result['receive_pay'];
			$inserted_date = date_format(new DateTime($result['date_of_expense']), 'd M Y , D');
			$html = '<tr id="'.$result['day_b_id'].'">';

			$html .= '<td class="name">'.$i++.'</td>';

			$html .= '<td class="name">'.$inserted_date.'</td>';

			$html .= '<td class="name">'.$result['expense_by'].'</td>';
			if($result['expense_type'] == 'Cash balance') {
				if(isset($rec_pay) && $rec_pay == 'Receive'){
					$html .= '<td class="name" style="background-color:#88C08B;">'.$result['amount'].'</td>';
					$receive_value += $result['amount'];
				}else{
					$html .= '<td class="name" style="background-color:#88C08B"></td>';
				}
			} else {
				if(isset($rec_pay) && $rec_pay == 'Receive'){
					$html .= '<td class=" ">'.$result['amount'].'</td>';
					$receive_value += $result['amount'];
				}else{
					$html .= '<td class="name"></td>';
				}
			}
			if(isset($rec_pay) && $rec_pay == 'Pay'){
				$html .= '<td class="name">'.$result['amount'].'</td>';
				$pay_value += $result['amount'];
			}else{
				$html .= '<td class="name"></td>';
			}
			
			$html .= '<td class="name">'.$result['description'].'</td>';
			$html .= '<td class="name">'.$result['department'].'</td>';
			if($result['expense_type'] == 'Cash balance') { 
			$html .= '<td class="name" style="width:80px;"><a disabled href="#edit_day_book" data-toggle="modaldaybook"  id="'.$result['day_b_id'].'" class="btn">Edit</a></td>';
			} else { 
			$html .= '<td class="name" style="width:80px;"><a href="#edit_day_book" data-toggle="modaldaybook"  id="'.$result['day_b_id'].'" class="btn">Edit</a></td>';
			}
			$html .= '<td class="name" style="width:80px;"><a href="#" class="delete" title="'.$result['day_b_id'].'" id="btn_r1">Delete</a></td>';
			
			$html .= '</tr>';

			echo $html;
			
		}
		$current_balance = $receive_value - $pay_value;
      	echo '<hr>';
		echo '<tr>
		        <td colspan="4" style="text-align:right;padding-right:70px;font-size:14px;">Total : '.$receive_value.'</td>
		        <td  style="font-size:14px;">Total : '.$pay_value.'</td>
		        <td colspan="5" style="text-align:right;padding-left:70px;font-size:14px;"> Currnet Balance : <span style="font-size:16px;">'.$current_balance.'</span>Rs.</td>
		      </tr>';

		echo '<tr>';
		        if($current_balance <= 0) { 
		   		echo '<td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;"><span style="color:red;">Closing Balance : '.$current_balance.' Rs</span></td>';
		        } else {
		        echo '<td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;color:#30C8FF;">Closing Balance  : ' . $current_balance . ' Rs</td>';
		        }
		      echo '</tr>';
	}else{
		echo '<tr><td colspan="10" style="color:#31708F;"><h3>No record found.</h3></td></tr>';	
	}

} else{
	echo '<tr><td colspan="10" style="color:#31708F;"><h3>No record found.</h3></td></tr>';
}


echo '<script type="text/javascript">
		$(".delete").click(function(){
		  var id = $(this).attr("title");
		  if(confirm("Are you sure you want to delete this?")){
		    $.ajax({
		      url : "delete.php?type=delete_daybook&id="+id,
		      type : "POST",
		      success:function(res){
		        if(res == 0){
		          $("#error").hide();
		          $("tr#"+id).css("background-color","#ccc");
		          $("tr#"+id).fadeOut("slow");
		        }else{
		          $("#error").show().html("<div class=alert alert-danger>Error! Please try again later.</div>");
		        }
		      }
		    });
		  }else{
		    return false;
		  }
		});

		$("a[data-toggle=modaldaybook]").click(function(){
		var d_book_id = $(this).attr("id");
		  $.ajax({
		    url : "edit_day_book.php?d_book_id="+d_book_id,
		    success:function(data){
		      $(".popup1").show().html(data);
		    }
		  });
		});
		</script>';
?>