<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Contact</title>
<?php echo $link_script; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section  id="_wtBdySec" class="_wtWdArea _wtThmSec">
    <div class="_wtH54"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-1">
                <h5 class="adminHead m-0 text-end"><small>Admin / All Contact Us Data</small></h5>
            </div>
            
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm history-wrapper w-100" id="contact_datatable" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th>Adddress</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th>Adddress</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- start alert modal -->

<div class="alert_bg">
    <!-- next alert modal -->
    <div class="alert_box img_prev_modal">
        <div class="alert_header">
            <h4>Preview Image</h4>
        </div>

        <div class="alert_body">
            <div class="field text-center">
                <img id="img01" style="max-height: 300px;">
                <div id="caption"></div>
            </div>
            <div class="field" style="display: flex;">
                <input type="text" id="img_link" readonly>
                <button type="button" class="_wtBtnMd bg_Cyan" style="width: 115px;" onclick="copyTextData('img_link')">Copy Link</button>
            </div>
        </div>
        <div class="alert_footer field text-right">
            <button type="button" class="_wtBtnMd bg_Theme alert_cancel">&nbsp; OK &nbsp;</button>
        </div> 
    </div>
    
</div>
<!-- end alert modal -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    //datatable loading
    $('#contact_datatable').DataTable({
        'pageLength': 20,
        'lengthMenu': [10, 20, 50, 100, 200],
        "language": {
            "lengthMenu": '_MENU_',
            "sSearch": "",
            "searchPlaceholder": "Search records"
        },
        "processing" : true,
        "serverSide" : true,
        "ajax":{
            data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>'},
            url:"<?php echo base_url('admin/admin_view_notification/fetch_all_contact'); ?>",  
            type:"POST"
        },  
        "columnDefs":[
            {  
                "orderable":false, "targets":[0,1,2,3,4,5,6,7,8],  
            },  
        ],  
    });
});
function reload_data_table(ele){
    $(ele).DataTable().ajax.reload();
}
function delete_contact(id){
    if(window.confirm("Are you sure to delete it?")){
        $.ajax({
            url:"<?php echo base_url('admin/admin_view_notification/delete_contact'); ?>",
            method:"POST",
            data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', id:id},
            dataType: "JSON",
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#contact_datatable");
                }
            }
        })
    }else{
        return false;
    }
}
$(document).on('click', 'table tr>td>img', function(event){
    $('#img01').attr('src', $(this).attr('src'));
    $('#img_link').val($(this).prop('src'));
    $('#caption').html($(this).attr('alt'));
    alert_box_open('img_prev_modal');
});
</script>

</body>
</html>
