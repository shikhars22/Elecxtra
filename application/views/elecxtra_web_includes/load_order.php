<?php 
if(count($order_data)>0){
    foreach ($order_data as $key => $value) { ?>
    <div class="cart_box">
        <div class="prod_qnty">
            <a href="javascript:void(0)" class="prod_img img_contain mb-0">
                <img src="<?php echo base_url('uploads/products/').$value->product_img; ?>">
            </a>
        </div>
        <div class="_allInfo">
            <div class="prod_info border-top-0 text-left pl-lg-2 pl-md-2 pl-0 py-0">
                <p class="prod_name clip_txt_1 pl-0"><small><?php echo $value->order_id; ?></small></p>
                <p class="prod_name clip_txt_2 pl-0"><?php echo $value->product_name; ?></p>
                <p class="prod_price mb-0 pl-0">
                    <?php echo $value->qty; ?> X &#8377;<?php echo $value->sell_price; ?> = &#8377;<?php echo $value->subtotal; ?>
                </p>
            </div>
            <div class="delivery_info py-0">
                <p class="fs_12 mb-1">Delivery Charge: &#8377;<?php echo $value->delivery_charge; ?></span></p>
                <p class="prod_name fs_13">Ordered on <?php echo date('d M, Y', strtotime($value->order_date)); ?></p>
                <p class="_delete mb-0 fs_16">
                <?php if($value->status=='hold' || $value->status=='packaged'){ ?>
                    <small class="text-danger"><b data-seller_id="<?php echo $value->seller_id; ?>" data-product_id="<?php echo $value->product_id; ?>" data-order_id="<?php echo $value->order_id; ?>" data-qty="<?php echo $value->qty; ?>" onclick="calcel_order(this)">Cancel</b></small>
                <?php }elseif($value->status=='picked'){ ?>
                    <small class="text-info"><b>Delivered to nearest hub</b></small>
                <?php }elseif($value->status=='ready_order'){ ?>
                    <small class="text-info"><b>On the way</b></small>
                <?php }elseif($value->status=='out_order'){ ?>
                    <small class="text-info"><b>On the way</b></small>
                <?php }elseif($value->status=='completed'){ ?>
                    <?php 
                    $return_time=date('Y-m-d', strtotime(date('Y-m-d', strtotime($value->edit_date)). ' + '.$value->return_day.' days'));
                    if(date('Y-m-d')<=$return_time){ ?>
                        <small class="text-success" data-seller_id="<?php echo $value->seller_id; ?>" data-product_id="<?php echo $value->product_id; ?>" data-order_id="<?php echo $value->order_id; ?>" data-qty="<?php echo $value->qty; ?>" onclick="return_order(this)"><b>Return</b></small>
                    <?php }else{ ?>
                        <small class="text-success mr-2"><b>Delivered</b></small>
                        <small><a class="fs_14" href="javascript:void(0)" onclick="fetch_order_invoice('<?php echo $value->order_id; ?>')"><b>View Invoice</b></a></small>
                    <?php } ?>

                <?php }elseif ($value->status=='canceled') { ?>
                    <small class="text-muted"><b>Canceled</b></small>
                <?php }elseif ($value->status=='returned') { ?>
                    <small class="text-muted"><b>Returned</b></small>
                <?php }else{ ?>
                    <!-- <small class="w-50"><b><?php //echo $value->status; ?></b></small> -->
                <?php } ?>
                </p>
            </div>
        </div>
    </div>
    <?php }
}else{
    echo "You dont have any order service!";
}?>
<div class="cart_box p-0 m-0"></div>