<?php 
include('../include/header.php');
include_once ("../include/pagination_function.php");
$pg_obj = new PaginationFunction();
include('is_login.php');

if(isset($_GET["page"]))

  $page = (int)$_GET["page"];
 
  else
 
  $page = 1;

  $setLimit =100;

  $pageLimit = ($page * $setLimit) - $setLimit;

  $hotel = $obj->getAllInsertedhotelDetails($setLimit, $pageLimit);


if(isset($_GET['edit']) && $_GET['edit'] == 'y'){

  $id = $_GET['id'];

  $hoteldetails = $obj->getInsertedHotelDetailsById($id);

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
/*search list*/
#city_list {
    float: left;
    list-style: none;
    margin-top: 14px;
    margin-left: -50px;
    padding: 0;
    width: 460px;
    position: absolute;
    z-index: 100;
}
#city_list li {
    padding: 10px;
    background: #f34343;
    border-bottom: #bbb9b9 1px solid;
}

#state_list {
    float: left;
    list-style: none;
    margin-top: 14px;
    margin-left: -50px;
    padding: 0;
    width: 460px;
    position: absolute;
    z-index: 100;
}
#state_list li {
    padding: 10px;
    background: #f34343;
    border-bottom: #bbb9b9 1px solid;
}

#country_list {
    float: left;
    list-style: none;
    margin-top: 14px;
    margin-left: -50px;
    padding: 0;
    width: 460px;
    position: absolute;
    z-index: 100;
}
#country_list li {
    padding: 10px;
    background: #f34343;
    border-bottom: #bbb9b9 1px solid;
}


