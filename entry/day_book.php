<?php 
include('../include/header.php');
include('is_login.php');

$exp_categories = $obj->getExpensesCategories();
?>
<style>
.preview {
	background-color: #f34343;
	border: none;
	color: white;
	padding: 7px 15px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 14px;
	margin: 2px 2px;
	cursor: pointer;
}
</style>

<div class="content">
	<div class="idealsteps-container">
		<form action="" class="idealforms" id="day_book_form" enctype="multipart/form-data" method="post" role="form" name="day_book_form" >
			<div class="idealsteps-wrap">
				<!-- Step 1 -->
				<section class="idealsteps-step" data-step="0">
					<h3>Day Book </h3>
					<span id="message"></span>
					<div class="field">
						<label class="main">Date <span style="color:red;"> *  </span>: </label>
						<?php if(isset($_SESSION['checkin'])){ ?>
						<input class="date-pick ipt" value="<?php echo $_SESSION['checkin'];?>" type="text" id="checkin" name="checkin" placeholder="Day Book Entry Date">
						<?php } else { ?>
						<input class="date-pick ipt" type="text" id="checkin" name="checkin" placeholder="Day Book Entry Date">
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Type <span style="color:red;"> *  </span>:</label>
						<select name="exp_type" id="selectt" class="exp_type">
							<option value="">Select type..</option>
							<?php foreach ($exp_categories as $exp_category) { 
								if(isset($_SESSION['exp_type'])){
							?>
							<option value="<?php echo $exp_category['category_name']?>"<?php if($_SESSION['exp_type'] == $exp_category['category_name']) echo 'selected="selected"';?>><?php echo $exp_category['category_name']?></option>
							<?php } else {?>
							<option value="<?php echo $exp_category['category_name']?>"><?php echo $exp_category['category_name']?></option>
							<?php } } ?>
						</select>
					</div>
					<div class="clear"></div>
					<div class="field">
						<label class="main">Receive / Pay  <span style="color:red;">* </span>:</label>
						<select name="receive" id="selectt" class="receive">
							<option value="">Select one..</option>
							<?php 
							$rece_pay = array('Receive','Pay');
							foreach ($rece_pay as $rece_p) {
							if(isset($_SESSION['receive'])){
							?>
							<option value="<?php echo $rece_p;?>"<?php if($_SESSION['receive'] == $rece_p) echo 'selected="selected"';?>><?php echo $rece_p;?></option>
							<?php } else {?>
							<option value="<?php echo $rece_p;?>"><?php echo $rece_p;?></option>
							<?php } } ?>
						</select>
					</div>
					
					<div class="field">
						<label class="main">Name / Room no.<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['exp_by'])) { ?>
						<input name="exp_by" id="exp_by"  value="<?php echo $_SESSION['exp_by'];?>" type="text" class="ipt"  placeholder="Enter Name / Room number"></br>
						<?php } else { ?>
						<input name="exp_by" id="exp_by" type="text" value="<?php if(isset($update_checkin_details['email'])) echo $update_checkin_details['email']; ?>" class="ipt"  placeholder="Enter Name / Room number"></br>
						<?php } ?>
					</div>
					<div class="clear"></div>
					<div class="field">
						<label class="main">Amount <span style="color:red;"> * </span>:</label>
						<?php if(isset($_SESSION['amount'])) { ?>
						<input name="amount" id="amount" value="<?php echo $_SESSION['amount'];?>" type="number" class="ipt"  placeholder="Enter Amount">
						<?php } else { ?>
						<input name="amount" id="amount" value="<?php if(isset($update_checkin_details['amount'])) echo $update_checkin_details['amount']; ?>" type="number" class="ipt"  placeholder="Enter Amount">
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Description : </label>
						<?php if(isset($_SESSION['description'])) { ?>
						<textarea name="description" id="description" type="text"  placeholder="Description"><?php echo $_SESSION['description'];?></textarea>
						<?php } else { ?>
						<textarea name="description" id="description" type="text"  placeholder="Description"><?php if(isset($update_checkin_details['address'])) echo $update_checkin_details['address']; ?></textarea>
						<?php } ?>
					</div>

					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" class="reset" id="reset_day_book" value="Reset" />
							<input type="button" id="day_book" class="next" value="Submit" />
							<img class="modallodar" style="display: none" alt="" src="images/ajax-loader-search.gif" />
						</div>

					</div>
				</section>
			</div>
		</form>
	</div>
</div>       
<?php include('../include/footer.php');?>
<script type="text/javascript" src="js/formvalidation.js"></script>
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/submit_form_value.js"></script>

<script>

	$(".hotel").change(function(){
	   	var hotel_id = $(this).attr("value");
	    $.ajax({
	      	url : "save_hotel_id.php?hotel_id="+hotel_id,
	      	success:function(data){
	        	window.location.href='day_book.php';
	      	}
	    });
	 });
	
	$('form.idealforms').idealforms('addRules', {
		'comments': 'required minmax:50:200'
	});
</script>
<script>
	$(document).ready(function () {

		$("#checkin").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });

		$("#checkout").datepicker({ beforeShow: setminDate });

		var start1 = $('#checkin');      
		function setminDate() {          
			var p = start1.datepicker('getDate');          
			if (p) { 
				var k ="01/30/2012";            
				return {
					minDate: p,
					maxDate:k
				}};         
			}           
			function clearEndDate(dateText, inst) {          
				end1.val('');      
			}  
		});
	$(function() {
		$( "#checkout" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
		$( "#checkin" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
	});
	$('#nights').click(function() {
		var start = $('#checkin').datepicker('getDate');
		var end   = $('#checkout').datepicker('getDate');
		var days   = (end - start)/1000/60/60/24;
		$("#nights").val(days);
	});
</script>
</body>
</html>
