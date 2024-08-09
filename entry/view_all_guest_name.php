<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
if(isset($_GET['checkin_date'])){
	$checkin_date = $_GET['checkin_date'];
	$checkin_id = $_SESSION['checkin_id'];
	$view_all_guests = $obj->getViewAllGuestName($checkin_id, $checkin_date);
}
?>
<!-- popup form #3 --> 
<div class="content">
	<div class="form-wizard">
		<div class="row">
			<div class="col-md-12 col-sm-7">
				<div class="data-container">
		         	<h3 class="heading">All Guest Name</h3>
		         	<?php
		         	if(!empty($view_all_guests)){
		         	foreach ($view_all_guests as $view_all_guest) { ?>
						<dl>
							<dt>Name</dt>
							<dd><?php echo $view_all_guest['name_title'].' '.$view_all_guest['name'];?></dd>
						</dl>
						<dl>
							<dt>Gender</dt>
							<dd><?php echo $view_all_guest['gender']?></dd>
						</dl>
						<hr style="height:1px;border:none;color:#333;background-color:#333;">
					<?php } } ?>
				</div><!--/ .data-container-->
			</div>
		</div><!--/ .row-->
	</div>
	<a class="close" href=""></a>
</div>  