</style>
<link rel="stylesheet" href="css/pagination.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">			
<div class="content">
	<div class="idealsteps-container">
		<form action="" class="idealforms" id="hotel_details" enctype="multipart/form-data" method="post" role="form" name="hotel_details" >
			<div class="idealsteps-wrap">
				<!-- Step 1 -->
				<section class="idealsteps-step" data-step="0">
					<h4>Hotels Detalis</h4>
					<div id="message"></div>
					<div class="field">
						<input type="hidden" name="id" value="<?php if(!empty($_GET['id'])) echo $_GET['id']; ?>">
						<label class="main">Hotel Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['h_name'])) { ?>
						<input name="h_name" id="h_name"  value="<?php echo $_SESSION['h_name'];?>" type="text" class="ipt"  placeholder="Hotel Name" style="text-transform: capitalize;">
						<?php } else { ?>
						<input name="h_name" id="h_name" type="text" value="<?php if(isset($hoteldetails['hotel_name'])) echo $hoteldetails['hotel_name']; ?>" class="ipt"  placeholder="Hotel Name" style="text-transform: capitalize;">
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Contact Person<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['contp'])) { ?>
						<input name="contp" id="contp"  value="<?php echo $_SESSION['contp'];?>" type="text" class="ipt"  placeholder="Contact Person Name" style="text-transform: capitalize;">
						<?php } else { ?>
						<input name="contp" id="contp" type="text" value="<?php if(isset($hoteldetails['contact_person'])) echo $hoteldetails['contact_person']; ?>" class="ipt"  placeholder="Contact Person Name" style="text-transform: capitalize;">
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Designation<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['contact_p_desi'])) { ?>
						<input name="cont_desi" id="cont_desi"  value="<?php echo $_SESSION['contact_p_desi'];?>" type="text" class="ipt"  placeholder="Contact Person Designation" style="text-transform: capitalize;">
						<?php } else { ?>
						<input name="cont_desi" id="cont_desi" type="text" value="<?php if(isset($hoteldetails['designation'])) echo $hoteldetails['designation']; ?>" class="ipt"  placeholder="Contact Person Designation" style="text-transform: capitalize;">
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">E-mail ID<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['maillist'])) { ?>
						<input name="maillist" id="maillist"  value="<?php echo $_SESSION['mailid'];?>" type="text" class="ipt"  placeholder="Enter Mail Id">
						<?php } else { ?>
						<input name="maillist" id="maillist" type="text" value="<?php if(isset($hoteldetails['email'])) echo str_replace('<br>',',',$hoteldetails['email']); ?>" class="ipt"  placeholder="Multipal email sepereate by comma(,)">
						<?php } ?>
						</br>
						<span id="email_erro" style="color: red;margin-left: 120px;"></span>
					</div>
					<div class="field">
						<label class="main">Contact Number<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['contactno'])) { ?>
						<input name="contactno" id="contactno"  value="<?php echo $_SESSION['contactno'];?>" type="text" class="ipt"  placeholder="Enter phone number">
						<?php } else { ?>
						<input name="contactno" id="contactno" type="text" value="<?php if(isset($hoteldetails['phone'])) echo $hoteldetails['phone']; ?>" class="ipt"  placeholder="Contact Number"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Address<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['address'])) { ?>
						<input name="address" id="address"  value="<?php echo $_SESSION['address'];?>" type="text" class="ipt"  placeholder="Address" style="text-transform: capitalize;"></br>
						<?php } else { ?>
						<input name="address" id="address" type="text" value="<?php if(isset($hoteldetails['address'])) echo $hoteldetails['address']; ?>" class="ipt"  placeholder="Address" style="text-transform: capitalize;"></br>
						<?php } ?>
					</div>
					<div class="clear"></div>
					<div class="field">
						<label class="main">City:</label>
						<?php if(isset($_SESSION['city'])) { ?>
						<input name="city" id="city" value="<?php echo $_SESSION['city'];?>" type="text" class="ipt"  placeholder="City" autocomplete="off" style="text-transform: capitalize;"></br>
						<?php } else { ?>
						<input name="city" id="city" type="text" value="<?php if(isset($hoteldetails['city'])) echo $hoteldetails['city']; ?>" class="ipt"  placeholder="City" autocomplete="off" style="text-transform: capitalize;"></br>
						<?php } ?>
						<div id="city_list"></div>
					
					</div>
					<div class="field">
						<label class="main">State<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['state'])) { ?>
						<input name="state" id="state"  value="<?php echo $_SESSION['state'];?>" type="text" class="ipt"  placeholder="state" autocomplete="off" style="text-transform: capitalize;"></br>
						<?php } else { ?>
						<input name="state" id="state" type="text" value="<?php if(isset($hoteldetails['state'])) echo $hoteldetails['state']; ?>" class="ipt"  placeholder="state" autocomplete="off" style="text-transform: capitalize;"></br>
						<?php } ?>
						<div id="state_list"></div>
					
					</div>
					<div class="field">
						<label class="main">Pincode:</label>
						<?php if(isset($_SESSION['pincode'])) { ?>
						<input name="pincode" id="pincode"  value="<?php echo $_SESSION['pincode'];?>" type="text" class="ipt"  placeholder="Pincode"></br>
						<?php } else { ?>
						<input name="pincode" id="pincode" type="text" value="<?php if(isset($hoteldetails['pincode'])) echo $hoteldetails['pincode']; ?>" class="ipt"  placeholder="Pincode"></br>
						<?php } ?>
					</div>
					<div class="field">
						<label class="main">Country<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['country'])) { ?>
						<input name="country" id="country"  value="<?php echo $_SESSION['country'];?>" type="text" class="ipt"  placeholder="Country" autocomplete="off" style="text-transform: capitalize;"></br>
						<?php } else { ?>
						<input name="country" id="country" type="text" value="<?php if(isset($hoteldetails['country'])) echo $hoteldetails['country']; ?>" class="ipt"  placeholder="Country" autocomplete="off" style="text-transform: capitalize;"></br>
						<?php } ?>
						<div id="country_list"></div>

					</div>
					<div class="field">
						<label class="main">Website:</label>
						<?php if(isset($_SESSION['website'])) { ?>
						<input name="website" id="website"  value="<?php echo $_SESSION['website'];?>" type="text" class="ipt"  placeholder="Enter website"></br>
						<?php } else { ?>
						<input name="website" id="website" type="text" value="<?php if(isset($hoteldetails['website'])) echo $hoteldetails['website']; ?>" class="ipt"  placeholder="Enter website"></br>
						<?php } ?>
					</div>
					
					<div class="clear"></div>
					
					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" class="reset" id="reset_day_book" value="Reset" />
							<input type="button" id="hotel" name="hotel" class="next" value="Submit" />
						
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
		<div id="tableheader">
		    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
		      <div class="search">
		        <input id="search_name" name="search_name" type="text" placeholder="Search by Contact number" autocomplete="off"/>
		        <button id="search_gks" type="button" class="btn btn-default" style="padding-top: 10px;padding-bottom: 9px;border: #499f4d 1px solid;background-color:#499f4d!important;border-radius: 0px;">
		          <span class="glyphicon glyphicon-search"></span> Search
		        </button>
		        <img class="modallodar1" style="display: none" alt="" src="ajax-loader.gif" />
		      </div>
		    </form>
		</div>
		
		<div class="row">
		  <div class="col-lg-1 col-md-1 col-sm-1"></div>
		  <div class="col-lg-10 col-md-10 col-sm-10">
		    <div id="paginator"></div>
		    <div class="loader text-center" style="display: none;">
		      <img src="ajax-loader.gif">
		    </div>
		  </div>
		  <div class="col-lg-1 col-md-1 col-sm-1"></div>

		</div>
		<br/>
		<div id="show_data"></div>
		<div id="tablesearch_top">
			<section>
		    	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
	                <thead>
	                    <tr>
	                        <th><h3>S.N.</h3></th>
	                        <th><h3>Name</h3></th>
	                        <th><h3>Contact Person</h3></th>
	                        <th><h3>Designation</h3></th>
	                        <th><h3>Mail List</h3></th>
	                        <th><h3>Contact Number</h3></th>
	                        <th><h3>Location(Full Address)</h3></th>
	                        <th><h3>Website</h3></th>
	                        <th><h3>&nbsp;</h3></th>
			            	<th><h3>&nbsp;</h3></th>
	                    </tr>
	                </thead>
	                 <tbody>
	                    <?php 
	                        $i=1;
	                        if(!empty($hotel)){
	                        foreach ($hotel as $hot_category) {
	                            $location = "";
	                            $location = $hot_category['address'];
	                            if(!empty($hot_category['city'])){
	                            	$location .= ','.$hot_category['city'];
	                            }
	                            if(!empty($hot_category['state'])){
	                            	$location .= ','.$hot_category['state'];
	                            }
	                            if(!empty($hot_category['pincode'])){
	                            	$location .= '-'.$hot_category['pincode'];
	                            }
	                            if(!empty($hot_category['country'])){
	                            	$location .= ','.$hot_category['country'];
	                            }
	                            //`hotel_name`, `contact_person`, `designation`, `email`, `phone`, `address`, `city`, `state`, `pincode`, `country`, `website`, `inserted_date`

	                    ?>
	                    <tr id="<?php echo $hot_category['hotel_details_id'];?>">
		                    <td><?php echo $i++;?></td>
		                    <td><?php echo $hot_category['hotel_name'];?></td>
		                   	<td><?php echo $hot_category['contact_person'];?></td>
		                   	<td><?php echo $hot_category['designation'];?></td>
		                    <td><?php echo $hot_category['email'];?></td>
		                    <td><?php echo $hot_category['phone'];?></td> 
		                    <td><?php echo $location;?></td> 
		                    <td><?php echo $hot_category['website'];?></td> 
		                    <td class="name">
		                        <a href="hotel-details.php?edit=y&id=<?php echo $hot_category['hotel_details_id'];?>" class="btn">Edit</a>
		                    </td>
		                    <td class="name"><a href="##" class="delete" title="<?php echo $hot_category['hotel_details_id'];?>" id="btn_r1">Delete</a></td>
	                    </tr>
	                    <?php } } ?>
	                </tbody>
	             </table>
	              <?php   
	              		echo $pg_obj->displayAllInsertedHotelDetailsPagination($setLimit, $page);
	              ?>
	        </section>
        </div>
        <div id="tablesearch">
		    <section>
		      <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
		        <thead>
		          	<tr>
	                    <th><h3>S.N.</h3></th>
	                    <th><h3>Name</h3></th>
	                    <th><h3>Contact Person</h3></th>
	                    <th><h3>Designation</h3></th>
	                    <th><h3>Mail List</h3></th>
	                    <th><h3>Contact Number</h3></th>
	                    <th><h3>Location(Full Address)</h3></th>
	                    <th><h3>Website</h3></th>
	                    <th><h3>&nbsp;</h3></th>
		            	<th><h3>&nbsp;</h3></th>
	                </tr>
		        </thead>
		        <tbody></tbody>
		      </table>
		    </section>
  		</div>
  		<p>&nbsp;</p>
  		<p>&nbsp;</p>
  		<p>&nbsp;</p>
  		<p>&nbsp;</p>
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
            	window.location.href='hotelagent.php';
          	}
      	});
   	});

	$('form.idealforms').idealforms('addRules', {
		'comments': 'required minmax:50:200'
	});

