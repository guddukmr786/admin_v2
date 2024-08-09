<?php 
include('../include/header2.php'); 
include('is_login.php');
$countries = $obj->getCountries();
$parties = $obj->getPartyDetails();

//update data
if(!empty($_GET['id'])){
  $id = $_GET['id'];
  $invoice_up = $obj->getGeneratedInvoiceValueOfSushantTravelsById($id);
  $invoice_up_date = $obj->getDateDayOfSushantTravelsById($id);
} 
?>
<div class="content">
  <div class="col-md-6"><h3><span class="clr_red">Add Travels Details</span></h3></div>
  <hr>
  <form class="form-group" action="#" method="post" role="form" name="travels_form" id="travels_form" autocomplete="off">
  
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Full Name <span style="color: red;">*</span></label>
      <div class="col-sm-4" style="padding-left:0px;">
          <input type="text" id="name" name="name" value="<?php if(!empty($invoice_up['name'])) echo $invoice_up['name'];?>" placeholder="Full Name" class="form-control" autofocus>
          <input type="hidden" name="checkin_id" value="">
      </div>
      <label for="party" class="col-sm-2 control-label">Select Tax % <span style="color: red;">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <select id="tax" name="tax" class="form-control">
            <?php 
            $tax_per = array(0 =>'LGST 0%',5 =>'LGST 5%',12 =>'LGST 12%',18=>'LGST 18%',28=>'LGST 28%',01 =>'IGST 0%',10 =>'IGST 5%',24=>'IGST 12%',36=>'IGST 18%',56=>'IGST 28%');
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
    
    <div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="email" name="email" value="<?php if(!empty($invoice_up['email'])) echo $invoice_up['email'];?>" placeholder="Email" class="form-control" autofocus>
      </div>
      <label for="contact" class="col-sm-2 control-label">Cotact Number <span style="color: red;">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="contact" name="contact" value="<?php if(!empty($invoice_up['contact'])) echo $invoice_up['contact'];?>" placeholder="Contact Number" class="form-control" autofocus>
      </div>
      
    </div>
    <div class="clear"></div>
    <div class="form-group">
      <label for="City" class="col-sm-2 control-label">City <span style="color: red;">*</span></label>
      <div class="col-sm-4" style="padding-left:0px;">
          <input type="text" id="city" name="city" value="<?php if(!empty($invoice_up['city'])) echo $invoice_up['city'];?>" placeholder="City name" class="form-control" autofocus>
      </div>
      <label for="country" class="col-sm-2 control-label">Nationality <span style="color: red;">*</span></label>
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
      <label for="firstName" class="col-sm-2 control-label">Date Of Invoice <span style="color: red;">*</span></label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="invoice_date" name="invoice_date" value="<?php if(!empty($invoice_up['invoice_date'])) echo $invoice_up['invoice_date'];?>" placeholder="dd/mm/yyyy" class="form-control date-pick1 ipt" autofocus>
      </div>
     
    </div>
    
    <div class="clear"></div>
    <div class="form-group">
      <label for="firstName" class="col-sm-2 control-label">Attachment</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="file" id="image" name="image[]" placeholder="Select Image" class="form-control" autofocus multiple="">
      </div>
      <label for="Passport" class="col-sm-2 control-label">Passport Details</label>
      <div class="col-sm-4" style="padding-left:0px">
          <input type="text" id="passport" name="passport" value="<?php if(!empty($invoice_up['passport_details'])) echo $invoice_up['passport_details'];?>" placeholder="Passport Details" class="form-control" autofocus>
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
    </div>

    <div class="clear"></div>
    <p>&nbsp;</p>
    <table class="table table-bordered table-hover" id="tab_logic">
      <thead>
        <tr >
          <th>S.N.</th>
          <th>Day<span style="color: red;">*</span></th>
          <th>Description<span style="color: red;">*</span></th>
          <th>HSN/SAC Code<span style="color: red;">*</span></th>
          <th>Amount<span style="color: red;">*</span></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=0;
        $j=1;
        if(!empty($invoice_up_date)){
          
         foreach($invoice_up_date as $values ){
        
        ?>
        <tr id='addr<?php echo $i;?>'>
          <input type="hidden" name="s_invoice_id" id="s_invoice_id" value="<?php if(!empty($id)) echo $id;?>">
          <td style="">
            <p><?php echo $j++;?></p>
          </td>
          <td >
            <input  type="text" name="checkin[]" value="<?php echo $values['days']?>" class="form-control date-pick ipt" id="checkin"  placeholder="" />
          </td>
          <td>
            <input style="width: 500px!important;" type="text" name="description[]" id="description" value="<?php echo $values['description']?>" class="form-control ipt">
          </td>
          <td>
            <input type="text" name="hsncode[]" value="<?php echo $values['hsn_code']?>" class="form-control " id="hsncode" placeholder="" />
          </td>
          <td>
            <input type="text" name="amount[]" value="<?php echo $values['amount']?>" class="form-control amount1" id="amount<?php echo $i;?>" placeholder="" />
          </td>
        </tr>
        
        <?php $i++; } } else { ?>
        <tr id='addr<?php echo $i;?>'>
          <td style="">
            <p><?php echo $j++;?></p>
          </td>
          <td >
            <input  type="text" name="checkin[]" value="" class="form-control date-pick ipt" id="checkin"  placeholder="" />
          </td>
          <td>
            <input style="width: 500px!important;" type="text" name="description[]" id="description" value="" class="form-control ipt">
          </td>
          <td>
            <input type="text" name="hsncode[]" value="9963" class="form-control " id="hsncode" placeholder="" />
          </td>
          <td>
            <input type="text" name="amount[]" class="form-control amount1" id="amount0" placeholder="" />
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
        window.location.href='generate_sushant_invoice.php';
      }
    });
  });

  $(document).ready(function(){

    $("#delete_row").hide();
    var i = '<?php echo $i;?>';
    var j = '<?php echo $j;?>'

    if(i > 1){
      $("#delete_row").show();
    }else{
      $("#delete_row").hide();
    }

    $("#add_row").click(function(){

      $('#addr'+i).html('<td style=""><p>'+j+'</p></td><td ><input  type="text" name="checkin[]" value="" class="form-control date-pick ipt" id="checkin"  placeholder="" /></td><td><input style="width: 500px!important;" type="text" name="description[]" id="description" value="" class="form-control ipt"></td><td><input type="text" name="hsncode[]" class="form-control menu" id="hsncode" value="9963" placeholder="" /></td><td><input type="text" value="0.00" name="amount[]" class="form-control" id="amount'+i+'" placeholder="" /></td>');
      i++; 
      j++;
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
      j--;
    }
  });
  


  $("#tax").on('change',function(){
    var value = $(this).val();
    if(value == 1){
      var div_val = 0;
    }else{
      var div_val = value / 2;
    }

    if(value == 1 || value == 10 || value == 24 || value == 36 || value == 56){

      $(".igst").text('Add IGST @ '+div_val+'%');
      $(".sgst").text('ADD SGST @ 0%');
      $(".cgst").text('ADD CGST @ 0%');
    }else{
      $(".igst").text('Add IGST @ 0%');
      $(".sgst").text('ADD SGST @ '+div_val+'%');
      $(".cgst").text('ADD CGST @ '+div_val+'%');
    }
  });


  $(document).on('click','#cgst,#sgst,#igst,#total,#subtotal',function(){
    var total = 0;
    var tax = $("#tax").val()/2;

    //var taxCal = 0;
    for (var j = 0; j < i; j++) {
      total += parseInt($("#amount"+j).val());

      /*if($("#amount"+j).val() > 999){
          taxCal += ($("#amount"+j).val()*tax)/100;
      }*/
    }
    var taxCal = (total*tax)/100;

    $("#subtotal").val(total.toFixed(2));

    if($("#tax").val() == 1 || $("#tax").val() == 10 || $("#tax").val() == 24 || $("#tax").val() == 36 || $("#tax").val() == 56){
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
  
    var grand_total = sgst_total;

    $("#total").val(grand_total.toFixed(2));

  });
  
});

