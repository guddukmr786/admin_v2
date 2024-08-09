<?php 
include('../include/header2.php'); 
include('is_login.php');
$countries = $obj->getCountries();
$parties = $obj->getPartyDetails();

//update data
if(!empty($_GET['id'])){
  $id = $_GET['id'];
  $invoice_up = $obj->getGeneratedInvoiceValueById($id);
  $invoice_up_date = $obj->getDateDayById($id);
} 
?>
<div class="content">
  <div class="col-md-6"><h3><span class="clr_red">Add Travels Details</span></h3></div>
  <hr>
  <span style="margin-left:18px;font-size: 14px" id="bookingvia"></span>
  <form class="form-group" action="#" method="post" role="form" name="travels_form" id="travels_form" autocomplete="off">
    <div class="form-group">
      <label for="party" class="col-sm-2 control-label">Select Party</label>
      <div class="col-sm-4" style="padding-left:0px">
          <select id="party" name="party" class="form-control">
            <option value="">Select Party</option>
            <?php 
            foreach ($parties as $party) { 
            if (isset($invoice_up['name'])) { 
            ?>
            <option value="<?php echo $party['booking_via_id']?>"<?php if($party['booking_via_id'] == $invoice_up['party_id']) echo 'selected="selected"';?>><?php echo $party['category_name']?></option>
            <?php } else { ?>
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
        <label for="name" class="col-sm-2 control-label">Booking ID</label>
        <div class="col-sm-4" style="padding-left:0px;">
            <input type="text" id="booking" name="booking" value="<?php if(!empty($invoice_up['booking_id'])) echo $invoice_up['booking_id'];?>" placeholder="Booking ID" class="form-control" autofocus>
        </div>

        <label for="name" class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-4" style="padding-left:0px;">
            <input type="text" id="name" name="name" value="<?php if(!empty($invoice_up['name'])) echo $invoice_up['name'];?>" placeholder="Full Name" class="form-control" autofocus>
            <input type="hidden" name="checkin_id" value="">
        </div>
    </div>
    
    <div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="email" name="email" value="<?php if(!empty($invoice_up['email'])) echo $invoice_up['email'];?>" placeholder="Email" class="form-control" autofocus>
      </div>
      <label for="contact" class="col-sm-2 control-label">Cotact Number</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="contact" name="contact" value="<?php if(!empty($invoice_up['contact'])) echo $invoice_up['contact'];?>" placeholder="Contact Number" class="form-control" autofocus>
      </div>
    </div>
    <div class="clear"></div>
    <div class="form-group">
      <label for="City" class="col-sm-2 control-label">City</label>
      <div class="col-sm-4" style="padding-left:0px;">
          <input type="text" id="city" name="city" value="<?php if(!empty($invoice_up['city'])) echo $invoice_up['city'];?>" placeholder="City name" class="form-control" autofocus>
      </div>

      <label for="country" class="col-sm-2 control-label">Nationality</label>
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

      <label for="firstName" class="col-sm-2 control-label">Date Of Invoice</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="invoice_date" name="invoice_date" value="<?php if(!empty($invoice_up['invoice_date'])) echo $invoice_up['invoice_date'];?>" placeholder="dd/mm/yyyy" class="form-control date-pick1 ipt" autofocus>
      </div>
     
    </div>
    
    <div class="clear"></div>
    <?php /*<div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Attachment</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="file" id="image" name="image[]" placeholder="Select Image" class="form-control" autofocus multiple="">
      </div>
      <label for="Passport" class="col-sm-2 control-label">Passport Details</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="passport" name="passport" value="<?php if(!empty($invoice_up['passport'])) echo $invoice_up['passport'];?>" placeholder="Passport Details" class="form-control" autofocus>
      </div>
    </div>
    <div class="clear"></div>
    <div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Inculsion</label>
      <div class="col-sm-4" style="padding-left:0px">
          <textarea type="text" id="inc" name="inc" placeholder="Inculsion" cols="4" rows="4" class="form-control" autofocus><?php if(!empty($invoice_up['inclusion'])) echo $invoice_up['inclusion'];?></textarea> 
      </div>
      <label for="firstName" class="col-sm-2 control-label">Exclution</label>
      <div class="col-sm-4" style="padding-left:0px">
          <textarea type="text" id="exc" name="exc" placeholder="Exclution" cols="4" rows="4" class="form-control" autofocus><?php if(!empty($invoice_up['exclusion'])) echo $invoice_up['exclusion'];?></textarea> 
      </div>
    </div>*/?>

    <div class="clear"></div>
    <p>&nbsp;</p>
    <table class="table table-bordered table-hover" id="tab_logic">
      <thead>
        <tr >
           <th>Description</th>
           <th>Check in Date</th>
           <th>Check out Date</th>
           <th>HSN/SAC Code</th>
           <th>Unit</th>
           <th>Qty.</th>
           <th>Price</th>
           <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=0;
        if(!empty($invoice_up_date)){
          
         foreach($invoice_up_date as $values ){
        
        ?>
        <tr id='addr<?php echo $i;?>'>
          <input type="hidden" name="travel_id" id="travel_id" value="<?php if(!empty($id)) echo $id;?>">
          <td style="">
            <input  type="text" name="description[]" value="<?php echo $values['description'];?>" class="form-control ipt" id="description"  placeholder="" />
          </td>
          <td >
            <input  type="text" name="checkin[]" value="<?php echo $values['checkin_date'];?>" class="form-control date-pick ipt" id="checkin"  placeholder="" />
          </td>
          <td>
            <input type="text" name="checkout[]" value="<?php echo $values['checkout_date'];?>" class="form-control date-pick ipt" id="checkout" placeholder="" />
          </td>
          <td>
            <input type="text" name="hsncode[]" value="<?php echo $values['hsn_code'];?>" class="form-control " id="hsncode" placeholder="" />
          </td>
          <td>
            <input  type="text" name="unit[]" value="<?php echo $values['unit'];?>" class="form-control ipt" id="unit" value="nights"  placeholder="" />
          </td>
          <td>
            <input type="text" name="qty[]" value="<?php echo $values['qty'];?>" class="form-control qty" id="qty" placeholder="" />
          </td>
          <td>
            <input type="text" name="price[]" value="<?php echo $values['price'];?>" class="form-control price" id="price" placeholder="" />
          </td>
          <td>
            <input type="text" name="amount[]" value="<?php echo $values['amount'];?>" class="form-control amount" id="amount<?php echo $i;?>" placeholder="" />
          </td>
        </tr>
        
        <?php $i++; } } else { ?>
        <tr id='addr<?php echo $i;?>'>
          <td style="width: 200px!important;">
            <input  type="text" name="description[]" class="form-control ipt" id="description" value="Room Accommodation"  placeholder="" />
          </td>
          <td >
            <input  type="text" name="checkin[]" value="" class="form-control date-pick ipt" id="checkin"  placeholder="" />
          </td>
          <td>
            <input type="text" name="checkout[]" value="" class="form-control date-pick ipt" id="checkout" placeholder="" />
          </td>
          <td>
            <input type="text" name="hsncode[]" value="9963" class="form-control " id="hsncode" placeholder="" />
          </td>
          <td>
            <input  type="text" name="unit[]" class="form-control" id="unit" value="nights" placeholder="" />
          </td>

          <td>
            <input type="text" name="qty[]" class="form-control qty" id="qty" placeholder="" />
          </td>
          <td>
            <input type="text" name="price[]" class="form-control price" id="price" placeholder="" />
          </td>
          <td>
            <input type="text" name="amount[]" class="form-control amount" id="amount0" placeholder="" />
          </td>
        </tr>
        <?php $i++;} ?>
        <tr id='addr<?php echo $i;?>'></tr>
      </tbody>
    </table>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="subtotal" name="subtotal" value="<?php if(!empty($invoice_up['sub_total'])) echo $invoice_up['sub_total'];?>" placeholder="Enter CGST Amount" />
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
        <input type="text" class="form-control" id="comm" name="comm" value="<?php if(!empty($invoice_up['commission'])) echo $invoice_up['commission']; else echo 0.00;?>" placeholder="Commission" />
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
   <?php /* <div class="clear"></div>
     <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" class="form-control" id="sgstcm" name="sgstcm" value="<?php if(!empty($invoice_up['gst'])) echo $invoice_up['gst'];?>" placeholder="SGST Commmission" />
      </div>
      <div class="col-md-4" style="float: right;padding-top: 5px;"> Less SGST On Commmission @ 9%: </div>
    </div>*/?>
    <div class="clear"></div>

    <hr>
    <div>
      <div class="col-md-2" style="float:right;padding-right:5px;" >
        <input type="text" onclick="subTatoal()" class="form-control" id="total" name="total" value="<?php if(!empty($invoice_up['total_amount'])) echo $invoice_up['total_amount'];?>" placeholder="Total Amount" />
      </div>
      <div class="col-md-4" style="float: right;padding-top: 5px;">Total Amount : </div>
    </div>
    
    <div class="clear"></div>
    <div class="row mt30">
      <div class="col-md-2 pull-right"><input type="button" id="travel_btn" name="travel_btn" class="form-control btn-danger" value="Submit"/></div>
      <div class="col-md-2 pull-right"><input type="button" class="form-control btn-success" id="add_row" value="Add More" /></div>
      <div class="col-md-2 pull-right"><input type="button" class="form-control btn-danger" id="delete_row" value="Delete Summary" /></div>
      <img class="modallodar" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      <span id="message"></span>
    </div>
  </form>
</div>

<?php include('../include/footer.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">

  $(".hotel").change(function(){
      var hotel_id = $(this).attr("value");
      $.ajax({
          url : "save_hotel_id.php?hotel_id="+hotel_id,
          success:function(data){
            window.location.href='generate_invoice.php';
          }
      });
   });

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
    var div_val = value / 2;
    if(div_val == 0.5){
      div_val = 0;
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

    var comm = $("#comm").val();
    var comm9 = (comm * 18)/100;
  
    $("#cgstcm").val(comm9.toFixed(2));
  
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
  $(document).on("keyup","#booking", function(){
    var value = $(this).val();
    if(value){
        $.ajax({
        url : 'guest_details.php?bid='+value,
        dataType : 'JSON',
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
          if(data){
            $("#bookingvia").text(data.booking_via);
            $("#name").val(data.name);
            $("#email").val(data.email);
            $("#contact").val(data.phone);
            $("#city").val(data.state);
            $("#qty").val(data.booking_nights);
            $("#amount0").val(data.booking_amount);
            $("#price").val(data.booking_amount / data.booking_nights);
            $("#dob").val(data.date_of_birth);
            $("#checkin").val(data.checkin_date);
            $("#checkout").val(data.checkout_date);
            $("#checkin_id").val(data.checkin_id);

          }else{
            $("#name").val('');
            $("#email").val('');
            $("#contact").val('');
            $("#city").val('');
            $("#qty").val('');
            $("#amount0").val('');
            $("#price").val('');
            $("#dob").val('');
            $("#checkin").val('');
            $("#checkout").val('');
            $("#checkin_id").val('');
          }
          
        }
      });
    }
    
  });

</script>

<script type="text/javascript">
//name=&dob=&email=&passport=&city=&country=&party=&inc=&exc=&checkin_id=&day_date%5B%5D=&details%5B%5D=&amount%5B%5D=&cgst=&sgst=&gst=&total=
  $('#name,#contact, #city, #country, #details, #amount,#total,#comm').click(function(){
    $("#name").css('border','');
    $("#contact").css('border','');
    $("#passport").css('border','');
    $("#city").css('border','');
    $("#country").css('border','');
    $("#details").css('border','');
    $("#amount").css('border','');
    $("#total").css('border','');
    $("#comm").css('border','');
  });

  $('#travel_btn').click(function(e) {
    var name = $("#name").val();
    var contact = $("#contact").val();
    var city = $("#city").val();
    var country = $("#country").val();
    var details = $("#details").val();
    var amount = $("#amount").val();
    var total = $("#total").val();
    var comm = $("#comm").val();

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
    
    if(!comm){
      $("#comm").css('border','solid 1px red');
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
    var invoice_date = $("#invoice_date").val();
    if(!invoice_date){
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
    }
  });


  $(document).ready(function () {
    $(".date-pick").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });
  });

  $('body').on('focus',".date-pick", function(){
    $(this).datepicker();
  });
  //form submit script
  $("#travel_btn").click(function(){
    var formData = new FormData($("#travels_form")[0]);
    $.ajax({
      url : 'insert_data.php?type=generate_invoice',
      data : formData,
      type : 'post',
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".modallodar").show();
      },
      success:function(data){
        $(".modallodar").hide();
        if(data == 0){
          $("#message").html('<div class="alert alert-success">Travel Details has been saved.</div>');
          setTimeout(function(){
            window.location.href ='view_invoice.php'; 
          },2000);

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
</body>
</html>

