<?php echo '
<div class="row">
  <div class="col-md-2">
    <input type="text" class="form-control" placeholder="Bill ID" id="bill_id" name="bill_id[]" />
  </div>
  <div class="col-md-3">
    <input type="text" class="form-control" id="menu" name="menu[]" placeholder="Menu" />
  </div>
  <div class="col-md-2">
    <input type="number" class="form-control" id="qty" name="qty[]" placeholder="Qty" />
  </div>
  <div class="col-md-2">
    <input type="number" class="form-control" id="bill_amount" name="bill_amount[]" placeholder="Bill Amout" />
  </div>
  <div class="col-md-2">
    <input type="number" class="form-control" id="totla_amount" name="total_amount[]" placeholder="Total Amount" />
  </div>
</div>
&nbsp;

<div id="wrapelement2"></div>

<script type="text/javascript">
$("#qty, #bill_amount").change(function(){

  var qty = parseFloat($("#qty").val()) || 0;

  var amount = parseFloat($("#bill_amount").val()) || 0;

  $("#total_amount").val(qty * amount);

});

</script>

';?>