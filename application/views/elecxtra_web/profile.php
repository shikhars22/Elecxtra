<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | My Profile</title>
<?php echo $link_scripts; ?>
<style type="text/css">
#rating_card {position: fixed; height: 100%; width: 100%; left: 0; top: 0; background-color: #00000073; display: none; z-index: 9999;}
.rating_holder {position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%); padding: 25px; border-radius: 25px; background-color: #fff; width: 320px;}
.rating_holder .fa-star {color: #dcdcdc;}
.rating_holder .checked, .rating_holder .finalChecked {color: #fcc322;}
.cart_box ._allInfo {width: calc(100% - 90px);}
.cart_box .delivery_info {width: 200px;}
.cart_box .prod_info {width: calc(100% - 200px);}

.cr_modal {position: fixed; top:0; left:0; height:100%; width: 100%; display:none; align-items: center; justify-content:center; background-color:#00000026; z-index:9999;}
.cr_modal_body {background-color: #fff; padding: 30px; border-radius: 8px; position:relative;}
.cr_modal_body .close_i {position: absolute; right:0; top:0; padding: 15px; cursor: pointer;}
.cr_modal_body label {font-size:14px; margin-bottom:0px;}
.cr_modal_body select, .cr_modal_body textarea {width:100%; border:1px solid #ddd; padding:7px; font-size:14px;}

.open_cr_modal {display:grid !important;}


/*/Invoice Modal/*/
.ivoice_modal {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background-color: #22222250; z-index: 99999; overflow-y: auto; display: none; padding: 20px;}
.invoice_content {width: 70%; background-color: #fff; margin: auto; padding: 20px;}
.invoice_heading, .invoice_gen {display: flex; justify-content: space-between; border: 1px solid #ccc; border-bottom: none;}
.invoice_gen h5 {font-weight: 700;}
.invoice_heading h6, .invoice_heading i {padding: 15px;}
.invoice_table {border: 1px solid #ccc;}
.invoice_table .item_desp {padding: 15px; border-bottom: 1px solid #ccc; text-align: left;}
.invoice_table table tr th {font-size: 14px;}
.ivoice_modal .p-3 {padding: 15px;}
.ivoice_modal .mb-0 {margin-bottom: 0;}
.ivoice_modal .mb-1 {margin-bottom: 5px;}
.ivoice_modal .text_right {text-align: right;}
.ivoice_modal .table {width: 100%; margin-bottom: 0; color: #212529; border-collapse: collapse;}
.ivoice_modal .table-responsive {display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: none;}

.ivoice_modal tr {border: 1px solid #ccc;}

.ivoice_modal_show {display: block;}

.spanSpace span{margin-right:3px;}

@media only screen and (max-width:991px) {
    .cart_box ._allInfo {display:block;}
    .cart_box .prod_info {width: 100%;}
    .cart_box .delivery_info {width: 100%; margin-top: 8px;}
}
    
@media only screen and (max-width:767px) {
    .cart_box ._allInfo {padding-left: 15px;}
    .cart_box .delivery_info {padding:0;}
}
@media only screen and (max-width:576px) {
    .ivoice_modal {padding:0;}
    .invoice_content {width: 100%; padding: 10px;}
    .cr_modal_body {width: 100%; padding: 25px 15px;}
}
@media only screen and (max-width:480px) {

}
</style>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<section class="profile py-lg-3 py-md-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 plrm_0 mb-4">
                <div class="profile_box">
                    <a href="javascript:void(0)" data-href="#myprofile" class="box_info box_open">
                        <span class="fs_13"><i class="fas fa-edit text-white fs_13 mt-3"></i></span>
                        <h6><i class="fas fa-user"></i> <?php echo $user_data->name; ?></h6>
                        <p><i class="fas fa-phone-alt"></i> <?php echo $user_data->phone; ?></p>
                        <p><i class="fas fa-envelope"></i> <?php echo $user_data->email; ?></p>
                    </a>
                    <div class="box_info">
                        <h6><i class="fas fa-map-marker-alt"></i> Address <i class="fas fa-edit float-right fs_13 mt-1"></i></h6>
                        <?php
                            if(empty($user_data->pins)){
                                echo "<h6>No Address Found!</h6>";
                            }else{
                                $types=explode("||", $user_data->types);
                                $pins=explode("||", $user_data->pins);
                                $cities=explode("||", $user_data->cities);
                                $land_marks=explode("||", $user_data->land_marks);
                                $addresses=explode("||", $user_data->addresses);
                                $states=explode("||", $user_data->states);
                                for ($i=0; $i < count($pins); $i++) { ?>
                                    <div data-href="#address" class="text-dark box_open" data-form_id="address_<?php echo $i; ?>">
                                        <p class="mb-0 fs_14 pl-3"><?php echo $pins[$i] ?>, <?php echo $cities[$i] ?>, <?php echo $land_marks[$i] ?>, <?php echo $addresses[$i] ?>, <?php echo $states[$i] ?>
                                        </p>
                                    </div>
                                <?php }
                            } 
                        ?>
                    </div>
                    <div>
                        <a href="javascript:void(0)" data-href="#myorder" class="box_info border-bottom-0 box_open">
                            <h6 class="border-bottom-0"><i class="fas fa-shopping-cart"></i> View Order History</h6>
                        </a>
                        <a href="javascript:void(0)" data-href="#password" class="box_info border-bottom-0 box_open">
                            <h6 class="border-bottom-0"><i class="fas fa-lock"></i> Change Password</h6>
                        </a>
                        <a href="<?php echo base_url("logout"); ?>" class="box_info box_open">
                            <h6 class="border-bottom-0"><i class="fas fa-sign-out-alt"></i> Logout</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 plrm_0">
                <div class="profile_edit_box">
                    <div class="profile_cmmn" style="display: block;">
                        <h6 class="subheading mb-3 mt-2 mx-3">Welcome to Elecxtra <i class="fas fa-arrow-right float-right d-lg-none d-md-none" onclick="closeEditor(this)"></i></h6>
                        <hr>
                        <div class="form_inputs">
                            <p class="fs_14 mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>

                    <div id="myprofile" class="profile_cmmn">
                        <form id="p_form">
                            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                            <h6 class="subheading mb-3 mt-2 mx-3">My Profile <i class="fas fa-arrow-right float-right d-lg-none d-md-none" onclick="closeEditor(this)"></i></h6>
                            <hr>
                            <div class="form_inputs">
                                <small class="mb-0">Name *</small>
                                <input type="text" name="name" required value="<?php echo $user_data->name; ?>" class="m-0">
                            </div>

                            <div class="form_inputs">
                                <small class="mb-0">Mobile Number</small>
                                <input type="text" name="phone" value="<?php echo $user_data->phone; ?>" class="m-0">
                            </div>

                            <div class="form_inputs">
                                <small class="mb-0">Email Address *</small>
                                <input type="email" name="email" required value="<?php echo $user_data->email; ?>" class="m-0">
                            </div>

                            <div class="form_inputs justify-content-end mb-0">
                                <button type="submit" class="button_1 bg-success">&nbsp;&nbsp; Save &nbsp;&nbsp;</button>
                                <button onclick="closeEditor(this)" type="button" class="closeEditor button_1 bg-warning">&nbsp;&nbsp; Close &nbsp;&nbsp;</button>
                            </div>
                        </form>
                    </div>

                    <div id="address" class="profile_cmmn">
                       <?php
                            if(empty($user_data->pins)){
                                echo "<h6>No Address Found!</h6>";
                            }else{
                                for ($i=0; $i < count($pins); $i++) { ?>
                                    <form id="address_<?php echo $i; ?>" class="addr_form" style="display:none;">
                                        <h6 class="subheading mb-3 mt-2 mx-3">My Address <i class="fas fa-arrow-right float-right d-lg-none d-md-none" onclick="closeEditor(this)"></i></h6>
                                        <hr>
                                        <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                                        <input type="hidden" name="old_type" value="<?php echo $types[$i]; ?>">
                                        <div class="form_inputs">
                                            <small class="mb-0">Type</small>
                                            <input type="text" name="type" value="<?php echo $types[$i]; ?>">
                                        </div>
                                        <div class="form_inputs">
                                            <small class="mb-0">Pin</small>
                                            <input type="text" name="pin" value="<?php echo $pins[$i]; ?>">
                                        </div>
                                        <div class="form_inputs">
                                            <small class="mb-0">City</small>
                                            <input type="text" name="city" value="<?php echo $cities[$i]; ?>">
                                        </div>
                                        <div class="form_inputs">
                                            <small class="mb-0">State</small>
                                            <input type="text" name="state" value="<?php echo $states[$i]; ?>">
                                        </div>
                                        <div class="form_inputs">
                                            <small class="mb-0">Land Mark</small>
                                            <input type="text" name="land_mark" value="<?php echo $land_marks[$i]; ?>">
                                        </div>
                                        <div class="form_inputs">
                                            <small class="mb-0">Address</small>
                                            <textarea cols="3" name="address"><?php echo $addresses[$i]; ?></textarea>
                                        </div>
                                        <div class="form_inputs justify-content-end mb-0">
                                            <button type="submit" class="button_1 bg-success">&nbsp;&nbsp; Save &nbsp;&nbsp;</button>
                                            <button onclick="closeEditor(this)" type="button" class="closeEditor button_1 bg-warning">&nbsp;&nbsp; Close &nbsp;&nbsp;</button>
                                        </div>
                                    </form>
                                <?php }
                            } 
                        ?>
                    </div>

                    <div id="password" class="profile_cmmn">
                        <form id="change_pass_form">
                            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                            <h6 class="subheading mb-3 mt-2 mx-3">Change Password <i class="fas fa-arrow-right float-right d-lg-none d-md-none" onclick="closeEditor(this)"></i></h6>
                            <hr>
                            <div class="form_inputs">
                                <small class="mb-0">Enter Old Password *</small>
                            <input type="password" name="old_password" required class="m-0">
                            </div>

                            <div class="form_inputs">
                                <small class="mb-0">Enter New Password *</small>
                                <input type="password" name="password" required class="m-0">
                            </div>

                            <div class="form_inputs">
                                <small class="mb-0">Confirm New Password *</small>
                                <input type="password" name="con_password" required class="m-0">
                            </div>

                            <div class="form_inputs justify-content-end mb-0">
                                <button type="submit" class="button_1 bg-success">&nbsp;&nbsp; Save &nbsp;&nbsp;</button>
                                <button onclick="closeEditor(this)" type="button" class="closeEditor button_1 bg-warning">&nbsp;&nbsp; Close &nbsp;&nbsp;</button>
                            </div>
                        </form>
                    </div>

                    <div id="myorder" class="profile_cmmn py-0" style="display: none; background-color: #eee;">
                        <h6 class="subheading p-3 mb-1 bg-white">My Orders <i class="fas fa-arrow-right float-right pb-2 d-lg-none d-md-none" onclick="closeEditor(this)"></i></h6>
                        <div id="order_data">
                            
                        </div>
                    </div>
                    <div id="oooo" class="profile_cmmn d-none" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- start invoice modal -->
<div class="ivoice_modal">
    <div class="invoice_content">
        <div class="invoice_heading">
            <h6 class="mb-0">Invoice</h6>
            <i class="fas fa-times close_modal"></i>
        </div>
        <!--load-order-->
            <div id="invBody">
        
            </div>
        <!--load-order-end-->
    </div>
</div>
<!-- end invoice modal -->

<!-- Cancel & Reurnt Modal -->
<div class="cr_modal" id="cancel_modal">
    <div class="cr_modal_body">
        <i class="fas fa-times close_i" onclick="$(this).closest('.cr_modal').removeClass('open_cr_modal');"></i>
        <form id="cancel_form" method="post">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <input type="hidden" name="order_id">
            <input type="hidden" name="qty">
            <input type="hidden" name="seller_id">
            <input type="hidden" name="product_id">
            <div class="mb-3">
                <label>Choose Reason</label>
                <select name="cancel_reason" required>
                    <option value="">Select Reason</option>
                    <option value="Ordered by mistake">Ordered by mistake</option>
                    <option value="Ordered wrong product">Ordered wrong product</option>
                    <option value="Want to change delivery address">Want to change delivery address</option>
                    <option value="Delivery time is very long">Delivery time is very long</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Write Something</label>
                <textarea name="cancel_reason_text"></textarea>
            </div>
            
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('.cr_modal').removeClass('open_cr_modal');">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>

<div class="cr_modal" id="return_modal">
    <div class="cr_modal_body">
        <i class="fas fa-times close_i" onclick="$(this).closest('.cr_modal').removeClass('open_cr_modal');"></i>
        <form id="return_form" method="post">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <input type="hidden" name="order_id">
            <input type="hidden" name="qty">
            <input type="hidden" name="seller_id">
            <input type="hidden" name="product_id">
            <div class="mb-3">
                <label>Choose Reason</label>
                <select name="return_reason">
                    <option value="Received wrong product">Received wrong product</option>
                    <option value="Delivered too late">Delivered too late</option>
                    <option value="Want to buy another product">Want to buy another product</option>
                    <option value="Product quality is not good">Product quality is not good</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Something Else</label>
                <textarea name="return_reason_text"></textarea>
            </div>
            
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('.cr_modal').removeClass('open_cr_modal');">Close</button>
                &nbsp;
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- Cancel & Reurnt Modal -->

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>

<script type="text/javascript">
$(document).on("click", ".box_open", function(e){
    e.stopPropagation();
    $(".profile_edit_box .profile_cmmn").hide();
    $(".profile_edit_box "+$(this).data("href")).show();
    if($(this).data("href")=="#address"){
        $("#address form").hide();
        $("#address #"+$(this).data("form_id")).show();
    }
    if($(this).data("href")=="#myorder"){
        fetch_recent_my_order("all_order");
    }
});
function closeEditor(self) {
    $(self).closest(".profile_cmmn").hide();
}
function is_active(){
    var loc=window.location.href;
    var click=loc.split('#')[1];
    $(".profile_box a[href='#"+click+"'").trigger('click');
}
$(document).ready(function() {
    is_active();
});

$(document).on('submit', '#p_form', function(e){
    e.preventDefault();
    var getThis=$(this);
    $.ajax({  
        url:"<?php echo base_url('personal-form-data'); ?>", 
        method:'POST',
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type:data.type, message:data.text});
            if(data.type=='success'){
                $(getThis).find(".closeEditor").trigger("click");
            }
        }
    });
});
$(document).on('submit', '.addr_form', function(e){
    e.preventDefault();
    var getThis=$(this);
    $.ajax({  
        url:"<?php echo base_url('address-form'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type:data.type, message:data.text});
            if(data.type=='success'){
                $(getThis).find(".closeEditor").trigger("click");
            }
        }
    });
});
$(document).on('submit', '#change_pass_form', function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('change-pass-form'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type:data.type, message:data.text});
            if(data.type=='success'){
                location.replace("<?php echo base_url('logout'); ?>");
            }
        }
    });
});
function calcel_order(self){
    $("#cancel_form").find("input[name='order_id']").val($(self).data('order_id'));
    $("#cancel_form").find("input[name='qty']").val($(self).data('qty'));
    $("#cancel_form").find("input[name='seller_id']").val($(self).data('seller_id'));
    $("#cancel_form").find("input[name='product_id']").val($(self).data('product_id'));
    $("#cancel_modal").addClass('open_cr_modal');
}
function return_order(self){
    $("#return_form").find("input[name='order_id']").val($(self).data('order_id'));
    $("#return_form").find("input[name='qty']").val($(self).data('qty'));
    $("#return_form").find("input[name='seller_id']").val($(self).data('seller_id'));
    $("#return_form").find("input[name='product_id']").val($(self).data('product_id'));
    $("#return_modal").addClass('open_cr_modal');
}
$(document).on('submit', '#cancel_form', function(e){
    e.preventDefault();
    if($("#cancel_form").find("input[name='seller_id']").val()=="" || $("#cancel_form").find("input[name='product_id']").val()=="" || $("#cancel_form").find("input[name='order_id']").val()=="" || $("#cancel_form").find("input[name='qty']").val()=="" || $("#cancel_form").find("input[name='cancel_reason']").val()==""){
        webinaToast({type:'warning', message:'Something went wrong! OrderId not found!'});
    }else{
        $.ajax({  
            url:base_url+"/cancel-order", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    location.replace("<?php echo base_url('profile'); ?>");
                }
            }
        });
    }
});
$(document).on('submit', '#return_form', function(e){
    e.preventDefault();
    if($("#return_form").find("input[name='seller_id']").val()=="" || $("#return_form").find("input[name='product_id']").val()=="" || $("#return_form").find("input[name='order_id']").val()=="" || $("#return_form").find("input[name='qty']").val()=="" || $("#return_form").find("input[name='return_reason']").val()==""){
        webinaToast({type:'warning', message:'Something went wrong! OrderId not found!'});
    }else{
        $.ajax({  
            url:base_url+"/return-order",
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,  
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    location.replace("<?php echo base_url('profile'); ?>");
                }
            }
        });
    }
});
function fetch_recent_my_order(status){
    $.ajax({  
        url:"<?php echo base_url('my-order-data'); ?>", 
        method:'POST',
        data:{[csrfName]:csrfHash, status:status},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
                $("#order_data").html(data.data);
            }
        }
    });
}


