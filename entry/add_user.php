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
ul.chil-ul{
	margin-left: 30px;
	display: none;
}
</style>
<script language="javascript">
    function addNumbers() {
        var val1 = parseInt(document.getElementById("salary").value);
        var val2 = parseInt(document.getElementById("convenience").value);
        var total = document.getElementById("total");
        total.value = val1 + val2;
    }
</script>
<style type="text/css"> 
	#f_name,#last_name{
	    text-transform:capitalize;
	}
</style>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/hummingbird-treeview-1.1.css" rel="stylesheet" type="text/css">
<div class="content">
	<div class="idealsteps-container">
		<form action="" class="idealforms" id="add_user_form" enctype="multipart/form-data" method="post" role="form" name="add_user_form" >
			<div class="idealsteps-wrap">
				<!-- Step 1 -->
				<section class="idealsteps-step" data-step="0">
					<h3>Add user </h3>
					<div id="message"></div>
					<div class="field">
						<label class="main">First Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['f_name'])) { ?>
						<input name="f_name" id="f_name"  value="<?php echo $_SESSION['f_name'];?>" type="text" class="ipt"  placeholder="Enter First Name"></br>
						<?php } else { ?>
						<input name="f_name" id="f_name" type="text" value="<?php if(isset($update_checkin_details['f_name'])) echo $update_checkin_details['f_name']; ?>" class="ipt"  placeholder="Enter first Name"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Last Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['last_name'])) { ?>
						<input name="last_name" id="last_name"  value="<?php echo $_SESSION['last_name'];?>" type="text" class="ipt"  placeholder="Enter last name"></br>
						<?php } else { ?>
						<input name="last_name" id="last_name" type="text" value="<?php if(isset($update_checkin_details['last_name'])) echo $update_checkin_details['last_name']; ?>" class="ipt"  placeholder="Enter Last name"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Email<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['email'])) { ?>
						<input name="email" id="email"  value="<?php echo $_SESSION['email'];?>" type="text" class="ipt"  placeholder="Enter email"></br>
						<?php } else { ?>
						<input name="email" id="email" type="text" value="<?php if(isset($update_checkin_details['email'])) echo $update_checkin_details['email']; ?>" class="ipt"  placeholder="Enter Email"></br>
						<?php } ?>
						<div id="email_msg"></div>
					</div>
					<div class="field">
						<label class="main">User Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['user_name'])) { ?>
						<input name="user_name" id="user_name"  onkeypress="return avoidSpace(event)"  value="<?php echo $_SESSION['user_name'];?>" type="text" class="ipt"  placeholder="Enter User Name without space"></br>
						<?php } else { ?>
						<input name="user_name" id="user_name" onkeypress="return avoidSpace(event)" type="text" value="<?php if(isset($update_checkin_details['user_name'])) echo $update_checkin_details['user_name']; ?>" class="ipt"  placeholder="Enter User Name without space"></br>
						<?php } ?>
						<div class="match_user"></div>
					</div>
					
					
					<div class="field">
						<label class="main">Password<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['password'])) { ?>
						<input name="password" id="password"  value="<?php echo $_SESSION['password'];?>" type="password" class="ipt"  placeholder="Enter password"></br>
						<?php } else { ?>
						<input name="password" id="password" type="password" value="<?php if(isset($update_checkin_details['password'])) echo $update_checkin_details['password']; ?>" class="ipt"  placeholder="Enter password"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Confirm Password<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['c_password'])) { ?>
						<input name="c_password" id="c_password"  value="<?php echo $_SESSION['c_password'];?>" type="password" class="ipt"  placeholder="Enter Confirm Password"></br>
						<?php } else { ?>
						<input name="c_password" id="c_password" type="password" value="<?php if(isset($update_checkin_details['c_password'])) echo $update_checkin_details['c_password']; ?>" class="ipt"  placeholder="Enter Confirm Password"></br>
						<?php } ?>
						<div class="match"></div>
					</div>
					<div class="field">
						<label class="main">User Type<span style="color:red;"> * </span>:</label>
						<select name="user_type" id="selectt" class="user_type">
							<option value="">Select User Type</option>
							<?php 
							$user_type = array('Super Admin','Admin','Manager');
							foreach ($user_type as $user_t) { 
							?>
							<option value="<?php echo $user_t?>"<?php if(isset($update_user['user_type']) && $user_t == $update_user['user_type']) echo 'selected="selected"';?>><?php echo $user_t;?></option>
							<?php  } ?>
						</select>
					</div>
					<div class="field hotel_ss" >
						<label class="main">Hotels<span style="color:red;"> * </span>:</label>
						<select name="hotel_name" id="selectt" class="hotel_name">
							<option value="">Select hotel</option>
							<?php 
							foreach ($all_hotels as $all_hotel) { 
							?>
							<option value="<?php echo $all_hotel['hotel_id'];?>"<?php if(isset($update_user['hotel_name']) && $all_hotel['hotel_name'] == $update_user['hotel_name']) echo 'selected="selected"';?>><?php echo $all_hotel['hotel_name'];?></option>
							<?php  } ?>
						</select>
					</div>
					<!--tab with checkbox-->
					<div class="clear"></div>
					<div class="field hummingbird-treeview">
						<label class="main">Previleges<span style="color:red;"> * </span>:</label>
						<div id="treeview_container" class="hummingbird-treeview">
						    <ul id="treeview" style="margin-left: 0px;">
						      <li> 
						        <ul>
						        	<li>
						        		<span class="glyphicon glyphicon-minus"></span>
							            <input  id="xnode-0-0" name="previleges[]" data-id="custom-0-0" type="checkbox" value="Room View" />
							            <label>Room View</label>
						          	</li>
						          	<li>
						          		<span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-1" name="previleges[]" data-id="custom-0-1" type="checkbox" value="CIR Guest" />
							            <label>CIR Guest </label>
							            <ul class="chil-ul">
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-1-1" data-id="custom-0-1-1" type="checkbox"  value="Guest Entry Form" />
							                  	<label>Guest Entry Form</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" value="Guest Entry List" />
							                   	<label>Guest Entry List</label>
							              	</li>
							            </ul>
						          	</li>
						          	<li> 
								        <span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-2" name="previleges[]" data-id="custom-0-2" type="checkbox" value="CIR Arrival Booking" />
							            <label>CIR Arrival Booking</label>
							            <ul class="chil-ul">
							              	<li>
							                  	<input class="hummingbirdNoParent" id="xnode-0-2-1" name="previleges[]" data-id="custom-0-2-1" type="checkbox" value="Arrival Booking Form" />
							                	<label>Arrival Booking Form</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" value="Arrival Booking List" />
							                  	<label>Arrival Booking List</label>
							              	</li>
							            </ul>
						          	</li>
						          	<li> 
								        <span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-3" name="previleges[]" data-id="custom-0-2" type="checkbox" value="Day Book" />
							            <label>Day Book</label>
							            <ul class="chil-ul">
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-3-1" data-id="custom-0-3-1" type="checkbox" value="Entry Day Book" />
							                	<label>Entry Day Book</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-3-2" data-id="custom-0-3-2" type="checkbox" value="View Day Book" />
							                  	<label>View Day Book</label>
							              	</li>
							            </ul>
						          	</li>
						          	<li> 
								        <span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-4" name="previleges[]" data-id="custom-0-2" type="checkbox" value="Employees" />
							            <label>Employees</label>
							            <ul class="chil-ul">
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-4-1" data-id="custom-0-4-1" type="checkbox" value="Add Employees Details" />
							                  	<label>Add Employees Details</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-4-2" data-id="custom-0-4-2" type="checkbox" value="View Employees Details" />
							                  	<label>View Employees Details</label>
							              	</li>
							            </ul>
						          	</li>
						          	<li> 
								        <span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-5" name="previleges[]" data-id="custom-0-2" type="checkbox" value="Users" />
							            <label>Users</label>
							            <ul class="chil-ul">
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-5-1" data-id="custom-0-5-1" type="checkbox" value="Add Users" />
							                  	<label>Add Users</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-5-2" data-id="custom-0-5-2" type="checkbox" value="View Users" />
							                  	<label>View Users</label>
							              	</li>
							            </ul>
						          	</li>
						          	<li> 
								        <span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-6" name="previleges[]" data-id="custom-0-6" type="checkbox" value="Travels" />
							            <label>Travels</label>
							            <ul class="chil-ul">
							            	
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-1" data-id="custom-0-6-1" type="checkbox" value="Travel Agents" />
							                  	<label>Travel Agents</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-2" data-id="custom-0-6-2" type="checkbox" value="Add Party" />
							                  	<label>Add Party</label>
							              	</li>
							              	<li>
							                	
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-3" data-id="custom-0-6-3" type="checkbox" value="Generate Invoice" />
							                  	<label>Generat Invoice</label>
							             	</li>
							              	<li>
							                	
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-4" data-id="custom-0-6-4" type="checkbox" value="View Invoice" />
							                  	<label>View Invoice</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-5" data-id="custom-0-6-5" type="checkbox" value="Sushant Travels Invoice" />
							                  	<label>Sushant Travels Invoice</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-6" data-id="custom-0-6-6" type="checkbox" value="View Sushant Travels Invoice" />
							                  	<label>View Sushant Travels Invoice</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-7" data-id="custom-0-6-7" type="checkbox" value="View Sushant Travels Invoice" />
							                  	<label>Hotel Details</label>
							              	</li>
							            </ul>
						          	</li>
						          	<li> 
								        <span class="glyphicon glyphicon-plus"></span>
							            <input  id="xnode-0-7" name="previleges[]" data-id="custom-0-2" type="checkbox" value="Reports" />
							            <label>Reports</label>
							            <ul class="chil-ul">
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-7-1" data-id="custom-0-7-1" type="checkbox"  value="View Reports" />
							                  	<label>View Reports</label>
							              	</li>
							              	<li>
							                  	<input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-7-2" data-id="custom-0-7-2" type="checkbox" value="Date Wise Checkin Details" />
							                  	<label>Date Wise Checkin Details</label>
							              	</li>
							            </ul>
						          	</li>
						        </ul>
						      </li>
						    </ul>
						</div>
					</div>
					<!--end tab with checkbox-->
					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" class="reset" id="reset_day_book" value="Reset" />
							<input type="button" id="add_user_btn" name="add_user_btn" class="next" value="Submit" />
							<img class="modallodar" style="display: none" alt="" src="images/ajax-loader-search.gif" />
						</div>
					</div>
				</section>
			</div>
		</form>
	</div>
