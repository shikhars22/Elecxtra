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
                <h2 class="main_heading mb-3">Refund & Cancellation Policy</h1>
                <h6>Refund Policy</h6>
                <p class="fs_14">Thank you for your purchase. We hope you are happy with your purchase. However, if you are not completely satisfied with your purchase for any reason, you may return it to us for a full refund/store credit /an exchange/a full refund or store credit/for a full refund or an exchange/for store credit or an exchange/for a full refund, store credit, or an exchange only. Please see below for more information on our return policy.</p>
                
                <h6>Returns / Cancellation</h6>
                <p class="fs_14">All returns must be postmarked within 10 days of the purchase date with a reason for opting it.</p>
                
                <h6>Refunds</h6>
                <p class="fs_14">After receiving your return request and inspecting the condition of your reason, we will process your refund. Please allow at least 7-10 working days from the receipt of your request to process refund. Refunds may take 1-2 billing cycles to appear on your credit card statement, depending on your credit card company. We will notify you by email when your return has been processed</p>
                
                <h6>Exceptions</h6>
                <p class="fs_14 mb-0">The following items cannot be returned (or exchanged) For defective or damaged products(kits), please contact us at the customer service number below to arrange a refund or exchange.</p>
            </div>
        </div>
    </div>
</section>

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>
</body>
</html>