var modal = document.querySelector(".ivoice_modal");
var closeButton = document.querySelector(".close_modal");
function toggleModal() {
  modal.classList.toggle("ivoice_modal_show");
  $("body").toggleClass("no_scroll")
}
function windowOnClick(event) {
  if (event.target === modal) {
    toggleModal();
  }
}
closeButton.addEventListener("click", toggleModal);
function windowOnClick(event) {
  if (event.target === modal) {
    toggleModal();
  }
}
window.addEventListener("click", windowOnClick);
function fetch_order_invoice(order_id){
    $.ajax({  
        url:base_url+"/fetch-order-invoice", 
        method:'POST',
        data:{[csrfName]:csrfHash, order_id:order_id},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
                toggleModal()
                $("#invBody").html(data.data);
            }
        }
    });
}
</script>


<script language="javascript">
function PrintMe(DivID) {
var inv_id="0000000";
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
   var content_vlue = document.getElementById(DivID).innerHTML;
   var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
   docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head><title>'+inv_id+'</title>');
  docprint.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">');
  
   docprint.document.write('<style>.ivoice_modal {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background-color: #22222250; z-index: 99999; overflow-y: auto; display: none; padding: 20px;} .invoice_content {width: 70%; background-color: #fff; margin: auto; padding: 20px;} .invoice_heading, .invoice_gen {display: flex; justify-content: space-between; border: 1px solid #ccc; border-bottom: none;} .invoice_gen h5 {font-weight: 700;} .invoice_heading h6, .invoice_heading i {padding: 15px;} .invoice_table {border: 1px solid #ccc;} .invoice_table .item_desp {padding: 15px;  border-bottom: 1px solid #ccc; text-align: left;} .invoice_table table tr th {font-size: 14px;} .ivoice_modal .p-3 {padding: 15px;} .ivoice_modal .mb-0 {margin-bottom: 0;} .ivoice_modal .mb-1 {margin-bottom: 5px;} .ivoice_modal .text_right {text-align: right;} .ivoice_modal .table {width: 100%; margin-bottom: 0; color: #212529; border-collapse: collapse;} .ivoice_modal .table-responsive {display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: none;} .ivoice_modal td, .ivoice_modal th {border: 1px solid #ddd;} .ivoice_modal_show {display: block;} .spanSpace span{margin-right:3px;} @media only screen and (max-width:576px) { .ivoice_modal {padding:0;} .invoice_content {width: 100%; padding: 10px;} }</style>');
  
   docprint.document.write('</head><body onLoad="self.print()"><center>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}
</script>
</body>
</html>