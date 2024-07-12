<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | All Customers</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
<?php echo $link_script; ?>

</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<!-- start page content -->
<section  id="_wtBdySec" class="_wtThmSec">
    <div class="container-fluid">
        <div class="row">            
            <div class="col-12">
                <div class="table-responsive _allProdTable _scrollDx">
                    <table class="table" id="customer_datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Registered On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot style="display: none;">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
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

<!-- start alert modal -->
<div class="alert_bg text_modal">
    <!-- next alert modal -->
    <div class="alert_box alert_md height_auto">
        <div class="alert_header sticky_top">
            <h6 class="mb-0 p-3">Full Text</h6>
            <hr class="my-0">
        </div>
        <div class="alert_body">
            <div class="w-100">
                <textarea id="textNote" rows="5" class="w-100" readonly></textarea>
            </div>
        </div>
        <div class="alert_footer sticky_bottom text-end">
            <button type="button" class="_wtBtnMd bg_cyan" onclick="copyTextData('textNote')">Copy Text</button>
            <button type="button" class="_wtBtnMd bg_theme_2 alert_cancel">&nbsp; Close &nbsp;</button>
        </div>
    </div>  
</div>
<!-- end alert modal -->

<!-- start alert modal -->
<div class="alert_bg html_modal">
    <!-- next alert modal -->
    <div class="alert_box alert_md height_auto">
        <div class="alert_header sticky_top">
            <h6 class="mb-0 p-3">Full Info</h6>
            <hr class="my-0">
        </div>
        <div class="alert_body">
            <div class="w-100">
                <div id="htmlNote" class="p-3"></div>
            </div>
        </div>
        <div class="alert_footer sticky_bottom text-end">
            <button type="button" class="_wtBtnMd bg_theme_2 alert_cancel">&nbsp; Close &nbsp;</button>
        </div>
    </div>  
</div>
<!-- end alert modal -->

<!-- start alert modal -->
<div class="alert_bg write_text_modal">
    <!-- next alert modal -->
    <div class="alert_box alert_md height_auto">
        <form id="rejectForm">
            <input type="hidden" name="id" value="" required>
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>" required>
            <div class="alert_header sticky_top">
                <h6 class="mb-0 p-3">Enter Reason Here</h6>
                <hr class="my-0">
            </div>
            <div class="alert_body">
                <div class="w-100">
                    <textarea id="writeTextNote" rows="5" class="w-100" name="reject_note" required></textarea>
                </div>
            </div>
            <div class="alert_footer sticky_bottom text-end">
                <button type="submit" class="_wtBtnMd bg_theme_1">&nbsp; Submit &nbsp;</button>
                <button type="button" class="_wtBtnMd bg_theme_2 alert_cancel">&nbsp; Close &nbsp;</button>
            </div>
        </form>
    </div>  
</div>
<!-- end alert modal -->

<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript">
var base_url="<?php echo base_url(); ?>";
var csrfName="<?php echo $csrfName; ?>";
var csrfHash="<?php echo $csrfHash; ?>";

$(document).ready(function() {
    $('#customer_datatable').DataTable({
        "pageLength" : 50,
        "lengthMenu" : [10, 20, 50, 100, 200],
        "language": {
            "lengthMenu": '_MENU_',
            "sSearch": "",
            "searchPlaceholder": "Search records"
        },
        "processing" : true,
        "serverSide" : true,
        "ajax":{
            url:base_url+"/elecxtra_admin/Admin_customer/fetch_all_customer",  
            type:"POST",
            data:{[csrfName]:csrfHash}
        },
        "columnDefs":[
            {"orderable":false, "targets":[4,6]}
        ], 
    });
});
function reload_data_table(element){
    $(element).DataTable().ajax.reload();
}

$(document).on('click', 'table tr td .img', function(event){
    $('#img_view').attr('src', $(this).find("img").attr('src'));
    $('#img_link').val($(this).find("img").prop('src'));
    $('#caption').html($(this).find("img").attr('alt'));
    alert_box_open('img_prev_modal');
});


$(document).on("click", ".showFullTxt", function(e){
    e.preventDefault();
    alert_box_open('text_modal');
    $("#textNote").val($(this).text());
});
$(document).on("click", ".showFullHtml", function(e){
    e.preventDefault();
    alert_box_open('html_modal');
    $("#htmlNote").html($(this).html());
});
</script>
</body>
</html>