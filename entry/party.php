<?php 
include('../include/header.php');
include('is_login.php');


$parties = $obj->getPartyDetails();

if(isset($_GET['edit']) && $_GET['edit'] == 'y'){

  $id = $_GET['id'];

  $party_update = $obj->getPartyDetailsForUpdate($id);

}

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
h3 {
    width: 80px;
}
</style>
<link rel="stylesheet" href="css/pagination.css">				
<div class="content">
	<div class="idealsteps-container">
		<form action="" class="idealforms" id="party_details" enctype="multipart/form-data" method="post" role="form" name="party_details" >
			<div class="idealsteps-wrap">
				<!-- Step 1 -->
				<section class="idealsteps-step" data-step="0">
					<h4>Add Party Detalis</h4>
					<div id="message"></div>
					<div class="field">
						<input type="hidden" name="id" value="<?php if(!empty($_GET['id'])) echo $_GET['id']; ?>">
						<label class="main">Name<span style="color:red;">* </span>:</label>
						<input name="name" id="name" type="text" value="<?php if(isset($party_update['category_name'])) echo $party_update['category_name']; ?>" class="ipt"  placeholder="Enter Name">
					</div>
					<div class="field">
						<label class="main">Phone Number:</label>
						<input name="phone" id="phone" type="text" value="<?php if(isset($party_update['phone'])) echo $party_update['phone']; ?>" class="ipt"  placeholder="phone">
					</div>
					<div class="field">
						<label class="main">Email ID:</label>
						<input name="mailid" id="mailid" type="text" value="<?php if(isset($party_update['email'])) echo $party_update['email']; ?>" class="ipt"  placeholder="Mail id">
						</br>
						<span id="email_erro" style="color: red;margin-left: 120px;"></span>
					</div>

					<div class="field">
						<label class="main">GSTIN:</label>
						<input name="gstin" id="gstin" type="text" value="<?php if(isset($party_update['gstin'])) echo $party_update['gstin']; ?>" class="ipt"  placeholder="GSTIN"></br>
					</div>
					<div class="clear"></div>
					<div class="field">
						<label class="main">Address Line1:</label>
						<input name="addressl1" id="addressl1" type="text" value="<?php if(isset($party_update['addressl1'])) echo $party_update['addressl1']; ?>" class="ipt"  placeholder="Address Line1">
					</div>
					<div class="field">
						<label class="main">Address Line2:</label>
						<input name="addressl2" id="addressl2" type="text" value="<?php if(isset($party_update['addressl2'])) echo $party_update['addressl2']; ?>" class="ipt"  placeholder="Address Line2">
					</div>
					<div class="field">
						<label class="main">Address Line3:</label>
						<input name="addressl3" id="addressl3" type="text" value="<?php if(isset($party_update['addressl3'])) echo $party_update['addressl3']; ?>" class="ipt"  placeholder="Address Line3">
					</div>
					<div class="field">
						<label class="main">State:</label>
						<input name="state" id="state" type="text" value="<?php if(isset($party_update['state'])) echo $party_update['state']; ?>" class="ipt"  placeholder="State">
					</div>
					
					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" class="reset" id="reset_day_book" value="Reset" />
							<input type="button" id="party" name="party" class="next" value="Submit" />
						
						</div>
						<div id='loadingmessage' style="display: none;">
						  <img src='ajax-loader.gif'/>
						</div>
					</div>
				</section>
			</div>
		</form>
	</div>

</div>   
	<div id="tablewrapper">
		<br/>
		<div id="show_data"></div>
		<div id="tablesearch_top">
			<section>
		    	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
	                <thead>
	                    <tr>
	                        <th><h3>S.N.</h3></th>
	                        <th><h3>Name</h3></th>
	                        <th><h3>Phone </h3></th>
	                        <th><h3>Email ID</h3></th>
	                        <th><h3>GSTIN</h3></th>
	                        <th><h3>Address Line1</h3></th>
	                        <th><h3>Address Line2</h3></th>
	                        <th><h3>Address Line3</h3></th>
	                        <th><h3>&nbsp;</h3></th>
			            	<th><h3>&nbsp;</h3></th>
	                    </tr>
	                </thead>
	                 <tbody>
	                    <?php 
	                        $i=1;
	                        foreach ($parties as $party) {
	                    ?>
	                    <tr id="<?php echo $party['booking_via_id'];?>">
		                    <td class="name"><?php echo $i++;?></td>
		                    <td class="name"><?php echo $party['category_name'];?></td>
		                   	<td class="name"><?php echo $party['phone'];?></td>
		                    <td class="name"><?php echo $party['email'];?></td>
		                    <td class="name"><?php echo $party['gstin'];?></td>
		                    <td class="name"><?php echo $party['addressl1'];?></td> 
		                    <td class="name"><?php echo $party['addressl2'];?></td> 
		                    <td class="name"><?php echo $party['addressl3'];?></td> 
		                    <td class="name">
		                        <a href="party.php?edit=y&id=<?php echo $party['booking_via_id'];?>" class="btn">Edit</a>
		                    </td>
		                    <td class="name"><a href="#" class="delete" title="<?php echo $party['booking_via_id'];?>" id="btn_r1">Delete</a></td>
	                    </tr>
	                    <?php } ?>
	                </tbody>
	             </table>
	             <p>&nbsp;</p>
	             <p>&nbsp;</p>
	             <p>&nbsp;</p>
	        </section>
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
            	window.location.href='party.php';
          	}
      	});
   	});

	$('form.idealforms').idealforms('addRules', {
		'comments': 'required minmax:50:200'
	});
