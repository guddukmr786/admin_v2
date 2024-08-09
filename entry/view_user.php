<?php 
include_once('../include/header.php');

include_once ("../include/pagination_function.php");//include of paginat page
$pg_obj = new PaginationFunction();

include('is_login.php');

if(isset($_GET["page"]))
$page = (int)$_GET["page"];
else
$page = 1;
$setLimit = 40;
$pageLimit = ($page * $setLimit) - $setLimit;
$details = $obj->getToatalUsersDetails($setLimit, $pageLimit);


$inactive_details = $obj->getToatalInactiveUsersDetails($setLimit, $pageLimit);


?>
<!-- Paginator css-->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-datepicker.css" rel="stylesheet" media="screen">
<link href="css/bootstrap-datepaginator.css" rel="stylesheet" media="screen">
<style type="text/css">
  .btn-default{
    background-color: #499f4d!important;
  }
  .btn-default:hover{
    background-color: #a9d8ab!important;
  }

</style>
<style>
/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
#Active{
  display: block;
}

</style>
<!--end Paginator css-->
<link rel="stylesheet" href="css/pagination.css">
<div id="tablewrapper">
  <div id="tableheader">
    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
      <div class="search">
        <input id="name" name="name" type="text" placeholder="Search by name" autocomplete="off"/>
        <button type="button" id="search_gks" class="btn btn-default" style="padding-top: 10px;padding-bottom:10px;border: #499f4d 1px solid;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
        </button>
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>
    <div class="tab">
      <button class="tablinks Active" onclick="openCity(event, 'Active')">Active Users</button>
      <button class="tablinks Inactive" onclick="openCity(event, 'Inactive')">Inactive Users</button>
    </div>
  </div>
<div id="show_data"></div>
<div id="tablesearch_top">
  <!-- This code for recheckin-->
    
      <div id="Active" class="tabcontent">
        <section>
          <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
            <thead>
              <tr>
                <th><h3>S.No.</h3></th>
                <th><h3>Name</h3></th>
                <th><h3>User Name</h3></th>
                <th><h3>E-mail ID</h3></th>
                <th><h3>IP Address</h3></th>
                <th><h3>Last Login</h3></th>
                <th><h3>User Type</h3></th>
                <th><h3>Previleges</h3></th>
                <th><h3>Created Date</h3></th>
                <th><h3>Status</h3></th>
                <th><h3>&nbsp;</h3></th>
                <th><h3>&nbsp;</h3></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $i=1;
               
                if(!empty($details)){
                  foreach ($details as $detail) { 
              ?>
              <tr id_value="<?php echo $detail['admin_id'];?>">
                <td class="name"><?php echo  $i++;?></td>
                <td class="name"><?php echo $detail['name'] ;?></td>
                <td class="name"><?php echo $detail['user_name'];?><p></p></td>
                <td class="name"><?php echo $detail['email'];?></td>
                <td class="name"><?php echo $detail['ip_address'];?></td>
                <td class="name"><?php echo $detail['last_login'];?></td>
                <td class="name"><?php echo $detail['user_type_hai'];?></td>
                <td class="name"><?php echo $detail['previleges'];?></td>
                <td class="name"><?php echo $detail['created_date'];?></td>
                <?php if($detail['status'] == 0){ ?>

                <td class="name"><select style="padding:5px 0px 5px 5px;" name="<?php echo $detail['admin_id'];?>" id="active"><option value="0" selected="selected">Active</option><option value="1">Inactive</option></select>
                <img class="modallodard<?php echo $detail['admin_id'];?>" style="display: none" alt="" src="images/ajax-loader-search.gif" />
                </td>

                <?php } else { ?>

                <td class="name"><select  style="padding:5px 0px 5px 5px;" name="<?php echo $detail['admin_id'];?>" id="active"><option value="0">Active</option><option value="1" selected="selected">Inactive</option></select>
                  <img class="modallodard<?php echo $detail['admin_id'];?>" style="display: none" alt="" src="images/ajax-loader-search.gif" />
                </td>

                <?php } ?>

                <td class="name"><a href="#change_pass" data-toggle="modal-pass"  id="<?php echo $detail['admin_id'];?>" class="btn">Change Passwrod</a></td>
                <td class="name"><a href="#user_edit" data-toggle="modaluser"  id="<?php echo $detail['admin_id'];?>" class="btn">Edit</a>
                
                </td>
               
              </tr>
            <?php } } else { ?>
              <tr><td colspan="10" style="height:50px;"><h1>No record found.</h1></td></tr>
            <?php } ?>
            </tbody>
          </table>
        </section>
      </div>

      <div id="Inactive" class="tabcontent">
        <section>
          <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
            <thead>
              <tr>
                <th><h3>S.No.</h3></th>
                <th><h3>Name</h3></th>
                <th><h3>User Name</h3></th>
                <th><h3>E-mail ID</h3></th>
                <th><h3>IP Address</h3></th>
                <th><h3>Last Login</h3></th>
                <th><h3>User Type</h3></th>
                <th><h3>Previleges</h3></th>
                <th><h3>Created Date</h3></th>
                <th><h3>Status</h3></th>
                <th><h3>&nbsp;</h3></th>
                <th><h3>&nbsp;</h3></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $i=1;
               
                if(!empty($inactive_details)){
                  foreach ($inactive_details as $detail) { 
              ?>
              <tr id_value="<?php echo $detail['admin_id'];?>">
                <td class="name"><?php echo  $i++;?></td>
                <td class="name"><?php echo $detail['name'] ;?></td>
                <td class="name"><?php echo $detail['user_name'];?><p></p></td>
                <td class="name"><?php echo $detail['email'];?></td>
                <td class="name"><?php echo $detail['ip_address'];?></td>
                <td class="name"><?php echo $detail['last_login'];?></td>
                <td class="name"><?php echo $detail['user_type_hai'];?></td>
                <td class="name"><?php echo $detail['previleges'];?></td>
                <td class="name"><?php echo $detail['created_date'];?></td>
                <?php if($detail['status'] == 0){ ?>

                <td class="name"><select style="padding:5px 0px 5px 5px;" name="<?php echo $detail['admin_id'];?>" id="active"><option value="0" selected="selected">Active</option><option value="1">Inactive</option></select>
                <img class="modallodard<?php echo $detail['admin_id'];?>" style="display: none" alt="" src="images/ajax-loader-search.gif" />
                </td>

                <?php } else { ?>

                <td class="name"><select  style="padding:5px 0px 5px 5px;" name="<?php echo $detail['admin_id'];?>" id="active"><option value="0">Active</option><option value="1" selected="selected">Inactive</option></select>
                  <img class="modallodard<?php echo $detail['admin_id'];?>" style="display: none" alt="" src="images/ajax-loader-search.gif" />
                </td>

                <?php } ?>

                <td class="name"><a href="#change_pass" data-toggle="modal-pass"  id="<?php echo $detail['admin_id'];?>" class="btn">Change Passwrod</a></td>
                <td class="name"><a href="#user_edit" data-toggle="modaluser"  id="<?php echo $detail['admin_id'];?>" class="btn">Edit</a>
                
                </td>
               
              </tr>
            <?php } } else { ?>
              <tr><td colspan="10" style="height:50px;"><h1>No record found.</h1></td></tr>
            <?php } ?>
            </tbody>
          </table>
        </section>
      </div>
  <?php
    echo $pg_obj->displayPaginationBelowUserDetails($setLimit, $page, $hotel_id);
  ?>
