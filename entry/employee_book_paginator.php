<?php
require_once('../include/config.php');
$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];
if((!empty($_GET['date']))) {
	$date = date('Y-m-d',strtotime($_GET['date']));

	$query_ff= "SELECT * FROM employees WHERE date_of_join = '".$date."' AND hotel_id = '".$hotel_id."' ORDER BY employee_id DESC";
	$query = $db->execute($query_ff);
	$num_rows = $db->rowCount($query);
	$results = $db->getResults($query);
	
	//end
	if($num_rows > 0){
		$i = 1;
		foreach ($results as $result) {
			$inserted_date = date_format(new DateTime($result['date_of_join']), 'd M Y , D');
			$html = '<tr id="'.$result['employee_id'].'">';

			$html .= '<td class="name">'.$i++.'</td>';

			$html .= '<td class="name">'.$inserted_date.'</td>';

			$html .= '<td class="name">'.$result['name'].'</td>';
			$html .= '<td class="name">'.$result['phone'].'</td>';
			$html .= '<td class="name">'.$result['email'].'</td>';
			$html .= '<td class="name">'.$result['department'].'</td>';
			$html .= '<td class="name" style="width:80px;"><a href="#edit_employee" data-toggle="modalemp"  id="'.$result['employee_id'].'" class="btn">Edit</a></td>';
			$html .= '<td class="name" style="width:80px;"><a href="#" class="delete" title="'.$result['employee_id'].'" id="btn_r1">Delete</a></td>';
			
			$html .= '</tr>';

			echo $html;
			
		}
		
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
		      url : "delete.php?type=delete_employee_details&id="+id,
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

		$("a[data-toggle=modalemp]").click(function(){
		  var employee_id = $(this).attr("id");
		  $.ajax({
		    url : "edit_emp_detials.php?employee_id="+employee_id,
		    success:function(data){
		      $(".popup1").show().html(data);
		    }
		  });
		});
		</script>';
?>