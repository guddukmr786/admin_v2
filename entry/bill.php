<?php  
// error_reporting(E_ALL);
include('../include/header2.php'); 
include('is_login.php');

$countries = $obj->getCountries();
$parties = $obj->getPartyDetails();

$hotel_id = $_COOKIE['hotel_id'];
if(isset($_GET['checkin_id'])){
  $checkin_id = $_GET['checkin_id'];
  $invoice_up = $obj->getEntryListById($checkin_id, $hotel_id);
  $price = number_format($invoice_up['booking_amount'] / $invoice_up['booking_nights'], 2, '.', '');

  
} elseif (isset($_GET['room_number'])) {

  $room_number = $_GET['room_number'];
  $invoice_up = $obj->getEntryListByRoomNumber($room_number, $hotel_id);
  $price = number_format($invoice_up['booking_amount'] / $invoice_up['booking_nights'], 2, '.', '');
}

?>
<style type="text/css">
  a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
}
</style>

<div class="content">
  <div class="col-md-6"><h3><span class="clr_red">Add Travels Details</span></h3></div>
  <hr>
  <form class="form-group" action="invoice.php" method="post" role="form" name="travels_form" id="travels_form" autocomplete="off" target="_blank">
    <div class="form-group">
      <label for="party" class="col-sm-2 control-label">Select Party</label>
      <div class="col-sm-4" style="padding-left:0px">
          <?php if(!empty($via) && strtolower($via) !='direct'){?>
          <select id="party" name="party" class="form-control">
          <?php } else {?>
          <select name="party" class="form-control">
          <?php } ?>
            <option value="">Direct</option>
            <?php 
            foreach ($parties as $party) { 
              if(!empty($invoice_up['booking_via'])){
            ?>
            <option value="<?php echo $party['booking_via_id']?>"<?php if($party['booking_via_id'] == $invoice_up['booking_via']) echo 'selected="selected"';?>><?php echo $party['category_name']?></option>
            <?php } else{ ?>
            <option value="<?php echo $party['booking_via_id']?>"><?php echo $party['category_name']?></option>
            <?php } } ?>
          </select>
      </div>
      <label for="party" class="col-sm-2 control-label">Select Tax %</label>
      <div class="col-sm-4" style="padding-left:0px">
          <select id="tax" name="tax" class="form-control">
            <?php 
            $tax_per = array(0 =>'LGST 0%',12 =>'LGST 12%',18=>'LGST 18%',28=>'LGST 28%',01 =>'IGST 0%',24=>'IGST 12%',36=>'IGST 18%',56=>'IGST 28%');
            foreach ($tax_per as $key=>$value) { 
            if (isset($invoice_up['tax'])) { 
            ?>
            <option value="<?php echo $key;?>"<?php if($key == $invoice_up['tax']) echo 'selected="selected"';?>><?php echo $value;?></option>
            <?php } else { ?>
            <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php } } ?>
          </select>
      </div>
    </div>
    
    <div class="clear"></div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Booking ID<span style="color:red">*</span></label>
        <div class="col-sm-4" style="padding-left:0px;">
            <input type="text" id="booking" name="booking" value="<?php if(!empty($invoice_up['booking_id'])) echo $invoice_up['booking_id'];?>" placeholder="Booking ID" class="form-control" autofocus>
            <input type="hidden" name="checkin_id" value="<?php if(!empty($invoice_up['checkin_id'])) echo $invoice_up['checkin_id'];?>">
        </div>

        <label for="name" class="col-sm-2 control-label">Full Name<span style="color:red">*</span></label>
        <div class="col-sm-4" style="padding-left:0px;">
            <input type="text" id="name" name="name" value="<?php if(!empty($invoice_up['name'])) echo $invoice_up['name'];?>" placeholder="Full Name" class="form-control" autofocus>
        </div>
    </div>
    
    <div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Email<span style="color:red">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="email" name="email" value="<?php if(!empty($invoice_up['email'])) echo $invoice_up['email'];?>" placeholder="Email" class="form-control" autofocus>
      </div>
      <label for="contact" class="col-sm-2 control-label">Cotact Number<span style="color:red">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="contact" name="contact" value="<?php if(!empty($invoice_up['phone'])) echo $invoice_up['phone'];?>" placeholder="Contact Number" class="form-control" autofocus>
      </div>
    </div>
    <div class="clear"></div>
    <div class="form-group">
      <label for="City" class="col-sm-2 control-label">City<span style="color:red">*</span></label>
      <div class="col-sm-4" style="padding-left:0px;">
          <input type="text" id="city" name="city" value="<?php if(!empty($invoice_up['state'])) echo $invoice_up['state'];?>" placeholder="City name" class="form-control" autofocus>
      </div>

      <label for="country" class="col-sm-2 control-label">Nationality<span style="color:red">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <select id="country" name="country" class="form-control">
            <option value="">Select Nationality</option>
            <?php 
            foreach ($countries as $country) { 
            if (isset($invoice_up['country'])) { 
            ?>
            <option value="<?php echo $country['country_name']?>"<?php if($country['country_name'] == $invoice_up['country']) echo 'selected="selected"';?>><?php echo $country['country_name']?></option>
            <?php } else { ?>
            <option value="<?php echo $country['country_name']?>"><?php echo $country['country_name']?></option>
            <?php } } ?>
          </select>
      </div>
    </div>
    
    <div class="clear"></div>
    <div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Guest GSTIN</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="gstin" name="gstin" value="<?php if(!empty($invoice_up['gstin'])) echo $invoice_up['gstin'];?>" placeholder="Guest GSTIN" class="form-control" autofocus style="text-transform:uppercase">
      </div>

      <label for="firstName" class="col-sm-2 control-label">Date Of Invoice<span style="color:red">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="invoice_date" name="invoice_date" value="<?php if(!empty($invoice_up['invoice_date'])) echo $invoice_up['invoice_date'];?>" placeholder="dd/mm/yyyy" class="form-control date-pick1 ipt" autofocus>
      </div>
     
    </div>
    

    <div class="clear"></div>
    <p>&nbsp;</p>
    <table class="table table-bordered table-hover" id="tab_logic">
      <thead>
        <tr >
           <th>Description<span style="color:red">*</span></th>
           <th>Check in Date</th>
           <th>Check out Date</th>
           <th>HSN/SAC Code</th>
           <th>Unit<span style="color:red">*</span></th>
           <th>Qty.<span style="color:red">*</span></th>
           <th>Price<span style="color:red">*</span></th>
           <th>Amount<span style="color:red">*</span></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=0;
        ?>
        <tr id='addr<?php echo $i++;?>'>
          <td style="width: 200px!important;">
            <input  type="text" name="description[]" class="form-control ipt" id="description" value="Room Accommodation"  placeholder="" />
          </td>
          <td >
            <input  type="text" name="checkin[]" value="<?php if(!empty($invoice_up['checkin_date'])) echo $invoice_up['checkin_date'];?>" class="form-control date-pick ipt" id="checkin"  placeholder="" />
          </td>
          <td>
            <input type="text" name="checkout[]" value="<?php if(!empty($invoice_up['checkout_date'])) echo $invoice_up['checkout_date'];?>" class="form-control date-pick ipt" id="checkout" placeholder="" />
          </td>
          <td>
            <input type="text" name="hsncode[]" value="9963" class="form-control " id="hsncode" placeholder="" />
          </td>
          <td>
            <input  type="text" name="unit[]" class="form-control" id="unit" value="nights" placeholder="" />
          </td>

          <td>
            <input type="text" name="qty[]" value="<?php if(!empty($invoice_up['booking_nights'])) echo $invoice_up['booking_nights'];?>" class="form-control qty" id="qty" placeholder="" />
          </td>
          <td>
            <input type="text" name="price[]" value="<?php if(!empty($price)) echo $price;?>" class="form-control price" id="price" placeholder="" />
          </td>
          <td>
            <input type="text" name="amount[]" value="<?php if(!empty($invoice_up['booking_amount'])) echo number_format($invoice_up['booking_amount'],2, '.', '');?>" class="form-control amount" id="amount0" placeholder="" />
          </td>
        </tr>
       
        <tr id='addr<?php echo $i;?>'></tr>
      </tbody>
    </table>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="subtotal" name="subtotal" value="" placeholder="Enter CGST Amount" />
      </div>
      <div class="col-md-4 " style="float: right;padding-top: 5px;"> Sub Total: </div>
    </div>
    <div class="clear"></div>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="cgst" name="cgst" value="<?php if(!empty($invoice_up['cgst'])) echo $invoice_up['cgst'];?>" placeholder="Enter CGST Amount" />
      </div>
      <div class="col-md-4 cgst" style="float: right;padding-top: 5px;"> Add CGST @ 0%: </div>
    </div>
    <div class="clear"></div>

    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="sgst" name="sgst" value="<?php if(!empty($invoice_up['sgst'])) echo $invoice_up['sgst'];?>" placeholder="Enter SGST Amount" />
      </div>
      <div class="col-md-4 sgst" style="float: right;padding-top: 5px;">Add SGST @ 0%: </div>
    </div>
    <div class="clear"></div>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="igst" name="igst" value="<?php if(!empty($invoice_up['igst'])) echo $invoice_up['igst'];?>" placeholder="Enter IGST Amount" />
      </div>
      <div class="col-md-4 igst" style="float: right;padding-top: 5px;">Add IGST @ 0%: </div>
    </div>
    <div class="clear"></div>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="comm" name="comm" value="<?php if(!empty($invoice_up['commission'])) echo $invoice_up['commission'];?>" placeholder="Commission" />
      </div>
      <div class="col-md-4" style="float: right;padding-top: 5px;">Less Commmission : </div>
    </div>
    <div class="clear"></div>
     <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="cgstcm" name="cgstcm" value="<?php if(!empty($invoice_up['cgst_comm'])) echo $invoice_up['cgst_comm'];?>" placeholder="CGST Commmission" />
      </div>
      <div class="col-md-4" style="float: right;padding-top: 5px;"> Less IGST On Commmission @ 18%: </div>
    </div>
    <div class="clear"></div>

    <hr>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text"  class="form-control" id="total" name="total" value="<?php if(!empty($invoice_up['total_amount'])) echo $invoice_up['total_amount'];?>" placeholder="Total Amount" />
      </div>
      <div class="col-md-4" style="float: right;padding-top: 5px;">Total Amount : </div>
    </div>
    <hr>
    <div>
      <div class="col-md-3" style="float:right;padding-right:5px;" >
        <input type="text"  class="form-control nextll" id="checkout_by" name="checkout_by" value="" placeholder="Enter your name" />
      </div>
    
    </div>
    <div>
      <div class="col-md-3" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control nextll" id="nextlocation" name="nextlocation" value="" placeholder="Enter Guest Next Location" />
      </div>
    </div>


    <div class="clear"></div>
    <div class="row mt30">
      <?php /*<div class="col-md-2 pull-right ">
        <a style="text-decoration: none;" id="no" href="room_view.php?checkin_id=<?php echo $invoice_up['checkin_id'];?>&room_number=<?php echo $invoice_up['room_number'];?>" class="form-control btn-danger not-active" ><i class="fa fa-sign-out">&nbsp;</i>Final Check Out</a>

      </div>*/?>
      <div class="col-md-2 pull-right">
        <input type="button" name="checkout_btn" id="checkout_btn" value="Final Check Out" class="form-control btn-danger not-active">
      </div>
      <div class="col-md-1 pull-right">
        <input type="submit" name="submit_form" id="submit_form" value="Print" class="form-control btn-danger">
      </div>
      <div class="col-md-1.5 pull-right"><input type="button" class="form-control btn-success" id="add_row" value="Add More" /></div>
      <div class="col-md-1.5 pull-right"><input type="button" class="form-control btn-danger" id="delete_row" value="Delete Summary" /></div>
      <span id="message"></span>
    </div>
  </form>
