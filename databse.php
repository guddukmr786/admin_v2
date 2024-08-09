<?php 
 $host_name = "localhost";

    $user_name = "checklmo_cir_adm";

    $password = "RMnSN?U)-9.J";

    $db_name ="checklmo_cir_admin";



$con = mysql_connect($host_name, $user_name, $password) or die("Couldn't connect to the database".mysql_error());

mysql_select_db($db_name,$con);
?>