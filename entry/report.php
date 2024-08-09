<?php 
include('../include/header.php');

include('is_login.php');
$booking_vias = $obj->getAllBookingViaCategories();

?>
<style type="text/css">
  .category option{
    padding: 5px!important;
  }
   .hotelname option{
    padding: 5px!important;
  }
</style>
<div class="content">
  <span class="details" style="margin-bottom: 10px;">
    <!--<div ><a class="button blue" id="download" href="download_data.php?type=download_email/phone">Download Email, Phone</a></div>
    <div ><a class="button blue" href="download_data.php?type=all">Download Full Data</a></div>
    <div ><a class="button blue" href="download_data.php?type=dailydata">Download Daily Data</a></div>
  </span>-->

  <hr>
  <div class="idealsteps-container">
    <form action="#" class="idealforms" id="checkin_form" enctype="multipart/form-data" method="post" role="form" name="checkin_form" autocomplete="on">
      <!--<span id="arrival_mess"></span>-->
      <!--<h3 style='text-align: center;color:#F34343;'>Download Data </h3>-->
      <div class="field">
        <label class="main">Select Hotel <span style="color:red;">*</span> :</label>
        <select  style="padding:3px!important;" name="hotel" id="selectt" class="hotelname">
          <option value="">Select Hotel </option>
          <?php foreach ($all_hotels as $hotel) { 
          ?>
          <option value="<?php echo $hotel['hotel_id']?>"><?php echo $hotel['hotel_name']?></option>
          <?php } ?>
        </select>
      </div>
      <div class="field">
        <label class="main">What do u want? <span style="color:red;">*</span> : </label>
        <select style="padding:3px!important;" name="category" id="selectt" class="category">
          <option value="">Select one...</option>
          <?php
          $categories = array('Email', 'Phone', 'All Detials');
          foreach ($categories as $category) { 
          ?>
          <option value="<?php echo $category;?>"><?php echo $category;?></option>
          <?php } ?>
        </select>
      </div>
      <div class="clear"></div> 
      <div class="field">
        <label class="main">Start Date <span style="color:red;">*</span> :</label>
        <input class="date-pick ipt" type="text" id="start_date" name="start_date" placeholder="Check In Date">
      </div>
    
      <div class="field">
        <label class="main">End Date <span style="color:red;">*</span> :</label>
        <input class="date-pick ipt" type="text" id="end_date" name="end_date" placeholder="Check Out Date">
      </div>
      <div class="field">
        <label class="main">Select Company :</label>
        <select name="company" id="selectt" class="company" style="padding:9px!important;">
          <option value="">All Companies data</option>
          <?php 
          foreach ($booking_vias as $booking_via) {
          ?>
          <option value="<?php echo $booking_via['booking_via_id'];?>"><?php echo $booking_via['category_name'];?></option>
          <?php }  ?>
        </select>
      </div>
      <div class="field buttons">
        <label class="main">&nbsp;</label>
        <!--<input type="button" class="reset" id="reset" value="Reset" />-->
        <input type="submit" id="download" class="preview" name="download" value="Download">
        <input type="button" id="view" class="preview" name="view" value="view">
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>
  </div>
</div> 
<span id="view_report"></span>
<?php include('../include/footer.php');?>
<script src="js/bootstrap-datepicker.js"></script>
<script>
  $(document).ready(function () {
    $("#start_date").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });
    $("#end_date").datepicker({ beforeShow: setminDate });
    var start1 = $('#start_date');      
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
    $( "#end_date" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
    $( "#start_date" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
  });
  $('#nights').click(function() {
    var start = $('#start_date').datepicker('getDate');
    var end   = $('#end_date').datepicker('getDate');
    var days   = (end - start)/1000/60/60/24;
    $("#nights").val(days);
  });
</script>

<script type="text/javascript">
  $('.category,#start_date, #end_date,.hotelname').click(function(){
    $(".category").css("border", "");
    $("#start_date").css("border", "");
    $("#end_date").css("border" , "");
    $(".hotelname").css("border","");
  });

  $('#download').on('click', function(e) {
    var category = $('.category');
    var start_date = $('#start_date');
    var end_date = $('#end_date');
    var hotelname = $('.hotelname');
    
    if(!hotelname.val()) {
      $('.hotelname').css("border", "1px solid red");
      $('.hotelname').focus();
      e.preventDefault();
    }

    if(!category.val()) {
      $('.category').css("border", "1px solid red");
      $('.category').focus();
      e.preventDefault();
    }

    if(!start_date.val()) {
      $('#start_date').css("border", "1px solid red");
      $('#start_date').focus();
      e.preventDefault();
    }

    if(!end_date.val()) {
      $('#end_date').css("border", "1px solid red");
      $('#end_date').focus();
      e.preventDefault();
    }

  });
</script>
<script type="text/javascript">
  $("#download").click(function(){
    var category = $(".category").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    if(category && start_date && end_date){
      $('form[action="#"]').attr('action', "download_data.php");
      $("#checkin_form").submit();
    }else{
      return false;
    }
  });
</script>
<script type="text/javascript">
  $("#view").click(function(){
    var hotel = $(".hotelname").val();
    var category = $(".category").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    $('form[action="download_data.php"]').attr('action', "#");
    formData = $("#checkin_form").serialize();
    if(!hotel){
      $('.hotelname').css("border", "1px solid red");
      $('.hotelname').focus();
    }
    if(!category){
      $('.category').css("border", "1px solid red");
      $('.category').focus();
    }
    if(!start_date){
      $('#start_date').css("border", "1px solid red");
      $('#start_date').focus();
    }
    if(!end_date){
      $('#end_date').css("border", "1px solid red");
      $('#end_date').focus();
    }
    if(hotel && category && start_date && end_date){
      $.ajax({
        url : 'view_report.php?type=view_report',
        type : 'post',
        data : formData,
        beforeSend: function () {
          $(".modallodar1").show();
        },
        success:function(result){
          $(document).ready(function(){
            $(".modallodar1").hide();
          });
          $("#view_report").show().html(result);
        }
      });
    }
 });
</script>
<script type="text/javascript">
  $(".hotel").change(function(){
      var hotel_id = $(this).attr("value");
      $.ajax({
          url : "save_hotel_id.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
          success:function(data){
            window.location.href='report.php';
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
          url: "searching_arrival_booking.php",
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

</body>
</html>
