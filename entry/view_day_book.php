<?php 
include_once('../include/header.php');

include_once ("../include/pagination_function.php");//include of paginat page
$pg_obj = new PaginationFunction();

include('is_login.php');

if(isset($_GET["page"]))
$page = (int)$_GET["page"];
else
$page = 1;
$setLimit = 25;
$pageLimit = ($page * $setLimit) - $setLimit;
$day_books = $obj->getToatalDayBookEntryList($setLimit, $pageLimit, $hotel_id);
//print_r($day_books);die;

$opening_balance = $obj->getClosingBalance($hotel_id);

//for Opening balance
/*$resutls_op = $obj->getAmountBeforeCurrentDate($hotel_id);
if(isset($resutls_op)){
  $op_rec = 0;
  $op_pay = 0;
  foreach ($resutls_op as $resutl_op) {
    if($resutl_op['receive_pay'] == 'Receive'){
      $op_rec += $resutl_op['amount'];
    }elseif ($resutl_op['receive_pay'] == 'Pay') {
      $op_pay += $resutl_op['amount'];
    }
  }
  $opening_balance = $op_rec - $op_pay;
}*/

$receive_value = 0;
$pay_value = 0;
foreach ($day_books as $day_book) {
  if($day_book['receive_pay'] == 'Receive'){
    $receive_value += $day_book['amount'];
  }elseif ($day_book['receive_pay'] == 'Pay') {
    $pay_value += $day_book['amount'];
  }
}
//$avi_balance = $receive_value - $pay_value;

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
<!--end Paginator css-->
<link rel="stylesheet" href="css/pagination.css">
<div id="tablewrapper">
  <div id="tableheader">
    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
      <div class="search">
        <input id="name" name="name" type="text" placeholder="Search by /name/type/department" autocomplete="off"/>
        <button type="button" id="search_gks" class="btn btn-default" style="padding-top: 10px;padding-bottom:10px;border: #499f4d 1px solid;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
        </button>
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>
    
    <span class="details" style="padding-top:0px!important;">
      
      <form name="filter_form" id="filter_form" role="form" action="#" method="post">
        
        <div class="field" style="padding-top:10px;">
          <input class="date-pick ipt" type="text" id="checkin" name="start_date" placeholder="Check Start Date">
        </div>
        <div class="field" style="padding-top:10px;">
          <input class="date-pick ipt" type="text" id="checkout" name="end_date" placeholder="Check End Date">
        </div>
        <div class="field" >
          <select style="width:200px;" name="depart" class="depart" id="selectt">
            <option style="padding-top:5px;padding-bottom: 5px;" value="">Select Department..</option>
            <?php 
            $departs = array('Traveling','Kitchen Cafe','Hotel','Dues Amount');
            foreach ($departs as $depart) {
            ?>
            <option style="padding-top:5px;padding-bottom: 5px;" value="<?php echo $depart;?>"><?php echo $depart;?></option>
            <?php } ?>
          </select>
        </div>
        <div style="padding-top:10px;padding-right:20px;">
          <button style="padding-top:9px;padding-bottom:9px;" id="day_book_btn" name="day_book_btn" type="button" class="btn btn-primary">Search</button>
          <?php if($_COOKIE['user_type'] == 'Admin' OR $_COOKIE['user_type'] == 'Super Admin') { ?>
          <button style="padding-top:9px;padding-bottom:9px;" id="day_book_download" name="day_book_download" type="submit" class="btn btn-primary">Download</button>
          <?php } ?>
        </div>
        <br>
        <span id="error"></span>
      </form>
    </span>
  </div>
 
  <!--Paginator html-->
  <br/>
  <div class="row">
    <div class="col-lg-1 col-md-1 col-sm-1"></div>
    <div class="col-lg-10 col-md-10 col-sm-10">
      <div id="paginator"></div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1"></div>
  </div>
 
  <?php /*<div class="col-md-6">
    <?php if($opening_balance['closing_balance'] <= 0) { ?>
    <div class="col-md-5" style="padding-left:0px;padding-left:0px;font-size:16px;color:#30C8FF;">Opening Balance : <span style="color:red;"><?php if(isset($opening_balance['closing_balance'])) echo $opening_balance['closing_balance'];?> Rs.</span></div>
    <?php } else { ?>
    <div class="col-md-5" style="padding-left:0px;font-size:16px;color:#30C8FF;">Opening Balance : <?php if(isset($opening_balance['closing_balance'])) echo $opening_balance['closing_balance'];else echo 0;?> Rs.</div>
    <?php } ?>
  </div>*/?>
  
