<div id="_wtSideNv" class="_wt_ThmNv <?php if($session_data['admin_role']=="superadmin"){ ?>_super_admin_nav <?php } ?>">
    <div class="logo"><img src="<?php echo base_url('admin_assets/images/logo.png'); ?>"> <img class="_bars" src="<?php echo base_url('admin_assets/images/bars.png'); ?>"></div>
    <div class="_wtNvPrnt">
        <ul>
            <li class="_wtLbl"><i class="fas fa-tachometer-alt"></i> MAIN</li>
            <ul class="sub_menu d-block">
                <li><a href="<?php echo base_url(); ?>" target="_blank"><span class="fs_10 pe-2">&#9675;</span> View Website</a></li>
                <li><a href="<?php echo base_url('admin/admin-dashboard'); ?>"><span class="fs_10 pe-2">&#9675;</span> Dashboard</a></li>
            </ul>
        </ul>
        <?php if($session_data['admin_role']=="superadmin"){ ?>
            <ul>
                <li class="_wtLbl"><i class="fas fa-info-circle"></i>Product Family <i class="fas fa-angle-down ms-auto"></i></li>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url('admin/product-family'); ?>"><span class="fs_10 pe-2">&#9675;</span> Product Categories</a></li>
                </ul>
            </ul>
            <ul>
                <li class="_wtLbl"><i class="fas fa-shopping-cart"></i> Product Management <i class="fas fa-angle-down ms-auto"></i></li>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url('admin/approved-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Approved Products</a></li>
                    <li><a href="<?php echo base_url('admin/pending-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Pending Products</a></li>
                    <li><a href="<?php echo base_url('admin/rejected-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Rejected Products</a></li>
                </ul>
            </ul>
            <ul>
                <li class="_wtLbl"><i class="fas fa-user"></i> Seller Management <i class="fas fa-angle-down ms-auto"></i></li>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url('admin/pending-seller'); ?>"><span class="fs_10 pe-2">&#9675;</span> Pending Seller</a></li>
                    <li><a href="<?php echo base_url('admin/approved-seller'); ?>"><span class="fs_10 pe-2">&#9675;</span> Approved Seller</a></li>
                    <li><a href="<?php echo base_url('admin/rejected-seller'); ?>"><span class="fs_10 pe-2">&#9675;</span> Rejected Seller</a></li>
                </ul>
            </ul>
            <ul>
                <li class="_wtLbl"><i class="fas fa-user"></i> Customer Management <i class="fas fa-angle-down ms-auto"></i></li>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url('admin/all-customer'); ?>"><span class="fs_10 pe-2">&#9675;</span> Customer List</a></li>
                </ul>
            </ul>
            <ul>
                <li class="_wtLbl"><i class="fas fa-image"></i> Banner & Advertise <i class="fas fa-angle-down ms-auto"></i></li>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url('admin/banner'); ?>"><span class="fs_10 pe-2">&#9675;</span> Banner</a></li></li>
                </ul>
            </ul>
        <?php } ?>
        <?php if($session_data['admin_role']=="seller"){ ?>
            <ul>
                <li class="_wtLbl"><i class="fas fa-shopping-cart"></i> Product Management <i class="fas fa-angle-down ms-auto"></i></li>
                <ul class="sub_menu">
                    <li><a href="<?php echo base_url('admin/add-product'); ?>"><span class="fs_10 pe-2">&#9675;</span> Add Product</a></li>
                    <li><a href="<?php echo base_url('admin/approved-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Approved Products</a></li>
                    <li><a href="<?php echo base_url('admin/pending-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Pending Products</a></li>
                    <li><a href="<?php echo base_url('admin/rejected-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Rejected Products</a></li>
                    <li><a href="<?php echo base_url('admin/trash-products'); ?>"><span class="fs_10 pe-2">&#9675;</span> Trash Products</a></li>
                </ul>
            </ul>
        <?php } ?>
        <ul>
            <li class="_wtLbl"><i class="fas fa-user"></i> Order Management <i class="fas fa-angle-down ms-auto"></i></li>
            <ul class="sub_menu">
                <li><a href="<?php echo base_url('admin/hold-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> New Orders</a></li>
                <li><a href="<?php echo base_url('admin/packaged-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Confirmed & Packaged</a></li>
                <li><a href="<?php echo base_url('admin/picked-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Picked Orders</a></li>
                <li><a href="<?php echo base_url('admin/ready-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Ready To Deliver</a></li>
                <li><a href="<?php echo base_url('admin/out-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Out For Deliver</a></li>
                <li><a href="<?php echo base_url('admin/completed-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Completed Orders</a></li>
                <li><a href="<?php echo base_url('admin/canceled-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Canceled Orders</a></li>
                <li><a href="<?php echo base_url('admin/returned-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Returned Orders</a></li>
                <li><a href="<?php echo base_url('admin/pending-order'); ?>"><span class="fs_10 pe-2">&#9675;</span> Pending Orders</a></li>
            </ul>
        </ul>
        <?php if($session_data['admin_role']=="superadmin"){ ?>
        <ul>
            <li class="_wtLbl"><i class="fas fa-cogs"></i> Price Setting <i class="fas fa-angle-down ms-auto"></i></li>
            <ul class="sub_menu">
                <li><a href="<?php echo base_url('admin/commission') ?>"><i class="fa fa-percent"></i> Commission</a></li>
                <li><a href="<?php echo base_url('admin/subscription') ?>"><i class="fa fa-cog"></i> Subscription</a></li>
            </ul>
        </ul>
        <?php } ?>
        <ul>
            <li class="_wtLbl"><i class="fas fa-cogs"></i> SETTINGS <i class="fas fa-angle-down ms-auto"></i></li>
            <ul class="sub_menu">
                <li><a href="<?php echo base_url('admin/my-profile') ?>"><i class="fa fa-user"></i> My Profile</a></li>
                <li><a href="<?php echo base_url('admin/change-password') ?>"><i class="fa fa-key"></i> Change Password</a></li>
                <li><a href="<?php echo base_url('admin/admin-logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </ul>
        <div class="_wtH54"></div>
    </div>
</div>
<script type="text/javascript">
function nav_current_tap(){
    var nav_a=$("a[href='"+window.location.href+"']");
    nav_a.addClass("nav_active");
    nav_a.parents('li').find('a').trigger('click');
    $('#_wtSideNv ._wtNvPrnt').scrollTop(nav_a.offset().top-150);
}
nav_current_tap();

$(document).on("click", "._bars", function(){
    $("._wt_ThmNv").toggleClass("_open_ThmNv");
});
$(document).on("click", "._wtLbl", function(){
    $(this).next(".sub_menu").slideToggle();
});

</script>