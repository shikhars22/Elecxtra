<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | My Profile</title>
<?php echo $link_script; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section id="_wtBdySec" class="_wtThmSec">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
                <h6 class="adminHead d_flex_evr py-3 m-0"><small class="fs_13 ms-auto">Admin / My Profile</small></h6>
            </div>
			<div class="col-12">
			<form id="vendor_profile_form" method="post" class="prodInputs">
				<input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
				<!-- <div class='row formInput py-3 mb-1 bg-white'>
					<h5>Profile Image</h5>
					<div class='col-lg-5 col-md-6 col-sm-12 col-12 mb-5'>
						<div class='profile_box'>
							<div class='profile_img'>
								<img src='<?php //echo $profile_data->profile_img; ?>'>
								<input type='file' accept='image/*' name='upload_image' class='upload_image'>
							</div>
						</div>
					</div>
				</div> -->
				<div class='row formInput py-3 mb-1 bg-white'>
					<h5>Personal Information</h5>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Full Name</small>
						<input type='text' name='user_name' value='<?php echo $profile_data->user_name; ?>' required>
					</div>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Conatct Number</small>
						<input type='text' name='user_phone' value='<?php echo $profile_data->user_phone; ?>'>
					</div>

					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Email Address</small>
						<input type='email' name='user_email' value='<?php echo $profile_data->user_email; ?>'>
					</div>

					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Gender</small>
						<select class="" name="user_gender">
							<option <?php if($profile_data->user_gender=="Male"){echo "selected";} ?> value="Male">Male</option>
							<option <?php if($profile_data->user_gender=="Female"){echo "selected";} ?> value="Female">Female</option>
						</select>
					</div>

				</div>

				<div class='row formInput py-3 mb-1 bg-white'>
					<h5 class='mb-2'>Business Information</h5>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Shop / Company Name</small>
						<input type='text' name='company_name' value='<?php echo $profile_data->company_name; ?>'>
					</div>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Business Type</small>
						<input type='text' name='company_type' value='<?php echo $profile_data->company_type; ?>'>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
						<small>Business Address</small>
						<textarea name="user_address" rows="3"><?php echo $profile_data->user_address; ?></textarea>
					</div>
				</div>

				<div class='row formInput py-3 mb-1 bg-white'>
					<h5 class='mb-2'>Address Information</h5>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
						<small>City</small>
						<input type="text" name="user_city" value="<?php echo $profile_data->user_city; ?>">
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
						<small>Land Mark</small>
						<input type="text" name="user_land_mark" value="<?php echo $profile_data->user_land_mark; ?>">
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
						<small>Pincode</small>
						<input type="text" name="user_pin" value="<?php echo $profile_data->user_pin; ?>">
					</div>
				</div>

				<div class='row formInput py-3 mb-1 bg-white'>
					<h5 class='mb-2'>Bank Information</h5>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Bank Name</small>
						<input type='text' name='user_bank_name' value='<?php echo $profile_data->user_bank_name; ?>'>
					</div>

					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Bank Branch</small>
						<input type="text" name="user_bank_branch" value="<?php echo $profile_data->user_bank_branch; ?>">
					</div>

					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Accont Holder</small>
						<input type="text" name="user_account_name" value="<?php echo $profile_data->user_account_name; ?>">
					</div>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Account Number</small>
						<input type="text" name="user_account_no" value="<?php echo $profile_data->user_account_no; ?>">
					</div>
					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>IFSC</small>
						<input type="text" name="user_ifsc_code" value="<?php echo $profile_data->user_ifsc_code; ?>">
					</div>

					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>Pan Number</small>
						<input type="text" name="user_pan" value="<?php echo $profile_data->user_pan; ?>">
					</div>

					<div class='col-lg-6 col-md-6 col-sm-12 col-12 mb-3'>
						<small>GST Number</small>
						<input type="text" name="user_gst" value="<?php echo $profile_data->user_gst; ?>">
					</div>

					<div class='col-12 mb-3 text-end'>
						<button type='submit' class='_wtBtnMd bg_theme_2' name='save_profile'>Save</button>
					</div>
				</div>

			</form>
			</div>
		</div>

	</div>

</section>



<script type="text/javascript">
$(document).on('submit', '#vendor_profile_form', function(event){ 
    event.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_view_profile/update_admin_profile'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
        }
    });   
});
</script>
</body>
</html>




