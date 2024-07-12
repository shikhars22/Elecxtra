<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=""/>
<title>Cart | <?php echo site_title(); ?></title>
<link rel="canonical" href="https://www.ecom.webinatech.in/" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

<?php echo $link_scripts; ?>

</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<!-- <section class="banner_other no_resp">
    <div class="banner">
        <div class="banner_img">
            <img src="<?php //echo base_url(); ?>/uploads/banner/banner2.jpg" alt="Banner">
        </div>
    </div>
</section> -->

<section class="cart_page">
	<div class="container-fluid">
		<div class="row" id="load_cart">
			
		</div>
	</div>
</section>
<?php echo $footer; ?>
<script id="add_to_cart_script" data-csrfname="<?php echo $csrfName; ?>" data-csrfhash="<?php echo $csrfHash; ?>" data-base_url="<?php echo base_url(); ?>" src="<?php echo base_url("viewer_assets/jquery/add_to_cart.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
	load_cart();
});
</script>
</body>
</html>