<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(empty($cart_data)){
	$cart_data=array();
}else{
	$cart_data=array_column($cart_data, 'product_id');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=""/>
<title>Product Details | <?php echo site_title(); ?></title>
<?php echo $link_scripts; ?>
<style type="text/css">
	@media only screen and (max-width:576px) {
		body {padding-bottom: 45px;}
	}
</style>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>

<section class="prod_sec bg-white mt-2 py-2 mx-lg-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-5 col-md-5 order-lg-1 order-2">
				<div class="_prodImgViewr">
					<div id="_bigImg">
						<div class="prod_det_img img_contain" id="_zoom_img">
							<img id="img_src" src="<?php echo base_url('uploads/products/').$product->main_img; ?>" alt="<?php echo $product->title; ?>">
						</div>
					</div>
					<div class="view_more_img">
						<div class="divImg"><img src="<?php echo base_url('uploads/products/').$product->main_img; ?>" alt="<?php echo $product->title?>"></div>
							<?php if(!empty($product->other_img)){ $other_img=explode("|", trim($product->other_img, "|")); ?>
									<?php foreach ($other_img as $key => $value){ ?>
										<div class="divImg"><img src="<?php echo base_url('uploads/products/').$value; ?>" alt="<?php  echo $product->title; ?>"></div>
									<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>

			<div class="col-lg-5 col-md-7 order-lg-2 order-3">
				<div id="_zoomed"></div>
				<canvas id="canvas" style="display: none"></canvas>
				<div class="prod_full_details">
					<ul class="bread_cumbs mb-1">
	               <li><a href="javascript:void(0)"></a><?php echo $product->cat_name; ?></li>
	               <li><a href="javascript:void(0)"></a><?php echo $product->sub_cat_name; ?></li>
	               <li><a href="javascript:void(0)"></a><?php echo $product->item_name; ?></li>
	            </ul>
					<h1 class="prod_name_big mb-1"><?php echo $product->name; ?></h1>

					<ul class="_highLights mb-2" id="heighLight">
						
					</ul>
					<div class="prod_price mb-3">
						<h4 class="mb-0">
							<?php $price_commission=json_decode(price_commission());
								$finalPrice=0;
  		            foreach ($price_commission as $k => $v){
  	                if($product->price<=$v->max_price){
                        $other_charge=2;
                        $comms=$v->commission;
                        $webViewPrice=$product->price+($product->price*$v->commission/100);
                        $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                        break;
    	                }
                    }
      		      echo "&#8377;".$finalPrice;
      	       ?>
						</h4>
						<p class="mb-0" style="color: #999; font-weight: 400;"></p>
					</div>
					<h6 class="mb-2 text-success fs_14"><?php echo $product->stock; ?> In Stock</h6>

					<ul class="mb-2 _manufacture">
						<?php if(!empty($product->manufacturer)){ ?>
							<li><small><span>Manufacturer :</span> <?php echo $product->manufacturer; ?></small></li>
						<?php } ?>
						<?php if(!empty($product->manufacturer_pro_num)){ ?>
							<li><small><span>Manufacturer Part Number :</span> <?php echo $product->manufacturer_pro_num; ?></small></li>
						<?php } ?>
						<?php if(!empty($product->manufacturer_lead_time)){ ?>
							<li><small><span>Manufacturer Standard Lead Time :</span> <?php echo $product->manufacturer_lead_time; ?></small></li>
						<?php } ?>
						<?php 
							$all_attachment=explode("|", $product->attachment);
							for ($i=0; $i < count($all_attachment); $i++) { 
								if(!empty($all_attachment[$i])){ ?>
									<li><small><span>Datasheet : &nbsp;</span> <a target="_blank" href="<?php echo base_url('uploads/products/attachments/').$all_attachment[$i]; ?>"><i class="fa fa-file pr-2"></i>Datasheet</a></small></li>
								<?php }
							}
						?>
					</ul>

					<p class="fs_14 clip_txt_8 read_toggle mb-1"><?php echo $product->description; ?></p>
					<a class="fs_14 mb-2 d-inline-block" href="javascript:void(0)" onclick="read_toggle(this)">Read More</a>
					

					<!-- <div class="_deliverTo mb-3">
						<h6 class="mb-1 text-success fs_13">Deliver to :</h6>
						<input type="text" name="" placeholder="">
						<button type="button">Check</button>
					</div> -->

					<?php if($product->stock>0){ ?>
						<div class="mainQtyHolder add_cart_qty _wht_to_do mb-lg-3 mb-md-3 mb-sm-3 mb-0">
							<?php if(in_array($product->id, $cart_data)){ ?>
	              <a href="<?php echo base_url('cart'); ?>" class="button_2 bg-success btn_100">VIEW CART</a>
	            <?php }else{ ?>
	            	<div class="_qnty qty_holder" data-cartdata="<?php echo base64_encode(convert_uuencode($product->id)); ?>" data-maxstock="<?php echo $product->stock; ?>">
									<span class="qty_down">-</span>
									<input type="text" class="qnty_input" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
									<span class="qty_up">+</span>
								</div>
								<button class="button_2" type="button" onclick="add_to_cart(this)" data-cartdata="<?php echo base64_encode(convert_uuencode($product->id)); ?>" data-cartalert="no">ADD TO CART</button>
								<button class="button_1" type="button" onclick="add_to_cart(this)" data-cartdata="<?php echo base64_encode(convert_uuencode($product->id)); ?>" data-buynow="yes">BUY NOW</button>
						<?php } ?>
							</div>	
					<?php } ?>	
                    
     		 <?php $all_attr_name=explode("|", $product->attr_names); if($all_attr_name[0]!=""){ ?>
					<div class="_features_tab">
						<table class="table table-sm table-hover">
							<thead>
								<tr><th>Type</th><th>DESCRIPTION</th></tr>
							</thead>
							<?php 
								$all_attr_value=explode("|", $product->attr_values);
								for ($i=0; $i < count($all_attr_name); $i++) { 
									if(!empty($all_attr_name[$i])){
										echo "<tr><td>".$all_attr_name[$i]."</td><td>".$all_attr_value[$i]."</td></tr>";
									}
								}
							?>
						</table>
						<div class="_tab_box _features" id="productFeatures" style="display: block;">

						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-2 order-lg-3 order-1">
				<div class="share_icons">
					<h6 class="text-success fs_13">Share On</h6>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url('product-details/').$product->title; ?>"><i class="fab fa-facebook" style="color: #3B5999"></i></a>
					<a href="whatsapp://send?text=<?php echo base_url('product-details/').$product->title; ?>"><i class="fab fa-whatsapp" style="color: #38d656"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="prod_sec mx-lg-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 bg-white my-1">
				<div class="_heading mb-0 px-lg-3 px-md-3 px-0">
					<h4 class="mb-0">Similar Products</h4>
				</div>
			</div>
			<div class="col-12 bg-white">
				<div class="view_silde" id="relatedProduct">

				</div>
			</div>
		</div>
	</div>
</section>

<section class="prod_sec mb-1 mx-lg-2 mb-lg-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 bg-white my-1">
				<div class="_heading mb-0 px-lg-3 px-md-3 px-0">
                    <h4 class="mb-0">You May Also Like</h4>
                </div>
            </div>
            <div class="col-12">
				<div class="interested_box" id="interestedBox">
					
				</div>
			</div>
		</div>
	</div>
</section>

<?php echo $footer; ?>

<script id="add_to_cart_script" data-csrfname="<?php echo $csrfName; ?>" data-csrfhash="<?php echo $csrfHash; ?>" data-base_url="<?php echo base_url(); ?>" src="<?php echo base_url("viewer_assets/jquery/add_to_cart.js"); ?>"></script>

<script type="text/javascript">
var product_id="<?php echo $product->id; ?>";							
var item_id="<?php echo $product->item_id; ?>";
var sub_cat_id="<?php echo $product->sub_cat_id; ?>";
var cat_id="<?php echo $product->cat_id; ?>";

$('.view_more_img').slick({ dots: false, infinite: false, speed: 300, slidesToShow: 5, slidesToScroll: 1, });
function relatedProductSlideInit(){
	$('#relatedProduct').slick({
		dots: false,
		infinite: false,
		speed: 300,
		slidesToShow: 6,
		slidesToScroll: 2,
		responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 6,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 2,
        }
      }
    ]
	});
}
function interestedBoxSliderInit(){
	$('#interestedBox').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 4,
	      }
	    },
	    {
	      breakpoint: 991,
	      settings: {
	        slidesToShow: 3,
	      }
	    },
	    {
	      breakpoint: 767,
	      settings: {
	        slidesToShow: 1,
	      }
	    }
	  ]
	});
}
function loadRelatedProduct(){
	$.ajax({  
    url:base_url+"/load-related-products", 
    method:'POST',  
    data:{[csrfName]:csrfHash, product_id:product_id, cat_id:cat_id, sub_cat_id:sub_cat_id, item_id:item_id},
    dataType: 'JSON',  
    success:function(data){
      if(data.type=="success"){
      	var allRelPro=data.data;
        $.each(allRelPro, function(key, value){
	        var other_img=value.other_img.split("|");
          var finalPrice=0;
          for (var i = 0; i < price_commission.length; i++){
            if(value.price <= parseFloat(price_commission[i].max_price)){
              var other_charge=2;
              var comms=parseFloat(price_commission[i].commission);
              var webViewPrice=(parseFloat(value.price)+parseFloat(value.price*comms/100)).toFixed(2);
              finalPrice=(parseFloat(webViewPrice)+parseFloat(webViewPrice*other_charge/100)).toFixed(2);
              break;
            }
          }
	        $("#relatedProduct").append('<div class="prod_box">'+
						'<a href="'+base_url+"/product-details/"+value.title+'" class="prod_img img_contain">'+
						  '<img src="'+base_url+"/uploads/products/"+value.main_img+'" alt="'+value.title+'">'+
						  ((other_img[0]!="" && other_img.length>0)?
              	'<img class="imgHvr" src="'+base_url+'/uploads/products/'+value.main_img+'" alt="'+value.name+'"><img class="imgHvr" src="'+base_url+'/uploads/products/'+other_img[0]+'" alt="'+value.name+'">':
              	'<img src="'+base_url+'/uploads/products/'+value.main_img+'" alt="'+value.name+'">'
              )+
						  '<div class="top_info">'+
						  '</div>'+
						'</a>'+
						'<div class="prod_info">'+
							'<p class="prod_name clip_txt_1"><small>'+value.sub_cat_name+', '+value.item_name+'</small></p>'+
						  	'<p class="prod_name clip_txt_1 mb-1">'+value.name+'</p>'+
						  	'<h6>&#8377;'+finalPrice+'</h6>'+
						  	'<a href="'+base_url+"/product-details/"+value.title+'" class="button_2 py-2 px-3 fs_10 w-100 mt-1">View Details</a>'+
						'</div>'+
					'</div>');
        });
        relatedProductSlideInit();
    	}
    }
	});
}
$(document).on("click", ".view_more_img .divImg", function(){
	$("#_bigImg").find("img").attr("src", $(this).find("img").attr("src"));
	$(this).siblings().removeClass("activeImg");
	$(this).addClass("activeImg");
});
$(document).on("click", ".view_more_img .slick-next", function(){
	$(this).closest(".view_more_img").find(".activeImg").next(".divImg").addClass("activeImg");
	$(this).closest(".view_more_img").find(".activeImg").prev(".activeImg").removeClass("activeImg")
	$("#_bigImg").find("img").attr("src", $(this).closest(".view_more_img").find(".activeImg").find("img").attr("src"));
});
$(document).on("click", ".view_more_img .slick-prev", function(){
	$(this).closest(".view_more_img").find(".activeImg").prev(".divImg").addClass("activeImg");
	$(this).closest(".view_more_img").find(".activeImg").next(".activeImg").removeClass("activeImg")
	$("#_bigImg").find("img").attr("src", $(this).closest(".view_more_img").find(".activeImg").find("img").attr("src"));
});
$(document).on("click", "._features_tab li", function(){
	$("._features_tab ul li").css({"border" : "none"});
	$(this).css({"border-bottom" : "2px solid #f0a80e"});
	$("._tab_box").css({"display" : "none"});
	$("."+$(this).data("li")).css({"display" : "block"});
});
function visitor_count(){
	$.ajax({  
  	url:"<?php echo base_url('visitor-count'); ?>", 
  	method:'POST',
  	data:{[csrfName]:csrfHash, ref_id:product_id},
  	dataType: 'JSON',
  	success:function(data){
      if(data.type=="success"){
       	console.log(data.total_visitor);
       	$(".visitor_count").html(data.total_visitor);
      }
  	}
   });
}

