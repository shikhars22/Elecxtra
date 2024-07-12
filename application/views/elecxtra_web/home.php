<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=""/>
<title>Home | <?php echo site_title(); ?></title>
<link rel="canonical" href="https://www.ecom.webinatech.in/" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<?php echo $link_scripts; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<section class="banner_home">
    <div class="banner">
        <?php $all_banner=get_banner_images('home'); ?>
        <?php foreach($all_banner as $key=>$value){ ?>
            <div class="banner_img">
                <img src="<?php echo base_url('uploads/media/').$value->img; ?>" alt="Banner">
            </div>
        <?php } ?>
    </div>
    <div class="bnnrSlide bnnrLeft"><img src="<?php echo base_url(); ?>/viewer_assets/images/chevron-left.png"></div>
    <div class="bnnrSlide bnnrRight"><img src="<?php echo base_url(); ?>/viewer_assets/images/chevron-right.png"></div>
</section>

<section class="about_sec bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 pr-lg-3 pr-md-3 pr-sm-3 pr-1">
                <div class="service_box">
                    <img src="viewer_assets/images/delivery.png" alt="Delivery">
                    <div>
                        <h5>Fast Delivery</h5>
                        <p>Fast shipping on all order</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 px-lg-3 px-md-3 px-sm-3 px-1">
                <div class="service_box">
                    <img src="viewer_assets/images/discount.png" alt="Delivery">
                    <div>
                        <h5>Member Discount</h5>
                        <p>Onevery order over &#8377;2000</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 pl-lg-3 pl-md-3 pl-sm-3 pl-1">
                <div class="service_box">
                    <img src="viewer_assets/images/support.png" alt="Delivery">
                    <div>
                        <h5>Support 24/7</h5>
                        <p>Support 24 hours a day</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="grid_2">
                    <div class="adv_250h img_cover">
                        <img src="<?php echo base_url(); ?>/uploads/advertise/add1.jpg" alt="Advertise Name">
                    </div>

                    <div class="adv_250h img_cover">
                        <img src="<?php echo base_url(); ?>/uploads/advertise/add1.jpg" alt="Advertise Name">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prod_sec mb-lg-3 mb-md-3 mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="interested_box" id="interestedBox">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prod_sec mb-lg-3 mb-md-3 mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="_heading mt-0">
                    <h4 class="mb-0">Latest Products</h4>
                    <a class="button_2 p-2 fs_10 ml-auto" style="margin-right: 100px; visibility: hidden;" href="<?php echo base_url('view-product/deal'); ?>">View All</a>
                </div>
                <div class="prod_slide_small view_btn_fixed" id="recentProducts">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prod_sec mb-lg-3 mb-md-3 mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-lg-0 mb-md-3 mb-sm-3 mb-0">
                <div class="advertise_img">
                    <img src="<?php echo base_url('uploads/advertise/advertise-4.jpg'); ?>" alt="Advertise Name" style="height: auto; object-fit: inherit; border-radius: 8px;">
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 pl-lg-0">
                <div class="_heading mt-lg-0 mt-md-0 mt-sm-2 mt-2">
                    <h4 class="mb-0">Deals Of The Day</h4>
                    <a class="button_2 p-2 fs_10 ml-auto" href="<?php echo base_url('view-product/deal'); ?>">View All</a>
                </div>
                <div class="prod_slide_small btn_mr0_4" id="deal_products">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prod_sec mb-lg-3 mb-md-3 mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="_heading mt-0">
                    <h4 class="mb-0">Featured Products</h4>
                    <a class="button_2 p-2 fs_10 ml-auto" href="<?php echo base_url('view-product/feature'); ?>">View All</a>
                </div>
                <div class="prod_slide_small btn_mr0_6" id="feature_products">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $footer; ?>
<script type="text/javascript">
function visitor_count(){
    $.ajax({  
        url:"<?php echo base_url('visitor-count'); ?>", 
        method:'POST',
        data:{[csrfName]:csrfHash, ref_id: "<?php echo 'homepage_visitor'; ?>"},
        dataType: 'JSON',
        success:function(data){
            if(data.type=="success"){
                console.log(data.total_visitor);
            }
        }
    });
}
//Banner Slide JS//
document.addEventListener('visibilitychange', function(event){
  if (document.hidden) { clearInterval(tickerID); }else{ ticker() }
});

