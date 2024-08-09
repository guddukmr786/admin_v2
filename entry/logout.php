<?php 
include_once('../include/config.php');
$db = new Database();
$current_date = DATE_TIME;
$login_h_id = $_COOKIE['login_h_id'];
$db->execute("UPDATE login_history SET logout_date_time = '$current_date' WHERE login_h_id = '$login_h_id'");

setcookie ("login_h_id", "",time()-60*60*24*100, "/"); 
setcookie ("admin_id", "",time()-60*60*24*100, "/"); 
setcookie ("user_name", "",time()-60*60*24*100, "/"); 
setcookie ("s_id", "",time()-60*60*24*100, "/"); 
setcookie ("ip_ad", "",time()-60*60*24*100, "/"); 

session_destroy();
echo die('<script>window.location.href="../index.php"</script>');
?>