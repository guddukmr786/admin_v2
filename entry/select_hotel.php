<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotels = $obj->getHotels();
?>

<!--hotel transfer modal -->
	<?php if(isset($_GET['empid'])){?>
	<h3 class="text-center" style="color:#035CA7">Transfer Employee details to another hotel</h3>
	<?php } else { ?>
	<h3 class="text-center" style="color:#035CA7">Transfer guest arrival list to another hotel</h3>
	<?php } ?>
		<span class="success"></span>
		<form class="idealforms" id="extend_form" enctype="multipart/form-data" role="form" name="extend_form">
			<?php if(isset($_GET['empid'])){ ?>

			<input type="hidden" name="empid" id="empid" value="<?php echo $_GET['empid']; ?>">
			<input type="hidden" name="name" id="name" value="<?php echo $_POST['name']; ?>">
			<input type="hidden" name="phone" id="phone" value="<?php echo $_POST['phone']; ?>">
			
			<?php } else { ?>

			<input type="hidden" name="id" id="id" value="<?php echo $_GET['arrival_b_id']; ?>">

			<?php } ?>

			<div class="field" style="padding-left:230px">
				<label class="main">Select Hotel<span style="color:red;"> * </span>:</label>
				<select name="h_id" id="selectt" class="h_id">
					<option value="">Select your hotel</option>
					<?php foreach($hotels as $hotel){ ?>
					<option value="<?php echo $hotel['hotel_id'];?>"><?php echo $hotel['hotel_name'];?></option>
					<?php } ?>
				</select>
			</div>
			<br/>
    		<br/>
			<h4><input type="button" name="transfer_hotel" id="transfer_hotel" value="Submit" style="padding:5px 10px 5px 10px;" ></h4>
		</form>
  	<a class="close" href=""></a> 
</div>
<script src="js/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){

	$(".h_id").click(function(){
		$(".h_id").css("border","");
	});

	$('#transfer_hotel').on('click', function(e) {
		var h_id = $(".h_id");
		if(!h_id.val()) {
			$('.h_id').css("border", "1px solid red");
			$('.h_id').focus();
			e.preventDefault();
		} 
	});

	$("#transfer_hotel").click(function(){
		if($("#empid").val()){
			var empid = $("#empid").val();
			var data = $("#extend_form").serialize();
		}else{
			var id = $("#id").val();
		}
		var h_id = $(".h_id").val();
		
		if(h_id && empid){
			//for employees details
			$.ajax({
				url : 'insert_data.php?type=employee_transfer&h_id='+h_id+'&empid='+empid,
				type : 'POST',
				data : data,
				success:function(data){
					
					if(data == 0){
						$("#extend_form")[0].reset();
						$(".success").html("<div class='alert alert-success'>Successfully transferred arrival booking</div>");
					}else if(data == 1){
						$(".success").html("<div class='alert alert-danger'>Error...Please try again later.</div>");
						setTimeout(function(){location = 'view_arrival_booking_list.php'},10000);
					}
				}
			});
		}else if(h_id && id){
			//for arrival list booking
			$.ajax({
				url : 'insert_data.php?type=arrival_booking_transfer&h_id='+h_id+'&id='+id,
				success:function(data){
					if(data == 0){
						$("#extend_form")[0].reset();
						$(".success").html("<div class='alert alert-success'>Successfully transferred arrival booking</div>");
					}else if(data == 1){
						$(".success").html("<div class='alert alert-danger'>Error...Please try again later.</div>");
						setTimeout(function(){location = 'view_arrival_booking_list.php'},10000);
					}
				}
			});
		}
		
	});

});	
</script>

