<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | User Login</title>
<?php echo $link_scripts; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<input type="hidden" id="redirect_to" value="<?php echo current_url(); ?>">
<section>
    <div class="log_reg_form text-center">
        <form id="login_form" action="javascript:void(0)" method="post">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <div class="form_inputs login_box">
                <p class="mb-3 d-block">LOG IN</p>
                <input type="text" name="username" placeholder="Enter Mobile / Email" class="mb-3">
                <div class="_input_otp mb-3">
                    <input type="password" name="password" placeholder="Password">
                    <i class="fas fa-eye _showPassword"></i>
                </div>
                <button type="submit" class="button_2 w-100">Login</button>
                <a href="javascript:void(0)" class="d-inline-block mt-3 fs_14 text-danger" onclick="forgot_pass_open_form()">Forgot password!</a>
                <br>
                <a href="<?php echo base_url('register'); ?>" class="mt-2 d-inline-block fs_14 text-info">Don't have an account? Sign Up Now!</a>
            </div>
        </form>
        <form id="forgot_pass_form" style="display: none;">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <div id="details_holder">
                <div class="form_inputs">
                    <p class="mb-3 d-block">FORGOT PASSWORD</p>
                    <input type="text" name="username" placeholder="Enter Mobile / Email" autocomplete="off" class="mb-3">
                    <button type="button" onclick="forgot_pass_send_otp()" class="button_2 w-100">Send OTP</button>
                </div>
            </div>
            <div class="form_inputs" style="display: none;" id="password_holder">
                <p class="mb-3 d-block">SET NEW PASSWORD</p>
                <div class="d-flex">
                    <input type="text" name="otp" placeholder="OTP" class="mb-3">
                    <button type="button" class="btn btn-primary btn-sm" style="height: 35px;" onclick="forgot_pass_send_otp()">Resend</button>
                </div>
                <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="New Password" class="mb-3">
                <input type="password" name="con_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Confirm Password" class="mb-3">
                <button type="button" class="button_2 w-100" onclick="submit_form(this)">Change Password</button>
                <br>
                <a href="<?php echo base_url('register'); ?>" class="mt-2 d-inline-block">Sign Up</a>
            </div>
        </form>
    </div>
</section>
</body>
<?php echo $footer; ?>
<?php echo $footer_bottom; ?>

<script type="text/javascript">
function submit_form(self){
    $(self).closest("form").submit();
}
$(document).on('submit', '#login_form', function(e){
    e.preventDefault();
    if($(this).find('input').val()==""){
        webinaToast({type:'error', message:'Enter Mobile & Password'});
    }else{
        $.ajax({  
            url:"<?php echo base_url('login-data'); ?>", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    if($("#redirect_to").val().split('/').pop()=='login-first'){
                        location.replace("<?php echo base_url('cart'); ?>");
                    }else{
                        location.replace("<?php echo base_url('profile'); ?>");
                    }
                }
            }
        });
    }
});
$(document).on('submit', '#forgot_pass_form', function(e){
    e.preventDefault();
    if($(this).find('input').val()==""){
        webinaToast({type:'error', message:'Enter New password confirm password!'});
    }else{
        if($(this).find('input[name="password"]').val()!=$(this).find('input[name="con_password"]').val()){
            webinaToast({type:'error', message:'Make sure your password matched!'});
        }else{
            $.ajax({  
                url:"<?php echo base_url('recover-pass-account'); ?>",
                method:'POST',  
                data:new FormData(this),
                dataType: 'JSON',
                contentType:false,  
                processData:false,  
                success:function(data){
                    webinaToast({type:data.type, message:data.text});
                    if(data.type=='success'){
                        location.reload();
                    }
                }
            });
        }
    }
});
function forgot_pass_open_form(){
    $("#login_form").slideUp(500);
    $("#forgot_pass_form").slideDown(500);
}
function forgot_pass_send_otp(){
    if($("#forgot_pass_form input[name='username']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('recover-pass-account-otp'); ?>",
            method:'POST',  
            data:{[csrfName]:csrfHash, username:$("#forgot_pass_form").find("input[name='username']").val()},
            dataType: 'JSON',  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    $("#details_holder").slideUp(500);
                    $("#password_holder").slideDown(500);
                }
            }
        });
    }else{
        webinaToast({type:'error', message:'Please Enter Registerd Mobile No.'});
    }
}
</script>
</body>
</html>