<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $COOKIE['hotel_id'];
if(isset($_GET['employee_id'])){
	$employee_id = $_GET['employee_id'];
	$reslut = $obj->getEmployeeDetailsForUpdate($employee_id, $hotel_id);
	if(isset($reslut['date_of_join'])){
		$entry_datess = str_replace('-', '/', $reslut['date_of_join']);
		$entry_date = date('d/m/Y', strtotime($entry_datess));
	}
}
?>
<script language="javascript">
    function addNumbers()
    {
            var val1 = parseInt(document.getElementById("salary").value);
            var val2 = parseInt(document.getElementById("convenience").value);
            var total = document.getElementById("total");
            total.value = val1 + val2;
    }
 	</script>
<!--Re-checkin modal -->
	<h3 class="text-center" style="text-align:center!important;">Update Employees Details </h3>
    <form action="#" class="idealforms" id="employee" enctype="multipart/form-data" role="form" name="employee" >
      	<span id="messsage"></span>
      	<div class="field">
			<label class="main">Full Name<span style="color:red;">* </span>:</label>
			<input name="fname" id="fname" type="text" value="<?php if(isset($reslut['name'])) echo $reslut['name']; ?>" class="ipt"  placeholder="Enter Name"></br>
		
		</div>
		<div class="field">
			<label class="main">Qualification<span style="color:red;">* </span>:</label>
			<input name="qualification" id="qualification" type="text" value="<?php if(isset($reslut['qualification'])) echo $reslut['qualification']; ?>" class="ipt"  placeholder="Qualification"></br>
		
		</div>
		<div class="field">
			<label class="main">Father Name<span style="color:red;">* </span>:</label>
			<input name="father_name" id="father_name" type="text" value="<?php if(isset($reslut['father_name'])) echo $reslut['father_name']; ?>" class="ipt"  placeholder="Enter Name"></br>
		
		</div>
		<div class="field">
			<label class="main">Contact number <span style="color:red;">* </span>:</label>
			<input name="phone" id="phone" type="text" value="<?php if(isset($reslut['phone'])) echo $reslut['phone']; ?>" class="ipt"  placeholder="Enter phone number"></br>
		
		</div>
		<div class="field">
			<label class="main">Home Cont. Number<span style="color:red;">* </span>:</label>
			<input name="home_contact" id="home_contact" type="text" value="<?php if(isset($reslut['home_contact'])) echo $reslut['home_contact']; ?>" class="ipt"  placeholder="Enter phone number"></br>
		
		</div>
		<div class="field">
			<label class="main">Ref. Cont. Number <span style="color:red;">* </span>:</label>
			<input name="ref_contact" id="ref_contact" type="text" value="<?php if(isset($reslut['ref_contact'])) echo $reslut['ref_contact']; ?>" class="ipt"  placeholder="Enter phone number"></br>
		
		</div>
		
		<div class="field">
			<label class="main">Email:</label>
			<input name="email" id="email" type="text" value="<?php if(isset($reslut['email'])) echo $reslut['email']; ?>" class="ipt"  placeholder="Enter email"></br>
			
		</div>
		
		<div class="field">
			<label class="main">Department <span style="color:red;"> *  </span>:</label>
			<select name="depart1" id="selectt" class="depart1">
				<option value="">Select Department..</option>
				<?php 
				$department  = array('Administrator','Manager','Waiter','Sweeper','Chef','Helper','Other' );
				foreach ($department as $depart) { 
				?>
				<option value="<?php echo $depart;?>" <?php if($reslut['department'] == $depart) echo 'selected="selected"';?>><?php echo $depart;?></option>
				<?php }  ?>
			</select>
		</div>
		<div class="field">
			<label class="main">Salary:</label>
			<input name="salary" id="salary" type="text" value="<?php if(isset($reslut['salary'])) echo $reslut['salary']; ?>" class="ipt"  placeholder="Enter Salary"></br>
			
		</div>
		<div class="clear"></div>
		<div class="field">
			<label class="main">Convenience:</label>
			<input name="convenience" id="convenience" type="text" value="<?php if(isset($reslut['convenience'])) echo $reslut['convenience']; ?>" class="ipt"  placeholder="Enter Convenience"></br>
			
		</div>
		<div class="field">
			<label class="main">Total:</label>
			<input  onclick="javascript:addNumbers()" name="total" id="total" type="text" value="<?php if(isset($reslut['total'])) echo $reslut['total']; ?>" class="ipt"  placeholder="Enter Total salary"></br>
			
		</div>
		
		<div class="field">
			<label class="main">Date of Join <span style="color:red;"> *  </span>: </label>
			<input class="date-pick ipt" type="text" value="<?php if(!empty($entry_date)) echo $entry_date;?>" id="checkin1" name="checkin" placeholder="Day Book Entry Date">
			
		</div>
		<div class="field"> 
			<label class="main">ID's:</label>
			<input id="picture" name="picture[]" class="ipt"  type="file" placeholder="Select Multiple Id's using press CTRL and hold it."  multiple >
			<p style="font-size:10px;padding-left:5px;padding-left: 120px;">Select Multiple Id's using press CTRL and hold it.</p>
		</div>
		<div class="field"> 
			<label class="main">Current Address : </label>
			<textarea placeholder="Address" type="text" id="current_address" rows="5" cols="2" name="current_address"><?php if(isset($reslut['current_address'])) echo $reslut['current_address']; ?></textarea>
		</div>
		<div class="field"> 
			<label class="main">Address : </label>
			<textarea placeholder="Address" type="text" id="address" rows="5" cols="2" name="address"><?php if(isset($reslut['address'])) echo $reslut['address']; ?></textarea>
		</div>
		<div class="field"> 
			<label class="main">Remarks : </label>
			<textarea placeholder="Remarks" type="text" id="remark" rows="5" cols="2" name="remark"><?php if(isset($reslut['remark'])) echo $reslut['remark']; ?></textarea>
		</div>
		<div class="field buttons" >
			<button type="button" id="submit_emp" title="<?php echo $employee_id;?>" class="reset">Submit</button>
    	</div>
    	<div id='loadingmessage' style="display: none;">
		  <img src='ajax-loader.gif'/>
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
		$( "#checkin1" ).datepicker();
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
	$('#fname,#phone,.depart1,#checkin1').click(function(){
		
		$('#fname').css("border", "");
		$('#phone').css("border", "");
		$('.depart1').css("border", "");
		$('#checkin1').css("border", "");
	})
});

