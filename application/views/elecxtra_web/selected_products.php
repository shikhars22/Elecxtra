<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=""/>
<title>Products | <?php echo site_title(); ?></title>
<?php echo $link_scripts; ?>

</head>
<body>   
<?php echo $header; ?>
<?php echo $navigation; ?>
<section class="py-lg-2 py-md-2">
    <div class="px-lg-5 px-0">
        <div class="grid_5 _allProdList">
            <?php if($found_product){ 
            $price_commission=json_decode(price_commission());
            foreach ($product as $key => $value) { ?>
            <div class="prod_box m-lg-2 m-md-2">
                <a href="<?php echo base_url('product-details/').$value->title; ?>" class="prod_img img_contain">
                    <?php $other_img=explode("|", trim($value->other_img, "|")); if(!empty($other_img[0]) && count($other_img)>0){ ?>
                        <img class="imgHvr" src="<?php echo base_url('uploads/products/').$value->main_img; ?>" alt="<?php echo $value->name; ?>">
                        <img class="imgHvr" src="<?php echo base_url('uploads/products/').$other_img[0]; ?>" alt="<?php echo $value->name; ?>">
                    <?php }else{ ?>
                        <img src="<?php echo base_url('uploads/products/').$value->main_img; ?>" alt="<?php echo $value->name; ?>">
                    <?php } ?>
                    <div class="top_info">
                    </div>
                </a>
                <div class="prod_info">
                    <p class="prod_name clip_txt_1"><small><?php echo $value->cat_name.', '.$value->item_name; ?></small></p>
                    <p class="prod_name clip_txt_1"><?php echo $value->name; ?></p>
                    <h6>
                    <?php $price_commission=json_decode(price_commission());
                        $finalPrice=0;
                        foreach ($price_commission as $k => $v){
                            if($value->price<=$v->max_price){
                                $other_charge=2;
                                $comms=$v->commission;
                                $webViewPrice=$value->price+($value->price*$v->commission/100);
                                $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                                 break;
                            }
                        }
                        echo "&#8377;".$finalPrice;
                    ?></h6>
                    
                    <a href="<?php echo base_url('product-details/').$value->title; ?>" class="button_1 py-2 px-3 fs_10 w-100 mt-1">View Details</a>
                </div>
            </div>
            <?php } }else{ ?>
                <h6 class="">Sorry No Products Found!</h6>
            <?php } ?>
        </div>
    </div>
</section>

<?php echo $footer; ?>

<script id="add_to_cart_script" data-csrfname="<?php echo $csrfName; ?>" data-csrfhash="<?php echo $csrfHash; ?>" data-base_url="<?php echo base_url(); ?>" src="<?php echo base_url("viewer_assets/jquery/add_to_cart.js"); ?>"></script>


</body>
</html>