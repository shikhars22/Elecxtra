<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Subscription</title>
<?php echo $link_script; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section  id="_wtBdySec" class="_wtThmSec">
    <div class="fixed_box display_none open_subscription_form">
        <form id="add_subscription_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="bg-white p-3">
                    <h5 class="heading">Add Subscription <span style="float:right; padding: 5px; cursor: pointer; font-size:35px; color:red;" onclick="close_subscription_form()">&times;</span></h5>
                    <small>Dashboard > Add Subscription</small>
                </div>

                <div class="bg-white p-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Plan Name</label><br>
                                <input type="text" name="plan_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Plan Price</label><br>
                                <input type="number" name="plan_price" step="any" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="w-100 mb-3">
                                <label>Description</label><br>
                                <textarea name="plan_description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button type="button" onclick="close_subscription_form()" class="_wtBtnMd bg_gray">Cancel</button>
                            <button type="submit" class="_wtBtnMd bg_theme_2">Add Subscription</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="fixed_box display_none open_up_subscription_form">
        <form id="up_subscription_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <input type="hidden" name="id">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="bg-white p-3">
                    <h5 class="heading">Edit & Update subscription <span style="float:right; padding: 5px; cursor: pointer; font-size:35px; color:red;" onclick="close_up_subscription_form()">&times;</span></h5>
                    <small>Dashboard > Edit & Update subscription</small>
                </div>

                <div class="bg-white p-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Plan Name</label><br>
                                <input type="text" name="plan_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Plan Price</label><br>
                                <input type="number" name="plan_price" step="any" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="w-100 mb-3">
                                <label>Description</label><br>
                                <textarea name="plan_description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 text-end">
                            <button type="button" onclick="close_up_subscription_form()" class="_wtBtnMd bg_gray">Cancel</button>
                            <button type="submit" class="_wtBtnMd bg_theme_2">Update Subscription</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h6 class="adminHead d_flex_evr py-3 m-0"><a href="javascript:void(0)" onclick="open_subscription_form()" class="_wtBtnMd bg_theme_2">+&nbsp; Add subscription</a><small class="fs_13 ms-auto">Admin / subscriptions</small></h6>
            </div>
            
            <div class="col-12">
                <div class="table-responsive _allProdTable _scrollDx">
                    <table class="table table-sm history-wrapper w-100" id="subscription_datatable">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Plan Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Plan Name</th>
                                <th>Plan Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- start alert modal -->
<div class="alert_bg img_prev_modal">
    <!-- next alert modal -->
    <div class="alert_box alert_auto">
        <div class="alert_body height_calc">
            <div class="img_contain" style="height: calc(100% - 30px);">
                <img id="img_view">
                <div id="caption"></div>
            </div>
            <input type="text" id="img_link" readonly class="fs_12 w-100">
        </div>
        <div class="alert_footer text-end">
            <button type="button" class="_wtBtnMd bg_cyan" onclick="copyTextData('img_link')">Copy Link</button>
            <button type="button" class="_wtBtnMd bg_theme_1 alert_cancel">&nbsp; OK &nbsp;</button>
        </div>
    </div>  
</div>
<!-- end alert modal -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
var base_url="<?php echo base_url(); ?>";
var csrfName="<?php echo $csrfName; ?>";
var csrfHash="<?php echo $csrfHash; ?>";