</div>
<?php include('../include/footer.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  $(".nextll").keyup(function(){
    var nextlocation = $('#nextlocation').val();
    var checkout_by = $('#checkout_by').val();
    if(nextlocation && checkout_by){
      $('input[id="checkout_btn"]').removeClass('not-active');
      $.ajax({
        url : 'insert_data.php?type=checkout_name_locaion&nextlocation='+nextlocation+'&checkout_by='+checkout_by,
        success:function(){

        }
      });
    }else{
      $('input[id="checkout_btn"]').addClass('not-active');
    }
  });
  $(".nextll").click(function(){
    var nextlocation = $('#nextlocation').val();
    var checkout_by = $('#checkout_by').val();
    if(nextlocation && checkout_by){
      $('input[id="checkout_btn"]').removeClass('not-active');
      $.ajax({
        url : 'insert_data.php?type=checkout_name_locaion&nextlocation='+nextlocation+'&checkout_by='+checkout_by,
        success:function(){

        }
      });
    }else{
      $('input[id="checkout_btn"]').addClass('not-active');
    }
  });
  
  
</script>

<script type="text/javascript">

  

  $(document).ready(function(){

    $("#delete_row").hide();
    var i='<?php echo $i;?>';

    if(i > 1){
      $("#delete_row").show();
    }else{
      $("#delete_row").hide();
    }

    $("#add_row").click(function(){

      $('#addr'+i).html('<td><input  type="text" name="description[]" class="form-control ipt" id="description"  placeholder="" /></td><td ><input  type="text" name="checkin[]" value="" class="form-control date-pick ipt" id="checkin"  placeholder="" /></td><td><input type="text" name="checkout[]" value="" class="form-control date-pick ipt" id="checkout" placeholder="" /></td><td><input type="text" name="hsncode[]" class="form-control menu" id="hsncode" value="9963" placeholder="" /></td><td><input  type="text" name="unit[]" class="form-control ipt" id="unit" value=""  placeholder="" /></td><td><input type="text" name="qty[]" class="form-control qty" id="qty" placeholder="" /></td><td><input type="text" name="price[]" class="form-control price" id="price" placeholder="" /></td><td><input type="text" name="amount[]" class="form-control amount" id="amount'+i+'" placeholder="" /></td>');
      i++; 
      $('#tab_logic').append('<tr id="addr'+i+'"></tr>');
      
      $("#delete_row").show();

   });

  /*<td ><input  type="text" name="checkin[]" value="" class="form-control date-pick ipt" id="checkin"  placeholder="" /></td><td><input type="text" name="checkout[]" value="" class="form-control date-pick ipt" id="checkout" placeholder="" /></td>*/

  $("#delete_row").click(function(){
    if(i <= 2){
      $("#delete_row").hide();
    }
    if(i>1){
      $("#addr"+(i-1)).html('');
      i--;
    }
  });
  


  $("#tax").on('change',function(){
    var value = $(this).val();
    var value = $(this).val();
    if(value == 1){
      var div_val = 0;
    }else{
      var div_val = value / 2;
    }
    
    if(value == 1 || value == 24 || value == 36 || value == 56){
      $(".igst").text('Add IGST @ '+div_val+'%');
      $(".sgst").text('ADD SGST @ 0%');
      $(".cgst").text('ADD CGST @ 0%');
    }else{
      $(".igst").text('Add IGST @ 0%');
      $(".sgst").text('ADD SGST @ '+div_val+'%');
      $(".cgst").text('ADD CGST @ '+div_val+'%');
    }
  });


  $(document).on('click','.amount,#igst,#cgst,#sgst,#total,#subtotal,#comm,#cgstcm,#sgstcm',function(){
    var total = 0;
    
    var tax = $("#tax").val()/2;
    if(tax == 0.5){
      tax = 0;
    }
    var taxCal = 0;
    for (var j = 0; j < i; j++) {
      total += parseInt($("#amount"+j).val());

      if($("#amount"+j).val() > 999){
          taxCal += ($("#amount"+j).val()*tax)/100;
      }
    }
    $("#subtotal").val(total.toFixed(2));
    //var comm = (total * 24)/100;
    var comm = $("#comm").val();
    var comm9 = (comm * 18)/100;
  
    $("#cgstcm").val(comm9.toFixed(2));
   // $("#sgstcm").val(comm9.toFixed(2));
    //$("#comm").val(comm.toFixed(2));

    if($("#tax").val() == 1 || $("#tax").val() == 24 || $("#tax").val() == 36 || $("#tax").val() == 56){
      $("#igst").val(taxCal.toFixed(2));
      $("#sgst").val('');
      $("#cgst").val('');
      var sgst_total = total + taxCal;
    }else{
      $("#igst").val('');
      $("#sgst").val(taxCal.toFixed(2));
      $("#cgst").val(taxCal.toFixed(2));
      var sgst_total = total + ( taxCal + taxCal );
    }
    var commission = parseFloat(comm) + parseFloat(comm9);
    var grand_total = sgst_total - commission;

    $("#total").val(grand_total.toFixed(2)); 
  });
  
});

