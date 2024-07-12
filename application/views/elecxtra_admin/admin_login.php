<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

<!-- scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?php echo base_url('admin_assets/jquery/admin_common_js.js'); ?>"></script>
<style type="text/css">
#login {width: 100%; height: 100%; position: relative; background-color: #fff; position: absolute; z-index: 9;}
#login:after {content: ''; position: absolute; height: 100%; width: 100%; left: 0; top: 0; background-image: url('<?php echo base_url('admin_assets/images/world-dots.webp'); ?>'); background-repeat: no-repeat; background-size: cover; opacity: 0.4; z-index: -1;}
#login_form {position:absolute; width:100%; height: 100%; top:0; left:50%; transform:translateX(-50%); background-color: transparent; display: grid; align-content: center; justify-items: center; grid-row-gap: 15px;}
#login_form .company_logo {height: 40px;}
#login_form .devloper_logo {display: flex; grid-column-gap: 5px; align-items: center; text-decoration: none; color: #333; font-size: 14px; font-weight: 500;}
#login_form .heading {margin: 0; text-transform: uppercase; letter-spacing: 3px; font-size: 18px; font-weight: 400;}
#login_form .input_group {display: block; height: 44px; margin-bottom: 10px; background-color: transparent; width: 310px; border-radius: 4px; position: relative; border: 1px solid #dadce0;}
#login_form .input_group .img {position: absolute; left: 0; top: 0; height: 100%; width: 35px; display: grid; align-content: center; justify-items: center;}
#login_form .input_group input {width: 100%; height: 44px; background-color: #ffffff38; border: none; padding-left: 35px; padding-bottom: 5px;}
#login_form .input_group input:focus {background-color: transparent; outline: none; border: 1px solid #3a448b; box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px #3a448b;}
#login_form .login_btn {background-color: #3a448b; display: block; width: 100%; padding: 10px; color: #fff; border-radius: 4px; border: none; margin-top: -2px; text-transform: uppercase; letter-spacing: 1px; font-size: 14px;}

</style>
</head>

<body>
<section id="login">
    <form id="login_form">
        <!-- <img class="company_logo" src="<?php //echo base_url('admin_assets/images/logo.png'); ?>"> -->

        <h4 class="heading">Admin Login</h4>
        <div><input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>"></div>

        <div class="input_group">
            <div class="img"><img src="<?php echo base_url('admin_assets/images/user.png'); ?>"></div>
            <input type="text" placeholder="Enter Mobile / Email" name="user_id" required>
        </div>
        <div class="input_group">
            <div class="img"><img src="<?php echo base_url('admin_assets/images/lock.png'); ?>"></div>
            <input type="password" placeholder="Password" name="user_password" required>
        </div>
        <div class="input_group">
            <button type="submit" class="login_btn">Login</button>
        </div>
        <div class="text-center"><a href="javascript:void(0)">Having problem in Login? <i><u>Click here</u></i></a></div>

        <a href="https://www.webinatech.in/" class="devloper_logo">Develope by<br><img height="20px" src="https://www.webinatech.in/assets/images/logo.png"></a>
    </form>
</section>
<!-- start forgot pass modal-->

<!-- end forgot pass modal-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url("wt_assets/wt_alert.css"); ?>">
<script type="text/javascript" src="<?php echo base_url("wt_assets/wt_alert.js"); ?>"></script>

<script type="text/javascript">
$(document).on('submit', '#login_form', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_login/login_data'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                location.replace("<?php echo base_url('admin/admin-dashboard'); ?>");
            }
        }
    });   
});
</script>
</body>
</html>




