<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo site_title(); ?> | Become a Seller</title>
    <?php echo $link_scripts; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>

<section class="bg-white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 pl-lg-0 d-lg-block d-none">
                <div class="vendor_box">
                    <img src="<?php echo base_url('viewer_assets/images/vendor.png'); ?>" alt="Seller Form">
                </div>
            </div>

            <div class="col-lg-8 pr-lg-0" id="registerPart">
                <div class="_vendor_form">
                    <form  id="seller_register_form">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                            <a href="<?php echo base_url(); ?>" class="logo h-auto">
                                <img src="<?php echo base_url(); ?>viewer_assets/images/logo.png" alt="Logo">
                            </a>
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Already have an account?</p>&nbsp; &nbsp;
                                <a href="javascript:void(0)" class="" onclick="open_login()">Login</a>
                            </div>
                        </div>
                        <h1 class="fs_26 mb-3">Become A Seller</h1>
                        <div class="row first_step">
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Full Name *</label>
                                <input type="text" name="user_name" required>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Mobile Number *</label>
                                <div class="_input_otp">
                                    <input type="number" name="user_phone" maxlength="12" required>
                                    <!-- <button type="button" class="bg-primary">Send OTP</button> -->
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Email Address *</label>
                                <input type="email" name="user_email" required>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Business Name</label>
                                <input type="text" name="company_name">
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Business Type</label>
                                <input type="text" name="company_type">
                            </div>

                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Document * <code>(PAN for individual, CIN and GST certificate for companies - pdf format only)</code></label>
                                <input type="file" name="attachments[]" accept="application/pdf" multiple required>
                            </div>

                            <div class="col-lg-12">
                                <p class="fs_13">By continuing you will receive an OTP in your Phone & Email</p>
                                <button type="button" class="button_2" onclick="seller_validate_account();">Continue With OTP</button>
                                <a href="javascript:void(0)" class="button_3 float-right" onclick="next_step()">NEXT STEP ></a>
                            </div>
                        </div>
                        <div class="row second_step" style="display:none;">
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label class="mb-0">Enter Otp *</label>
                                <div class="d-flex">
                                    <input type="text" name="otp" required>
                                    <button type="button" class="btn btn-primary btn-sm" style="height: 35px;" onclick="seller_validate_account()">Resend</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Create Password *</label>
                                <div class="_input_otp">
                                    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="user_password" required>
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Confirm Password *</label>
                                <div class="_input_otp">
                                    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="con_password" required>
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <p class="fs_13">By registering, I agree to Elecxtra's <a href="<?php echo base_url('terms-condition'); ?>">Terms of Use</a> & <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></p>
                                <a href="javascript:void(0)" class="button_3" onclick="prev_step()">< PREV STEP</a>
                                <button type="submit" class="button_2 float-right">Register</button>
                            </div>
                        </div>
                    </form>
                    <form id="seller_login_form" style="display:none;">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                            <a href="<?php echo base_url(); ?>" class="logo h-auto">
                                <img src="<?php echo base_url(); ?>viewer_assets/images/logo.png" alt="Logo">
                            </a>
                            <div class="d-flex align-items-center">
                                <p class="mb-0">No Account? Register To Click Here</p>&nbsp; &nbsp;
                                <a href="javascript:void(0)" class="" onclick="open_register()">Register</a>
                            </div>
                        </div>
                        <h1 class="fs_26 mb-3">Seller Login</h1>
                        <div class="row">
                            <div class="col-12 mb-3 form_inputs">
                               <label>Enter Mobile / Email *</label>
                               <input type="text" name="user_id" required>
                            </div>
                            <div class="col-12 mb-3 form_inputs">
                               <label>Password *</label>
                                <div class="_input_otp">
                                    <input type="password" name="user_password" required>
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <a href="javascript:void(0)" onclick="forgot_pass_open_form()" class="mt-2 fs_14 float-left">Forgot Password?</a>
                                <button type="submit" class="button_2 float-right">Login</button>
                            </div>
                        </div>
                    </form>
                    
                    <!--start forgot password-->
                    <form id="forgot_pass_form" style="display:none;">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                            <a href="<?php echo base_url(); ?>" class="logo h-auto">
                                <img src="<?php echo base_url(); ?>viewer_assets/images/logo.png" alt="Logo">
                            </a>
                            <div class="d-flex align-items-center">
                                <p class="mb-0">No Account? Register To Click Here</p>&nbsp; &nbsp;
                                <a href="javascript:void(0)" class="" onclick="open_register()">Register</a>
                            </div>
                        </div>
                        <div class="row forgot_step_1">
                            <div class="col-lg-12 mb-3 form_inputs">
                                <h4>Forgot Password</h4>
                                <small>Recover Account</small>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Username*</label>
                                <input type="text" name="username" placeholder="Enter Mobile / Email" autocomplete="off">
                            </div>
                                
                            <div class="col-lg-12 mb-3 form_inputs">
                                <button type="button" onclick="forgot_pass_send_otp()" class="button_2 float-right">Send OTP</button>
                                <a href="javascript:void(0)" onclick="open_login()"> < Back to Login</a>
                            </div>
                        </div>
                        <div class="row forgot_step_2 d-none">
                            <div class="col-lg-12 mb-3 form_inputs">
                                <h4>Change Password</h4>
                                <small>Recover Account</small>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>OTP*</label>
                                <div class="d-flex">
                                    <input type="text" name="otp" required>
                                    <button type="button" class="btn btn-primary btn-sm" style="height: 35px;" onclick="forgot_pass_send_otp()">Resend</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Set Password*</label>
                                <div class="_input_otp">
                                    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" placeholder="New Password">
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Confirm Password*</label>
                                <div class="_input_otp">
                                    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="con_password" placeholder="Confirm Password">
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <button type="button" onclick="submit_form(this)" class="button_2 float-right">Change Password</button>
                            </div>
                        </div>
                    </form>
                    <!--end forgot password-->
                    
                </div>
            </div>
        </div>
    </div>