</div>       
<?php include('../include/footer.php');?>
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<script src="js/hummingbird-treeview-1.1.js"></script>
<script type="text/javascript" src="js/checkbox-script.js"></script>

<script type="text/javascript">
	$(".hotel").change(function(){
	   	var hotel_id = $(this).attr("value");
	    $.ajax({
	      	url : "save_hotel_id.php?hotel_id="+hotel_id,
	      	success:function(data){
	        	window.location.href='add_user.php';
	      	}
	    });
	});
</script>
<script type="text/javascript">

	$(document).ready(function(){
		$("label").removeClass("ideal-radiocheck-label");
		$("input").removeAttr("style");
		$(".ideal-check").remove();
	})
</script>
<script>
	$("#treeview").hummingbird();
	$( "#checkAll" ).click(function() {
	  $("#treeview").hummingbird("checkAll");
	});
	$( "#uncheckAll" ).click(function() {
	  $("#treeview").hummingbird("uncheckAll");
	});
	$( "#collapseAll" ).click(function() {
	  $("#treeview").hummingbird("collapseAll");
	});
	$( "#checkNode" ).click(function() {
	  $("#treeview").hummingbird("checkNode",{attr:"id",name: "xnode-0-2-2",expandParents:false});
	});
</script>

<script>
	
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
	
	$(document).ready(function(){ 
		$('#f_name,#last_name,#user_name,#email,#password,#c_password,.user_type,.hotel_name').click(function(){
			$('#f_name').css("border", "");
			$('#last_name').css("border", "");
			$('#user_name').css("border", "");
			$('#email').css("border", "");
			$('#password').css("border", "");
			$('#c_password').css("border", "");
			$('.user_type').css("border", "");
			$('.hotel_name').css("border", "");
		});
	});

	$('#add_user_btn').on('click', function(e) {
		var f_name = $('#f_name');
		var last_name = $('#last_name');
		var user_name = $('#user_name');
		var email = $('#email');
		var user_name = $('#user_name');
		var email = $('#email');
		var password = $('#password');
		var c_password = $('.c_password');
		var user_type = $('.user_type');
		var hotel_name = $('.hotel_name');
		if(!f_name.val()) {
			$('#f_name').css("border", "1px solid red");
			$('#f_name').focus();
			e.preventDefault();
			
		} 

		if(!last_name.val()) {
			$('#last_name').css("border", "1px solid red");
			$('#last_name').focus();
			e.preventDefault();
			
		} 
		if(!user_name.val()) {
			$('#user_name').css("border", "1px solid red");
			$('#user_name').focus();
			e.preventDefault();
			
		} 

		if(!email.val()) {
			$('#email').css("border", "1px solid red");
			$('#email').focus();
			e.preventDefault();
			
		} 

		if(!password.val()) {
			$('#password').css("border", "1px solid red");
			$('#password').focus();
			e.preventDefault();
			
		} 

		if(!c_password.val()) {
			$('#c_password').css("border", "1px solid red");
			$('#c_password').focus();
			e.preventDefault();
			
		} 

		if(!user_type.val()) {
			$('.user_type').css("border", "1px solid red");
			$('.user_type').focus();
			e.preventDefault();
			
		}
		if(!hotel_name.val()) {
			$('.hotel_name').css("border", "1px solid red");
			$('.hotel_name').focus();
			e.preventDefault();
			
		}
	});


	$("#email").keyup(function(){
		var email = $("#email").val();
		if(email){
			$.ajax({
				url : 'validate.php?email='+email,
				success:function(data){
					//alert(data);
					if(data == 1){
						$("#messsage").hide(data);
						$("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					}else{
						$("#email_msg").hide();
					}
				}
			});
		}
	});
	$("#email,#user_name").on('click',function(){
		
		var email = $("#email").val();
		if(email){
			$.ajax({
				url : 'validate.php?email='+email,
				success:function(data){
					//alert(data);
					if(data == 1){
						$("#messsage").hide(data);
						$("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					}else{
						$("#email_msg").hide();
					}
				}
			});
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".hotel_ss").hide();
		$(".user_type").on('change',function(){
			var type = $(this).val();
			if(type == 'Manager'){
				$(".hotel_ss").show();
			}else{
				$(".hotel_ss").hide();
			}

			if(type == 'Super Admin'){
				$(".hummingbird-treeview").hide();
			}else{
				$(".hummingbird-treeview").show();
			}
		});
	});
</script>
<script type="text/javascript">
	function avoidSpace(event){
		var k = event ? event.which : window.event.keycode;
		if(k==32)
			return false;
	}
	$("#add_user_btn").click(function(event){
        event.preventDefault();
        var formData = new FormData($("#add_user_form")[0]);
        var password = $("#password").val();
        var cnf_pass = $("#c_password").val();
        var user_name = $("#user_name").val();
        //var previleges = $("#add_user_form").serialize();
       // alert(previleges);
        
        if(password == cnf_pass){
        	$.ajax({
	          	url: 'insert_data.php?type=Add-User',
	          	type: 'POST', 
	          	data: formData,
	          	async: false,
	          	cache: false,
	          	contentType: false,
	          	processData: false,
	          	beforeSend: function() {
	              $(".modallodar").show();
	           	},
	          	success: function (data) {
	          		
	          		$(".modallodar").hide();
		            if(data == 0){
						$("#add_user_form")[0].reset();
						$("#message").html("<div class='alert alert-success'>Your data has been successfully saved.<div>");
					}else if(data == 1){
						$("#message").html("<div class='alert alert-danger'>Please fill out all required fields marked with an asterisk.<div>");
					}else if(data == 2){
						$("#message").html("<div class='alert alert-danger'>Passwrod dosen't match.<div>");
					}else{
						$("#message").html("<div class='alert alert-danger'>Something is wrong pleae try again later.<div>");
					}
		        }
	        });
        }else{
        	$(".match").html("<span style='color:red;'>Passwrod doesn't match</span>");
        	return false;
        }
    });
</script>
</body>
</html>
