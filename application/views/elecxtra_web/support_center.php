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
                <h1 class="main_heading">Support Center</h1>
                <ul class="address_ul">
                    <li><h5><i class="fas fa-phone-alt"></i> Phone</h5><a href="tel:<?php echo get_phone_list(1); ?>"><?php echo get_phone_list(1); ?></a></li>
                    <li><h5><i class="fas fa-envelope"></i> Email</h5><a href="mailto:<?php echo get_email_name('info'); ?>"><?php echo get_email_name('info'); ?></a></li>
                    <li class="border-bottom-0"><h5><i class="fas fa-map-marker-alt"></i> Address</h5><a href="https://goo.gl/maps/ZmqvYkREh5vcLZAR7">Yelahanka Newtown, Bangalore, 560064</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>
</body>
</html>