<header id="_wtHeader" class="_wt_ThmHdr d_flex_evr <?php if($session_data['admin_role']=="superadmin"){ ?>_super_admin_nav <?php } ?>">
    <div class="_search_admin d_flex_evr">
        <img src="<?php echo base_url(); ?>admin_assets/images/search.png">
        <input type="text" placeholder="Search here...">
    </div>
    <div class="_admin_assets d_flex_evr ms-auto">
        <li class="p-1 onlyMob _bars"><img src="<?php echo base_url(); ?>admin_assets/images/bars.png"></li>
        <li class="p-1"><img style="height:17px" src="<?php echo base_url(); ?>admin_assets/images/app.png">
            <div class="other_apps">
                <p class="mb-0 fs_14 d-flex">Web Apps <a href="" class="ms-auto fs_12">View All</a></p>
                <ul class="only_icon_ul">
                    <li><a href="<?php echo base_url('admin/calender'); ?>"><img src="<?php echo base_url('admin_assets/images/calendar.png'); ?>">Calendar</a></li>
                    <li><a href="<?php echo base_url('admin/google-map'); ?>"><img src="<?php echo base_url('admin_assets/images/google-map.png'); ?>">Map</a></li>
                    <li><a href="<?php echo base_url('admin/weather'); ?>"><img src="<?php echo base_url('admin_assets/images/weather.png'); ?>">Weather</a></li>
                    <li><a href="<?php echo base_url('admin/converter') ?>"><img src="<?php echo base_url('admin_assets/images/converter.png'); ?>">Converter</a></li>
                </ul>
            </div>
        </li>
        <li class="p-1"><img src="<?php echo base_url(); ?>admin_assets/images/email.png">
            <div class="other_apps">
                <!-- <p class="mb-0 fs_14 d-flex">4 New Messages <a href="" class="ms-auto fs_12">View All</a></p>
                <ul class="notice_ul message_icon">
                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/faceIcon.png'); ?>">
                    <span class="clip_txt_2">Leonardo De Caprio<br><small style="color: #888; position: relative; top: -3px;">Project Submitted</small></span>
                    <small class="ms-auto" style="position:relative; top:-11px; color:#888">1 min</small></a></li>

                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/faceIcon.png'); ?>">
                    <span class="clip_txt_2">Asif Ali<br><small style="color: #888; position: relative; top: -3px;">Project Updated</small></span>
                    <small class="ms-auto" style="position:relative; top:-11px; color:#888">1 hrs</small></a></li>

                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/faceIcon.png'); ?>">
                    <span class="clip_txt_2">Mofijul Hasan Ali<br><small style="color: #888; position: relative; top: -3px;">Meeting Fixed</small></span>
                    <small class="ms-auto" style="position:relative; top:-11px; color:#888">2 hrs</small></a></li>

                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/faceIcon.png'); ?>">
                    <span class="clip_txt_2">Leonardo De Caprio<br><small style="color: #888; position: relative; top: -3px;">Project Submitted</small></span>
                    <small class="ms-auto" style="position:relative; top:-11px; color:#888">1 min</small></a></li>
                    
                </ul> -->
            </div>
        </li>
        <li class="p-1"><img src="<?php echo base_url(); ?>admin_assets/images/bell.png">
            <div class="other_apps">
                <!-- <p class="mb-0 fs_14 d-flex">4 New Notification <a href="" class="ms-auto fs_12">View All</a></p>
                <ul class="notice_ul notice_icon">
                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/order.svg'); ?>">
                    <span class="clip_txt_2">New Order Recieved<br><small style="color: #888; position: relative; top: -3px;">30 min ago</small></span></a></li>

                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/user.svg'); ?>">
                    <span class="clip_txt_2">New Customer Registered<br><small style="color: #888; position: relative; top: -3px;">30 min ago</small></span></a></li>


                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/download.svg'); ?>">
                    <span class="clip_txt_2">Download Completed<br><small style="color: #888; position: relative; top: -3px;">30 min ago</small></span></a></li>

                    <li><a href="#"><img src="<?php //echo base_url('admin_assets/images/order.svg'); ?>">
                    <span class="clip_txt_2">New Order Recieved<br><small style="color: #888; position: relative; top: -3px;">30 min ago</small></span></a></li>
                    
                </ul> -->
            </div>
        </li>
        <li class="admin_user"><img src="<?php echo (empty($session_data['admin_img'])?base_url('admin_assets/images/faceIcon.png'):$session_data['admin_img']); ?>">
            <div class="other_apps">
                <div class="user_info">
                    <div><img src="<?php echo (empty($session_data['admin_img'])?base_url('admin_assets/images/faceIcon.png'):$session_data['admin_img']); ?>"></div>
                    <h6><?php echo $session_data['admin_name']; ?><br><small><?php echo $session_data['admin_email']; ?></small></h6>
                </div>
                <ul class="notice_ul notice_icon">
                    <li><a href="<?php echo base_url('admin/my-profile'); ?>"><img src="<?php echo base_url('admin_assets/images/user.svg'); ?>"><span class="clip_txt_2"> Profil</span></a></li>
                    <li><a href="<?php echo base_url('admin/change-password'); ?>"><img src="<?php echo base_url('admin_assets/images/key.png'); ?>"><span class="clip_txt_2"> Change Password</span></a></li>
                    <li><a href="<?php echo base_url('admin/admin-logout'); ?>"><img src="<?php echo base_url('admin_assets/images/switch-user.svg'); ?>"><span class="clip_txt_2"> Switch user</span></a></li>
                    <li><a href="<?php echo base_url('admin/admin-logout'); ?>"><img src="<?php echo base_url('admin_assets/images/logout.svg'); ?>"><span class="clip_txt_2"> Logout</span></a></li>
                </ul>
            </div>
        </li>

    </div>
</header>

<script type="text/javascript">
$(document).on("click", "._admin_assets li", function(){
    $(this).siblings("li").find(".other_apps").removeClass("other_apps_open");
    $(this).find(".other_apps").toggleClass("other_apps_open");
})
</script>