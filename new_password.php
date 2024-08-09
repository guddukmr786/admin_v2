<?php 
session_start();
date_default_timezone_set('Asia/Calcutta');
if(empty($_GET['token'])) { 

    header("Location:index.php");
}else{

    if(isset($_GET['t']) && (time() - $_GET['t'] > 1200)){
        session_unset();
        session_destroy();
        header("Location:expire.php");
    }else{

        $email = base64_decode($_GET['token']);
    }
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Password Reset</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
<style type="text/css">
    .bs-example{
        margin: 20px;
    }
    /* Fix alignment issue of label on extra small devices in Bootstrap 3.2 */
    .form-horizontal .control-label{
        padding-top: 7px;
    }
</style>
</head>
<body>
<div class="container">
    <div class="bs-example">
        
        <form style="align-content: center;" class="form-horizontal" action="#" name="reset_form" id="reset_form">
            <h3 style="text-align: center;color: #2B669A;font-family: Georgia, serif;">Check In Room | Password reset</h3>
            <hr>
            <br/>
            <div class="message"></div>
            <div class="form-group">
                <label for="inputEmail" class="control-label col-xs-2">New password</label>
                <div class="col-xs-8">
                    <input type="text" class="form-control" id="new_pass" name="new_pass" ="new_pass" placeholder="New password">
                </div>
                <input type="hidden" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="inputPassword" class="control-label col-xs-2">Confirm Password</label>
                <div class="col-xs-8">
                    <input type="password" class="form-control" id="conf_pass" name="conf_pass" placeholder="Confirm password">
                </div>
            </div>
           <div class="alert alert-warning"><strong>Note: - </strong>Password must have at least  one number(0-9), one letter [a - z], one of the following: !@#$% , Minimum lenght 6 and maximum 25</div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    <button type="button" name="reset" id="reset" class="btn btn-primary">Reset Password</button> <h4> Or </h4>
                    <a href="index.php">Click here</a> to login. 
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>  

<script type="text/javascript">
    $("#reset").click(function(e){
        var new_pass = $('#new_pass');
        var conf_pass = $('#conf_pass');

        if(!new_pass.val()){
            $('#new_pass').css("border", "1px solid red");
            $('#new_pass').focus();
            e.preventDefault();
        }

        if(!conf_pass.val()){
            $('#conf_pass').css("border", "1px solid red");
            $('#conf_pass').focus();
            e.preventDefault();
        }
    });

    $("#new_pass,#conf_pass").click(function(){
        $('#new_pass').css("border", "");
        $('#conf_pass').css("border", "");
    });

    $("#reset").click(function(){
        var formData = $("#reset_form").serialize();
        $.ajax({
            url : 'forgot_password.php?type=generate_pass',
            type : 'post',
            data : formData,
            success : function(res){
                
                if(res == 0){
                    //$("#reset_form")[0].reset();
                    $(".message").show().html("<div class='alert alert-success'>Your new password successfully created </div>");
                    $("#new_pass").val('');
                    $("#conf_pass").val('');

                }else if(res == 1){
                    $(".message").show().html("<div class='alert alert-danger'>All fields are required.</div>");  
                }else if(res == 2){
                    $(".message").show().html("<div class='alert alert-danger'>Password mismatch.</div>");  
                }else if(res == 3){
                    $(".message").show().html("<div class='alert alert-danger'>Invalid E-mail!...Please eneter your valid E-mail.</div>");  
                }else if(res == 4){
                    $(".message").show().html("<div class='alert alert-danger'>Password must have at least one number(0-9), one letter [a - z], one of the following: !@#$% , Minimum lenght 6 and maximum 25</div>");  
                }else{
                    $(".message").show().html("<div class='alert alert-danger'>Error!..Please try again later.</div>");  
                }
            }
        });
    });
 
</script>                                       