<div id="show_data"></div>
<div id="tablesearch_top">
  <!-- This code for recheckin-->
 
  <section>
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
      <thead>
        <tr>
          <th><h3>S.No.</h3></th>
          <th><h3>Date</h3></th>
          <th><h3>Name</h3></th>
          <th><h3>Receive Amount</h3></th>
          <th><h3>Pay Amount</h3></th>
          <th><h3>Description</h3></th>
          <th><h3>Department</h3></th>
          <th><h3>Date and Time</h3></th>
          <th><h3>&nbsp;</h3></th>
          <th><h3>&nbsp;</h3></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $i=1;
         
          if(!empty($day_books)){
            foreach ($day_books as $day_book) { 
              $amount = $day_book['amount'];
              $rec_pay = $day_book['receive_pay'];
              $inserted_date = date_format(new DateTime($day_book['date_of_expense']), 'd M Y , D');
              $inserted_date_time = date_format(new DateTime($day_book['inserted_date']), 'd M Y H:i:s');
        ?>
        <tr id="<?php echo $day_book['day_b_id'];?>">
          <td class="name"><?php echo  $i++;?></td>
          <td class="name"><?php echo $inserted_date;?></td>
          <td class="name"><?php echo $day_book['expense_by'] ;?></td>
          <?php if($day_book['expense_type'] == 'Cash balance') { ?>
          <td class="name" style="background-color:#88C08B;"><?php if($rec_pay == 'Receive') echo $amount;?></td>
          <?php } else { ?>
          <td class="name"><?php if($rec_pay == 'Receive') echo $amount;?></td>
          <?php } ?>
          <td class="name"><?php if($rec_pay == 'Pay') echo $amount; ?></td>
          <td class="name"><?php echo $day_book['description'];?></td>
          <td class="name"><?php echo $day_book['department'];?></td>
          <td class="name"><?php echo $inserted_date_time;?></td>
          <!--<td class="name"><a href="view.php?checkin_id=<?php //echo $list['checkin_id'];?>" class="btn">View</a></td>-->
          <?php if($day_book['expense_type'] == 'Cash balance') { ?>
          <td class="name" style="width:80px;"><a disabled href="#edit_day_book" data-toggle="modaldaybook"  id="<?php echo $day_book['day_b_id'];?>" class="btn">Edit</a></td>
          <?php } else { ?>
          <td class="name" style="width:80px;"><a href="#edit_day_book" data-toggle="modaldaybook"  id="<?php echo $day_book['day_b_id'];?>" class="btn">Edit</a></td>
          <?php } ?>
          <td class="name" style="width:80px;"><a href="#" class="delete" title="<?php echo $day_book['day_b_id'];?>" id="btn_r1">Delete</a></td>
        </tr>
      <?php } 
      $current_balance = $receive_value - $pay_value;
      $obj->updateClosingBalance($hotel_id, $current_balance);
      ?> 
      <hr>
      <tr>
        <td colspan="4" style="text-align:right;padding-right:70px;font-size:14px;">Total Receive : <?php echo $receive_value ;?></td>
        <td style="font-size:14px;">Total Pay : <?php echo $pay_value;?></td>
        <td colspan="5" style="text-align:right;padding-left:70px;font-size:14px;">Currnet Balance : <span style="font-size:16px;"><?php echo $current_balance ;?></span> Rs</td>
      </tr>
      <tr>
        <?php if($current_balance <= 0) { ?>
        <td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;"><span style="color:red;">Closing Balance <?php echo $current_balance ;?> Rs</span></td>
        <?php } else { ?>
        <td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;color:#30C8FF;">Closing Balance  : <?php echo $current_balance ;?> Rs</td>
        <?php } ?>
      </tr>
      <?php } else { ?>
        <tr><td colspan="10" style="height:50px;"><h1>No record found.</h1></td></tr>
      <?php } ?>
      </tbody>
    </table>
  </section>
  <?php
    echo $pg_obj->displayPaginationBelowDayBookList($setLimit, $page, $hotel_id);
  ?>