$(document).ready(function(e) {
    //datatable loading
    $('#subscription_datatable').DataTable({
        "processing" : true,
        "serverSide" : true,
        "language": {
            "lengthMenu": '_MENU_',
            "sSearch": "",
            "searchPlaceholder": "Search records"
        },
        "ajax":{
            data:{[csrfName]:csrfHash},
            url:"<?php echo base_url('elecxtra_admin/admin_price_setting/fetch_all_subscription'); ?>",  
            type:"POST"
        },  
        "columnDefs":[
            {  
                "orderable":false, "targets":[0,1,2,3],  
            },  
        ],  
    });
});
function reload_data_table(element){
    $(element).DataTable().ajax.reload();
}
function open_subscription_form(){
    $(".open_subscription_form").fadeIn();
}
function close_subscription_form(){
    $('.fixed_box').animate({scrollTop:0},300);
    $("#add_subscription_form").find("select[name='type'], input[type='text'],input[type='file'],input[type='number'],textarea").val("");  
    $("#add_subscription_form").find(".showImg").attr("src", "");  
    $("#add_subscription_form").find("._showVdo").attr("src", "");  
    $(".open_subscription_form").fadeOut();
}
function open_up_subscription_form(){
    $(".open_up_subscription_form").fadeIn();
}
function close_up_subscription_form(){
    $('.fixed_box').animate({scrollTop:0},300);
    $("#up_subscription_form").find("select[name='type'], input[type='text'],input[type='file'],input[type='number'],textarea").val(""); 
    $("#up_subscription_form").find(".showImg").attr("src", "");   
    $("#up_subscription_form").find("._showVdo").attr("src", "");   
    $(".open_up_subscription_form").fadeOut();
}
$(document).on("change", ".select_media", function(){
    switch($(this).val()) {
        case "Image":
            $(this).closest("form").find(".Video, .Youtube").slideUp();
            $(this).closest("form").find(".Image").slideDown();
            break;

        case "Video":
            $(this).closest("form").find(".Image, .Youtube").slideUp();
            $(this).closest("form").find(".Video").slideDown();
            break;

        case "Youtube":
            $(this).closest("form").find(".Video, .Image").slideUp();
            $(this).closest("form").find(".Youtube").slideDown();
            break;
    }
});
$(document).on('submit', '#add_subscription_form', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_price_setting/add_subscription'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                close_subscription_form();
                reload_data_table("#subscription_datatable");
            }
        }
    });
});
$(document).on('submit', '#up_subscription_form', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_price_setting/update_subscription'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                close_up_subscription_form();
                reload_data_table("#subscription_datatable");
            }
        }
    });   
});
function subscription_status_data(id){
    if($("#"+id+"_status").is(":checked")){
        var status=1;
    }else{
        var status=0;
    }
    $.ajax({  
        url:base_url+"/elecxtra_admin/admin_price_setting/subscription_status_data", 
        method:'POST',  
        data:{[csrfName]:csrfHash, id:id, status:status},
        dataType: 'JSON',
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                reload_data_table("#subscription_datatable");
            }
        }
    });
}
function delete_media(id){
    if(window.confirm("Are you sure to delete it?")){
        $.ajax({
            url:"<?php echo base_url('elecxtra_admin/admin_price_setting/delete_subscription'); ?>",
            method:"POST",
            data:{[csrfName]:csrfHash, id:id},
            dataType: "JSON",
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#subscription_datatable");
                }
            }
        });
    }
}
function update_all_details(id){
    open_up_subscription_form();
    $.ajax({
        url:"<?php echo base_url('elecxtra_admin/admin_price_setting/update_subscription_fetch'); ?>",
        method:"POST",
        data:{[csrfName]:csrfHash, id:id},
        dataType: "JSON",
        success:function(data){
            $.each(data, function(i, row) {
                $('#up_subscription_form [name="' + i + '"]').val(row);
                if(i=="img" && row!=""){
                    $(".select_media").val("Image").trigger("change");
                    $("#up_subscription_form .showImg").attr("src", "<?php echo base_url('uploads/media/'); ?>"+row);
                }
                if(i=="vdo" && row!=""){
                    $(".select_media").val("Video").trigger("change");
                    $("#up_subscription_form ._showVdo").attr("src", "<?php echo base_url('uploads/uploader/'); ?>"+row);
                }
                if(i=="youtube_link" && row!=""){
                    $(".select_media").val("Youtube").trigger("change");
                    $("#up_subscription_form ._showVdo").attr("src", "<?php echo base_url('uploads/media/'); ?>"+row);
                }
            });            
        }
    });
}

$(document).on('click', 'table tr td img', function(event){
    $('#img_view').attr('src', $(this).attr('src'));
    $('#img_link').val($(this).prop('src'));
    $('#caption').html($(this).attr('alt'));
    alert_box_open('img_prev_modal');
});
</script>
</body>
</html>



