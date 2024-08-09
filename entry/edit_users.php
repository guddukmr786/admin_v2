<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

if(isset($_GET['admin_id'])){
	$admin_id = $_GET['admin_id'];
	$reslut = $obj->getUserDetailsForUpdate($admin_id);

   $all_hotels = $obj->getAllHotelDetails();
   if(isset($reslut['name'])){
      $name = explode(' ',$reslut['name']);
      $f_name = $name[0];
      $last_name = $name[1];
   }
   $previlege = explode('|', $reslut['previleges']);
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
<form action="#" class="idealforms" id="add_user_form" enctype="multipart/form-data" role="form" name="add_user_form" autocomplete="off">
   <span id="message"></span>
   <div class="field">
      <label class="main">First Name<span style="color:red;">* </span>:</label>
      <input name="f_name" id="f_name" type="text" value="<?php if(isset($f_name)) echo $f_name; ?>" class="ipt"  placeholder="Enter first Name"></br>
      <input type="hidden" name="id" value="<?php echo $admin_id;?>">
   </div>
   <div class="field">
      <label class="main">Last Name:</label>
      <input name="last_name" id="last_name" type="text" value="<?php if(isset($last_name)) echo $last_name; ?>" class="ipt"  placeholder="Enter Last name"></br>
   </div>
   <div class="field">
      <label class="main">Email<span style="color:red;">* </span>:</label>
     
      <input name="email" id="email" type="text" value="<?php if(isset($reslut['email'])) echo $reslut['email']; ?>" class="ipt"  placeholder="Enter Email"></br>
     
      <div id="email_msg"></div>
   </div>
   <div class="field">
      <label class="main">User Name<span style="color:red;">* </span>:</label>
      
      <input name="user_name" id="user_name" onkeypress="return avoidSpace(event)" type="text" value="<?php if(isset($reslut['user_name'])) echo $reslut['user_name']; ?>" class="ipt"  placeholder="Enter User Name without space"></br>
      
      <div class="match_user"></div>
   </div>
   
   <div class="field">
      <label class="main">User Type<span style="color:red;"> * </span>:</label>
      <select name="user_type" id="selectt" class="user_type">
         <option value="">Select User Type</option>
         <?php 
         $user_type = array('Super Admin','Admin','Manager');
         foreach ($user_type as $user_t) { 
         ?>
         <option value="<?php echo $user_t;?>"<?php if(isset($reslut['user_type_hai']) && $user_t == $reslut['user_type_hai']) echo 'selected="selected"';?>><?php echo $user_t;?></option>
         <?php  } ?>
      </select>
   </div>
   <?php if(!empty($reslut['user_type_hai']) && $reslut['user_type_hai'] =='Manager' ){ ?>
   <div class="field hotel_ss" >
      <label class="main">Hotels<span style="color:red;"> * </span>:</label>
      <select name="hotel_name" id="selectt" class="hotel_name">
         <option value="">Select hotel</option>
         <?php 
         foreach ($all_hotels as $all_hotel) { 
         ?>
         <option value="<?php echo $all_hotel['hotel_id'];?>"<?php if(isset($reslut['hotel_id']) && $reslut['hotel_id'] == $all_hotel['hotel_id']) echo 'selected="selected"';?>><?php echo $all_hotel['hotel_name'];?></option>
         <?php  } ?>
      </select>
   </div>
   <?php } ?>
<!--tab with checkbox-->
   <div class="clear"></div>
   <div class="field hummingbird-treeview">
      <label class="main">Previleges<span style="color:red;"> * </span>:</label>
      <div id="treeview_container" class="hummingbird-treeview">
          <ul id="treeview" style="margin-left: 0px;">
            <li> 
               <ul>
                  <li>
                     <span class="glyphicon glyphicon-minus"></span>
                     <?php if(in_array('Room View', $previlege)){ ?>
                     <input  id="xnode-0-0" name="previleges[]" data-id="custom-0-0" type="checkbox" value="Room View" checked="checked" />
                     <?php } else { ?>
                     <input  id="xnode-0-0" name="previleges[]" data-id="custom-0-0" type="checkbox" value="Room View" />
                     <?php } ?>
                     <label>Room View</label>
                  </li>
                  <li>
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('CIR Guest', $previlege)){ ?>
                     <input  id="xnode-0-1" name="previleges[]" data-id="custom-0-1" type="checkbox" value="CIR Guest" checked="checked" />
                     <?php } else { ?>
                     <input  id="xnode-0-1" name="previleges[]" data-id="custom-0-1" type="checkbox" value="CIR Guest" />
                     <?php } ?>
                     <label>CIR Guest </label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('Guest Entry Form', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-1-1" data-id="custom-0-1-1" type="checkbox"  value="Guest Entry Form" checked="checked" />
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-1-1" data-id="custom-0-1-1" type="checkbox"  value="Guest Entry Form" />
                           <?php } ?>
                           <label>Guest Entry Form</label>
                        </li>
                        <li>
                           <?php if(in_array('Guest Entry List', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" value="Guest Entry List" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" value="Guest Entry List" />
                           <?php } ?>
                           <label>Guest Entry List</label>
                        </li>
                     </ul>
                  </li>
                  <li> 
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('CIR Arrival Booking', $previlege)){ ?>
                     <input  id="xnode-0-2" name="previleges[]" data-id="custom-0-2" type="checkbox" value="CIR Arrival Booking" checked="checked"/>
                     <?php } else { ?>
                     <input  id="xnode-0-2" name="previleges[]" data-id="custom-0-2" type="checkbox" value="CIR Arrival Booking" />
                     <?php } ?>
                     <label>CIR Arrival Booking</label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('Arrival Booking Form', $previlege)){ ?>
                           <input class="hummingbirdNoParent" id="xnode-0-2-1" name="previleges[]" data-id="custom-0-2-1" type="checkbox" value="Arrival Booking Form" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" id="xnode-0-2-1" name="previleges[]" data-id="custom-0-2-1" type="checkbox" value="Arrival Booking Form" />
                           <?php } ?>
                           <label>Arrival Booking Form</label>
                        </li>
                        <li>
                           <?php if(in_array('Arrival Booking List', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" value="Arrival Booking List" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" value="Arrival Booking List" />
                           <?php } ?>
                           <label>Arrival Booking List</label>
                        </li>
                     </ul>
                  </li>
                  <li> 
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('Day Book', $previlege)){ ?>
                     <input  id="xnode-0-3" name="previleges[]" data-id="custom-0-3" type="checkbox" value="Day Book" checked="checked"/>
                     <?php } else { ?>
                     <input  id="xnode-0-3" name="previleges[]" data-id="custom-0-3" type="checkbox" value="Day Book" />
                     <?php } ?>
                     <label>Day Book</label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('Entry Day Book', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-3-1" data-id="custom-0-3-1" type="checkbox" value="Entry Day Book" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-3-1" data-id="custom-0-3-1" type="checkbox" value="Entry Day Book" />
                           <?php } ?>
                           <label>Entry Day Book</label>
                        </li>
                        <li>
                           <?php if(in_array('View Day Book', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-3-2" data-id="custom-0-3-2" type="checkbox" value="View Day Book" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-3-2" data-id="custom-0-3-2" type="checkbox" value="View Day Book" />
                           <?php } ?>
                           <label>View Day Book</label>
                        </li>
                     </ul>
                  </li>
                  <li> 
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('Employees', $previlege)){ ?>
                     <input  id="xnode-0-4" name="previleges[]" data-id="custom-0-4" type="checkbox" value="Employees" checked="checked"/>
                     <?php } else { ?>
                     <input  id="xnode-0-4" name="previleges[]" data-id="custom-0-4" type="checkbox" value="Employees" />
                     <?php } ?>
                     <label>Employees</label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('Add Employees Details', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-4-1" data-id="custom-0-4-1" type="checkbox" value="Add Employees Details" checked="checked" />
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-4-1" data-id="custom-0-4-1" type="checkbox" value="Add Employees Details" />
                           <?php } ?>
                           <label>Add Employees Details</label>
                        </li>
                        <li>
                           <?php if(in_array('View Employees Details', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-4-2" data-id="custom-0-4-2" type="checkbox" value="View Employees Details" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-4-2" data-id="custom-0-4-2" type="checkbox" value="View Employees Details" />
                           <?php } ?>
                           <label>View Employees Details</label>
                        </li>
                     </ul>
                  </li>
                  <li> 
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('Users', $previlege)){ ?>
                     <input  id="xnode-0-5" name="previleges[]" data-id="custom-0-5" type="checkbox" value="Users" checked="checked"/>
                     <?php } else { ?>
                     <input  id="xnode-0-5" name="previleges[]" data-id="custom-0-5" type="checkbox" value="Users" />
                     <?php } ?>
                     <label>Users</label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('Add Users', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-5-1" data-id="custom-0-5-1" type="checkbox" value="Add Users" checked="checked" />
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-5-1" data-id="custom-0-5-1" type="checkbox" value="Add Users" />
                           <?php } ?>
                           <label>Add Users</label>
                        </li>
                        <li>
                           <?php if(in_array('View Users', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-5-2" data-id="custom-0-5-2" type="checkbox" value="View Users" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-5-2" data-id="custom-0-5-2" type="checkbox" value="View Users" />
                           <?php } ?>
                           <label>View Users</label>
                        </li>
                     </ul>
                  </li>
                  <li> 
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('Travels', $previlege)){ ?>
                     <input  id="xnode-0-6" name="previleges[]" data-id="custom-0-6" type="checkbox" value="Travels" checked="checked"/>
                     <?php } else { ?>
                     <input  id="xnode-0-6" name="previleges[]" data-id="custom-0-6" type="checkbox" value="Travels" />
                     <?php } ?>
                     <label>Travels</label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('Travel Agents', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-1" data-id="custom-0-6-1" type="checkbox" value="Travel Agents" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-1" data-id="custom-0-6-1" type="checkbox" value="Travel Agents" />
                           <?php } ?>
                           <label>Travel Agents</label>
                        </li>
                        <li>
                           <?php if(in_array('Add Party', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-2" data-id="custom-0-6-2" type="checkbox" value="Add Party" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-2" data-id="custom-0-6-2" type="checkbox" value="Add Party" />
                           <?php } ?>
                           <label>Add Party</label>
                        </li>
                        <li>
                           <?php if(in_array('Generate Invoice', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-3" data-id="custom-0-6-3" type="checkbox" value="Generate Invoice" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-3" data-id="custom-0-6-3" type="checkbox" value="Generate Invoice" />
                           <?php } ?>
                           <label>Generat Invoice</label>
                        </li>
                        <li>
                           <?php if(in_array('View Invoice', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-4" data-id="custom-0-6-4" type="checkbox" value="View Invoice" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-4" data-id="custom-0-6-4" type="checkbox" value="View Invoice" />
                           <?php } ?>
                           <label>View Invoice</label>
                        </li>
                        <li>
                           <?php if(in_array('Sushant Travels Invoice', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-5" data-id="custom-0-6-5" type="checkbox" value="Sushant Travels Invoice" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-5" data-id="custom-0-6-5" type="checkbox" value="Sushant Travels Invoice" />
                           <?php } ?>
                           <label>Sushant Travels Invoice</label>
                        </li>
                        <li>
                           <?php if(in_array('View Sushant Travels Invoice', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-6" data-id="custom-0-6-6" type="checkbox" value="View Sushant Travels Invoice" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-6" data-id="custom-0-6-6" type="checkbox" value="View Sushant Travels Invoice" />
                           <?php } ?>
                           <label>View Sushant Travels Invoice</label>
                        </li>
                        <li>
                           <?php if(in_array('Hotel Details', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-7" data-id="custom-0-6-7" type="checkbox" value="Hotel Details" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-6-7" data-id="custom-0-6-7" type="checkbox" value="Hotel Details" />
                           <?php } ?>
                           <label>Hotel Details</label>
                        </li>
                     </ul>
                  </li>
                  <li> 
                     <span class="glyphicon glyphicon-plus"></span>
                     <?php if(in_array('Reports', $previlege)){ ?>
                     <input  id="xnode-0-7" name="previleges[]" data-id="custom-0-7" type="checkbox" value="Reports" checked="checked"/>
                     <?php } else { ?>
                     <input  id="xnode-0-7" name="previleges[]" data-id="custom-0-7" type="checkbox" value="Reports" />
                     <?php } ?>
                     <label>Reports</label>
                     <ul class="chil-ul">
                        <li>
                           <?php if(in_array('View Reports', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-7-1" data-id="custom-0-7-1" type="checkbox"  value="View Reports" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-7-1" data-id="custom-0-7-1" type="checkbox"  value="View Reports" />
                           <?php } ?>
                           <label>View Reports</label>
                        </li>
                        <li>
                           <?php if(in_array('Date Wise Checkin Details', $previlege)){ ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-7-2" data-id="custom-0-7-2" type="checkbox" value="Date Wise Checkin Details" checked="checked"/>
                           <?php } else { ?>
                           <input class="hummingbirdNoParent" name="previleges[]" id="xnode-0-7-2" data-id="custom-0-7-2" type="checkbox" value="Date Wise Checkin Details" />
                           <?php } ?>
                           <label>Date Wise Checkin Details</label>
                        </li>
                     </ul>
                  </li>
               </ul>
            </li>
          </ul>
      </div>
   </div>
   <!--end tab with checkbox-->
   <div class="footer">
      <div class="field buttons">
         <label class="main">&nbsp;</label>
         <input type="button" class="reset" id="reset_day_book" value="Reset" />
         <input type="button" id="add_user_btn" name="add_user_btn" class="next" value="Submit" />
      
      </div>
   <div id='loadingmessage' style="display: none;">
      <img src='ajax-loader.gif'/>
   </div>
</form>
<a class="close" href=""></a> 
</div>
<?php //include_once('../include/footer.php');?>
<script type="text/javascript" src="js/checkbox-script.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
      var hotel = "<?php echo $reslut['hotel_id'];?>";
      var user_type_hai = "<?php echo $reslut['user_type_hai'];?>";
      if(user_type_hai = 'Manager'){
         $(".hotel_ss").show();
      }else{
         $(".hotel_ss").hide();
      }

      if(user_type_hai == 'Super Admin'){
         $(".hummingbird-treeview").hide();
      }else{
         $(".hummingbird-treeview").show();
      }


      $(".user_type").on('change',function(){
         var type = $(this).val();
         if(type == 'Manager'){
            $(".hotel_ss").show();
         }else{
            $(".hotel_ss").hide();
         }

         if(type == 'Super Admin'){
            $(".hummingbird-treeview").hide();
         }else{
            $(".hummingbird-treeview").show();
         }

      });
   });
</script>
<script type="text/javascript">
 
   $(document).ready(function(){ 
      $('#f_name,#last_name,#user_name,#email,.user_type,.hotel_name').click(function(){
         $('#f_name').css("border", "");
         $('#last_name').css("border", "");
         $('#user_name').css("border", "");
         $('#email').css("border", "");
         $('.user_type').css("border", "");
         $('.hotel_name').css("border", "");
      });
   });

   $('#add_user_btn').on('click', function(e) {
      var f_name = $('#f_name');
      var user_name = $('#user_name');
      var email = $('#email');
      var user_name = $('#user_name');
      var email = $('#email');
      var user_type = $('.user_type');
      var hotel_name = $('.hotel_name');
      if(!f_name.val()) {
         $('#f_name').css("border", "1px solid red");
         $('#f_name').focus();
         e.preventDefault();
         return false;
      } 

      if(!user_name.val()) {
         $('#user_name').css("border", "1px solid red");
         $('#user_name').focus();
         e.preventDefault();
         return false;
      } 

      if(!email.val()) {
         $('#email').css("border", "1px solid red");
         $('#email').focus();
         e.preventDefault();
         return false;
      } 

      if(!user_type.val()) {
         $('.user_type').css("border", "1px solid red");
         $('.user_type').focus();
         e.preventDefault();
         return false;
      }
      if(!hotel_name.val()) {
         $('.hotel_name').css("border", "1px solid red");
         $('.hotel_name').focus();
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


   //form submition script
   function avoidSpace(event){
      var k = event ? event.which : window.event.keycode;
      if(k==32)
         return false;
   }
   $("#add_user_btn").click(function(event){
        event.preventDefault();
        var formData = new FormData($("#add_user_form")[0]);
        var password = $("#password").val();
        var cnf_pass = $("#c_password").val();
        var user_name = $("#user_name").val();
        if(password == cnf_pass){
         $.ajax({
               url: 'insert_data.php?type=Add-User',
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
                  $("#message").html("<div class='alert alert-danger'>Passwrod dosen't match.<div>");
               }else if(data == 3){
                  $("#message").html("<div class='alert alert-success'>You data has been updated<div>");
               }else{
                  $("#message").html("<div class='alert alert-danger'>Something is wrong pleae try again later.<div>");
               }
              }
           });
        }else{
         $(".match").html("<span style='color:red;'>Passwrod doesn't match</span>");
         return false;
        }
    });
</script>