</script>
<!-- autocomplete script-->
<script type="text/javascript">
	$(document).ready(function(){
		$("#city").keyup(function(){
			var query = $(this).val();
			if(query != ""){
				$.ajax({
					url : "get_city.php?query="+query,
					success:function(data){
						$("#city_list").fadeIn();
						$("#city_list").html(data);
					}
				});
			}
		});

		$(document).on("click","#city_list li",function(){
			$("#city").val($(this).text());
			$("#city_list").fadeOut();
		});
		$(document).on("click",function(){
			$("#city_list").fadeOut();
		});



		$("#state").keyup(function(){
			var query = $(this).val();
			if(query != ""){
				$.ajax({
					url : "get_state.php?query="+query,
					success:function(data){
						$("#state_list").fadeIn();
						$("#state_list").html(data);
					}
				});
			}
		});

		$(document).on("click","#state_list li",function(){
			$("#state").val($(this).text());
			$("#state_list").fadeOut();
		});
		$(document).on("click",function(){
			$("#state_list").fadeOut();
		});


		$("#country").keyup(function(){
			var query = $(this).val();
			if(query != ""){
				$.ajax({
					url : "get_country.php?query="+query,
					success:function(data){
						$("#country_list").fadeIn();
						$("#country_list").html(data);
					}
				});
			}
		});

		$(document).on("click","#country_list li",function(){
			$("#country").val($(this).text());
			$("#country_list").fadeOut();
		});
		$(document).on("click",function(){
			$("#country_list").fadeOut();
		});
	});


