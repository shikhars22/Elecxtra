<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo site_title(); ?></title>
    <?php echo $link_scripts; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $navigation; ?>
<section class="banner_other">
    <div class="banner">
        <div class="banner_img">
            <img src="<?php echo base_url(); ?>/uploads/media/banner/banner2.jpg" alt="<?php echo site_title(); ?>">
            <div class="banner_info text-center">
                <!-- <h2>About Us</h2> -->
            </div>
        </div>
    </div>
</section>

<section class="about_sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-justify">
                <h2 class="main_heading">Shipping and Delivery</h1>
                <p class="fs_14 mb-0">The following items will be delivered in 3-10days based on your desired location and service of shipping partners
                </p>
            </div>
        </div>
    </div>
</section>

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>
</body>
</html>