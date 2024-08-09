<?php 
include('../include/config.php');
$db = new Database();
if(isset($_GET['query'])){
	$output = '';
	$query = "SELECT DISTINCT state_name FROM country_states WHERE state_name  LIKE '%".$_GET['query']."%' LIMIT 10";
	$result = $db->execute($query);
	$results = $db->getResults($result);
	$output = '<ul>';
	if(!empty($results)){

		foreach ($results as $city) {
			$output .='<li>'.$city['state_name'].'</li>';
		}
	}else{
		$output .='<li>City Not Found</li>';
	}
	$output .='</ul>';	
	echo $output;

}

?>