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
<?php if($found_product){
    $cat_id=$product[0]->cat_id;
    $cat_name=$product[0]->cat_name;
    $sub_cat_id=$product[0]->sub_cat_id;
    $sub_cat_name=$product[0]->sub_cat_name;
    $item_id=$product[0]->item_id;
    $item_name=$product[0]->item_name;
} ?>
<section class="product_sec">
    <div class="_filter_sec _scrollDx" id="allFilterHolder">
        <div class="filter_head"><span>Filter</span> <i class="fas fa-times tooglefilter"></i></div>
        <div class="_allfilter" id="allFilter">
            <?php if($found_product){ ?>
                <div class="_filterBox">
                    <div class="prod_head"><h6 class="mb-0"><?php echo $sub_cat_name; ?></h6></div>
                    <ul class="sub_menu">
                        <?php foreach (get_items($sub_cat_id) as $k => $v) { ?>
                            <li><a href="<?php if($slug_arr[3]==strtolower($v->title)){echo 'javascript:void(0)';}else{echo strtolower(base_url('products/').$slug_arr[2].'/'.$v->title);} ?>" <?php if($slug_arr[3]==strtolower($v->title)){ echo 'class="active"';} ?>><?php echo $v->name; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }else{ ?>
                <div class="_filterBox">
                    <div class="prod_head"><h6 class="mb-0"><?php echo $sub_cat_name; ?></h6></div>
                    <ul class="sub_menu">
                        <?php foreach (get_items($sub_cat_id) as $k => $v) { ?>
                            <li><a href="<?php if($slug_arr[3]==strtolower($v->title)){echo 'javascript:void(0)';}else{echo strtolower(base_url('products/').$slug_arr[2].'/'.$v->title);} ?>" <?php if($slug_arr[3]==strtolower($v->title)){ echo 'class="active"';} ?>><?php echo $v->name; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="_allProd_sec">
        <div class="_prodOpt">
            <ul class="bread_cumbs">
               <li><a href="javascript:void(0)"></a><?php echo $sub_cat_name; ?></li> 
               <li><a href="javascript:void(0)"></a><?php echo $item_name; ?> <small id="totalProCount">(0 products)</small><small id="totalProCount2" style="display:none;">(0 products)</small></small></li>
            </ul>
            <div class="_filter_sort_view">
                <div class="sort_input">
                    <select id="sortOrder">
                        <option value="id_asc">Newest First</option>
                        <option value="id_desc">Oldest First</option>
                    </select>
                </div>
                <div class="_view_as">
                    <i class="fa fa-th-large text-dark"></i>
                    <i class="fa fa-list chng_view"></i>
                </div>
            </div>
        </div>

        <div class="grid_4 _allProdList" id="_allProdList">
            <?php $total_count=0; if($found_product){ ?>
                <?php foreach ($product as $key => $value) { 
                    $total_count++; 
                    $item_id=$value->item_id;
                    ?>
                    <div class="prod_box">
                        <a href="<?php echo base_url('product-details/').$value->title; ?>" class="prod_img img_contain">
                            <?php $other_img=explode("|", trim($value->other_img, "|")); if(!empty($other_img[0]) && count($other_img)>0){ ?>
                                <img src="<?php echo base_url('uploads/products/').$value->main_img; ?>" alt="<?php echo $value->name; ?>">
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
                <?php } ?>
            <?php }else{ ?>
                <h6 class="">Sorry No Products Found!</h6>
            <?php } ?>
        </div>

        <div class="grid_4 _allProdList" id="_allProdList2">
        </div>
    </div>
</section>

<?php echo $footer; ?>

<script type="text/javascript">
var item_id="<?php echo $item_id; ?>";

/*********start filter related function********/
var all_filter={};
$("#totalProCount").html("(<?php echo $total_count; ?> Products)");
$(document).on("change", "#sortOrder", function(){
    filterMyData();
});
function filterMyData(){
    $.ajax({
        url:base_url+"/products/product-with-filter",
        method:'POST',  
        data:{[csrfName]:csrfHash, item_id:item_id, filter:all_filter, sort_order:$("#sortOrder").val()},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
                $("#_allProdList, #totalProCount").hide();
                $("#_allProdList2").show().html(data.data);
                $("#totalProCount2").show().html("("+data.total_count+" products)");
            }
        }
    });
}
/*********end filter related function********/
</script>
</body>
</html>