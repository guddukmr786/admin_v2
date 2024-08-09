<?php 
if(empty($_COOKIE['admin_id']) || $_COOKIE['admin_id'] == "") {

	die("<script>location.href = '../index.php'</script>");
}elseif ($_COOKIE['ip_addres'] != $_SERVER['REMOTE_ADDR']) {
	
	die("<script>location.href = '../index.php'</script>");
}
?>