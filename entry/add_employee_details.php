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
form.idealforms textarea {
    width: 289px;
    height: 95px;
}


</style>
<script language="javascript">
                function addNumbers()
                {
                        var val1 = parseInt(document.getElementById("salary").value);
                        var val2 = parseInt(document.getElementById("convenience").value);
                        var total = document.getElementById("total");
                        total.value = val1 + val2;
                }
        </script>
<style type="text/css">
	#fname{
	    text-transform:capitalize;
	}
	#father_name{
		text-transform: capitalize;
	}
</style>
<div class="content">
	<div class="idealsteps-container">
		<form action="" class="idealforms" id="employees_details" enctype="multipart/form-data" method="post" role="form" name="employees_details" >
			<div class="idealsteps-wrap">
				<!-- Step 1 -->
				<section class="idealsteps-step" data-step="0">
					<h3>Add Employees Details </h3>
					<div id="message"></div>
					<div class="field">
						<label class="main">Full Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['name'])) { ?>
						<input name="fname" id="fname"  value="<?php echo $_SESSION['name'];?>" type="text" class="ipt"  placeholder="Enter Name"></br>
						<?php } else { ?>
						<input name="fname" id="fname" type="text" value="<?php if(isset($update_checkin_details['name'])) echo $update_checkin_details['name']; ?>" class="ipt"  placeholder="Enter Name"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Qualification<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['qualification'])) { ?>
						<input name="qualification" id="qualification"  value="<?php echo $_SESSION['qualification'];?>" type="text" class="ipt"  placeholder="Qualification"></br>
						<?php } else { ?>
						<input name="qualification" id="qualification" type="text" value="<?php if(isset($update_checkin_details['qualification'])) echo $update_checkin_details['qualification']; ?>" class="ipt"  placeholder="Qualification"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Father Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['father_name'])) { ?>
						<input name="father_name" id="father_name"  value="<?php echo $_SESSION['father_name'];?>" type="text" class="ipt"  placeholder="Enter Name / name number"></br>
						<?php } else { ?>
						<input name="father_name" id="father_name" type="text" value="<?php if(isset($update_checkin_details['father_name'])) echo $update_checkin_details['father_name']; ?>" class="ipt"  placeholder="Enter Name"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Contact number<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['phone'])) { ?>
						<input name="phone" id="phone"  value="<?php echo $_SESSION['phone'];?>" type="text" class="ipt"  placeholder="Enter phone number"></br>
						<?php } else { ?>
						<input name="phone" id="phone" type="text" value="<?php if(isset($update_checkin_details['phone'])) echo $update_checkin_details['phone']; ?>" class="ipt"  placeholder="Enter phone number"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Home Cont. No.<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['home_contact'])) { ?>
						<input name="home_contact" id="home_contact"  value="<?php echo $_SESSION['home_contact'];?>" type="text" class="ipt"  placeholder="Enter phone number"></br>
						<?php } else { ?>
						<input name="home_contact" id="home_contact" type="text" value="<?php if(isset($update_checkin_details['home_contact'])) echo $update_checkin_details['home_contact']; ?>" class="ipt"  placeholder="Enter phone number"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Ref. Cont. No.<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['ref_contact'])) { ?>
						<input name="ref_contact" id="ref_contact"  value="<?php echo $_SESSION['ref_contact'];?>" type="text" class="ipt"  placeholder="Enter phone number"></br>
						<?php } else { ?>
						<input name="ref_contact" id="ref_contact" type="text" value="<?php if(isset($update_checkin_details['ref_contact'])) echo $update_checkin_details['ref_contact']; ?>" class="ipt"  placeholder="Enter phone number"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Email:</label>
						<?php if(isset($_SESSION['email'])) { ?>
						<input name="email" id="email"  value="<?php echo $_SESSION['email'];?>" type="text" class="ipt"  placeholder="Enter email"></br>
						<?php } else { ?>
						<input name="email" id="email" type="text" value="<?php if(isset($update_checkin_details['email'])) echo $update_checkin_details['email']; ?>" class="ipt"  placeholder="Enter email"></br>
						<?php } ?>
					</div>
					
					<div class="field">
						<label class="main">Department <span style="color:red;"> *  </span>:</label>
						<select name="depart" id="selectt" class="depart">
							<option value="">Select Department..</option>
							<?php 
							$department  = array('Administrator','Manager','Waiter','Sweeper','Chef','Helper','Other');
							foreach ($department as $depart) { 
								if(isset($_SESSION['depart'])){
							?>
							<option value="<?php echo $depart;?>"<?php if($_SESSION['depart'] == $depart) echo 'selected="selected"';?>><?php echo $depart['depart']?></option>
							<?php } else {?>
							<option value="<?php echo $depart;?>"><?php echo $depart;?></option>
							<?php } } ?>
						</select>
					</div>
				
					<div class="field">
						<label class="main">Salary<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['salary'])) { ?>
						<input name="salary" id="salary"  value="<?php echo $_SESSION['salary'];?>" type="text" class="ipt"  placeholder="Enter Name / name number"></br>
						<?php } else { ?>
						<input name="salary" id="salary" type="text" value="<?php if(isset($update_checkin_details['salary'])) echo $update_checkin_details['salary']; ?>" class="ipt"  placeholder="Enter Salary"></br>
						<?php } ?>
					</div>
					<div class="clear"></div>
					<div class="field">
						<label class="main">Convenience<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['convenience'])) { ?>
						<input name="convenience" id="convenience"  value="<?php echo $_SESSION['convenience'];?>" type="text" class="ipt"  placeholder="Enter Convenience"></br>
						<?php } else { ?>
						<input name="convenience" id="convenience" type="text" value="<?php if(isset($update_checkin_details['convenience'])) echo $update_checkin_details['convenience']; ?>" class="ipt"  placeholder="Enter Convenience"></br>
						<?php } ?>
					</div>
					
					<div class="field">
						<label class="main">Total<span style="color:red;">* </span>:</label>

						<?php if(isset($_SESSION['total'])) { ?>
						<input name="total" id="total"  value="<?php echo $_SESSION['total'];?>" type="text" class="ipt"  placeholder="Total Salary Calculate Here"></br>
						<?php } else { ?>
						<input onclick="javascript:addNumbers()" name="total" id="total" type="text" value="<?php if(isset($update_checkin_details['total'])) echo $update_checkin_details['total']; ?>" class="ipt"  placeholder="Total Salary Calculate Here"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Date of Join <span style="color:red;"> *  </span>: </label>
						<?php if(isset($_SESSION['checkin'])){ ?>
						<input class="date-pick ipt" value="<?php echo $_SESSION['checkin'];?>" type="text" id="checkin" name="checkin" placeholder="Day Book Entry Date">
						<?php } else { ?>
						<input class="date-pick ipt" type="text" id="checkin" name="checkin" placeholder="Date of Join">
						<?php } ?>
					</div>
					
					<div class="field"> 
						<label class="main">ID's:</label>
						<input id="picture" name="picture[]" class="ipt"  type="file" placeholder="Select Multiple Id's using press CTRL and hold it."  multiple >
						<p style="font-size:10px;padding-left:5px;padding-left: 120px;">Select Multiple Id's using press CTRL and hold it.</p>
					</div>
					<div class="field"> 
						<label class="main">Current Address : </label>
						<textarea placeholder="Address" type="text" id="current_address" name="current_address"></textarea>
					</div>
					<div class="field"> 
						<label class="main">Permanent Address : </label>
						<textarea placeholder="Address" type="text" id="address" name="address"></textarea>
					</div>
					<div class="field"> 
						<label class="main">Remarks : </label>
						<textarea placeholder="Remarks" type="text" id="remark" name="remark" style="width:744px;"></textarea>
					</div>

					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" class="reset" id="reset_day_book" value="Reset" />
							<input type="button" id="day_book" name="day_book" class="next" value="Submit" />
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
<script>
	$(".hotel").change(function(){
	   	var hotel_id = $(this).attr("value");
	    $.ajax({
	      	url : "save_hotel_id.php?hotel_id="+hotel_id,
	      	success:function(data){
	        	window.location.href='add_employee_details.php';
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
<script type="text/javascript">
	$("#day_book").click(function(event){
        event.preventDefault();
        var formData = new FormData($("#employees_details")[0]);
        $.ajax({
          	url: 'insert_data.php?type=Employees_Details',
          	type: 'POST', 
          	data: formData,
          	async: false,
          	cache: false,
          	contentType: false,
          	processData: false,
          	beforeSend: function () {
			    $(".modallodar").show();
			},
          	success: function (data) {
          		$(".modallodar").hide();
	            if(data == 0){
					$("#employees_details")[0].reset();
					$("#message").html("<div class='alert alert-success'>Your data has been successfully saved.<div>");
				}else if(data == 1){
					$("#message").html("<div class='alert alert-danger'>Please fill out all required fields marked with an asterisk.<div>");
				}else if(data == 2){
					$("#message").html("<div class='alert alert-danger'>Invalid file Formate! You can upload only (jpg|jpeg) format file.<div>");
				}else if(data == 3){
					$("#message").html("<div class='alert alert-danger'>Error...Please select file < 4 mb.<div>");
				}else{
					$("#message").html("<div class='alert alert-danger'>Something is wrong pleae try again later.<div>");
				}
	        }
        });
        return false;
    });
</script>
</body>
</html>
