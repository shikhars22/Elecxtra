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
            <div class="col-lg-12 text-left">
                <h1 class="main_heading">Our Journey</h1>
                <p class="fs_14">Elecxtra is a brand from Convora Technologies Pvt Ltd. focused on solving the demand on electronics supply chain. We having a strong connections and network with many companies and people globally helps us to reach our current and future goals in Ecommerce domain by making a difference the way people purchase electronics for their needs.</p>
                <p class="fs_14 mb-0">WE WILL CONTINUE TO BUILD STONG NETWORK TO MAKE THIS HAPPEN.</p>
                <br>
                
                <h2 class="main_heading">Our Mission</h2>
                <p class="fs_16">Redefining the Way We Move</p>
                <p class="fs_14">Our mission to bring in the new way of purchasing and seller the components or any electronics requirements of companies and people who are into manufacturing or developing products.</p>
                <p class="fs_14 mb-0">Coming future we intend to make things better in ecommerce platform for all the vendors/suppliers with affordable rates with shortest lead time which is the biggest problem in todays market.</p>
            </div>
        </div>
    </div>
</section>

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>
</body>
</html>