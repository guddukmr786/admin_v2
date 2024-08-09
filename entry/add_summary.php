<?php 
include('../include/header2.php'); 
include('is_login.php');

?>
<div class="content">
  <div class="col-md-6"><h3><span class="clr_red">Add Room Summary Details</span></h3></div>
  <hr>
  <form class="form-group" action="#" method="post" role="form" name="summary_form" id="summary_form" autocomplete="off">
    <table class="table table-bordered table-hover" id="tab_logic">
      <thead>
        <tr >
           <th class="text-center">Bill ID<span style="color:red;">*</span></th>
           <th class="text-center">Menu<span style="color:red;">*</span></th>
           <th class="text-center">Qty<span style="color:red;">*</span></th>
           <th class="text-center">Price(Per Itme)<span style="color:red;">*</span></th>
           <th class="text-center">Total Amout <span style="color:red;">*</span></th>
        </tr>
      </thead>
      <tbody>
        <tr id='addr0'>
          <input type="hidden" name="checkin_id" id="checkin_id" value="<?php echo $customer_details['checkin_id'];?>">
          <td>
            <input type="text" name="bill_id[]" class="form-control bill_id" id="bill_id"  placeholder="Bill ID" />
          </td>
          <td>
            <input type="text" name="menu[]" class="form-control menu" id="menu" placeholder="Menu" />
          </td>
          <td>
            <input type="number" name="qty[]" class="form-control qty" id="qty" placeholder="Qty" />
          </td>
          <td>
            <input  type="number" class="form-control bill_amount" id="bill_amount" name="bill_amount[]" placeholder="Bill Amount" >
          </td>
          <td>
            <input type="number" class="form-control total_amount" id="total_amount" name="total_amount[]" placeholder="Total Amount" >
          </td>
        </tr>
        <tr id='addr1'></tr>
      </tbody>
    </table>
    <div class="col-md-3" style="float:right;padding-right:0px;" >
      <input type="number" class="form-control" id="room_number" name="room_number" placeholder="Enter Room Number" />
    </div>
    <div class="clear"></div>
    <div class="row mt30">
      <div class="col-md-2 pull-right"><input type="button" id="add_summary" name="add_summary" class="form-control btn-danger" value="Submit"/></div>
      <div class="col-md-2 pull-right"><input type="button" class="form-control btn-success" id="add_row" value="Add More" /></div>
      <div class="col-md-2 pull-right"><input type="button" class="form-control btn-danger" id="delete_row" value="Delete Summary" /></div>
      <span id="message"></span>
    </div>
  </form>
</div>

<?php include('../include/footer.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
  $("#add_summary").click(function(){
    var room_number = $("#room_number").val();
    var formData = $("#summary_form").serialize();
    if(room_number){
      $.ajax({
        url : 'check_room_is_booked.php?room_number='+room_number+'&&type=add_summary',
        success:function(res){
          if(res == 0){
            $.ajax({
              url : 'insert_data.php?type=add_summary',
              data : formData,
              type : 'post',
              success:function(data){
                if(data = 2){
                  $("#message").html('<div class="alert alert-success">Room summary has been saved.</div>');
                  setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                  }, 2000); 
                }else{
                  $("#message").html('<div class="alert alert-danger">Please fill out all required fields.</div>');
                }
              }
            });
          }else{
            $("#message").html('<div class="alert alert-danger">This room is not booked</div>');
          }
        }
      });
    }
    
  });

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
  $('#bill_id, #menu, #qty, #bill_amount, #total_amount,#room_number').click(function(){
    $("#bill_id").css('border','');
    $("#menu").css('border','');
    $("#qty").css('border','');
    $("#bill_amount").css('border','');
    $("#total_amount").css('border','');
    $("#room_number").css('border','');
  });

  $('#add_summary').click(function(e) {
    var bill_id = $("#bill_id").val();
    var menu = $("#menu").val();
    var qty = $("#qty").val();
    var bill_amount = $("#bill_amount").val();
    var total_amount = $("#total_amount").val();
    var room_number = $("#room_number").val();
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

    if(!room_number){
      $("#room_number").css('border','solid 1px red');
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
    if(room_number){
      $("#room_number").css('border','');
    }
    
  });

</script>
</body>
</html>

