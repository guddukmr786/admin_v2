<?php 

include_once('../lib/fetch_values.php');
$obj = new FetchValues();
if(isset($_GET['admin_id'])){
	$admin_id = $_GET['admin_id'];
	$reslut = $obj->getCirHotelDetailsForUpdate($admin_id);
}
?>

<style type="text/css">
   ul.chil-ul{
      margin-left: 30px;
      display: none;
   }
</style>
<!--Re-checkin modal -->
<h3 class="text-center" style="text-align:center!important;">Update User Details </h3>
<form action="#" class="idealforms" id="hotel_form" enctype="multipart/form-data" role="form" name="hotel_form" autocomplete="off">
   <span id="message"></span>
   <div class="field">
      <label class="main">Hotel Name<span style="color:red;">* </span>:</label>
      <input name="h_name" id="f_name" type="text" value="<?php if(isset($reslut['hotel_name'])) echo $reslut['hotel_name']; ?>" class="ipt"  placeholder="Hotel Name"></br>
      <input type="hidden" name="id" value="<?php echo $admin_id;?>">
   </div>
   <div class="field">
      <label class="main">Hotel Email<span style="color:red;">* </span>:</label>
      <input name="email" id="email" type="text" value="<?php if(isset($reslut['hotel_email'])) echo $reslut['hotel_email']; ?>" class="ipt"  placeholder="Enter Email"></br>
      <div id="email_msg"></div>
   </div>
   <div class="field">
      <label class="main">Hotel Contact<span style="color:red;">* </span>:</label>
      <input name="contact" id="contact" type="text" value="<?php if(isset($reslut['hotel_phone'])) echo $reslut['hotel_phone']; ?>" class="ipt"  placeholder="Hotel Contact"></br>
   </div>
   
   <div class="field">
      <label class="main">Hotel Address 1 <span style="color:red;">* </span>:</label>
      <input name="address1" id="address1" type="text" value="<?php if(isset($reslut['hotel_address'])) echo $reslut['hotel_address']; ?>" class="ipt"  placeholder="Hotel Address 1"></br>
   </div>
   <div class="field">
      <label class="main">Hotel Address 2 <span style="color:red;">* </span>:</label>
      <input name="address2" id="address2" type="text" value="<?php if(isset($reslut['hotel_address1'])) echo $reslut['hotel_address1']; ?>" class="ipt"  placeholder="Hotel Address 2"></br>
      <div class="match_user"></div>
   </div>
   
   <div class="field">
      <label class="main">Hotel Star<span style="color:red;"> * </span>:</label>
      <select name="star" id="selectt" class="star">
         <?php 
         $stars = array(1=>'*',2=>'**',3=>'***',4=>'****',5=>'*****');
         foreach ($stars as $key => $value ) { 
         ?>
         <option value="<?php echo $key;?>"<?php if(isset($reslut['hotel_star']) && $key == $reslut['hotel_star']) echo 'selected="selected"';?>><?php echo $value;?></option>
         <?php  } ?>
      </select>
   </div>
   <div class="footer">
      <div class="field buttons">
         <label class="main">&nbsp;</label>
         <input type="button" id="cir_hotel_edit_btn" name="cir_hotel_edit_btn" class="next" value="Submit" />
      
      </div>
   <div id='loadingmessage' style="display: none;">
      <img src='ajax-loader.gif'/>
   </div>
</form>
<a class="close" href=""></a> 
</div>
<?php //include_once('../include/footer.php');?>

<script type="text/javascript">
 
   $(document).ready(function(){ 
      $('#h_name,#email,#contact,#address1,.star').click(function(){
         $('#h_name').css("border", "");
         $('#email').css("border", "");
         $('#contact').css("border", "");
         $('#address1').css("border", "");
         $('.star').css("border", "");
      });
   });

   $('#cir_hotel_edit_btn').on('click', function(e) {
      var h_name = $('#h_name');
      var contact = $('#contact');
      var address1 = $('#address1');
      
      if(!h_name.val()) {
         $('#h_name').css("border", "1px solid red");
         $('#h_name').focus();
         e.preventDefault();
         return false;
      } 

      if(!contact.val()) {
         $('#contact').css("border", "1px solid red");
         $('#contact').focus();
         e.preventDefault();
         return false;
      } 

      if(!address1.val()) {
         $('#address1').css("border", "1px solid red");
         $('#address1').focus();
         e.preventDefault();
         return false;
      } 

   });

   //email validation script

   $("#email").keyup(function(){
      var email = $("#email").val();
      if(email){
         $.ajax({
            url : 'validate.php?email='+email,
            success:function(data){
               //alert(data);
               if(data == 1){
                  $("#messsage").hide(data);
                  $("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
                  return false;
               }else{
                  $("#email_msg").hide();
               }
            }
         });
      }
   });
   $("#email,#user_name").on('click',function(){
      
      var email = $("#email").val();
      if(email){
         $.ajax({
            url : 'validate.php?email='+email,
            success:function(data){
               //alert(data);
               if(data == 1){
                  $("#messsage").hide(data);
                  $("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
                  return false;
               }else{
                  $("#email_msg").hide();
               }
            }
         });
      }
   });

   $("#cir_hotel_edit_btn").click(function(event){
      event.preventDefault();
      var formData = new FormData($("#hotel_form")[0]);
     
      $.ajax({
         url: 'call_function.php?type=cir_hotel_details',
         type: 'POST', 
         data: formData,
         async: false,
         cache: false,
         contentType: false,
         processData: false,
         beforeSend: function() {
           $("#loadingmessage").show();
         },
         success: function (data) {
            $("#loadingmessage").hide();
            if(data == 0){
               $("#add_user_form")[0].reset();
               $("#message").html("<div class='alert alert-success'>Your data has been successfully saved.<div>");
            }else if(data == 1){
               $("#message").html("<div class='alert alert-danger'>Please fill out all required fields marked with an asterisk.<div>");
            }else if(data == 2){
                $("#message").html("<div class='alert alert-success'>You data has been updated<div>");
            }else{
               $("#message").html("<div class='alert alert-danger'>Something is wrong pleae try again later.<div>");
            }
         }
     });
   });
</script>