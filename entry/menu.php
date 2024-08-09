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

<link rel="stylesheet" href="css/pagination.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">			
<div class="content">
	<div class="idealsteps-container">
		<form action="" class="idealforms" id="menu_form" enctype="multipart/form-data" method="post" role="form" name="menu_form" >
			<div class="idealsteps-wrap">
				<!-- Step 1 -->
				<section class="idealsteps-step" data-step="0">
					<h4 style="margin-left: 30px;">Add Menu</h4>
					<div id="message"></div>
					<div class="field">
						<input type="hidden" name="id" value="<?php if(!empty($_GET['id'])) echo $_GET['id']; ?>">
						<label class="main">Menu Name<span style="color:red;">* </span>:</label>
						<?php if(isset($_SESSION['m_name'])) { ?>
						<input name="m_name" id="m_name"  value="<?php echo $_SESSION['m_name'];?>" type="text" class="ipt"  placeholder="Menu" style="text-transform: capitalize;">
						<?php } else { ?>
						<input name="m_name" id="m_name" type="text" value="<?php if(isset($hoteldetails['menu'])) echo $hoteldetails['menu']; ?>" class="ipt"  placeholder="Menu" style="text-transform: capitalize;">
						<?php } ?>
					</div>
					
					<div class="footer">
						<div class="field buttons">
							<label class="main">&nbsp;</label>
							<input type="button" class="reset" id="reset_day_book" value="Reset" />
							<input type="button" id="menu_btn" name="menu_btn" class="next" value="Submit" />
						
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

<!-- validation -->
<script type="text/javascript">
    $("#menu_btn").click(function(e){
        var m_name = $("#m_name");
       
        if(!m_name.val()){
        	$("#m_name").css("border", "1px solid red");
        	$("#m_name").focus();
        }
    });

</script>

<script type="text/javascript">
	$("#hotel").click(function(event){
        event.preventDefault();
        var formData = new FormData($("#menu_form")[0]);
        
        $.ajax({
          	url: 'insert_data.php?type=add_menu',
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
					$("#menu_form")[0].reset();
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
