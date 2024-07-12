<?php if(!empty($cart_data) && (!empty($product_details))){ $price_commission=json_decode(price_commission()); ?>
<div class="col-lg-8 pr_0">
    <div class="_heading bg-white">
        <h6 class="mb-0">Shopping Cart</h6>
    </div>
    <!--ITEMS-->
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
                <div class="cart_box">
                    <div class="prod_qnty">
                        <a href="<?php echo base_url('product-details/'.$pv['title']); ?>" class="prod_img img_contain">
                            <img src="<?php echo base_url('uploads/products/').$pv['main_img']; ?>">
                        </a>
                        <div class="_qnty qty_holder m-auto w-100" data-cartdata="<?php echo base64_encode(convert_uuencode($pv['id'])); ?>" data-maxstock="<?php echo $pv['stock'] ?>">
                            <span class="minus qty_down">-</span>
                            <input type="text" class="qnty_input" value="<?php echo $value['qty']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <span class="plus qty_up">+</span>
                        </div>
                    </div>
                    <div class="_allInfo">
                        <div class="prod_info border-top-0 text-left pl-lg-2 pl-md-2 pl-0">
                            <p class="prod_name clip_txt_1"><small><?php echo $pv['cat_name'].', '.$pv['item_name']; ?></small></p>
                            <p class="prod_name clip_txt_1"><?php echo $pv['name']; ?></p>
                            <div class="prod_price mb-2">
                                <h6>&#8377;<?php echo $finalPrice; ?></h6>
                            </div>
                        </div>
                        <div class="delivery_info">
                            <p class="prod_name fs_13">Delivery by Sun May 15</p>
                            <a href="javascript:void(0)" class="text-danger _delete" data-cartdata="<?php echo base64_encode(convert_uuencode($pv['id'])); ?>" onclick="remove_cart(this)">Remove</a>
                        </div>
                    </div>
                </div>
                <?php $all_total+=$sub_total; $count_total+=$count_sub_total; $item_count++;
            }
        }
    } ?>
    <div class="cart_box">
        <a href="javascript:void(0)" onclick="clear_cart(this)">Clear Cart</a>
    </div>
</div>

<div class="col-lg-4 plrm_0">
    <div class="price_details">
        <div class="_heading bg-white">
            <h6 class="mb-0">Price Details</h6>
        </div>
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
            <tr id="del_info" style="display:none;">
                
            </tr>
            <tr>
                <td>All Total</td>
                <td>&#8377;<span class="all_total_all"><?php echo $all_total; ?></span></td>
            </tr>
        </table>
        <div class="w-100 bg-white p-3 text-right"><a class="button_2" href="<?php echo base_url('cart/checkout'); ?>">Place Order</a></div>
        <table>
            <tr>
                <td class="text-left border-top-0"><img src="<?php echo base_url('viewer_assets/images/secure.png'); ?>"></td>
                <td class="text-left border-top-0 fs_14 pl-0">Security policy (edit with Customer reassurance module)</td>
            </tr>
        </table>
    </div>
</div>
<?php }else{ ?>
    <div class="col-12">
        <div class="empty_cart">
            <img src="<?php echo base_url('viewer_assets/images/empty-cart.png'); ?>" alt="Empty Cart">
            <p class="mb-0 mt-3">You don't have any item in cart!<br><br><a class="btn btn-primary" href="<?php echo base_url() ?>">Go for shopping</a></p>
        </div>
    </div>
<?php } ?>