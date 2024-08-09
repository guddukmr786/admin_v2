<?php 
echo $_POST['id'];die;
if($_POST['date1']){
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$datediff = $date1-$date2;
	$days = floor($datediff/(60*60*24));
	echo $days;
}
?>