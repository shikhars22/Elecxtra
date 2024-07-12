<footer>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-5 mb-lg-0 mb-md-4 mb-sm-4 mb-4">
    			<ul>
    				<li><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('viewer_assets/images/logo.png') ?>" width="150px"; style="filter: brightness(10) invert(0) grayscale(18);"></a></li>
    				<li>
    				    <h6><a href="javascript:void(0)">Discover the new ecommerce experience with Elecxtra.</a></h6>
    				    <a href="javascript:void(0)" class="clip_txt_2">We are trying to reduce the electronics shortage by increasing the flow of electronics materials among the sellers/consumers. Circulating the deadstock electronics items within the market to fill the gap or overcome the shortage of components.</a>
    				    <a href="<?php echo base_url('about-us'); ?>">Read More</a>
    				</li>
    			</ul>
    		</div>
    		<div class="col-lg-3 col-md-4 col-sm-12 col-12 mb-lg-0 mb-md-0 mb-sm-4 mb-4">
    			<ul>
    				<li><h5>Contact Us</h5></li>
    				<li><a href="javascript:void(0)"><i class="fas fa-map-marker-alt"></i> Yelahanka Newtown, Bangalore, 560064</a></li>
    				<li><a href="tel:<?php echo get_phone_list(1); ?>"><i class="fas fa-phone"></i> <?php echo get_phone_list(1); ?></a></li>
    				<li><a href="mailto:<?php echo get_email_name('info'); ?>"><i class="fas fa-envelope"></i> <?php echo get_email_name('info'); ?></a></li>
    			</ul>
    		</div>
    		<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-lg-0 mb-md-0 mb-sm-4 mb-4">
    			<ul>
    				<li><h5>Information</h5></li>
    				<li><a href="<?php echo base_url('about-us'); ?>">About us</a></li>
					<li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
					<li><a href="<?php echo base_url('seller-register'); ?>">Become A Seller</a></li>
    			</ul>
    		</div>
    		<div class="col-lg-2 col-md-4 col-sm-6 col-12">
    			<ul>
    				<li><h5>Help</h5></li>
					<li><a href="<?php echo base_url('terms-condition'); ?>">Terms & Conditions</a></li>
					<li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
					<li><a href="<?php echo base_url('refund-cancellation'); ?>">Refund & Cancellation</a></li>
					<li><a href="<?php echo base_url('shipping-delivery-policy'); ?>">Shipping & Delivery Policy</a></li>
					<li><a href="<?php echo base_url('support-center'); ?>">Support Center</a></li>
    			</ul>
    		</div>
    	</div>
    </div>
    <div class="footer_bottom">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<p class="text-center fs_12">&copy; <?php echo date('Y'); ?> <?php echo site_title(); ?>. All Rights Reserved | Designed & Developed by <a href="https://www.webinatech.in/">Webina Tech</a></p>
				</div>
			</div>
		</div>
	</div>
</footer>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('viewer_assets/jquery/common_js.js?v=1.0.0.6'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url("wt_assets/wt_alert.css"); ?>">
<script type="text/javascript" src="<?php echo base_url("wt_assets/wt_alert.js"); ?>"></script>

<script type="text/javascript">
var base_url="<?php echo base_url(); ?>";
var csrfName="<?php echo $csrfName; ?>";
var csrfHash="<?php echo $csrfHash; ?>";
var price_commission=JSON.parse('<?php echo price_commission(); ?>');

function load_cart_count(){
    $.ajax({  
        url:base_url+"/load-cart-price", 
        method:'POST',  
        data:{[csrfName]:csrfHash},
        dataType: 'JSON',  
        success:function(data){
            if(data.type=="success"){
                $(".cart_count").html(data.cart_count);
                $(".cart_total").html(data.cart_total);
            }
        }
    });
}
$(document).ready(function(){
    load_cart_count();
});
</script>
