<?php 
include('../include/config.php');
$db = new Database();
if(isset($_GET['query'])){
	$output = '';
	$query = "SELECT DISTINCT country_name FROM country_states WHERE country_name  LIKE '%".$_GET['query']."%' LIMIT 10";
	$result = $db->execute($query);
	$results = $db->getResults($result);
	$output = '<ul>';
	if(!empty($results)){

		foreach ($results as $city) {
			$output .='<li>'.$city['country_name'].'</li>';
		}
	}else{
		$output .='<li>City Not Found</li>';
	}
	$output .='</ul>';	
	echo $output;

}

?>