$('#submit_emp').on('click', function(e) {
	var fname = $('#fname');
	var phone = $('#phone');
	var depart1 = $('.depart1');
	var checkin1 = $('#checkin1');
	if(!fname.val()) {
	  	$('#fname').css("border", "1px solid red");
	  	$('#fname').focus();
	  	e.preventDefault();
	}
	
	if(!phone.val()) {
	  	$('#phone').css("border", "1px solid red");
	  	$('#phone').focus();
	  	e.preventDefault();
	}
	if(!depart1.val()) {
	  	$('.depart1').css("border", "1px solid red");
	  	$('.depart1').focus();
	  	e.preventDefault();
	}
	if(!checkin1.val()) {
	  	$('#checkin1').css("border", "1px solid red");
	  	$('#checkin1').focus();
	  	e.preventDefault();
	}
});
</script>

<script type="text/javascript">
	
	$("#submit_emp").click(function(event){
        event.preventDefault();
        var employee_id = $(this).attr('title');
        var formData = new FormData($("#employee")[0]);
        $.ajax({
          	url: 'insert_data.php?employee_id='+employee_id +'&type=update_employee_details',
          	type: 'POST', 
          	data: formData,
          	async: false,
          	cache: false,
          	contentType: false,
          	processData: false,
          	beforeSend: function() {
              $("#loadingmessage").show();
           	},
          	success: function (data) {
          		
          		$("#loadingmessage").hide();
          		if(data == 0){
					$("#employee")[0].reset();
					$("#messsage").html("<div style='color:green;margin-left:25px;'>Your data has been successfully saved.<div>");
				}else if(data == 1){
					$("#messsage").html("<div style='color:red;margin-left:25px;'>Please fill in all required fields marked with an asterisk.<div>");
				}else if(data == 2){
					$("#messsage").html("<div style='color:red;margin-left:25px;'>Invalid file Formate! You can upload only (docx|doc|pdf|jpg|png|jpeg|gif|bmp) format file.<div>");
				}else if(data == 3){
					$("#messsage").html("<div style='color:red;margin-left:25px;'>Error...Please select file < 4 mb.<div>");
				}else if(data == 4){
					$("#messsage").html("<div style='color:red;margin-left:25px;'>Execution Failed.<div>");
				}else{
					$("#messsage").html("<div style='color:red;margin-left:25px;'>Something is wrong pleae try again later.<div>");
				}
	        }
        });
        return false;
    });
</script>



