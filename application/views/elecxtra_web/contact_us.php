<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
    <div class="w-100">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15543.91373112226!2d77.56806067499825!3d13.100552802340678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae18605dd9cf5d%3A0x1b1ce96486083bbb!2sYelahanka%20New%20Town%2C%20Bengaluru%2C%20Karnataka!5e0!3m2!1sen!2sin!4v1657533696007!5m2!1sen!2sin" width="100%" height="250px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<section class="about_sec">
	<div class="container">
		<div class="row py-3">
			<div class="col-lg-5 col-md-6 mb-lg-0 mb-md-0 mb-4">
                <ul class="address_ul">
                	<h2 class="main_heading">How to reach us?</h2>
                    <li><h5><i class="fas fa-briefcase"></i> Company name</h5><a href="javascript:void(0)"><?php echo site_title(); ?></a></li>
                    <li><h5><i class="fas fa-phone-alt"></i> Phone</h5><a href="tel:<?php echo get_phone_list(1); ?>"><?php echo get_phone_list(1); ?></a></li>
                    <li><h5><i class="fas fa-envelope"></i> Email</h5><a href="mailto:<?php echo get_email_name('info'); ?>"><?php echo get_email_name('info'); ?></a></li>
                    <li class="border-bottom-0"><h5><i class="fas fa-map-marker-alt"></i> Address</h5><a href="https://goo.gl/maps/ZmqvYkREh5vcLZAR7">Yelahanka Newtown, Bangalore, 560064</a></li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-6">
                <form class="row contact_form contact_bg" id="contact_form">
                    <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
                    <div class="col-12">
                        <h1 class="main_heading">Send us your Message</h1>
                    </div>
                    <div class="col-12 mb-3">
                        <label>Your Name <small>(required)</small></label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label>Your Mobile <small>(required)</small></label>
                        <input type="number" name="phone" required>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label>Your Email</label>
                        <input type="email" name="email">
                    </div>
                    <div class="col-12 mb-3">
                        <label>Your Message</label>
                        <textarea rows="4" name="message"></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <div id="loadCaptcha" class="d-flex"><?php echo $captchaImg; ?></div>
                            <input type="text" name="captcha" required placeholder="Enter Capthca">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="button_1">Send Message</button>
                    </div>
                </form>
            </div>
		</div>
	</div>
</section>

<?php echo $footer; ?>
<?php echo $footer_bottom; ?>

<script type="text/javascript">
function reload_captcha(){
    $.ajax({  
    	data:{[csrfName]:csrfHash},
        url:"<?php echo base_url('contact-reload-captcha'); ?>", 
        method:'POST',  
        success:function(data){
            $("#loadCaptcha").html(data);
        }
    });
}
$(document).on("submit", "#contact_form", function(e){
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url('contact-us-data'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaFire({
                icon: data.type,
                title: "Thank you for getting in touch!",
                cancelButton: "Ok",
                message: data.text
            });
            if(data.type="success"){
                $("#contact_form").find("input,select,textarea").val("");
            }
        }
    });
});
</script>
</body>
</html>