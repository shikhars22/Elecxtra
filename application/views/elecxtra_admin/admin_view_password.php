<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Change Password</title>
<?php echo $link_script; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section  id="_wtBdySec" class="_wtThmSec">
    <div class="container-fluid">
            <div class="row">
                <div class="offset-lg-3 col-lg-6 mt-lg-5">
                    <form id="pass_form">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <h5 class="text-center mb-3 pt-3">Change Admin Password</h5>
                        <div class="prodInputs">
                            <div class="mb-3">
                                <input class="price_inputs" type="password" placeholder="Old Password" name="old_password" required>
                            </div>
                
                            <div class="mb-3">
                                <input class="price_inputs" type="password" placeholder="Password" name="password" required>
                            </div>
                
                            <div class="mb-3">
                                <input class="price_inputs" type="password" placeholder="Confirm Password" name="cpassword" required>
                            </div>
                
                            <div class="text-center">
                                <button type="submit" class="_wtBtnMd bg_green">&nbsp;Change Password&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
$(document).on('submit', '#pass_form', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_view_profile/admin_pass_change_data'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                location.assign("<?php echo base_url('admin/admin-logout'); ?>");
            }
        }
    });   
});
</script>
</body>
</html>



