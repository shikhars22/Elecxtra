<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $subscription_set=get_subscription_plan(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Become a Seller</title>
<?php echo $link_scripts; ?>
<style type="text/css">
body{font-family:arial;}
.seller_profile_box {user-select: none; border-radius: 4px; overflow: hidden;}
.seller_profile_box .profile_head {background-color: #f0a80e; color: #fff; padding: 15px;}
.seller_profile_box ul li a {display: block; font-size: 14px; background-color: #fff; color: #333; padding: 10px 15px; border-top: 1px solid #e7e7e7;}
.seller_profile_box ul li a:hover {background-color: #e7e7e7;}

/*.plan_tenure {list-style: none; margin:0; padding: 10px; display: grid; align-items: center; justify-content: space-between; grid-gap: 10px; grid-template-columns: repeat(2,1fr); width: 100%;}*/
.plan_tenure label {height: auto; padding: 15px 10px; margin: 0; background-color: #fff; border: 2px solid #ddd; border-radius: 5px; display: grid; align-items: center; justify-content: center; text-align: center; cursor: pointer; user-select: none;}
.plan_tenure h5 {font-size: 20px; font-weight: 800; color: #111; margin-bottom: 5px;}
.plan_tenure span {font-size: 12px; display: flex; align-items: center; grid-gap: 5px; justify-content: center;}
.plan_tenure label:hover, .plan_tenure label.active {border: 2px solid #6571ff}

@media only screen and (max-width:576px) {
    .plan_tenure {grid-template-columns: repeat(2,1fr); grid-gap: 5px; padding: 5px;}
}
</style>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>

<section class="py-3">
    <div class="container">
        <div class="row">
            <?php if(!empty($seller_details->reject_note)){ ?>
                <div class="offset-lg-1 col-lg-10 mb-3">
                    <div class="alert alert-success">
                      <p><?php echo $seller_details->reject_note; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="offset-lg-1 col-lg-3 mb-3">
                <div class="seller_profile_box">
                    <div class="profile_head">
                        <h5><?php echo $seller_details->user_name; ?></h5>
                        <p class="mb-0"><?php echo $seller_details->user_email; ?></p>
                    </div>
                    <ul>
                        <li><a href="javascript:void(0)" data-href="sellerDetails" class="navPanel"><i class="fas fa-user"></i>&nbsp; Profile</a></li>
                        <?php
                        if($seller_details->expire_month_count>0){
                            if(strtotime($seller_details->expire_date)>0){
                                $expire = strtotime($seller_details->expire_date);
                                $today = strtotime(date('Y-m-d'));
                                if($today >= $expire){ ?>
                                   <li><a href="javascript:void(0)" data-href="subscriptionDetails" class="navPanel"><i class="fas fa-calendar-alt"></i>&nbsp; Subscription<br><small class="text-danger pl-3">&nbsp;Expired in <?php echo date('d M, Y', strtotime($seller_details->expire_date)); ?></small></a></li>
                                <?php } else { ?>
                                    <li><a href="javascript:void(0)" data-href="subscriptionDetails" class="navPanel"><i class="fas fa-calendar-alt"></i>&nbsp; Subscription<br><small class="text-info pl-3">&nbsp;Expires in <?php echo date('d M, Y', strtotime($seller_details->expire_date)); ?></small></a></li>
                                <?php }
                            }else{ ?>
                                <li><a href="javascript:void(0)" data-href="subscriptionDetails" class="navPanel"><i class="fas fa-calendar-alt"></i>&nbsp; Subscription<br><small class="text-info pl-3">&nbsp; Your account is under approval!</small></a></li>
                            <?php }
                        }else{ ?>
                            <li><a href="javascript:void(0)" data-href="subscriptionDetails" class="navPanel"><i class="fas fa-calendar-alt"></i>&nbsp; Subscription<br><small class="text-warning">You don't have any subscription plan!</small></a></li>
                        <?php } ?>
                        
                        <li><a href="javascript:void(0)" data-href="sellerAddress" class="navPanel"><i class="fas fa-map-marker-alt"></i>&nbsp; Address</a></li>
                        <li><a href="javascript:void(0)" data-href="sellerBusiness" class="navPanel"><i class="fas fa-industry"></i>&nbsp; Business</a></li>
                        <li><a href="javascript:void(0)" data-href="sellerBank" class="navPanel"><i class="fas fa-building"></i>&nbsp; Bank</a></li>
                        
                        <li><a href="<?php echo base_url('admin'); ?>"><i class="fas fa-toolbox"></i>&nbsp; Admin Panel</a></li>
                        <li><a href="javascript:void(0)" data-href="sellerPass" class="navPanel"><i class="fas fa-lock"></i>&nbsp; Change Password</a></li>
                        <li><a href="<?php echo base_url('seller-logout'); ?>"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div id="sellerDetails" class="seller_profile_box cmnBx mb-3">
                    <div class="profile_head">
                        <h5 class="mb-0 fs_16">Profile</h5>
                    </div>
                    <form id="sellerDetailsForm">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="row p-3 bg-white form_inputs">
                            <div class="col-lg-12 mb-3">
                                <label>Full Name *</label>
                                <input type="text" name="user_name" value="<?php echo $seller_details->user_name; ?>" disabled>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Mobile Number *</label>
                                <div class="_input_otp">
                                    <input type="text" name="user_phone" value="<?php echo $seller_details->user_phone; ?>" maxlength="12" class="_number" disabled>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Email Address *</label>
                                <input type="email" name="user_email" value="<?php echo $seller_details->user_email; ?>" disabled>
                            </div>

                            <div class="col-lg-12 text-right">
                                <button type="button" class="button_2 px-3" onclick="$(this).closest('#sellerDetailsForm').find('input').prop('disabled', false); $(this).nextAll('button').show(); $(this).hide()">Edit</button>
                                <button type="button" class="button_1" onclick="$(this).closest('#sellerDetailsForm').find('input').prop('disabled', true); $(this).prev('button').show(); $(this).hide(); $(this).next('button').hide()" style="display: none;">Cancel</button>
                                <button type="submit" class="button_2" onclick="" style="display: none;">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
                
                <div id="subscriptionDetails" class="seller_profile_box cmnBx mb-3" style="display:none;">
                    <div class="profile_head">
                        <h5 class="mb-0 fs_16">Subscription Plan</h5>
                    </div>
                    <div class="row bg-white">
                        <div class="col-12">
                            <?php if($seller_details->expire_month_count>0){
                                if(strtotime($seller_details->expire_date)>0){
                                    if($today >= $expire){ ?>
                                        <!--start free subcription-->
                                        <form class="w-100" id="seller_subscription_form" method="post">
                                            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                                            <input type="hidden" name="price_amount" value="0">
                                            <input type="hidden" name="expire_month_count" value="1">
                                            <input type="hidden" name="subscription_plan" value="free">
                                            <input type="hidden" name="user_name" value="<?php echo $seller_details->user_name; ?>">
                                            <input type="hidden" name="user_phone" value="<?php echo $seller_details->user_phone; ?>">
                                            <input type="hidden" name="user_email" value="<?php echo $seller_details->user_email; ?>">
                                            <div class="card p-3">
                                                <label><h5>Free</h5><span>&#8377;0/Month</span></label>
                                                <div class="fs_13">
                                                    
                                                </div>
                                                <div class="p-3 text-right"><button type="submit" class="button_2">Subscribe Now</button></div>
                                            </div>
                                        </form>
                                        <!--end free subcription-->
                                        
                                        <!-- <form class="w-100 d-none" id="seller_subscription_form" method="post" style="display:none;">
                                            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                                            <input type="hidden" name="razorpay_order_id" value="">
                                            <input type="hidden" name="razorpay_payment_id" value="">
                                            <input type="hidden" name="merchant_order_ref" value="">
                                            <input type="hidden" name="price_amount" value="">
                                            <input type="hidden" name="expire_month_count" value="">
                                            <input type="hidden" name="subscription_plan" value="">
                                            <input type="hidden" name="user_name" value="<?php echo $seller_details->user_name; ?>">
                                            <input type="hidden" name="user_phone" value="<?php echo $seller_details->user_phone; ?>">
                                            <input type="hidden" name="user_email" value="<?php echo $seller_details->user_email; ?>">
                                            <?php foreach($subscription_set as $key=>$value){ ?>
                                                <div class="card p-3">
                                                    <label><h5><?php echo $value->plan_name; ?></h5><span>&#8377;<?php echo $value->plan_price; ?>/Month</span></label>
                                                    <div class="fs_13">
                                                        <?php echo nl2br($value->plan_description); ?>
                                                    </div>
                                                    <div class="p-3 text-right"><button type="button" data-plan_name="<?php echo $value->plan_name; ?>" data-plan_price="<?php echo $value->plan_price; ?>" onclick="pay_now_subscription(this)" class="button_2">Subscribe Now</button></div>
                                                </div>
                                            <?php } ?>
                                        </form> -->
                                    <?php } else { ?>
                                        <div class="p-3">
                                            <h6 class="mb-0">Expires in <?php echo date('d M, Y', strtotime($seller_details->expire_date)); ?></h6>
                                        </div>
                                    <?php }
                                }else{ ?>
                                    <div class="p-3">
                                        <h6 class="mb-0">Your account is under approval</h6>
                                    </div>
                                <?php }
                            }else{ ?>
                                <!--start free subcription-->
                                <form class="w-100" id="seller_subscription_form" method="post">
                                    <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                                    <input type="hidden" name="price_amount" value="0">
                                    <input type="hidden" name="expire_month_count" value="1">
                                    <input type="hidden" name="subscription_plan" value="free">
                                    <input type="hidden" name="user_name" value="<?php echo $seller_details->user_name; ?>">
                                    <input type="hidden" name="user_phone" value="<?php echo $seller_details->user_phone; ?>">
                                    <input type="hidden" name="user_email" value="<?php echo $seller_details->user_email; ?>">
                                    <div class="card p-3">
                                        <label><h5>Free</h5><span>&#8377;0/Month</span></label>
                                        <div class="fs_13">
                                            
                                        </div>
                                        <div class="p-3 text-right"><button type="submit" class="button_2">Subscribe Now</button></div>
                                    </div>
                                </form>
                                <!--end free subcription-->
                                    
                                <!-- <form class="w-100 d-none" id="seller_subscription_form" method="post" style="display:none;">
                                    <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                                    <input type="hidden" name="razorpay_order_id" value="">
                                    <input type="hidden" name="razorpay_payment_id" value="">
                                    <input type="hidden" name="merchant_order_ref" value="">
                                    <input type="hidden" name="price_amount" value="">
                                    <input type="hidden" name="expire_month_count" value="">
                                    <input type="hidden" name="subscription_plan" value="">
                                    <input type="hidden" name="user_name" value="<?php echo $seller_details->user_name; ?>">
                                    <input type="hidden" name="user_phone" value="<?php echo $seller_details->user_phone; ?>">
                                    <input type="hidden" name="user_email" value="<?php echo $seller_details->user_email; ?>">
                                    <?php foreach($subscription_set as $key=>$value){ ?>
                                        <div class="card p-3">
                                            <label><h5><?php echo $value->plan_name; ?></h5><span>&#8377;<?php echo $value->plan_price; ?>/Month</span></label>
                                            <div class="fs_13">
                                                <?php echo nl2br($value->plan_description); ?>
                                            </div>
                                            <div class="p-3 text-right"><button type="button" data-plan_name="<?php echo $value->plan_name; ?>" data-plan_price="<?php echo $value->plan_price; ?>" onclick="pay_now_subscription(this)" class="button_2">Subscribe Now</button></div>
                                        </div>
                                    <?php } ?>
                                </form> -->
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
                <div id="sellerAddress" class="seller_profile_box cmnBx mb-3" style="display:none;">
                    <div class="profile_head">
                        <h5 class="mb-0 fs_16">Address Details</h5>
                    </div>
                    <form id="sellerAddressForm">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="row p-3 bg-white form_inputs">
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>City *</label>
                                <input type="text" name="user_city" value="<?php echo $seller_details->user_city; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>State *</label>
                                <input type="text" name="user_state" value="<?php echo $seller_details->user_state; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Land Mark *</label>
                                <input type="text" name="user_land_mark" value="<?php echo $seller_details->user_land_mark; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Pincode *</label>
                                <input type="text" name="user_pin" value="<?php echo $seller_details->user_pin; ?>" disabled>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Address *</label>
                                <textarea cols="3" name="user_address" disabled><?php echo nl2br($seller_details->user_address); ?></textarea>
                            </div>

                            <div class="col-lg-12 text-right">
                                <button type="button" class="button_2 px-3" onclick="$(this).closest('#sellerAddress').find('input,textarea').prop('disabled', false); $(this).nextAll('button').show(); $(this).hide()">Edit</button>
                                <button type="button" class="button_1" onclick="$(this).closest('#sellerAddress').find('input').prop('disabled', true); $(this).prev('button').show(); $(this).hide(); $(this).next('button').hide()" style="display: none;">Cancel</button>
                                <button type="submit" class="button_2" style="display: none;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="sellerBusiness" class="seller_profile_box cmnBx mb-3" style="display:none;">
                    <div class="profile_head">
                        <h5 class="mb-0 fs_16">Business Details</h5>
                    </div>
                    <form id="sellerBusinessForm">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="row p-3 bg-white form_inputs">
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Business Name</label>
                                <input type="text" name="company_name" value="<?php echo $seller_details->company_name; ?>" disabled>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Business Type</label>
                                <input type="text" name="company_type" value="<?php echo $seller_details->company_type; ?>" disabled>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>Pancard</label>
                                <input type="text" name="user_pan" value="<?php echo $seller_details->user_pan; ?>" disabled>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-3">
                                <label>GST</label>
                                <input type="text" name="user_gst" value="<?php echo $seller_details->user_gst; ?>" disabled>
                            </div>

                            <div class="col-12">
                                <?php if(empty($seller_details->user_attachment)){ ?>
                                    <p><code>No Documents Found!</code></p>
                                <?php }else{
                                    $all_attach=explode("|", $seller_details->user_attachment);
                                    foreach ($all_attach as $key => $value) { ?>
                                        <p><a href="<?php echo base_url('uploads/seller/attachments/').$value ?>" target="_blank"><?php echo $value; ?></a></p>
                                    <?php } 
                                } ?>
                            </div>
                            <?php if($seller_details->status!="approved"){ ?>
                                <div class="col-lg-12 mb-3">
                                    <label>Document * <code>(PAN for individual, CIN and GST certificate for companies - pdf format only)</code></label>
                                    <input type="file" name="attachments[]" accept="application/pdf" multiple disabled>
                                </div>
                            <?php } ?>

                            <div class="col-lg-12 text-right">
                                <button type="button" class="button_2 px-3" onclick="$(this).closest('#sellerBusinessForm').find('input').prop('disabled', false); $(this).nextAll('button').show(); $(this).hide()">Edit</button>
                                <button type="button" class="button_1" onclick="$(this).closest('#sellerBusinessForm').find('input').prop('disabled', true); $(this).prev('button').show(); $(this).hide(); $(this).next('button').hide()" style="display: none;">Cancel</button>
                                <button type="submit" class="button_2" style="display: none;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="sellerBank" class="seller_profile_box cmnBx mb-3" style="display:none;">
                    <div class="profile_head">
                        <h5 class="mb-0 fs_16">Enter Bank Details</h5>
                    </div>
                    <form class="w-100" id="sellerBankForm" method="post">
                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                        <div class="row p-3 bg-white form_inputs">
                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Bank Name *</label>
                                <input type="text" name="user_bank_name" value="<?php echo $seller_details->user_bank_name; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Bank Branch *</label>
                                <input type="text" name="user_bank_branch" value="<?php echo $seller_details->user_bank_branch; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3 form_inputs">
                                <label>Account Holder Name *</label>
                                <input type="text" name="user_account_name" value="<?php echo $seller_details->user_account_name; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3 form_inputs" disabled>
                                <label>Account Number *</label>
                                <input type="number" name="user_account_no" value="<?php echo $seller_details->user_account_no; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3 form_inputs" disabled>
                                <label>IFSC *</label>
                                <input type="text" name="user_ifsc_code" value="<?php echo $seller_details->user_ifsc_code; ?>" disabled>
                            </div>


                            <div class="col-lg-12 text-right">
                                <button type="button" class="button_2 px-3" onclick="$(this).closest('#sellerBankForm').find('input').prop('disabled', false); $(this).nextAll('button').show(); $(this).hide()">Edit</button>
                                <button type="button" class="button_1" onclick="$(this).closest('#sellerBankForm').find('input').prop('disabled', true); $(this).prev('button').show(); $(this).hide(); $(this).next('button').hide()" style="display: none;">Cancel</button>
                                <button type="submit" class="button_2" style="display: none;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="sellerPass" class="seller_profile_box cmnBx mb-3" style="display:none;">
                    <div class="profile_head">
                        <h5 class="mb-0 fs_16">Change Password</h5>
                    </div>
                    <div class="row p-3 bg-white form_inputs">
                        <form class="w-100" id="sellerPass" method="post">
                            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Old Password *</label>
                                <input type="password" name="old_password">
                            </div>

                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Create Password *</label>
                                <div class="_input_otp">
                                    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="password">
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 form_inputs">
                                <label>Confirm Password *</label>
                                <div class="_input_otp">
                                    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="con_password">
                                    <i class="fas fa-eye _showPassword"></i>
                                </div>
                            </div>

                            <div class="col-lg-12 text-right">
                                <button type="submit" class="button_2">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- start payment modal -->
<div class="modal-body p-0" id="paymentDataUi"></div>
<!-- end payment modal -->

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script type="text/javascript">
$(document).on("click", ".navPanel", function(){
    $(".cmnBx").hide();
    $("#"+$(this).data("href")).show();
});
$(document).on('submit', '#sellerDetailsForm', function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('seller-details-data'); ?>", 
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
                    title: "Successfully Updated!",
                    message: data.text,
                });
                setTimeout(function(){
                    location.reload();
                }, 1000);
                
            }
        }
    });
});
$(document).on('submit', '#sellerBusinessForm', function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('seller-business-data'); ?>", 
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
                    title: "Successfully Updated!",
                    message: data.text,
                });
                setTimeout(function(){
                    location.reload();
                }, 1000);
                
            }
        }
    });
});
$(document).on('submit', '#sellerBankForm', function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('seller-bank-data'); ?>", 
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
                    title: "Successfully Updated!",
                    message: data.text,
                });
                setTimeout(function(){
                    location.reload();
                }, 1000);
                
            }
        }
    });
});
$(document).on('submit', '#sellerAddressForm', function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('seller-address-data'); ?>", 
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
                    title: "Successfully Updated!",
                    message: data.text,
                });
                setTimeout(function(){
                    location.reload();
                }, 1000);
                
            }
        }
    });
});
$(document).on('submit', '#sellerPassForm', function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('seller-pass-change'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type:data.type, message:data.text});
            if(data.type=='success'){
                location.replace("<?php echo base_url('seller-logout'); ?>");
            }
        }
    });
});
$(document).on("click", "#seller_subscription_form .plan_tenure label", function(){
    $("#seller_subscription_form .plan_tenure label").removeClass('active');
    $(this).addClass('active');
});
function razorpayform_submit(){
    $.ajax({  
        url:"<?php echo base_url('verify-payment'); ?>", 
        method:'POST',  
        data:new FormData(document.getElementById('razorpayform')),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            if(data.type=="success"){
                $("#seller_subscription_form input[name='razorpay_order_id']").val(data.razorpay_order_id);
                $("#seller_subscription_form input[name='razorpay_payment_id']").val(data.razorpay_payment_id);
                $("#seller_subscription_form input[name='merchant_order_ref']").val(data.merchant_order_ref);
                $("#seller_subscription_form input[name='expire_month_count']").val(1);
                $("#seller_subscription_form").submit();
            }else{
                webinaToast({type:data.type, message:data.text});
            }
        }
    });
}
function pay_now_subscription(self){
    var plan=$(self).data('plan_name');
    var price=$(self).data('plan_price');
    $("#seller_subscription_form input[name='price_amount']").val(price);
    $("#seller_subscription_form input[name='subscription_plan']").val(plan);
    $.ajax({
        url:"<?php echo base_url('make-subscription-payment'); ?>", 
        method:'POST',  
        data:new FormData(document.getElementById('seller_subscription_form')),
        dataType: 'JSON',
        contentType:false,  
        processData:false, 
        success:function(data){
            if(data.type=='success'){
                $("#paymentDataUi").html(data.payment_ui);
                document.getElementById("rzp-button1").click();
            }else{
                webinaToast({type:data.type, message:data.text});
            }
        }
    });
}
$(document).on('submit', '#seller_subscription_form', function(e){
    e.preventDefault();
    $.ajax({
        url:"<?php echo base_url('seller-subscription-change'); ?>", 
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
});
</script>
</body>
</html>