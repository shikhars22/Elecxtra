<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | All Seller</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
<?php echo $link_script; ?>
<style>
.plan_tenure {list-style: none; margin:0; padding:10px; display: grid; align-items: center; justify-content: space-between; grid-gap: 10px; grid-template-columns: repeat(3,1fr); width: 100%;}
.plan_tenure label {height: auto; padding: 15px 10px; margin: 0; background-color: #fff; border: 2px solid #ddd; border-radius: 5px; display: grid; align-items: center; justify-content: center; text-align: center; cursor: pointer; user-select: none;}
.plan_tenure h5 {font-size: 20px; font-weight: 800; color: #111; margin-bottom: 5px;}
.plan_tenure span {font-size: 12px; display: flex; align-items: center; grid-gap: 5px; justify-content: center;}
.plan_tenure label:hover, .plan_tenure label.active {border: 2px solid #6571ff}

</style>
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
                    <table class="table" id="seller_datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Document</th>
                                <th>Address</th>
                                <th>Bussiness Info</th>
                                <th>Product Info</th>
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
<div class="alert_bg approve_modal">
    <!-- next alert modal -->
    <div class="alert_box alert_md height_auto">
        <form id="approveForm">
            <input type="hidden" name="id" value="" required>
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>" required>
            <div class="alert_header sticky_top">
                <h6 class="mb-0 p-3">Select Expire Date</h6>
                <hr class="my-0">
            </div>
            <div class="alert_body">
                <div class="w-100">
                    <div class="plan_tenure">
                        <div class="card p-3">
                            <label><h5>Free</h5><span><input type="radio" name="subscription_plan" required value="free"> &#8377;0/Month</span></label>
                            <div class="fs_13 px-1">
                                
                            </div>
                        </div>
                        <?php $subscription_set=get_subscription_plan();
                        foreach($subscription_set as $key=>$value){ ?>
                            <div class="card p-3">
                                <label><h5><?php echo $value->plan_name; ?></h5><span><input type="radio" name="subscription_plan" required value="<?php echo $value->plan_name; ?>"> &#8377;<?php echo $value->plan_price; ?>/Month</span></label>
                                <div class="fs_13 px-1">
                                    <?php echo nl2br($value->plan_description); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
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

<!-- start alert modal -->
<div class="alert_bg reject_modal">
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
    $('#seller_datatable').DataTable({
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
            url:base_url+"/elecxtra_admin/Admin_seller/fetch_all_seller",  
            type:"POST",
            data:{[csrfName]:csrfHash, status:"<?php echo $status; ?>"}
        },
        "columnDefs":[
            {"orderable":false, "targets":[5,6,7,9]}
        ], 
    });
});
function reload_data_table(element){
    $(element).DataTable().ajax.reload();
}
/*function delete_data(id){
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_seller/delete_data", 
            method:'POST',  
            data:{[csrfName]:csrfHash, id:id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#seller_datatable");
                }
            }
        });
    }
}*/
$(document).on("click", "#approveForm .plan_tenure label", function(){
    $("#approveForm .plan_tenure label").removeClass('active');
    $(this).addClass('active');
});
function approve_data(self){
    var id=$(self).data('id');
    var subscription_plan=$(self).data('subscription_plan');
    alert_box_open("approve_modal");
    $("#approveForm").find("input[name='id']").val(id);
    $("#approveForm").find("input[name='subscription_plan'][value='"+subscription_plan+"']").closest("label").trigger("click");
}
$(document).on("submit", "#approveForm", function(e){
    e.preventDefault();
    if(window.confirm("Are you sure to approve?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_seller/approve_data", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    alert_box_close();
                    reload_data_table("#seller_datatable");
                }
            }
        });
    }
});
function reject_data(id){
    alert_box_open("reject_modal");
    $("#rejectForm").find("textarea").html("").val("");
    $("#rejectForm").find("input[name='id']").val(id);
}
$(document).on("submit", "#rejectForm", function(e){
    e.preventDefault();
    if(window.confirm("Are you sure to reject?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_seller/reject_data", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    alert_box_close();
                    reload_data_table("#seller_datatable");
                }
            }
        });
    }
});

$(document).on('click', 'table tr td .img', function(event){
    $('#img_view').attr('src', $(this).find("img").attr('src'));
    $('#img_link').val($(this).find("img").prop('src'));
    $('#caption').html($(this).find("img").attr('alt'));
    alert_box_open('img_prev_modal');
});

function delete_data_permanent(id){
    if(window.confirm("Are you sure to delete parmanently?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_seller/delete_permanently_data", 
            method:'POST',  
            data:{[csrfName]:csrfHash, id:id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#seller_datatable");
                }
            }
        });
    }
}
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