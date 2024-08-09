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
$invoices = $obj->getGeneratedInvoiceOfSushantTravels($setLimit, $pageLimit);

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
        <input id="search_name" name="search_name" type="text" placeholder="Search by /name/type/department" autocomplete="off"/>
        <button type="button" id="search_gks" class="btn btn-default" style="padding-top: 10px;padding-bottom:10px;border: #499f4d 1px solid;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
        </button>
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>
  </div>
 
<div id="show_data"></div>
<div id="tablesearch_top">
  <!-- This code for recheckin-->
  <section>
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
      <thead>
        <tr>
          <th><h3>S.No.</h3></th>
          <th><h3>Name</h3></th>
          <th><h3>Email</h3></th>
          <th><h3>City</h3></th>
          <th><h3>Country</h3></th>
          <th><h3>Invoice Date</h3></th>
          <th><h3>Details</h3></th> 
          <th><h3>Total_amount</h3></th>          
          <th><h3>&nbsp;</h3></th>
          <th><h3>&nbsp;</h3></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $i=1;
         
          if(!empty($invoices)){
            foreach ($invoices as $invoice) { 
              $s_invoice_id = $invoice['s_invoice_id'];
              $details_Day = $obj->getDataOfBookingDescriptionOfSushantTravels($s_invoice_id);
              $datedd = str_replace('/','-',$invoice['invoice_date']);

              $inserted_date = date( 'd M Y , D', strtotime($datedd));
        ?>
        <tr id="<?php echo $s_invoice_id;?>">
          <td class="name"><?php echo  $i++;?></td>
          <td class="name"><?php echo $invoice['name'] ;?></td>
          <td class="name"><?php echo $invoice['email']?></td>
          <td class="name"><?php echo $invoice['city'];?></td>
          <td class="name"><?php echo $invoice['country'];?></td>
          <td class="name"><?php echo $inserted_date;?></td>
          <td class="name"><?php echo $details_Day['description'];?></td>
          <td class="name"><?php echo $invoice['total_amount'];?></td>
          <td class="name" style="width:120px!important;"><a href="generate_sushant_invoice.php?id=<?php echo $invoice['s_invoice_id'];?>" class="btn">View</a>&nbsp;<a href="invoice_sushant.php?id=<?php echo $invoice['s_invoice_id'];?>" class="btn" target="_blank">Print</a></td>
          <td class="name" style="width:80px;"><a href="#" class="delete" title="<?php echo $invoice['s_invoice_id'];?>" id="btn_r1">Delete</a></td>
        </tr>
        <?php } } ?>
      <hr>
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
            <th><h3>Name</h3></th>
            <th><h3>Email</h3></th>
            <th><h3>City</h3></th>
            <th><h3>Country</h3></th>
            <th><h3>Invoice Date</h3></th>
            <th><h3>Details</h3></th> 
            <th><h3>Total_amount</h3></th>          
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
          window.location.href='view_sushant_invoice.php';
        }
    });
  });

$(".delete").click(function(){
  var id = $(this).attr('title');
  if(confirm("Are you sure you want to delete this?")){
    $.ajax({
      url : 'delete.php?type=delete_invoice&id='+id,
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

  $(document).ready(function() {  
    $("#tablesearch").hide();
    // Search
    $("#search_gks").on('click',function(){

      var query_value = $('input#search_name').val();
      if(query_value !== ''){
        $.ajax({
          type: "POST",
          url: "search_sushant_invoice.php",
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

<script>

$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});

</script>

</body>

</html>