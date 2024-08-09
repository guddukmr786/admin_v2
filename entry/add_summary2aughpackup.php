<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_SESSION['hotel_id'];
$hotels = $obj->getHotelDetailsById($hotel_id); 
include('../include/header2.php'); 
$obj = new FetchValues();
if(empty($_SESSION['admin_id']) || $_SESSION['admin_id'] == "") {
  header('Location:../index.php');
  die;
}
if(isset($_GET['checkin_id'])){
  $checkin_id = $_GET['checkin_id'];
}else {
  $checkin_id = $_SESSION['checkin_id'];
}
if(isset($_GET['type']) && $_GET['type'] == 'update_bill'){
  $up_bills = $obj->getBillDetailsByCheckinId($checkin_id, $hotel_id);
}
$customer_details = $obj->getEntryListById($checkin_id, $hotel_id);

?>
<form class="form-group" action="insert_data.php" method="post" role="form" name="summary_form" id="summary_form" autocomplete="off">
<div class="content">
  <div class="col-md-6"><h4><span class="clr_red">Customer Name :&nbsp;</span><?php echo $customer_details['name'];?></h4>
  </div>
    
  <div class="col-md-6"><h4><span class="clr_red">Booking ID :&nbsp;</span> <?php echo $customer_details['booking_id'];?></h4>
  </div>
  <div class="col-md-6 pull-right">
    <div class="row">
      <div class="col-md-5 label_text">
        <label>Advance Payment</label>
      </div>
      <div class="col-md-1 amount">
        <i class="fa fa-inr">&nbsp;</i>
      </div>
    <div class="col-md-5" style="padding-left:0px;" >
      <input type="text" class="form-control" id="advance_amount" name="advance_amount" />
    </div>
  </div>
</div>
<div class="clearfix"></div>
<hr>

  <table class="table table-bordered table-hover" id="tab_logic">
    <thead>
      <tr >
         <th class="text-center">Bill ID</th>
         <th class="text-center">Menu<span style="color:red;">*</span></th>
         <th class="text-center">Qty<span style="color:red;">*</span></th>
         <th class="text-center">Amount<span style="color:red;">*</span></th>
         <th class="text-center">Total Amout <span style="color:red;">*</span></th>
      </tr>
    </thead>
    <tbody>
      <tr id='addr0'>
        <input type="hidden" name="checkin_id" id="checkin_id" value="<?php echo $customer_details['checkin_id'];?>">
        <td>
          <input type="text" name="bill_id[]" value="<?php if(isset($up_bills['bill_id'])){ echo $up_bills['bill_id'][0];}?>" class="form-control bill_id" id="bill_id"  placeholder="Bill ID" />
        </td>
        <td>
          <input type="text" value="<?php if(isset($up_bills['menu'])){ echo $up_bills['menu'][0];}?>" name="menu[]" class="form-control menu" id="menu" placeholder="Menu" />
        </td>
        <td>
          <input type="number" name="qty[]" value="<?php if(isset($up_bills['qty'])){ echo $up_bills['qty'][0];}?>" class="form-control qty" id="qty" placeholder="Qty" />
        </td>
        <td>
          <input  type="number" value="<?php if(isset($up_bills['bill_amount'])){ echo $up_bills['bill_amount'][0];}?>" class="form-control bill_amount" id="bill_amount" name="bill_amount[]" placeholder="Bill Amount" >
        </td>
        <td>
          <input type="number" value="<?php if(isset($up_bills['total_amount'])){ echo $up_bills['total_amount'][0];}?>" class="form-control total_amount" id="total_amount" name="total_amount[]" placeholder="Total Amount" >
        </td>
      </tr>
      <tr id='addr1'></tr>
    </tbody>
  </table>
  <div class="row mt30">
    <div class="col-md-2 pull-right"><input type="submit" id="add_summary" name="add_summary" class="form-control btn-danger" value="Submit"/></div>
    <div class="col-md-2 pull-right"><input type="button" class="form-control btn-success" id="add_row" value="Add More" /></div>
    <div class="col-md-2 pull-right"><input type="button" class="form-control btn-danger" id="delete_row" value="Delete Summary" /></div>
    <?php if(isset($_SESSION['msg'])){ ?>
    <span style="color:green;padding-left:12px;"><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?></span>
    <?php } else if(isset($_SESSION['err'])){ ?>
    <span style="color:red;padding-left:12px;"><?php echo $_SESSION['err'];unset($_SESSION['err']);?></span>
    <?php } ?>
  </div>
