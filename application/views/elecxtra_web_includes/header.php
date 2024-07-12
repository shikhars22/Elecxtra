<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 col-3 order-lg-1 order-md-1 order-sm-1 order-1">
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url(); ?>viewer_assets/images/logo.png" alt="Logo">
                    <!--<h3 class="mb-0"><span class="text-white">Elec</span><span class="text-warning">Xtra</span></h3>-->
                </a>
            </div>
            <div class="col-lg-5 col-md-12 order-lg-2 order-md-3 order-sm-3 order-3">
                <div class="searc_bar">
                    <div class="d-flex w-100">
                        <input class="flex-fill searchProduct" type="search" placeholder="Search">
                        <!-- <button type="button" class="button_1">Search</button> -->
                    </div>
                    <ul class="search_list _scrollDx">
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-md-9 col-sm-8 col-9 order-lg-3 order-md-2 order-sm-2 order-2">
                <div class="nav">
                    <ul class="nav_ul">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="open_menu"><a href="javascript:void(0)">Products <i class="fas fa-angle-down"></i></a>
                        </li>
                        <li><a href="<?php echo base_url('seller-register'); ?>">Become a seller</a></li>
                    </ul>

                    <ul class="account_ul">
                        <li><a href="<?php echo base_url('login'); ?>"><img src="<?php echo base_url('viewer_assets/images/user.png'); ?>"></a></li>
                        <li><a href="<?php echo base_url('cart'); ?>"><img src="<?php echo base_url('viewer_assets/images/cart.png'); ?>"><span class="cart_count"></span></a></li>
                        <li class="barResp toggleNav"><a href="javascript:void(0)"><img src="<?php echo base_url('viewer_assets/images/bars.png'); ?>"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
var price_commission=JSON.parse('<?php echo price_commission(); ?>');
$(document).on("blur", ".searchProduct", function(){
    var getThis=$(this);
    getThis.closest(".searc_bar").find(".search_list").slideUp();
});
$(document).on("keyup", ".searchProduct", function(){
    var getThis=$(this);
    $.ajax({  
        url:base_url+"/search-product", 
        method:'POST',
        data:{[csrfName]:csrfHash, keywords: $(this).val()},
        dataType: 'JSON',
        success:function(data){
            if(data.type=="success"){
                var all_prod=data.products;
                // console.log(all_prod);
                var listHtml='';
                $.each(all_prod, function(key, value) {
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
                    listHtml+='<li><a href="'+base_url+'/product-details/'+value.title+'"><div class="img"><img src="'+base_url+'/uploads/products/'+value.main_img+'"></div><span class="span">'+value.sub_cat_name+', '+value.item_name+'<br><small><span>'+value.name+'</span><span>₹'+finalPrice+'</span></small></span></a></li>';
                    console.log(listHtml);
                });
                if(listHtml==""){
                    getThis.closest(".searc_bar").find(".search_list").slideUp();
                }else{
                    getThis.closest(".searc_bar").find(".search_list").slideDown().html(listHtml);
                }
            }
        }
    });
});
</script>