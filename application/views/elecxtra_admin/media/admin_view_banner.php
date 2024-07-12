<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Banner</title>
<?php echo $link_script; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section  id="_wtBdySec" class="_wtThmSec">
    <div class="fixed_box display_none open_banner_form">
        <form id="add_banner_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="bg-white p-3">
                    <h5 class="heading">Add Banner <span style="float:right; padding: 5px; cursor: pointer; font-size:35px; color:red;" onclick="close_banner_form()">&times;</span></h5>
                    <small>Dashboard > Add Banner</small>
                </div>

                <div class="bg-white p-3">
                    <div class="row">
                        <div class="col-lg-6 d-none" style="display:none;">
                            <div class="w-100 mb-3">
                                <label>Select Media</label><br>
                                <select class="form-control select_media">
                                    <option value="Image" selected>Image</option>
                                    <option value="Video">Video</option>
                                    <option value="Youtube">Youtube</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Name</label><br>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Position</label><br>
                                <input type="number" name="position" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 d-none" style="display:none;">
                            <div class="w-100 mb-3">
                                <label>Page</label><br>
                                <select name="page" class="form-control">
                                    <option value="home" selected>Home</option>
                                    <?php foreach (get_page_list() as $key => $value) { ?>
                                        <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 Video" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>banner Video</label><br>
                                <input type="text" name="vdo" class="_vdoUploadLink form-control" placeholder="Click to Upload Video" onclick="_wtUploaderOpenModal()" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 Video" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Video Preview</label><br>
                                <video src="" class="_showVdo" controls width="200px" height="100px"></video>
                            </div>
                        </div>
                        <div class="col-lg-6 Image">
                            <div class="w-100 mb-3">
                                <label>Banner Image</label><br>
                                <input type="hidden" name="img_extention">
                                <input type="text" name="image" class="_imgUploadLink form-control" placeholder="Click to Upload Image" onclick="_wtImgCompressorOpenModal()" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 Image">
                            <div class="w-100 mb-3">
                                <label>Image Preview</label><br>
                                <img src="" class="showImg" width="100px">
                            </div>
                        </div>
                        <div class="col-lg-12 Youtube" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Youtube Link</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Youtube Link" name="youtube_link">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 1</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 1 Name" name="button_1">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 1 Link</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 1 Link" name="button_1_link">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 2</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 2 Name" name="button_2">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 2 Link</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 2 Link" name="button_2_link">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="w-100 mb-3">
                                <label>Description</label><br>
                                <textarea rows="3" class="form-control summernote" placeholder="Describe your media here..." name="description"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 text-end">
                            <button type="button" onclick="close_banner_form()" class="_wtBtnMd bg_gray">Cancel</button>
                            <button type="submit" class="_wtBtnMd bg_theme_2">Add Banner</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="fixed_box display_none open_up_banner_form">
        <form id="up_banner_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <input type="hidden" name="id">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="bg-white p-3">
                    <h5 class="heading">Edit & Update Banner <span style="float:right; padding: 5px; cursor: pointer; font-size:35px; color:red;" onclick="close_up_banner_form()">&times;</span></h5>
                    <small>Dashboard > Edit & Update Banner</small>
                </div>

                <div class="bg-white p-3">
                    <div class="row">
                        <div class="col-lg-6 d-none" style="display:none;">
                            <div class="w-100 mb-3">
                                <label>Select Media</label><br>
                                <select class="form-control select_media">
                                    <option value="Image" selected>Image</option>
                                    <option value="Video">Video</option>
                                    <option value="Youtube">Youtube</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Name</label><br>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Position</label><br>
                                <input type="number" name="position" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 d-none" style="display:none;">
                            <div class="w-100 mb-3">
                                <label>Page</label><br>
                                <select name="page" class="form-control">
                                    <option value="home" selected>Home</option>
                                    <?php foreach (get_page_list() as $key => $value) { ?>
                                        <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 Video" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Banner Video</label><br>
                                <input type="text" name="vdo" class="_vdoUploadLink form-control" placeholder="Click to Upload Video" onclick="_wtUploaderOpenModal()" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 Video" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Video Preview</label><br>
                                <video src="" class="_showVdo" controls width="200px" height="100px"></video>
                            </div>
                        </div>
                        <div class="col-lg-6 Image" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Banner Image</label><br>
                                <input type="hidden" name="img_extention">
                                <input type="text" name="image" class="_imgUploadLink form-control" placeholder="Click to Upload Image" onclick="_wtImgCompressorOpenModal()" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 Image" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Image Preview</label><br>
                                <img src="" class="showImg" width="100px">
                            </div>
                        </div>
                        <div class="col-lg-12 Youtube" style="display: none;">
                            <div class="w-100 mb-3">
                                <label>Youtube Link</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Youtube Link" name="youtube_link">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 1</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 1 Name" name="button_1">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 1 Link</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 1 Link" name="button_1_link">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 2</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 2 Name" name="button_2">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mb-3">
                                <label>Button 2 Link</label><br>
                                <input type="text" class="form-control summernote" placeholder="Enter Button 2 Link" name="button_2_link">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="w-100 mb-3">
                                <label>Description</label><br>
                                <textarea rows="3" class="form-control summernote" placeholder="Describe your media here..." name="description"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 text-end">
                            <button type="button" onclick="close_up_banner_form()" class="_wtBtnMd bg_gray">Cancel</button>
                            <button type="submit" class="_wtBtnMd bg_theme_2">Update Banner</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h6 class="adminHead d_flex_evr py-3 m-0"><a href="javascript:void(0)" onclick="open_banner_form()" class="_wtBtnMd bg_theme_2">+&nbsp; Add Banner</a><small class="fs_13 ms-auto">Admin / Banners</small></h6>
            </div>
            
            <div class="col-12">
                <div class="table-responsive _allProdTable _scrollDx">
                    <table class="table table-sm history-wrapper" id="banner_datatable">
                        <thead>
                            <tr>
                                <th>Media</th>
                                <th>Page</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Media</th>
                                <th>Page</th>
                                <th>Name</th>
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
    $('#banner_datatable').DataTable({
        "processing" : true,
        "serverSide" : true,
        "language": {
            "lengthMenu": '_MENU_',
            "sSearch": "",
            "searchPlaceholder": "Search records"
        },
        "ajax":{
            data:{[csrfName]:csrfHash},
            url:"<?php echo base_url('elecxtra_admin/admin_view_media/fetch_all_banner'); ?>",  
            type:"POST"
        },  
        "columnDefs":[
            {  
                "orderable":false, "targets":[0,1,2,3,4],  
            },  
        ],  
    });
});
function reload_data_table(element){
    $(element).DataTable().ajax.reload();
}
function open_banner_form(){
    $(".open_banner_form").fadeIn();
}
function close_banner_form(){
    $('.fixed_box').animate({scrollTop:0},300);
    $("#add_banner_form").find("select[name='type'], input[type='text'],input[type='file'],input[type='number'],textarea").val("");  
    $("#add_banner_form").find(".showImg").attr("src", "");  
    $("#add_banner_form").find("._showVdo").attr("src", "");  
    $(".open_banner_form").fadeOut();
}
function open_up_banner_form(){
    $(".open_up_banner_form").fadeIn();
}
function close_up_banner_form(){
    $('.fixed_box').animate({scrollTop:0},300);
    $("#up_banner_form").find("select[name='type'], input[type='text'],input[type='file'],input[type='number'],textarea").val(""); 
    $("#up_banner_form").find(".showImg").attr("src", "");   
    $("#up_banner_form").find("._showVdo").attr("src", "");   
    $(".open_up_banner_form").fadeOut();
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
$(document).on('submit', '#add_banner_form', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_view_media/add_banner'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                close_banner_form();
                reload_data_table("#banner_datatable");
            }
        }
    });
});
$(document).on('submit', '#up_banner_form', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_view_media/update_banner'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                close_up_banner_form();
                reload_data_table("#banner_datatable");
            }
        }
    });   
});
function banner_status_data(id){
    if($("#"+id+"_status").is(":checked")){
        var status=1;
    }else{
        var status=0;
    }
    $.ajax({  
        url:base_url+"/elecxtra_admin/admin_view_media/banner_status_data", 
        method:'POST',  
        data:{[csrfName]:csrfHash, id:id, status:status},
        dataType: 'JSON',
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                reload_data_table("#banner_datatable");
            }
        }
    });
}
function delete_media(id){
    if(window.confirm("Are you sure to delete it?")){
        $.ajax({
            url:"<?php echo base_url('elecxtra_admin/admin_view_media/delete_banner'); ?>",
            method:"POST",
            data:{[csrfName]:csrfHash, id:id},
            dataType: "JSON",
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#banner_datatable");
                }
            }
        });
    }
}
function update_all_details(id){
    open_up_banner_form();
    $.ajax({
        url:"<?php echo base_url('elecxtra_admin/admin_view_media/update_banner_fetch'); ?>",
        method:"POST",
        data:{[csrfName]:csrfHash, id:id},
        dataType: "JSON",
        success:function(data){
            $.each(data, function(i, row) {
                $('#up_banner_form [name="' + i + '"]').val(row);
                if(i=="img" && row!=""){
                    $(".select_media").val("Image").trigger("change");
                    $("#up_banner_form .showImg").attr("src", "<?php echo base_url('uploads/media/'); ?>"+row);
                }
                if(i=="vdo" && row!=""){
                    $(".select_media").val("Video").trigger("change");
                    $("#up_banner_form ._showVdo").attr("src", "<?php echo base_url('uploads/uploader/'); ?>"+row);
                }
                if(i=="youtube_link" && row!=""){
                    $(".select_media").val("Youtube").trigger("change");
                    $("#up_banner_form ._showVdo").attr("src", "<?php echo base_url('uploads/media/'); ?>"+row);
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



