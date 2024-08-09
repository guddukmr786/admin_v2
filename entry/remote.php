<?php
$servername = "199.79.62.12 ";
$username = "budgee88_sushant";
$password = "eh!h)u9w,Uc}";
$database = "budgee88_sushanttravel";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$query = $conn->query("SELECT * FROM about_us");
$result = $query->fetch_assoc();
echo "<pre>";
print_r($result);
echo "<br>";
echo $result['image'];

?>
<img alt="Yesh baby" src="https://www.sushanttravels.com/admin/upload/aboutUsImage/<?php echo $result['image'];?>" width="200px" height="300">
