<?php 
session_start();
setcookie("hotel_id",$_GET['hotel_id'], time() + (86400 * 30),"/");
?>