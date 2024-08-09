<?php
require_once '../include/config.php';
$db = new Database();

$search_string =  trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	
	$query = 'SELECT * FROM travel_details WHERE CONCAT(name,"|",mailid,"|",contactno,"|",location) LIKE "%'.$search_string.'%"';


	$result = $db->execute($query);
	$result_array = $db->getResults($result);
	//print_r($result_array);die;
	
	if (!empty($result_array)) {
		$i=1;
		foreach ($result_array as $result) {
			// Output HTML formats
			$html = '<tr id="travelId">';

			//$html .= '<td style="width:10px!important;">idIncrement</td>';
			$html .= '<td style="width:10px!important;">idIncrement</td>';
			$html .= '<td class="name" style="width:150px;overflow:hidden;">nameString</td>';
			$html .= '<td class="name" style="width:100px;overflow:hidden;">contpString</td>';
			$html .= '<td class="name" style="width:150px;overflow:hidden;">mailidString</td>';
			$html .= '<td class="name" style="width:150px;overflow:hidden;">maillistString</td>';
			$html .= '<td class="name" style="width:25px;overflow:hidden;">contactnoString</td>';
			$html .= '<td class="name" style="width:50px;overflow:hidden;">locationString</td>';
			$html .= '<td class="name" style="width:100px;overflow:hidden;">websiteString</td>';

	       
	        $html .= '<td class="name" style="width:80px;"><a href="travelagent.php?edit=y&id=travelId" class="btn">Edit</a></td>';
	        
	        $html .= '<td class="name" style="width:80px;"><a href="#" id="btn_r1" title="travelId" class="delete">Delete</a></td>';
	        $html .= '</tr>';

			//$id = $result['id'];
			//$t_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);

			$t_name = $result['name'];
			$t_person = $result['contp'];
			$t_email = $result['mailid'];
			$t_maillist = $result['maillist'];
			$t_contact = $result['contactno'];
			$t_location = $result['location'];
			$t_website = $result['website'];
			$travel_id = $result['id']; //edit
			// Replace the items into above HTML
			$o = str_replace('idIncrement', $i++, $html);
			$o = str_replace('nameString', $t_name, $o);
			$o = str_replace('contpString', $t_person, $o);
			$o = str_replace('mailidString', $t_email, $o);
			$o = str_replace('maillist', $t_maillist, $o);
			$o = str_replace('contactnoString', $t_contact, $o);
			$o = str_replace('locationString', $t_location, $o);
			$o = str_replace('websiteString', $t_website, $o);
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
			      url : "delete.php?type=delete_travel&id="+id,
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