</script>
<!-- validation -->
<script type="text/javascript">
      $("#hotel").click(function(e){

        var name = $("#name");

        var contp = $("#contp");
       
        var maillist = $("#maillist");

        var contactno = $("#contactno");

        var location = $("#location");
        var address = $("#address");

        var state = $("#state");

        var country = $("#country");
       
        if(!contactno.val()){
        	$("#contactno").css("border", "1px solid red");
        	$("#contactno").focus();
        }

        if(!location.val()){
        	$("#location").css("border", "1px solid red");
        	$("#location").focus();
        }

        if(!maillist.val()){

          $("#maillist").css("border", "1px solid red");

          $("#maillist").focus();

          e.preventDefault();

        }


        if(!address.val()){
        	$("#address").css("border", "1px solid red");
        	$("#address").focus();
        }

        if(!state.val()){
        	$("#state").css("border", "1px solid red");
        	$("#state").focus();
        }

        if(!country.val()){
          $("#country").css("border", "1px solid red");
          $("#country").focus();
          e.preventDefault();

        }


        if(!contp.val()){

          $("#contp").css("border", "1px solid red");

          $("#contp").focus();

          e.preventDefault();

        }
        
        if(!name.val()){

          $("#name").css("border", "1px solid red");

          $("#name").focus();

          e.preventDefault();

        }

      });

    </script>

<script type="text/javascript">
	$("#hotel").click(function(event){
        event.preventDefault();
        var formData = new FormData($("#hotel_details")[0]);
        
        $.ajax({
          	url: 'insert_data.php?type=hotel_details',
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
					$("#hotel_details")[0].reset();
					$("#message").html("<div class='alert alert-success'>Your data has been successfully saved.<div>");
				}else if(data == 1){
					
					$("#message").html("<div class='alert alert-danger'>Please fill in all required fields marked with an asterisk.<div>");
				}else if(data == 2){
					$("#message").html("<div class='alert alert-success'>Your Data successfully Updated.<div>");

				}else{
					$("#messsage").html("<div class='alert alert-danger'>"+data+"</div>");
				}
	        }
        });
        return false;
    });

   /* delete */

		$(document).on("click",".delete",function(){
		  var id = $(this).attr('title');
		  
		  if(confirm("Are you sure you want to delete this?")){
		    $.ajax({
		      url : 'delete.php?type=delete_hotel&id='+id,
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
          url: "search_hotels_details.php",
          data: { query: query_value },
          cache: false,
          beforeSend: function () {
             $(".modallodar1").show();
          },
          success: function(html){
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