</script> 
<!-- validation -->
<script type="text/javascript">
      $("#party").click(function(e){
  
        var name = $("#name");
        if(!name.val()){
        	$("#name").css("border", "1px solid red");
        	$("#name").focus();
        }

        if(name.val()){
        	$("#name").css("");
        }
      });

    </script>

<script type="text/javascript">
	$("#party").click(function(event){
        event.preventDefault();
        var formData = new FormData($("#party_details")[0]);
        $.ajax({
          	url: 'insert_data.php?type=party_details',
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
					$("#party_details")[0].reset();
					$("#message").html("<div class='alert alert-success'>Your data has been successfully saved.<div>");
				}else if(data == 1){
					
					$("#message").html("<div class='alert alert-danger'>Please fill in all required fields marked with an asterisk.<div>");
				}else if(data == 2){
					$("#party_details")[0].reset();
					$("#message").html("<div class='alert alert-success'>Your Data successfully Updated.<div>");

				}else{
					$("#messsage").html("<div class='alert alert-danger'>"+data+"</div>");
				}
	        }
        });
        return false;
    });

   /* delete */

		$(".delete").click(function(){
		  var id = $(this).attr('title');
		  
		  if(confirm("Are you sure you want to delete this?")){
		    $.ajax({
		      url : 'delete.php?type=delete_party&id='+id,
		      type : 'POST',
		      success:function(res){
		        if(res == 0){
		          $("#error").hide();
		          $("tr#"+id).css("background-color","#ccc");
		          $("tr#"+id).fadeOut("slow");
		        }else{
		          $("#error").show().html("<div class='alert alert-danger'>Error! Please try again later.</div>");
		        }
		      }
		    });
		  }else{
		    return false;
		  }
		});

</script>

<!--Email validation and dupli-->
<script type="text/javascript">
	$("#mailid").keyup(function(){
		var email = $("#mailid").val();
		if(email){
			$.ajax({
				url : 'validate.php?email='+email,
				success:function(data){
					//alert(data);
					if(data == 1){
						$("#message").hide(data);
						$("#email_erro").show().html("<span>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					}else{
						$("#email_erro").hide();
						$.ajax({
							url : 'insert_data.php?mailid='+email,
							success:function(data){
								if(data == ""){
									$("#message").hide();
								}else{
									$("#message").show().html("<div class='alert alert-danger'>"+data+"</div>");
								}
							}
						});
					}
				}
			});
		}
	});

</script>

<script type="text/javascript">
	$("#mailid,#phone").click(function(){
		var email = $("#mailid").val();
		if(email){
			$.ajax({
				url : 'validate.php?email='+email,
				success:function(data){
					if(data == 1){
						$("#message").hide(data);
						$("#email_erro").show().html("<span>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					}else{
						$("#email_erro").hide();
						$.ajax({
							url : 'insert_data.php?mailid='+email,
							success:function(data){
								if(data == ""){
									$("#message").hide();
								}else{
									$("#message").show().html("<div class='alert alert-danger'>"+data+"</div>");
								}
								
							}
						});
					}
				}
			});
		}
	});
</script>

<script type="text/javascript">

  $(document).ready(function() {  
    $("#tablesearch").hide();
    // Search
    $("#search_gks").on('click',function(){

      var query_value = $('input#search_name').val();
      
      if(query_value !== ''){
        $.ajax({
          type: "POST",
          url: "travel_search.php",
          data: { query: query_value },
          cache: false,
          beforeSend: function () {
             $(".modallodar1").show();
          },
          success: function(html){
          	//alert(html);
            $(".modallodar1").hide();
            $("table#resultTable tbody").html(html);
            $("#tablesearch_top").hide();
            $("#tablesearch").show();
          }
        });
      }return false;
    });

    $("input#search_name").on("keyup", function(e) {
      var search_string = $(this).val();
      // Do Search
      if (search_string == '') {
        $("#tablesearch_top").show();
        $("#tablesearch").hide();
      }
    });
  });    
</script>


</body>
</html>
