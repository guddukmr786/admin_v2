<?php
include_once('../include/config.php');
$db = new Database();

$serach_term = $_GET['term'];
$query = $db->execute("SELECT DISTINCT country_name FROM country_states LIKE '%".$serach_term."%' ORDER BY country_name ASC");
$results = $db->getResults($query);
foreach ($results as $result) {
	$data[] = $result['country_name'];
}
echo json_encode($data);
?>