</div>
 
</form>

<?php include('../include/footer.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#delete_row").hide();
    var i=1;
    $("#add_row").click(function(){
    $('#addr'+i).html('<td><input type="text" name="bill_id[]" class="form-control bill_id"  placeholder="Bill ID" /> </td><td><input type="text" name="menu[]" class="form-control menu"  placeholder="Menu" /></td><td><input type="number" name="qty[]" class="form-control qty"  placeholder="Qty" /></td><td><input  type="number" class="form-control bill_amount" name="bill_amount[]" placeholder="Bill Amount" ></td><td><input type="number" class="form-control total_amount" name="total_amount[]" placeholder="Total Amount" ></td>');
    $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
    i++; 
    $("#delete_row").show();

    //calculation script start here 
    $(document).ready(function(){
      $(".qty,.bill_amount, .total_amount").click(function(){
        $('.table tr').each(function() {
          $(this).find('.total_amount').val(
            parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.bill_amount').val())
          );
        });
      });

      $(".qty,.bill_amount, .total_amount").keyup(function(){
        $('.table tr').each(function() {
            $(this).find('.total_amount').val(
              parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.bill_amount').val())
            );
        });
      });
    });
    //calculation script end here

   });
    $("#delete_row").click(function(){
      if(i <= 2){
        $("#delete_row").hide();
      }
     if(i>1){
      $("#addr"+(i-1)).html('');
      i--;
    }
  });
  });
  </script>

<script type="text/javascript">
  $(document).ready(function(){
    $(".qty,.bill_amount, .total_amount").click(function(){
       $('.table tr').each(function() {
          $(this).find('.total_amount').val(
            parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.bill_amount').val())
          );
       });
    });

    $(".qty,.bill_amount, .total_amount").keyup(function(){
        $('.table tr').each(function() {
          $(this).find('.total_amount').val(
            parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.bill_amount').val())
          );
        });
    });
  });
</script>

  <script>
  function getState(val) {
    $.ajax({
      type: "POST",
      url: "get_state.php",
      data:'country_id='+val,
      success: function(data){
        $("#state").html(data);
      }
    });
  }
</script>


<script>

$(document).ready(function(){
  var touch=$('#touch-menu');
  var menu=$('.menu');
  $(touch).on('click',function(e){
    e.preventDefault();
    menu.slideToggle();
  });$(window).resize(function(){
    var w=$(window).width();
    if(w>767&&menu.is(':hidden')){
      menu.removeAttr('style');
    }});
});

</script>
<script type="text/javascript">
  $('#bill_id, #menu, #qty, #bill_amount, #total_amount').click(function(){
    $("#bill_id").css('border','');
    $("#menu").css('border','');
    $("#qty").css('border','');
    $("#bill_amount").css('border','');
    $("#total_amount").css('border','');
  });

  $('#summary_form').on('submit', function(e) {
    var bill_id = $("#bill_id").val();
    var menu = $("#menu").val();
    var qty = $("#qty").val();
    var bill_amount = $("#bill_amount").val();
    var total_amount = $("#total_amount").val();
    if(!bill_id){
      $("#bill_id").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!menu){
      $("#menu").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!qty){
      $("#qty").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!bill_amount){
      $("#bill_amount").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!total_amount){
      $("#total_amount").css('border','solid 1px red');
      e.preventDefault();
    }



    if(bill_id){
      $("#bill_id").css('border','');
    }

    if(bill_date){
      $("#bill_date").css('border','');
    }

    if(bill_amount){
      $("#bill_amount").css('border','');
    }

    if(total_amount){
      $("#total_amount").css('border','');
    }
    
  });

</script>
</body>
</html>

