<?php
require_once '../include/config.php';
$db = new Database();

$search_string =  trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	
	$query = 'SELECT * FROM invoice_sushant_travels WHERE CONCAT(name,"|",email) LIKE "%'.$search_string.'%"';


	$result = $db->execute($query);
	$result_array = $db->getResults($result);
	//print_r($result_array);die;
	
	if (!empty($result_array)) {
		$i=1;
		foreach ($result_array as $result) {
			$travel_id = $result['travel_id'];

			$query_desc = "SELECT * FROM invoice_desc WHERE travel_id = '$travel_id' LIMIT 1";
			$result_desc = $db->execute($query_desc);
			$result_desc_arr = $db->getResult($result_desc);
			// Output HTML formats
			$html = '<tr id="travelId">';

			//$html .= '<td style="width:10px!important;">idIncrement</td>';
			$html .= '<td style="width:10px!important;">idIncrement</td>';
			$html .= '<td class="name">nameString</td>';
			$html .= '<td class="name">emailString</td>';
			$html .= '<td class="name">cityString</td>';
			$html .= '<td class="name">countryString</td>';
			$html .= '<td class="name">invoiceDateString</td>';
			$html .= '<td class="name">detailsString</td>';
			$html .= '<td class="name">amountString</td>';

	       
	        $html .= '<td class="name" style="width:120px;"><a href="generate_invoice.php?edit=y&id=travelId" class="btn">View</a>&nbsp;<a href="invoice.php?id=travelId" class="btn" target="_blank">Print</a></td>';
	        
	        $html .= '<td class="name" style="width:80px;"><a href="#" id="btn_r1" title="travelId" class="delete">Delete</a></td>';
	        $html .= '</tr>';

	       

			$t_name = $result['name'];
			$t_email = $result['email'];
			$t_city = $result['city'];
		
			$t_country = $result['country'];
			$t_invoice_date = $result['invoice_date'];
			$details = $result_desc_arr['description'];
			$t_location = $result['total_amount'];
			 //edit
			// Replace the items into above HTML
			$o = str_replace('idIncrement', $i++, $html);
			$o = str_replace('nameString', $t_name, $o);
			$o = str_replace('emailString', $t_email, $o);
			$o = str_replace('cityString', $t_city, $o);
			$o = str_replace('countryString', $t_country, $o);
			$o = str_replace('invoiceDateString', $t_invoice_date, $o);
			$o = str_replace('detailsString', $details, $o);
			$o = str_replace('amountString', $t_location, $o);
			$o = str_replace('travelId',$travel_id ,$o); //edit
			// Output it
			echo($o);

  		}
  		echo '
	  		<script type="text/javascript">
			$(".delete").click(function(){
			  var id = $(this).attr("title");
			  
			  if(confirm("Are you sure you want to delete this?")){
			    $.ajax({
			      url : "delete.php?type=delete_invoice&id="+id,
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
				</script>';
  	}
  		 else {
			echo '<td colspan="12">
				<h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
				<br/>
				<p>Only Guest name/ phone number/ booking id are accepted search field</p>
			</td>';
	}
}


?>