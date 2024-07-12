<?php if(empty($order_data)>0){ ?>
<code>sorry no data found!</code>
<?php }else{ ?>
<section id="printId">
    
    
<div class="invoice_gen">
    <div class="p-3"><img src="<?php echo base_url('viewer_assets/images/logo.png'); ?>"></div>
    <div class="p-3 text_right" style="text-align: right;">
        <h5 class="mb-1" style="font-size: 15px;">#<?php echo $order_data->order_id; ?></h5>
        <h6 class="mb-0" style="font-size: 14px;">Delivered on <?php echo date('d M, Y', strtotime($order_data->order_date)); ?></h6>
    </div>
</div>
<div class="invoice_gen">
    <div class="p-3" style="text-align: left; width: 33.33%;">
        <h5 class="mb-1" style="font-size: 15px;">Sold by</h5>
        <h6 class="mb-1" style="font-size: 14px;"><?php echo $order_data->seller_name; ?></h6>
        <h6 class="mb-1" style="font-size: 14px;"><?php echo $order_data->seller_city; ?>-<?php echo $order_data->seller_pin; ?> <?php echo $order_data->seller_state; ?></h6>
        <h6 class="mb-1" style="font-size: 14px;"><?php echo $order_data->seller_address; ?></h6>
        <h6 class="mb-0" style="font-size: 14px;">GST: <?php echo $order_data->seller_gst; ?></h6>
    </div>
    <?php if($this->session->userdata('admin_role')=="superadmin"){ ?>
    <div class="p-3 text_right" style="text-align: left; width: 33.33%">
        <h5 class="mb-1" style="font-size: 15px;">Customer Details</h5>
        <h6 class="mb-1" style="font-size: 14px;"><?php echo $order_data->name; ?></h6>
        <h6 class="mb-1" style="font-size: 14px;"><?php echo $order_data->email; ?></h6>
        <h6 class="mb-1" style="font-size: 14px;"><?php echo $order_data->phone; ?></h6>
    </div>
    <div class="p-3 text_right" style="text-align: left; width: 33.33%">
        <h5 class="mb-1" style="font-size: 15px;">Customer Adddress</h5>
        <h6 class="mb-1" style="font-size: 15px;">Shipping</h6>
        <h6 class="mb-0 spanSpace" style="font-size: 14px;"><?php echo $order_data->shipping_address; ?></h6>
        <br>
        <h6 class="mb-1" style="font-size: 15px;">Billing</h6>
        <h6 class="mb-0 spanSpace" style="font-size: 14px;"><?php echo $order_data->billing_address; ?></h6>
    </div>
    <?php } ?>
</div>
<div class="invoice_table">
    <div class="item_desp">
        <h5 class="mb-2" style="font-size: 15px;">Item Description</h5>
        <h6 class="mb-0" style="font-size: 14px;"><?php echo $order_data->product_name; ?></h6>
    </div>
    <div class="table-responsive">
        <table class="table w-100">
            <tr>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <tr>
                <td>&#8377;<?php echo $order_data->sell_price; ?></td>
                <td><?php echo $order_data->qty; ?></td>
                <td>&#8377;<?php echo $order_data->subtotal; ?></td>
            </tr>
        </table>
    </div>
    <table class="table mb-0">
        <tr>
            <td>Amount in words</td>
            <td style="text-transform:capitalize; text-align:right;"><?php echo number_in_word($order_data->subtotal); ?></td>
        </tr>
    </table>
</div>


</section>
<div class="text-end mt-3">
    <button onclick="PrintMe('printId')" class="btn btn-info btn-sm">Print</button>
</div>
<?php } ?>