</script>

<script type="text/javascript">
  //calculation script start here 
  $(document).on('click',".qty,.price,.amount",function(){
    $('.table tr').each(function() {
      $(this).find('.amount').val(
        parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.price').val())
      );
    });
  });

  $(document).on('keyup',".qty,.price,.amount",function(){
    $('.table tr').each(function() {
        $(this).find('.amount').val(
          parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.price').val())
        );
    });
  });
  
  $(document).on('change',"#checkin,#checkout",function(){
    $('.table tr').each(function() {
      $(this).find('.amount').val(
        parseFloat($(this).find('.qty').val()) * parseFloat($(this).find('.price').val())
      );
    });
  });
  //calculation script end here

</script>

<script type="text/javascript">
//name=&dob=&email=&passport=&city=&country=&party=&inc=&exc=&checkin_id=&day_date%5B%5D=&details%5B%5D=&amount%5B%5D=&cgst=&sgst=&gst=&total=
  $('#party,#name,#contact, #city, #country, #details, #amount,#total,#invoice_date').click(function(){
    $("#party").css('border','');
    $("#name").css('border','');
    $("#contact").css('border','');
    $("#passport").css('border','');
    $("#city").css('border','');
    $("#country").css('border','');
    $("#details").css('border','');
    $("#amount").css('border','');
    $("#total").css('border','');
    $("#invoice_date").css('border','');
  });

  $('#checkout_btn').click(function(e) {
    var party = $("#party").val();
    var name = $("#name").val();
    var contact = $("#contact").val();
    var city = $("#city").val();
    var country = $("#country").val();
    var details = $("#details").val();
    var amount = $("#amount").val();
    var total = $("#total").val();
    var invoice_date = $("#invoice_date").val();

    if(!party){
      $("#party").css('border','solid 1px red');
      e.preventDefault();
      return false;
    }
    if(!name){
      $("#name").css('border','solid 1px red');
      e.preventDefault();
    }
    if(!contact){
      $("#contact").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!city){
      $("#city").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!country){
      $("#country").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!details){
      $("#details").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!amount){
      $("#amount").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!total){
      $("#total").css('border','solid 1px red');
      e.preventDefault();
    }
    if(!invoice_date){
      $("#invoice_date").css('border','solid 1px red');
      e.preventDefault();
    }
    
  });