function load_siblings_item(){
	$.ajax({  
    url:base_url+"/load-siblings-item", 
    method:'POST',  
    data:{[csrfName]:csrfHash, product_id:product_id, cat_id:cat_id, sub_cat_id:sub_cat_id, item_id:item_id},
    dataType: 'JSON',  
    success:function(data){
      if(data.type=="success"){
      	var allSiblingsCat=data.data;
      	if(allSiblingsCat==""){
      		$("#interestedBox").closest(".prod_sec").html("");
      	}else{
	        $.each(allSiblingsCat, function(key, value){
	        	$("#interestedBox").append('<div class="interested_prod">'+
							'<div class="interested_div my-0">'+
								'<div class="interested_img">'+
									'<img src="'+base_url+'/uploads/products/'+value.main_img+'">'+
								'</div>'+
								'<div class="interested_info">'+
									'<h5>'+value.item_name+'</h5>'+
									'<a class="button_2 py-2 px-3 fs_10" href="'+base_url+'/products/'+value.cat_title+'/'+value.sub_cat_title+'">Shop Now</a>'+
								'</div>'+
							'</div>'+
						'</div>');
	        });
	        interestedBoxSliderInit();
	      }
    	}
    }
	});
}

$(document).ready(function(){
	visitor_count();
	loadRelatedProduct();
	load_siblings_item();
	$(".view_more_img").find(".divImg:first").addClass("activeImg")
});
</script>
</body>
</html>