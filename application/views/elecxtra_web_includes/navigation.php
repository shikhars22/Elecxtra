<div class="menu_bg_layer"></div>
<nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="menu">
                    <li class="onlyMob navTitle">
                        <img src="<?php echo base_url(); ?>viewer_assets/images/logo-white.png" alt="Logo" style="height: 40px;">
                        <i class="fas fa-arrow-left float-right mt-2 pt-1 fs_16 pl-3 text-white toggleNav"></i>
                    </li>
                    <li class="onlyMob"><a href="<?php echo base_url(); ?>"><span>Home</span></a></li>
                    <?php foreach (get_sub_categories() as $key => $value) { ?>
                        <li class="<?php if($key==0){echo 'first_li menu_active';} ?>">
                            <a href="javascript:void(0)"><span><?php echo $value->name; ?> <i class="fas fa-angle-right"></i></span></a>
                            <ul class="sub_menu">
                                <?php foreach (get_items($value->id) as $k => $v) { ?>
                                    <li><a href="<?php echo strtolower(base_url('products/').$value->title.'/'.$v->title); ?>"><?php echo $v->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>                   


                    <!---Dont Loop This Part--->
                    <li class="onlyMob"><a href="<?php echo base_url('seller-register'); ?>"><span>Become a seller</span></a></li>
                    <li class="onlyMob"><a href="<?php echo base_url('login'); ?>"><span>Login / Register</span></a></li>
                    <li class="onlyMob"><a href="<?php echo base_url('cart'); ?>"><span>My Cart</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script type="text/javascript">
$(window).scroll(function(){
    if ($(window).scrollTop() >= $("header").height()+80) {
        $('header').addClass('sticky');
    }
    else {
        $('header').removeClass('sticky');
    }
});
$(document).ready(function(){
    $('.toggleNav, .menu_bg_layer').click(function(){
        $('.menu').toggleClass('menu_open');
        $('.menu_bg_layer').toggleClass('bg_layer_open');
    });
});
if ($(window).width()>767) {
    $(document).on("mouseover", ".menu li", function(){
        $(this).siblings("li").removeClass("menu_active");
        $(this).addClass("menu_active");
    })
    $(document).on("mouseover", ".open_menu, .menu", function(){
        $(".menu").addClass("menu_open");
    })
    $(document).on("mouseleave", ".open_menu, .menu", function(){
        $(".menu").removeClass("menu_open");
        $(".menu").find("li").removeClass("menu_active");
        $(".first_li").addClass("menu_active");
    })
}else{
    $(document).on("click", ".menu li", function(){
        $(this).siblings("li").removeClass("menu_active");
        $(this).siblings("li").find(".sub_menu").slideUp();
        $(this).find(".sub_menu").slideToggle();
    })
}

</script>