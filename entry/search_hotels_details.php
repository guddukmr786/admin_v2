<?php
require_once '../include/config.php';
$db = new Database();
$search_string =  trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	
	$query = 'SELECT * FROM hotel_details WHERE CONCAT(hotel_name,"|",email,"|",phone,"|",address) LIKE "%'.$search_string.'%"';


	$result = $db->execute($query);
	$result_array = $db->getResults($result);
	if (!empty($result_array)) {
		$i=1;
		foreach ($result_array as $result) {
			// Output HTML formats
			$html = '<tr id="hotelDetailId">';

			//$html .= '<td style="width:10px!important;">idIncrement</td>';
			$html .= '<td class="name">idIncrement</td>';
			$html .= '<td class="name">nameString</td>';
			$html .= '<td class="name">contpString</td>';
			$html .= '<td class="name">designationString</td>';
			$html .= '<td class="name">mailidString</td>';
			$html .= '<td class="name">phoneString</td>';
			$html .= '<td class="name">locationString</td>';
			$html .= '<td class="name">websiteString</td>';

	       
	        $html .= '<td class="name"><a href="hotel-details.php?edit=y&id=hotelDetailId" class="btn">Edit</a></td>';
	        
	        $html .= '<td class="name"><a href="##" id="btn_r1" title="hotelDetailId" class="delete">Delete</a></td>';
	        $html .= '</tr>';

			//$id = $result['id'];
			//$t_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);

			$t_name = $result['hotel_name'];
			$t_contact_person = $result['contact_person'];
			$t_designation = $result['designation'];
			$t_email = $result['email'];
			$t_phone = $result['phone'];
			$location = "";
            $location = $hot_category['address'];
            if(!empty($result['city'])){
            	$location .= ','.$result['city'];
            }
            if(!empty($result['state'])){
            	$location .= ','.$result['state'];
            }
            if(!empty($result['pincode'])){
            	$location .= '-'.$result['pincode'];
            }
            if(!empty($result['country'])){
            	$location .= ','.$result['country'];
            };
			$t_website = $result['website'];
			$hotel_details_id = $result['hotel_details_id']; //edit
			// Replace the items into above HTML
			$o = str_replace('idIncrement', $i++, $html);
			$o = str_replace('nameString', $t_name, $o);
			$o = str_replace('contpString', $t_person, $o);
			$o = str_replace('designationString', $t_designation, $o);
			$o = str_replace('mailidString', $t_email, $o);
			$o = str_replace('phoneString', $t_phone, $o);
			$o = str_replace('locationString', $t_location, $o);
			$o = str_replace('websiteString', $t_website, $o);
			$o = str_replace('hotelDetailId',$hotel_details_id ,$o); //edit
			// Output it
			echo($o);

  		}
  		
  	}else {
		echo '<td colspan="12">
			<h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
			<br/>
			<p>Only Guest name/ phone number/ booking id are accepted search field</p>
		</td>';
	}


	echo '
	$(document).on("click",".delete",function(){
		  var id = $(this).attr("title");
		  
		  if(confirm("Are you sure you want to delete this?")){
		    $.ajax({
		      url : "delete.php?type=delete_hotel&id="+id,
		      type : "POST",
		      success:function(res){
		        if(res == 0){
		          $("#error").hide();
		          $("tr#"+id).css("background-color","#ccc");
		          $("tr#"+id).fadeOut("slow");
		        }else{
		          $("#error").show().html("<div class="alert alert-danger">Error! Please try again later.</div>");
		        }
		      }
		    });
		  }else{
		    return false;
		  }
		});';
}
?>