<?php if(!empty($cart_data) && (!empty($product_details))){ $price_commission=json_decode(price_commission()); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout</title>
<?php echo $link_script; ?>
<style type="text/css">
body{font-family: 'arial', sans-serif;}
.shippDiv {padding: 15px; background-color: #fff;}
.form_inputs ._labelDiv {position: relative; margin-bottom: 8px;}
label {font-size: 12px; color: #777; cursor: pointer;}
.form_inputs ._labelDiv label {position: absolute; top: 7px; left: 12px; user-select: none; font-size: 12px;}
.form_inputs input, .form_inputs select, .form_inputs textarea {margin-top: 0; margin-bottom: 0px; border: 1px solid #ddddddab; padding-top: 24px; height: auto; text-transform: capitalize;}
.cart_box .prod_img {height: 60px; width: 60px; margin: 0;}
.cart_box ._allInfo {width: calc(100% - 60px); display: grid; align-content: center; padding-left: 10px;}
.prod_info ul:empty {display: none;}
@media only screen and (max-width: 767px){
    .cart_box {padding: 0px 15px 0 5px; margin-bottom: 15px;}
}
@media only screen and (max-width:576px) {
    footer, .footer_btm {display: none;}
    .resp_proceed {position: fixed; bottom: 0; left: 0; width: 100%; height: 59px; border-top: 1px solid #ddd; display: flex; align-items: center; justify-content: space-between; padding: 0; background-color: #fff; z-index: 99;}
    ._mb60 {height: 50px;}
    ._atlstP0 {padding: 0;}
}

</style>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<section class="my-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                <form id="billing_form" class="billing_form_2" method="post">
                    <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                    <input type="hidden" name="payment_mode" value="Cash On Delivery">
                    <input type="hidden" name="razorpay_order_id" value="">
                    <input type="hidden" name="razorpay_payment_id" value="">
                    <input type="hidden" name="merchant_order_ref" value="">
                    <input type="hidden" name="name" value="<?php echo ucwords($user_data->name); ?>">
                    <input type="hidden" name="phone" value="<?php echo $user_data->phone; ?>">
                    <input type="hidden" name="email" value="<?php echo $user_data->email; ?>">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 _atlstP0">
                            <?php
                                if(empty($user_data->pins)){
                                    echo "<div class='_heading bg-white mb-2'><h6 class='mb-0'>No Address Found</h6><a class='fs_14 ml-auto' href='".base_url('profile#address')."'>+ Add an address</a></div>";
                                }else{
                                    echo "<div class='_heading bg-white mb-1'><h6 class='mb-0'>Deliver To This Address</h6></div>";
                                    $types=explode("||", $user_data->types);
                                    $pins=explode("||", $user_data->pins);
                                    $cities=explode("||", $user_data->cities);
                                    $land_marks=explode("||", $user_data->land_marks);
                                    $addresses=explode("||", $user_data->addresses);
                                    $states=explode("||", $user_data->states);
                                    for ($i=0; $i < count($pins); $i++) { ?>
                                        <div class="shippDiv mb-1 ship_div<?php if($i==0){echo ' ship_div_active';} ?>">
                                            <div class="availableAdrr">
                                                <div class="d-flex flex-wrap align-items-center w-100">
                                                    <label class="checkAddr">
                                                        <input type="radio" name="ship_addr_type" value="<?php echo $types[$i]; ?>" <?php if($i==0){echo "checked";} ?> style="height: 16px; width: 16px; position: relative; top: 4px;">&nbsp;&nbsp;
                                                        <span class="mb-0"><?php echo $types[$i]; ?> <span class="available_<?php echo $pins[$i] ?>"></span></span><br>
                                                        <p class="mb-0 fs_14 pl-3">&nbsp;&nbsp;<?php echo $pins[$i] ?>, <?php echo $cities[$i] ?>, <?php echo $land_marks[$i] ?>, <?php echo $addresses[$i] ?>, <?php echo $states[$i] ?></p>
                                                    </label>
                                                    <a href="javascript:void(0)" class="fs_15 ml-auto editable_shipping_form">Edit</a>
                                                </div>
                                            </div>
                                            <div class="row form_inputs shippingAddrArea" data-address_type="<?php echo $types[$i]; ?>" style="display: none;">
                                                <div class="col-12 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <input type="radio" checked style="height: 16px; width: 16px;">&nbsp;&nbsp;
                                                        <label class="mb-0">Change <?php echo $types[$i]; ?> Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-6 col-12 pr-lg-1">
                                                    <div class="_labelDiv">
                                                        <label>Pincode <span class="text-danger">*</span></label>
                                                        <input type="text" name="shipping_pin" autocomplete="off" value="<?php echo $pins[$i]; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-6 col-12 pl-lg-1">
                                                    <div class="_labelDiv">
                                                        <label>City <span class="text-danger">*</span></label>
                                                        <input type="text" name="shipping_city" autocomplete="off" value="<?php echo $cities[$i]; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-6 col-12 pr-lg-1">
                                                    <div class="_labelDiv">
                                                        <label>State <span class="text-danger">*</span></label>
                                                        <input type="text" name="shipping_state" autocomplete="off" value="<?php echo $states[$i]; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-6 col-12 pl-lg-1">
                                                    <div class="_labelDiv">
                                                        <label>Landmark <span class="text-danger">*</span></label>
                                                        <input type="text" name="shipping_land_mark" autocomplete="off" value="<?php echo $land_marks[$i]; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="_labelDiv mb-0">
                                                        <label>Address <span class="text-danger">*</span></label>
                                                        <textarea name="shipping_address" required><?php echo $addresses[$i]; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="button" onclick="save_this_address(this)" class="button_1 bg-success">Save This Address</button>
                                                    <button type="button" class="button_2 editable_shipping_form">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } 
                            ?>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-1 _atlstP0">
                            <div class='_heading bg-white mt-0 mb-1'><h6 class='mb-0'>Payment Method</h6></div>
                            <div class="shippDiv d-flex align-items-center pb-2">
                                <label class="fs_14 d-flex align-items-center w-50"><input type="radio" name="paymode" value="cash" required style="height: 16px; width: 16px;">&nbsp;&nbsp;<span>Cash On Delivery</span></label>
                                <label class="fs_14 d-flex align-items-center w-50"><input type="radio" name="paymode" value="paynow" required style="height: 16px; width: 16px;">&nbsp;&nbsp;<span>Pay Now</span></label>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 col-12 pl-lg-0 _atlstP0">
                <div class="price_details">
                    <div class="_heading bg-white mb-1">
                        <h6 class="mb-0">Price Details</h6>
                    </div>
                    <?php $all_total=0; $count_total=0; $item_count=0;
                        foreach($cart_data as $key => $value){
                            foreach($product_details as $p => $pv){
                                if($pv['id']==$value['product_id']){
                                    $finalPrice=0;
                                    foreach ($price_commission as $k => $v){
                                        if($pv['price']<=$v->max_price){
                                            $other_charge=2;
                                            $comms=$v->commission;
                                            $webViewPrice=$pv['price']+($pv['price']*$v->commission/100);
                                            $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                                            break;
                                        }
                                    }
                                    $sub_total=$finalPrice*$value['qty'];
                                    $count_sub_total=$finalPrice*$value['qty']; ?>
                                    <div class="cart_box mb-1 py-1 px-2">
                                        <div class="prod_img img_contain">
                                            <img src="<?php echo base_url('uploads/products/').$pv['main_img']; ?>">
                                        </div>
                                        <div class="_allInfo">
                                            <p class="prod_name clip_txt_1"><small><?php echo $pv['cat_name'].', '.$pv['item_name']; ?></small></p>
                                            <p class="prod_name clip_txt_1 fs_14"><?php echo $pv['name']; ?></p>
                                            <div class="prod_price mb-0">
                                                <h6>&#8377;<?php echo $finalPrice; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $all_total+=$sub_total; $count_total+=$count_sub_total; $item_count++;
                                }
                            }
                        } ?>
                    <table>
                        <tr>
                            <td><?php echo $item_count; ?> Items</td>
                            <td>&#8377;<?php echo $count_total; ?></td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td class="text-success fs_14">- &#8377;<?php echo ($count_total-$all_total); ?></td>
                        </tr>
                        <tr class="border-top" id="total_show">
                            <td>Total</td>
                            <td class="">&#8377;<?php echo $all_total; ?></td>
                        </tr>
                        <tr id="del_info">
                            
                        </tr>
                        <tr>
                            <td>All Total</td>
                            <td>&#8377;<span class="all_total_all"><?php echo $all_total; ?></span></td>
                        </tr>
                    </table>
                    <button class="place_order button_2 w-100 d-lg-block d-md-block d-sm-block d-none" type="button">Continue Checkout</button>
                    <table>
                        <tr>
                            <td class="text-left border-top-0"><img src="<?php echo base_url('viewer_assets/images/secure.png'); ?>"></td>
                            <td class="text-left border-top-0 fs_14 pl-0">Security policy (edit with Customer reassurance module)</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="_mb60"></div>
<div class="resp_proceed d-lg-none d-md-none d-sm-none bg-success">
    <p class="mb-0 all_total d-flex align-items-center pl-3 text-white"><span class="fs_13">All Total &nbsp; </span> &#8377;<span class="all_total_all fs_16"><?php echo $all_total; ?></span></p>
    <button type="button" class="place_order button_2 h-100">Continue Checkout</button>
</div>

<!-- start payment modal -->
<div class="modal-body p-0" id="paymentDataUi"></div>
<!-- end payment modal -->
<?php echo $footer; ?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script type="text/javascript">
var totalPayment=0;
function save_this_address(self){
    var address_type=$(self).closest(".shippingAddrArea").data("address_type");
    var shipping_pin=$("#billing_form .ship_div_active input[name='shipping_pin']").val();
    var shipping_city=$("#billing_form .ship_div_active input[name='shipping_city']").val();
    var shipping_state=$("#billing_form .ship_div_active input[name='shipping_state']").val();
    var shipping_address=$("#billing_form .ship_div_active textarea[name='shipping_address']").val();
    var shipping_land_mark=$("#billing_form .ship_div_active input[name='shipping_land_mark']").val();
    if(shipping_pin=="" || shipping_city=="" || shipping_state=="" || shipping_address=="" || shipping_land_mark==""){
        webinaToast({type:data.type, message:data.text});
    }else{
        $.ajax({
            url:base_url+"/address-form",
            method:'POST',
            data:{[csrfName]:csrfHash, old_type:address_type, type:address_type, pin:shipping_pin, address:shipping_address, city:shipping_city, state:shipping_state, land_mark:shipping_land_mark},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type:data.type, message:data.text});
                if(data.type=="success"){
                    location.reload();
                }
            }
        });
    }
}
$(document).ready(function(){
    search_this_pin("<?php echo $pins[0]; ?>");
});
$(document).on('click', '#billing_form .editable_shipping_form', function(){
    if($(this).closest('ship_div').hasClass('ship_div_active')==false){
        $(this).closest(".ship_div").siblings(".ship_div").find("input[name='ship_addr_type']").prop('checked', false);
    }
    $(this).closest('.ship_div').find('.availableAdrr').toggle();
    $(this).closest('.ship_div').find('.shippingAddrArea').toggle();
});
$(document).on('click', '#billing_form .ship_div', function(){
    $(this).siblings(".ship_div").find(".availableAdrr").show();
    $(this).siblings(".ship_div").find(".shippingAddrArea").hide();
    if($(this).hasClass('ship_div_active')==false){
        $(this).siblings(".ship_div").removeClass('ship_div_active');
        $(this).addClass('ship_div_active');
        search_this_pin($(this).find("input[name='shipping_pin']").val());
    }else{
        $(this).find("input[name='ship_addr_type']").prop('checked', true);
    }
});
$(document).on("submit", "#billing_form", function(e){
    e.preventDefault();
    var razorpay_order_id=$("#billing_form input[name='razorpay_order_id']").val();
    var razorpay_payment_id=$("#billing_form input[name='razorpay_payment_id']").val();
    var merchant_order_ref=$("#billing_form input[name='merchant_order_ref']").val();
    var payment_mode=$("#billing_form input[name='payment_mode']").val();
    var shipping_pin=$("#billing_form .ship_div_active input[name='shipping_pin']").val();
    var shipping_city=$("#billing_form .ship_div_active input[name='shipping_city']").val();
    var shipping_state=$("#billing_form .ship_div_active input[name='shipping_state']").val();
    var shipping_address=$("#billing_form .ship_div_active textarea[name='shipping_address']").val();
    var shipping_land_mark=$("#billing_form .ship_div_active input[name='shipping_land_mark']").val();
    $.ajax({
        url:base_url+"cart/place-order", 
        method:'POST',
        data:{[csrfName]:csrfHash, payment_mode:payment_mode, shipping_pin:shipping_pin, shipping_city:shipping_city, shipping_state:shipping_state, shipping_address:shipping_address, shipping_land_mark:shipping_land_mark, razorpay_order_id:razorpay_order_id, razorpay_payment_id:razorpay_payment_id, merchant_order_ref:merchant_order_ref},
        dataType: 'JSON',
        success:function(data){
            webinaToast({type:data.type, message:data.text});
            if(data.type=="success"){
                location.replace(base_url+"/profile");
            }
        }
    });

})
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
                $("#billing_form input[name='payment_mode']").val('Payment Done');
                $("#billing_form input[name='razorpay_order_id']").val(data.razorpay_order_id);
                $("#billing_form input[name='razorpay_payment_id']").val(data.razorpay_payment_id);
                $("#billing_form input[name='merchant_order_ref']").val(data.merchant_order_ref);
                $("#billing_form").submit();
            }else{
                webinaToast({type:data.type, message:data.text});
            }
        }
    });
}
$(document).on('click', '.place_order', function(){
    var check=Array();        
    if($('#billing_form .ship_div_active input[name="shipping_address"]').val()==""){
        webinaToast({type:'warning', message:'Shipping Address Required!'});
        check.push('false');
        return false;
    }
    $('#billing_form .ship_div_active input[type="text"]').each(function() {
        if($(this).val()==''){
            $(this).focus();
            check.push('false');
            return false;
        }
    });
    $('#billing_form .ship_div_active textarea').each(function() {
        if($(this).val()==''){
            $(this).focus();
            check.push('false');
            return false;
        }
    });
    $('#billing_form .ship_div_active select').each(function() {
        if($(this).find('option:selected').val()==''){
            $(this).focus();
            check.push('false');
            return false;
        }
    });
    if($('#billing_form input[name="paymode"]').is(':checked')){
        if($('#billing_form input[name="paymode"]:checked').val()=='paynow'){
            var name=$("#billing_form input[name='name']").val();
            var phone=$("#billing_form input[name='phone']").val();
            var email=$("#billing_form input[name='email']").val();
            var shipping_pin=$("#billing_form .ship_div_active input[name='shipping_pin']").val();
            var shipping_city=$("#billing_form .ship_div_active input[name='shipping_city']").val();
            var shipping_state=$("#billing_form .ship_div_active input[name='shipping_state']").val();
            var shipping_address=$("#billing_form .ship_div_active textarea[name='shipping_address']").val();
            var shipping_land_mark=$("#billing_form .ship_div_active input[name='shipping_land_mark']").val();
            $.ajax({  
                url:"<?php echo base_url('make-payment'); ?>", 
                method:'POST',  
                data:{[csrfName]:csrfHash, name:name, phone:phone, email:email, shipping_pin:shipping_pin, shipping_city:shipping_city, shipping_state:shipping_state, shipping_address:shipping_address, shipping_land_mark:shipping_land_mark},
                dataType: 'JSON',  
                success:function(data){
                    if(data.type=='success'){
                        $("#paymentDataUi").html(data.payment_ui);
                        document.getElementById("rzp-button1").click();
                    }else{
                        webinaToast({type:data.type, message:data.text});
                    }
                }
            });
            return false;
        }
    }else{
        webinaToast({type:'warning', message:'Select Payment Mode'});
        check.push('false');
        return false;
    }
    if(check.length==0){
        if($(this).html()=='Place Order'){
            $("#billing_form").submit();
        }else{
            search_this_pin($('#billing_form .ship_div_active input[name="shipping_pin"]').val());
        }
    }
});
function search_this_pin(search_pin){
    if(search_pin!=""){
        $.ajax({
            url:base_url+"cart/submit-checkout-pincode", 
            method:'POST',
            data:{[csrfName]:csrfHash ,search_pin:search_pin},
            dataType: 'JSON', 
            success:function(data){
                $(".available_"+search_pin).html(data.text);
                if(data.type=='success'){
                    totalPayment=data.total;
                    $("#del_info").show();
                    $("#total_show").show();
                    if(data.del_charge==0){
                        $("#del_info").html('<td></td><td class="text-success fs_13">No Delivery Charge!</td>');
                    }else{
                        $("#del_info").html('<td>Delivery</td><td class="text-warning fs_14">+ &#8377;'+data.del_charge+'</td>');
                    }
                    $(".all_total_all").html(data.total);
                    $(".place_order").html('Place Order');
                }else{
                    $("#del_info").hide();
                    $("#total_show").hide();
                    $(".place_order").html('Continue Checkout');
                }
            }
        });
    }
}
</script>
</body>
</html>
<?php }else{
    echo "something went wrong!";
} ?>