<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
$exp_categories = $obj->getExpensesCategories();
if(isset($_GET['d_book_id'])){
	$d_book_id = $_GET['d_book_id'];
	$reslut = $obj->getDayBookEntryForUpdate($d_book_id, $hotel_id);
	if(isset($reslut['date_of_expense'])){
		$entry_datess = str_replace('-', '/', $reslut['date_of_expense']);
		$entry_date = date('d/m/Y', strtotime($entry_datess));
	}
}
?>

<!--Re-checkin modal -->
	<h3 class="text-center" style="text-align:center!important;">Day Book </h3>
    <form action="#" class="idealforms" id="day_book_form" enctype="multipart/form-data" role="form" name="day_book_form" >
      	<span id="messsage"></span>
      	<div class="field">
        	<label class="main">Date<span style="color:red;"> * </span>:</label>
        	<input type="text" value="<?php if(!empty($entry_date)) echo $entry_date;?>" id="entry_date" name="entry_date" class="date-pick ipt">
      	</div>
      
		<div class="field">
			<label class="main">Type <span style="color:red;"> *  </span>:</label>
			<select name="exp_type" id="selectt" class="exp_type">
				<option value="">Select type..</option>
				<?php foreach ($exp_categories as $exp_category) { 
				?>
				<option value="<?php echo $exp_category['category_name']?>"<?php if($reslut['expense_type'] == $exp_category['category_name']) echo 'selected="selected"'; ?>><?php echo $exp_category['category_name']?></option>
				<?php } ?>
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
				?>
				<option value="<?php echo $rece_p;?>"<?php if($reslut['receive_pay'] == $rece_p) echo 'selected="selected"';?>><?php echo $rece_p;?></option>
				<?php } ?>
			</select>
		</div>
		<div class="field">
			<label class="main">Name / Room no.<span style="color:red;">* </span>:</label>
			<input name="exp_by" id="exp_by" type="text" value="<?php if(isset($reslut['expense_by'])) echo $reslut['expense_by']; ?>" class="ipt"  placeholder="Enter Name / Room number"></br>
		</div>
		<div class="clear"></div>
      	<div class="field">
			<label class="main">Amount <span style="color:red;"> * </span>:</label>
			<input name="amount" id="amount" value="<?php if(isset($reslut['amount'])) echo $reslut['amount']; ?>" type="number" class="ipt"  placeholder="Enter Amount">
		</div>
		<div class="field">
			<label class="main">Description : </label>
			<textarea style="width:746px!important;" name="description" id="description" type="text"  placeholder="Description"><?php if(isset($reslut['description'])) echo $reslut['description']; ?></textarea>
		</div>
		<div class="field buttons" style="margin-left:50%;">
			<button type="button" id="submit_day_book" title="<?php echo $d_book_id;?>" class="reset">Submit</button>
    	</div>
    </form>
  <a class="close" href=""></a> 
</div>
<?php include_once('../include/footer.php');?>
<script src="js/jquery.min.js" type="text/javascript"></script>
<!--<script src="js/jquery.reveal.js" type="text/javascript"></script> -->
<!--<script src="js/quantity-bt.js"></script>-->
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$( function() {
		$( "#entry_date" ).datepicker();
	} );
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
<script type="text/javascript">
$(document).ready(function(){ 
	$('.exp_type,.receive,#exp_by,#amount,#description,#entry_date').click(function(){
		
		$('.exp_type').css("border", "");
		$('.receive').css("border", "");
		$('#exp_by').css("border", "");
		$('#amount').css("border", "");
		$('#description').css("border", "");
		$('#entry_date').css("border", "");
	})
});

$('#submit_day_book').on('click', function(e) {
	var exp_type = $('.exp_type');
	var receive = $('.receive');
	var exp_by = $('#exp_by');
	var amount = $('#amount');
	var entry_date = $('#entry_date');
	
	if(!entry_date.val()) {
	  	$('#entry_date').css("border", "1px solid red");
	  	$('#entry_date').focus();
	  	e.preventDefault();
	}
	if(!exp_type.val()) {
	  	$('.exp_type').css("border", "1px solid red");
	  	$('.exp_type').focus();
	  	e.preventDefault();
	}
	if(!receive.val()) {
	  	$('.receive').css("border", "1px solid red");
	  	$('.receive').focus();
	  	e.preventDefault();
	}
	if(!exp_by.val()) {
	  	$('#exp_by').css("border", "1px solid red");
	  	$('#exp_by').focus();
	  	e.preventDefault();
	}
	if(!amount.val()) {
	  	$('#amount').css("border", "1px solid red");
	  	$('#amount').focus();
	  	e.preventDefault();
	}
});
</script>

<script type="text/javascript">
	$('#submit_day_book').click(function(){
	  	var d_book_id = $(this).attr('title');
	  	$.ajax({
	    	url : 'insert_data.php?d_book_id='+d_book_id +'&type=update_day_book',
	    	type : 'POST',
	    	data : $('form').serialize(),
	    	cache: false,
	    	success:function(data){
	    		if(data == 1){
		      		$('#messsage').show().html('<div class="alert alert-danger">Please fill out all required fields.</div>');
		      	} else if(data == 0){
		      		$("#day_book_form")[0].reset();
		      		$('#messsage').show().html('<div class="alert alert-success">Your data has been successfully updated.</div>');
		      	}
		    }
	  	});
	}); 
</script>