</section>


<?php echo $footer; ?>
<?php echo $footer_bottom; ?>

<script type="text/javascript">
function submit_form(self){
    $(self).closest("form").submit();
}
function next_step(){
    $('.first_step').slideUp();
    $('.second_step').slideDown();
}
function prev_step(){
    $('.first_step').slideDown();
    $('.second_step').slideUp();
}

function open_login(){
    $("#forgot_pass_form").slideUp();
    $("#seller_register_form").slideUp();
    $("#seller_login_form").slideDown();
}
function open_register(){
    $("#seller_register_form").slideDown();
    $("#seller_login_form").slideUp();
    $("#forgot_pass_form").slideUp();
}

/********start forgot password*******/
function forgot_pass_open_form(){
    $("#seller_register_form").slideUp();
    $("#seller_login_form").slideUp();
    $("#forgot_pass_form").slideDown();
}
function forgot_pass_send_otp(){
    if($("#forgot_pass_form input[name='username']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('seller-recover-pass-account-otp'); ?>",
            method:'POST',  
            data:{[csrfName]:csrfHash, username:$("#forgot_pass_form").find("input[name='username']").val()},
            dataType: 'JSON',  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    $(".forgot_step_1").addClass("d-none");
                    $(".forgot_step_2").removeClass("d-none");
                }
            }
        });
    }else{
        webinaToast({type:'error', message:'Please Enter Registerd Mobile No.'});
    }
}
$(document).on('submit', '#forgot_pass_form', function(e){
    e.preventDefault();
    if($(this).find('input').val()==""){
        webinaToast({type:'error', message:'Enter New password confirm password!'});
    }else{
        if($(this).find('input[name="password"]').val()!=$(this).find('input[name="con_password"]').val()){
            webinaToast({type:'error', message:'Make sure your password matched!'});
        }else{
            $.ajax({  
                url:"<?php echo base_url('seller-recover-pass-account'); ?>",
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
/********end forgot password*******/

function seller_validate_account(){
    if($("#seller_register_form").find("input[name='user_name']").val()!="" && $("#seller_register_form").find("input[name='user_phone']").val()!="" && $("#seller_register_form").find("input[name='user_email']").val()!="" && $("#seller_register_form").find("input[name='attachments[]']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('seller-validate-account'); ?>", 
            method:'POST',  
            data:{[csrfName]:csrfHash, user_name:$("#seller_register_form").find("input[name='user_name']").val(), user_phone:$("#seller_register_form").find("input[name='user_phone']").val(), user_email:$("#seller_register_form").find("input[name='user_email']").val()},
            dataType: 'JSON',  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    next_step();
                }
            }
        });
    }else{
        webinaToast({type:'warning', message:'Enter Name, Phone, Email & Business Info!'});
    }
}
$(document).on('submit', '#seller_register_form', function(e){
    e.preventDefault();
    if($("#seller_register_form").find("input[name='user_name']").val()!="" && $("#seller_register_form").find("input[name='user_phone']").val()!="" && $("#seller_register_form").find("input[name='user_email']").val()!="" && $("#seller_register_form").find("input[name='attachments[]']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('seller-register-data'); ?>", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    webinaFire({
                        icon: data.type,
                        title: "Successfully Registered!",
                        message: data.text,
                    });
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                    
                }
            }
        });
    }else{
        webinaToast({type:'warning', message:'Enter Name, Phone, Email & Documents!'});
    }
});
$(document).on('submit', '#seller_login_form', function(e){
    e.preventDefault();
    if($("#seller_login_form").find("input[name='user_id']").val()!="" && $("#seller_login_form").find("input[name='user_password']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('seller-login-data'); ?>", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    webinaFire({
                        icon: data.type,
                        title: "Successfully Login!",
                        message: data.text,
                    });
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                    
                }
            }
        });
    }else{
        webinaToast({type:'warning', message:'Enter Username & Password!'});
    }
});


</script>
</body>
</html>