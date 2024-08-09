<?php 
include_once('../include/header.php');

include('is_login.php');

$dt_wi_details = $obj->getDateWiseCheckedinDetails($hotel_id);

?>

<link rel="stylesheet" href="css/pagination.css">
<style type="text/css">
.popup1{
  background-color: #fff;
  border: 1px solid #d8d8d8;
  display: inline-block;
  left: 50%;
  color: #666;
  opacity: 0;
  padding: 15px;
  position: absolute;
  text-align: justify;
  top:0%;
  visibility: hidden;
  z-index: 10000;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  -ms-border-radius: 10px;
  -o-border-radius: 10px;
  border-radius: 10px;
  -webkit-transition: opacity .5s, top .5s;
  -moz-transition: opacity .5s, top .5s;
  -ms-transition: opacity .5s, top .5s;
  -o-transition: opacity .5s, top .5s;
  transition: opacity .5s, top .5s;
}
.overlay:target+.popup1 {
  top: 90%;
  opacity: 1;
  visibility: visible;width:70%;
}
.popup1 h4{text-align:center;margin-top:30px;}
.popup1 h4 a{background:#f34343;padding:7px 20px;color:#fff;border-radius:4px;-moz-border-radius:4px;}
.popup1 h4 a:hover{background:#132fa4;text-decoration:none;}

</style>

<!-- Paginator css-->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-datepicker.css" rel="stylesheet" media="screen">
<link href="css/bootstrap-datepaginator.css" rel="stylesheet" media="screen">

<!--end Paginator css-->

<div id="tablewrapper">
  <div id="tableheader">
    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
      <div class="search">
        <input id="name" name="name" type="text" placeholder="Search by Booking Id" autocomplete="off"/>
        <button id="search_gks" type="button" class="btn btn-default" style="padding-top: 10px;padding-bottom: 9px;border: #499f4d 1px solid;background-color:#499f4d!important;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
        </button>
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>

    <span class="details" style="padding-top:0px!important;">
      
      <form name="filter_form" id="filter_form" role="form" action="#">
        <span id="error" style="float:left;padding-top:10px;"></span>
        <div class="field" style="padding-top:10px;">
          <input class="date-pick ipt" type="text" id="checkin" name="start_date" placeholder="Check Start Date">
        </div>
        <div class="field" style="padding-top:10px;">
          <input class="date-pick ipt" type="text" id="checkout" name="end_date" placeholder="Check End Date">
        </div>
        <div style="padding-top:10px;padding-right:20px;">
          <button style="padding-top:9px;padding-bottom:9px;" id="day_book_btn" name="day_book_btn" type="button" class="btn btn-primary">Search</button>
          <img class="modallodar2" style="display: none" alt="" src="images/ajax-loader-search.gif" />
        </div>
        
      </form>
    </span>
  </div>
<!--Paginator html-->
<br/>
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

<div class="modallodar" style="display: none">
    <div class="center">
        <img alt="" src="ajax-loader1.gif" />
    </div>
</div>
<div id="tablesearch_top">
<section>
  <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
    <thead>
       <tr>
        <th><h5>S. N.</h5></th>
        <th><h5>Booking Id.</h5></th>
        <th><h5>Name</h5></th>
        <th><h5>Phone</h5></th>
        <th><h5>Email</h5></th>
        <th><h5>Room</h5></th>
        <th><h5>Country</h5></th>
        <th><h5>Amount</h5></th>
        <th><h5>Checkin</h5></th>
        <th><h5>Checkout</h5></th>
        <th><h5>Check In By</h5></th>
        <th><h5>&nbsp;</h5></th>
        
      </tr>
    </thead>
    <tbody>
      <?php
      
      if(!empty($dt_wi_details)){ 
        
        $i=1;
          foreach ($dt_wi_details as $booking) { 
        ?>
        <tr>
          <td class="name" style="width:30px;overflow:hidden;"><?php echo $i++;?></td>
          <td class="name" style="width:10px;overflow:hidden;" ><?php echo $booking['booking_id'];?></td>
          <td class="name"  style="width:150px;overflow:hidden;"><?php echo $booking['name'];?></td>
          <td class="name" style="width:100px;overflow:hidden;"><?php echo $booking['phone'];?></td>
          <td class="name" style="width:200px;overflow:hidden;"><a href="#" class="button-email" id="<?php echo $booking['guest_email'];?>" title="<?php echo $booking['email'];?>"><?php echo $booking['email'];?></a></td>
          <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['room_number'];?></td>
          <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['country'];?></td>
          <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['booking_amount'];?></td>
          <td class="name" style="width:25px;overflow:hidden;"><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$booking['checkin_date']))) ;?></td>
          <td class="name" style="width:85px;overflow:hidden;"><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$booking['checkout_date']))) ;?></td>
          <td class="name"  style="width:80px;overflow:hidden;"><?php echo $booking['inserted_by'];?></td>
          <td class="name" style="width:10px;overflow:hidden;"><a href="view_date_wise_checkin_details.php?checkin_id=<?php echo $booking['checkin_history_id'];?>" class="btn">View</a></td>
        </tr>
      <?php } } else { ?>
        <tr>
          <td colspan="13" style="color:#31708F;"><h3>No record found.</h3></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</section>

</div>
<div id="tablesearch">
<section>
  <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
    <thead>
      <tr>
        <th><h5>S. N.</h5></th>
        <th><h5>B.Id.</h5></th>
        <th><h5>Name</h5></th>
        <th><h5>Phone</h5></th>
        <th><h5>Email</h5></th>
        <th><h5>Room</h5></th>
        <th><h5>Country</h5></th>
        <th><h5>Amount</h5></th>
        <th><h5>Checkin</h5></th>
        <th><h5>Checkout</h5></th>
        <th><h5>Check In By</h5></th>
        <th><h5>&nbsp;</h5></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>
</div>
<p>&nbsp;</p>
</div>

<!--Arrival list chekin Modal -->
<a href="#x" class="overlay" id="empty"></a>
<div class="popup1"> 
  
</div>

<?php include_once('../include/footer.php');?> 
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>

<script type="text/javascript">

  $('a[data-toggle="modal_quick_checkin"]').click(function(){
    var arrival_b_id = $(this).attr('id');
    $.ajax({
      url : 'quick_check_in.php?arrival_b_id='+arrival_b_id,
      success:function(data){
        $(".popup1").show().html(data);
      }
    });
  });

</script>
<script type="text/javascript">
  $("a[href='##']").click(function(){
    var booking_id = $(this).attr('title');
    $.ajax({
      url : "process.php?type=arrival_booking_check_status&booking_id="+booking_id,
      success:function(data){
        if(data == 0){
          $("#confirm"+booking_id).replaceWith('<img src="images/icona_ok_v.png" titel="confirmation image" width="40px" height="30px">');
        }else{
          
        }
      }
    });
  });
</script>

<script type="text/javascript">

  $(document).ready(function() {  
    $("#tablesearch").hide();
    // Search
    $("#search_gks").on('click',function(){
      var query_value = $('input#name').val();
      if(query_value !== ''){
        $.ajax({
          type: "POST",
          url: "search_date_wise_chk_details.php",
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
</script>
<script type="text/javascript">
  /*$(".hotel").change(function(event){
    event.preventDefault();
    var hotel_id = $(this).attr("value");
    $.ajax({
      url : "hotel_based_arrival_booking_list.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
         $(".modallodar").show();
      },
      success:function(data){
        $(".modallodar").hide();
        $("#tablesearch_top").hide();
        $("#tablesearch").hide();
        $("#show_data").show().html(data);
      }
    });
  });*/
  $(".hotel").change(function(){
    var hotel_id = $(this).attr("value");
    $.ajax({
      url : "room_view_byhotel.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
      success:function(data){
        //$(".content_wrapper").hide();
        //$("#show_data").show().html(data);
        window.location.href='date_wise_checkin_details.php';
      }
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
  $('#nights').click(function() {
    var start = $('#checkin').datepicker('getDate');
    var end   = $('#checkout').datepicker('getDate');
    var days   = (end - start)/1000/60/60/24;
    $("#nights").val(days);
  });
  </script>

<!-- Paginator js-->
  <script type="text/javascript" src="js/moment.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-datepaginator.js"></script>
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
          $.get('date_wise_ch_paginator.php?date='+date1,function(data){
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
<!-- end Paginator js-->
<script type="text/javascript">
  $("#day_book_btn").click(function(){
    var formData = $("#filter_form").serialize();
    var start_date = $("#checkin").val(); 
    var end_date = $("#checkout").val();

    if(start_date && end_date){ 
        $.ajax({
          url : 'date_wise_checkedin_filter.php',
          type : 'POST',
          data : formData,
          beforeSend: function () {
            $(".modallodar2").show();
          },
          success:function(data){
            $(".modallodar2").hide();
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
    }
      
  });
</script>
<!--<script type="text/javascript" src="js/arrival_trigers.js"></script>-->
<script>

$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});

</script>

</body>

</html>