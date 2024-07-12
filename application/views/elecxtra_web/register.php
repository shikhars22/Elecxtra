<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | User Registration</title>
<?php echo $link_scripts; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<section class="log_reg">
    <div class="log_reg_form text-center">
        <form id="register_form" action="javascript:void(0)" method="post">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <div class="inputs login_box">
                <div id="details_holder" class="form_inputs">
                    <p class="mb-3 d-block">SIGN UP</p>
                    <input type="text" name="name" placeholder="Name*" class="mb-3">
                    <input type="number" name="phone" placeholder="Mobile No" class="mb-3">
                    <input type="email" name="email" placeholder="Email" class="mb-3">
                    <button type="button" class="button_2 w-100" onclick="validate_account()">Continue with Send OTP</button>
                </div>
                <div style="display: none;" id="password_holder" class="form_inputs">
                    <p class="mb-3 d-block">SET PASSWORD</p>
                    <div class="d-flex">
                        <input type="text" name="otp" placeholder="OTP" class="mb-3">
                        <button type="button" class="btn btn-primary btn-sm" style="height: 35px;" onclick="validate_account()">Resend</button>
                    </div>
                    <div class="_input_otp mb-3">
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" placeholder="Set Password*">
                        <i class="fas fa-eye _showPassword"></i>
                    </div>
                    <div class="_input_otp mb-3">
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="con_password" placeholder="Confirm Password*">
                        <i class="fas fa-eye _showPassword"></i>
                    </div>
                    <button type="button" onclick="submit_form(this)" class="button_2 w-100">Sign Up</button>
                </div>
                <a href="<?php echo base_url('login'); ?>" class="mt-3 fs_14 d-inline-block text-info">Already have an account? Sign In</a>
            </div>
        </form>
    </div>
</section>

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>

<script type="text/javascript">
function submit_form(self){
    $(self).closest("form").submit();
}
$(document).on('submit', '#register_form', function(e){
    e.preventDefault();
    if($("#register_form").find("input[name='phone']").val()!="" && $("#register_form").find("input[name='name']").val()!="" && $("#register_form").find("input[name='email']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('register-data'); ?>", 
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
                        location.replace("<?php echo base_url('profile'); ?>");
                    }, 1000);
                }
            }
        });
    }else{
        webinaToast({type:'warning', message:'Enter Name, Email & Mobile No.'});
    }
});
function have_reffer_code(){
    $("#reffer_code_holder").slideToggle(500);
}
function validate_account(){
    if($("#register_form").find("input[name='phone']").val()!="" && $("#register_form").find("input[name='name']").val()!="" && $("#register_form").find("input[name='email']").val()!=""){
        $.ajax({  
            url:"<?php echo base_url('validate-account'); ?>", 
            method:'POST',  
            data:{[csrfName]:csrfHash, name:$("#register_form").find("input[name='name']").val(), phone:$("#register_form").find("input[name='phone']").val(), email:$("#register_form").find("input[name='email']").val()},
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
        webinaToast({type:'warning', message:'Enter Name, Email & Mobile No.'});
    }
}
</script>
</body>
</html>