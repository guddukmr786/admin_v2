<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

if(isset($_GET['admin_id'])){
   $admin_id = $_GET['admin_id'];
}
?>

<!--Re-checkin modal -->
<h3 class="text-center" style="text-align:center!important;">Change Password</h3>
<div class="message"></div>
<form action="#" class="idealforms" id="change_password_form" enctype="multipart/form-data" role="form" name="change_password_form" autocomplete="off">
   <div class="field">
      <label class="main">Password<span style="color:red;"> * </span>:</label>
      <input name="password" id="password" type="password" class="ipt" placeholder="Password"></br>
      <input type="hidden" name="id" value="<?php echo $admin_id;?>">
   </div>
   <div class="field">
      <label class="main">Confirm Password<span style="color:red;"> * </span>:</label>
      <input name="c_password" id="c_password" type="password" class="ipt" placeholder="Enter Confirm Password"></br>
      <div class="match"></div>
   </div>
   <div class="footer">
      <div class="field buttons">
         <label class="main">&nbsp;</label>
         <input type="button" class="reset" id="reset_day_book" value="Reset" />
         <input type="button" id="change_password" name="change_password" class="next" value="Submit" />
      </div>
   <div id='loadingmessage' style="display: none;">
      <img src='ajax-loader.gif'/>
   </div>
</form>
<a class="close" href=""></a> 
</div>
<?php// include_once('../include/footer.php');?>
<script type="text/javascript">
 
   $(document).ready(function(){ 
      $('#password,#c_password').click(function(){
         $('#password').css("border", "");
         $('#c_password').css("border", "");
      });
   });

   $(document).on('click','#change_password', function(e) {
      var password = $('#password');
      var c_password = $('#c_password');
      if(!password.val()) {
         $('#password').css("border", "1px solid red");
         $('#password').focus();
         e.preventDefault();
         return false;
      } 

      if(!c_password.val()) {
         $('#c_password').css("border", "1px solid red");
         $('#c_password').focus();
         e.preventDefault();
         return false;
      } 
      
   });


   $(document).on("click","#change_password",function(event){
        event.preventDefault();
        var formData = $("#change_password_form").serialize();
        $.ajax({
           url: 'insert_data.php?type=change_password',
           type: 'POST', 
           data: formData,
           beforeSend: function() {
             $("#loadingmessage").show();
           },
           success: function (data) {
              
              $("#loadingmessage").hide();
              if(data == 0){
                $("#change_password_form")[0].reset();
                $(".message").html("<div class='alert alert-success'>Your data has been successfully saved.<div>");
              }else if(data == 1){
                  $(".message").html("<div class='alert alert-danger'>Please fill out all required fields marked with an asterisk.<div>");
              }else if(data == 2){
                  $(".message").html("<div class='alert alert-danger'>Password dosen't matched<div>");
              }else{
                  $(".message").html("<div class='alert alert-danger'>Something is wrong pleae try again later.<div>");
              }
          }
        });
    });
</script>