</script>
<script>
  $(document).ready(function () {
    $(".date-pick1").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });
  });

  //show selected date
  $(document).ready(function() {
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    $('.date-pick1').datepicker({
      format: "mm/dd/yyyy",
      todayHighlight: true,
      startDate: today,
      endDate: end,
      autoclose: true
    });
    
    $('.date-pick1').datepicker('setDate', today);
  });

  $(document).ready(function () {
    $(".date-pick").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });
  });

  $('body').on('focus',".date-pick", function(){
    $(this).datepicker();
  });
  //form submit script
  $("#checkout_btn").click(function(){
    
    var formData = new FormData($("#travels_form")[0]);
    
      $.ajax({
        url : 'insert_data.php?type=generate_invoice',
        data : formData,
        type : 'post',
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
          if(data == 0){
            window.location.href ='room_view.php?checkin_id=<?php echo $invoice_up['checkin_id'];?>&room_number=<?php echo $invoice_up['room_number'];?>'; 
          
          }else if(data == 2){
            $("#message").html('<div class="alert alert-success">Only (JPG) file type allowed.</div>');
          }else if(data == 3){
            $("#message").html('<div class="alert alert-success">File Size must be < 4 mb.</div>');
          }else{
            $("#message").html('<div class="alert alert-danger">Please fill out all required fields.</div>');
          }
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

  var start = $('#checkin').datepicker('getDate');
  var end   = $('#checkout').datepicker('getDate');
  var days   = (end - start)/1000/60/60/24;
  $("#qty").val(days);

  $(document).on('change','#checkout,#checkin',function() {
    var start = $('#checkin').datepicker('getDate');
    var end   = $('#checkout').datepicker('getDate');
    var days   = (end - start)/1000/60/60/24;
    $("#qty").val(days);
  });

   
  
  </script>