</script>

<script type="text/javascript">
//name=&dob=&email=&passport=&city=&country=&party=&inc=&exc=&checkin_id=&day_date%5B%5D=&details%5B%5D=&amount%5B%5D=&cgst=&sgst=&gst=&total=
  $('#name,#contact, #city, #country, #details, .amount1,#total,#checkin,#description').click(function(){
    $("#name").css('border','');
    $("#contact").css('border','');
    $("#passport").css('border','');
    $("#city").css('border','');
    $("#country").css('border','');
    $("#details").css('border','');
    $(".amount").css('border','');
    $("#total").css('border','');
    $("#checkin").css('border','');
    $("#description").css('border','');
  });

  $('#travel_btn').click(function(e) {
    var name = $("#name").val();
    var contact = $("#contact").val();
    var city = $("#city").val();
    var country = $("#country").val();
    var details = $("#details").val();
    var amount = $(".amount").val();
    var total = $("#total").val();
    var checkin = $("#checkin").val();
    var description = $("#description").val();

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
      $(".amount").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!total){
      $("#total").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!checkin){
      $("#checkin").css('border','solid 1px red');
      e.preventDefault();
    }

    if(!description){
      $("#description").css('border','solid 1px red');
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
  $("#travel_btn").click(function(){
    var formData = new FormData($("#travels_form")[0]);
    $.ajax({
      url : 'insert_data.php?type=generate_sushant_invoice',
      data : formData,
      type : 'post',
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
      
        if(data == 0){
          $("#message").html('<div class="alert alert-success">Travel Details has been saved.</div>');
          //setTimeout(function(){
           // window.location.href ='view_invoice.php'; 
         // },2000);

        }else if(data == 2){
          $("#message").html('<div class="alert alert-success">Only (JPG|GIF|PNG) file type allowed.</div>');
        }else if(data == 3){
          $("#message").html('<div class="alert alert-success">File Size must be < 4 mb.</div>');
        }else if(data == 1){
          $("#message").html('<div class="alert alert-danger">Please fill out all required fields.</div>');
        }else{
          $("#message").html('<div class="alert alert-danger">Internal server problem please try agin later.</div>');
        }
      }
    });
  });
</script>
</body>
</html>