</div>
<p>&nbsp;</p>

  <div id="tablesearch">
    <section>
      <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
        <thead>
          <tr>
            <th><h3>S.No.</h3></th>
            <th><h3>Date</h3></th>
            <th><h3>Name</h3></th>
            <th><h3>Receive Amount</h3></th>
            <th><h3>Pay Amount</h3></th>
            <th><h3>Description</h3></th>
            <th><h3>Department</h3></th>
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
<a href="#edit_day_book" class="overlay" id="edit_day_book"></a>
<div class="popup1"> 
</div>
<?php include_once('../include/footer.php');?>
<script src="js/bootstrap-datepicker.js"></script>

<!-- Paginator js-->
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepaginator.js"></script>

<script type="text/javascript">
$(".hotel").change(function(){
    var hotel_id = $(this).attr("value");
    $.ajax({
        url : "save_hotel_id.php?hotel_id="+hotel_id,
        success:function(data){
          window.location.href='view_day_book.php';
        }
    });
});

$("#day_book_download").click(function(){
  var start_date = $("#checkin").val();
  var end_date = $("#checkout").val();
  if(start_date && end_date){
    
    $('form[action="#"]').attr('action', "download-day-book.php");
    $("#filter_form").submit();
  }else{
    return false;
  }
});

$(".delete").click(function(){
  var id = $(this).attr('title');
  if(confirm("Are you sure you want to delete this?")){
    $.ajax({
      url : 'delete.php?type=delete_daybook&id='+id,
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

$('a[data-toggle="modaldaybook"]').click(function(){
var d_book_id = $(this).attr('id');
  $.ajax({
    url : 'edit_day_book.php?d_book_id='+d_book_id,
    success:function(data){
      $(".popup1").show().html(data);
    }
  });
});
</script>
  <script type="text/javascript">
    $(window).ready(function(event){
      var d1 = new Date();
      var month = d1.getMonth()+1;
      var day = d1.getDate();
      var output = d1.getFullYear() + '-' +
          ((''+month).length<2 ? '0' : '') + month + '-' +
          ((''+day).length<2 ? '0' : '') + day;

      var options = {
        selectedDate: output,
        onSelectedDateChanged: function(event, date) {
          var d = new Date(date);
          var date1 = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
          $('.loader').show();
          $.get('day_book_paginator.php?date='+date1,function(data){
            $('table#resultTable tbody').show().html(data);
            $("#tablesearch_top").hide();
            $("#tablesearch").show();
            $('.loader').hide();
          });
          
        }
      }
      $('#paginator').datepaginator(options);
    });

  </script>

<!-- end Paginator js-->
<script type="text/javascript">
  $("#day_book_btn").click(function(){
    var formData = $("#filter_form").serialize();
    $.ajax({
      url : 'day_book_filter.php',
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
  /*$(".hotel").change(function(){
    var hotel_id = $(this).attr("value");
    $.ajax({
      url : "hotel_based_entry_list.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
      success:function(data){
        $("#tablesearch_top").hide();
        $("#tablesearch").hide();
        $("#show_data").show().html(data);
      }
    });
  });*/
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
<script type="text/javascript" src="js/day_book_triggers.js"></script>
<!--searching script end here-->
<script>

$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});

</script>

</body>

</html>