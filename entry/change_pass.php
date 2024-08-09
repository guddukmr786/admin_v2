<?php 
include('../include/header.php');
include('is_login.php');

$exp_categories = $obj->getExpensesCategories();
?>
<style>
.preview {
    background-color: #f34343;
    border: none;
    color: white;
    padding: 7px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 2px 2px;
    cursor: pointer;
}
.field .form-control {
    width: 30%;
}

</style>
        <div class="content">
             <div class="idealsteps-container">
                
                <ul class="maintabmenu multipletabmenu">
                    
                    <!--<li><a href="editor.html">WYSIWYG Editor</a></li>
                    <li><a href="wizard.html">Wizard</a></li>-->
                </ul><!--maintabmenu-->
                
                <div class="content">
                    <div class="contenttitle">
                        <h2 class="form" style="font-family: Georgia, serif;"><span>Change Password</span></h2>
                    </div><!--contenttitle-->
                    
                    <br />
                     <?php if(isset($_SESSION['msg'])){  ?>
                        <div class="alert alert-success"><?php echo $_SESSION['msg'];unset($_SESSION['msg']);?></div>
                    <?php } elseif (isset($_SESSION['error_msg'])) { ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error_msg'];unset($_SESSION['error_msg']);?> </div>
                    <?php } ?> 
                    
                        <form class="stdform" action="change_password.php" id="change_password_form" method="post" enctype="multipart/form-data">
                            
                           <div class="field">
                                <label class="main">Old Password <span style="color:red;"> * </span>:</label>
                                <span class="field"><input type="text" name="old_pass" id="old_pass" class="form-control"></span>
                            </div>
                            <div class="field">
                                <label class="main">New Password <span style="color:red;"> * </span>:</label>
                                <span class="field"><input type="text" name="new_pass" id="new_pass" value="<?php if(isset($_SESSION['new_pass'])) echo $_SESSION['new_pass']; ?>" class="form-control" /></span>
                            </div>
                            <div class="field">
                                <label class="main">Confirm Password <span style="color:red;"> * </span>:</label>
                                <span class="field"><input type="password" name="conf_pass" id="conf_pass" value="<?php if(isset($_SESSION['conf_pass'])) echo $_SESSION['conf_pass']; ?>" class="form-control" /></span>
                            </div>
                            <br/>
                            <div class="alert alert-warning"><strong>Note: - </strong>Password must have at least  one number(0-9), one letter [a - z], one of the following: !@#$% , Minimum lenght 6 and maximum 25</div>
                            <div class="footer">
                                <div class="field buttons">
                                    <label class="main">&nbsp;</label>
                                    <input type="submit" name="chage_pass" id="chage_pass" class="btn btn-primary" value="Submit">
                                </div>
                            </div>

                        </form>
                    
                </div><!--content-->
                
            </div><!--maincontentinner-->
            
        </div><!--maincontent-->
                        
        </div><!--mainwrapperinner-->
    </div><!--mainwrapper-->
    <!-- END OF MAIN CONTENT -->
    <script type="text/javascript" src="js/formvalidation.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(".hotel").change(function(){
        var hotel_id = $(this).attr("value");
        $.ajax({
            url : "save_hotel_id.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
            success:function(data){
                window.location.href='change_pass.php';
            }
        });
     });
</script>
    <script type="text/javascript">
        $("#chage_pass").click(function(e){
            var old_pass = $('#old_pass');
            var new_pass = $('#new_pass');
            var conf_pass = $('#conf_pass');

            if(!old_pass.val()){
                $('#old_pass').css("border", "1px solid red");
                $('#old_pass').focus();
                e.preventDefault();
            }

            if(!new_pass.val()){
                $('#new_pass').css("border", "1px solid red");
                $('#new_pass').focus();
                e.preventDefault();
            }

            if(!new_pass.val()){
                $('#conf_pass').css("border", "1px solid red");
                $('#conf_pass').focus();
                e.preventDefault();
            }
            
            $("#old_pass").click(function(){
                $("#old_pass").css("border"," ");
            });
            $("#new_pass").click(function(){
                $("#new_pass").css("border"," ");
            });
            $("#conf_pass").click(function(){
                $("#conf_pass").css("border"," ");
            });
        });
    </script>
    
    

</body>

<!-- Mirrored from demo.themepixels.com/webpage/starlight/form.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Dec 2015 18:43:20 GMT -->
</html>