$(document).on("click", ".banner_home .bnnrLeft", function(){
    $(".banner_home .banner_img").last().remove();
    $(".banner_home .banner_img").eq(0).before($(".banner_home .banner_img").last().prev().clone());
    $(".banner_home .banner_img").eq(0).css({"width" : "0"});
    $(".banner_home .banner_img").eq(0).animate({"width" : "100%"});

});
$(document).on("click", ".banner_home .bnnrRight", function(){
    $(".banner_home .banner_img").eq(0).animate({"width" : "0%"}, function(){
        $(".banner_home .banner_img").first().remove();
        $(".banner_home .banner_img").last().after($(".banner_home .banner_img").first().next().clone());
    });
});

$(document).on("mouseover", ".bnnrLeft, .bnnrRight, .dots li", function(){
    clearInterval(tickerID);
})

$(document).on("mouseleave", ".bnnrLeft, .bnnrRight, .dots li", function(){
    ticker();
})

var tickerID = false; 
function ticker(){ 
    tickerID = setInterval(function(){ 
        $('.bnnrRight').click();
    }, 8000); 
}

if(tickerID != false) {
    clearInterval(tickerID);
    tickerID = false;
} else { ticker(); }
//End Banner Slide JS//

function recentProductsSliderInit(){
    $('#recentProducts').slick({
        dots: false,
        infinite: false,
        autoplay: true,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
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
function dealProductsSliderInit(){
    $('#deal_products').slick({
        dots: false,
        infinite: false,
        autoplay: true,
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
function featureProductsSliderInit(){
    $('#feature_products').slick({
        dots: false,
        infinite: false,
        autoplay: true,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
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
function loadRcentProduct(){
    $.ajax({  
    url:base_url+"/load-recent-products", 
    method:'POST',  
    data:{[csrfName]:csrfHash},
    dataType: 'JSON',  
    success:function(data){
      if(data.type=="success"){
        var allProData=data.data;
        // console.log(allProData);
        $.each(allProData, function(key, value){
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
            
            $("#recentProducts").append('<div class="prod_box">'+
                '<a href="'+base_url+'/product-details/'+value.title+'" class="prod_img img_contain">'+
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
                    '<a href="'+base_url+"/product-details/"+value.title+'" class="button_1 py-2 px-3 fs_10 w-100 mt-1">View Details</a>'+
                '</div>'+
            '</div>');
        });
        recentProductsSliderInit();
        }
    }
    });
}
function load_selected_products(p_type){
    $.ajax({  
        url:"<?php echo base_url('load-selected-products'); ?>", 
        method:'POST',
        data:{[csrfName]:csrfHash, type: p_type},
        dataType: 'JSON',
        success:function(data){
            if(data.type=="success"){
                $("#"+p_type+"_products").html(data.data);
                window[p_type+"ProductsSliderInit"]();
                $(".btn_mr0_4").each(function(){               
                    if ($(this).find(".prod_box").length<4) {
                        $(this).prev("._heading").find("a.button_2").addClass("mr-0");
                    }else{
                        $(this).prev("._heading").find("a.button_2").removeClass("mr-0");
                    }
                });

                $(".btn_mr0_6").each(function(){                
                    if ($(this).find(".prod_box").length<6) {
                        $(this).prev("._heading").find("a.button_2").addClass("mr-0");
                    }else{
                        $(this).prev("._heading").find("a.button_2").removeClass("mr-0");
                    }
                });
            }
        }
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
function load_siblings_subcat(){
    $.ajax({  
    url:base_url+"/load-siblings-subcategory", 
    method:'POST',  
    data:{[csrfName]:csrfHash},
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
                            '<h5>'+value.sub_cat_name+'</h5>'+
                            '<a class="button_2 py-2 px-3 fs_10" href="'+base_url+'/products/'+value.sub_cat_title+'/'+value.item_title+'">Shop Now</a>'+
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
    load_siblings_subcat();
    load_selected_products("deal");
    load_selected_products("feature");

    loadRcentProduct();

    var firstClone=$(".banner_home .banner_img").first().clone();
    var lastClone=$(".banner_home .banner_img").last().clone();
    $(".banner_home .banner_img").first().before(lastClone);
    $(".banner_home .banner_img").last().after(firstClone);
});

</script>
</body>
</html>