</div>
<p>&nbsp;</p>

  <div id="tablesearch">
    <section>
      <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
        <thead>
          <tr>
            <th><h3>S.No.</h3></th>
            <th><h3>Name</h3></th>
            <th><h3>User Name</h3></th>
            <th><h3>E-mail ID</h3></th>
            <th><h3>IP Address</h3></th>
            <th><h3>Last Login</h3></th>
            <th><h3>User Type</h3></th>
            <th><h3>Previleges</h3></th>
            <th><h3>Created Date</h3></th>
            <th><h3>Status</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </div>
  <p>&nbsp;</p>
 
</div>
</div>

<!-- recheckin modal-->
<a href="#user_edit" class="overlay" id="user_edit"></a>
<div class="popup3"> 
</div>

<!-- Change password modal-->
<a href="#change_pass" class="overlay" id="change_pass"></a>
<div class="popup3"> 
</div>
<?php include_once('../include/footer.php');?>
<!--tab style-->
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    $(".Active").css("background-color","");
}

$(window).load(function(){
  $(".Active").css("background-color","#ccc");
});
</script>
<script type="text/javascript">
  $(".hotel").change(function(){
      var hotel_id = $(this).attr("value");
      $.ajax({
          url : "save_hotel_id.php?hotel_id="+hotel_id,
          success:function(data){
            window.location.href='view_user.php';
          }
      });
   });

</script>
<script type="text/javascript">
$(".delete").click(function(){
  var id = $(this).attr('title');
  if(confirm("Are you sure you want to delete this?")){
    $.ajax({
      url : 'delete.php?type=delete_employee_details&id='+id,
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

$(document).on('click','a[data-toggle="modaluser"]',function(){
  var admin_id = $(this).attr('id');
  $.ajax({
    url : 'edit_users.php?admin_id='+admin_id,
    success:function(data){
      $(".popup3").show().html(data);
    }
  });
});

//change password popup
$(document).on('click','a[data-toggle="modal-pass"]',function(){
  var admin_id = $(this).attr('id');
  $.ajax({
    url : 'change_pass_popup.php?admin_id='+admin_id,
    success:function(data){
      $(".popup3").show().html(data);
    }
  });
});
</script>
<!-- end Paginator js-->
<script type="text/javascript">
  $("#day_book_btn").click(function(){
    var formData = $("#filter_form").serialize();
    $.ajax({
      url : 'emp_details_filter.php',
      type : 'POST',
      data : formData,
      success:function(data){
        if(data == 1){
          $("#error").show().html('<span style="color:red">Please select atleast one field</span>');
        }else{
          $("#error").hide();
          $("#tablesearch_top").hide();
          $("#tablesearch").hide();
          $("#show_data").show().html(data);
        }
      }
    });
  });
</script>


<script type="text/javascript">
  $(window).load(function(){
    $('.article-preview h1 a').hover(function(){
      $(this).animate({
          color: '#ffffff',
      }, 1500);
    });
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
</script>

<!--End Script Open Pannel-->


<!-- searching script here-->
<script type="text/javascript">

  $(document).ready(function() {  
    $("#tablesearch").hide();
    // Search
    $("#search_gks").on('click',function(){
      var query_value = $('input#name').val();
      if(query_value !== ''){
        $.ajax({
          type: "POST",
          url: "search_users_details.php",
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

    $("input#name").on("keyup", function(e) {
      var search_string = $(this).val();
      // Do Search
      if (search_string == '') {
        $("#tablesearch_top").show();
        $("#tablesearch").hide();
      }
    });
  }); 

  //active and inactive user
  $(document).on('change','#active',function(){
    var status = $(this).val();
    var id = $(this).attr('name');
    $.ajax({
      url :'update-status.php?status='+status+'&id='+id,
      beforeSend: function () {
        $(".modallodard"+id).show();
      },
      success:function(res){
        $(".modallodard"+id).hide();
      }
    });
  });   
</script>

<!--searching script end here-->
<script>

$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});

</script>

</body>

</html>