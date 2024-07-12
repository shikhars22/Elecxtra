<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | All Products</title>
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
                <h6 class="adminHead d_flex_evr py-3 m-0"><?php if($session_data['admin_role']=='seller'){ ?><a href="<?php echo base_url('admin/add-product'); ?>" class="_wtBtnMd bg_theme_2">+&nbsp; Add Product</a><?php } ?><small class="fs_13 ms-auto">Admin / All Products</small></h6>
            </div>
            
            <div class="col-12">
                <div class="table-responsive _allProdTable _scrollDx">
                    <table class="table" id="product_datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Product Info</th>
                                <th>Manufacturer</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Published</th>
                                <th>Last Update</th>
                                <?php if($session_data['admin_role']=='superadmin'){ ?><th>Seller</th><?php } ?>
                                <?php if($session_data['admin_role']=='seller'){ ?><th>Status</th><?php } ?>
                                <?php if($session_data['admin_role']=='superadmin'){ ?><th>Tags</th><?php } ?>
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
                                <?php if($session_data['admin_role']=='superadmin'){ ?><th></th><?php } ?>
                                <?php if($session_data['admin_role']=='seller'){ ?><th></th><?php } ?>
                                <?php if($session_data['admin_role']=='superadmin'){ ?><th></th><?php } ?>
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
            <input type="hidden" name="seller_id" value="" required>
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

var is_superadmin="<?php if($session_data['admin_role']=='superadmin'){echo "yes";}else{echo "no";} ?>";
var is_seller="<?php if($session_data['admin_role']=='seller'){echo "yes";}else{echo "no";} ?>";

$(document).ready(function() {
    $('#product_datatable').DataTable({
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
            url:base_url+"/elecxtra_admin/Admin_product/fetch_all_product",  
            type:"POST",
            data:{[csrfName]:csrfHash, approve:"<?php echo $product_status['approve']; ?>", reject:"<?php echo $product_status['reject']; ?>", trash:"<?php echo $product_status['trash']; ?>"}
        },
        "columnDefs":[
            (is_seller=="yes")?{"orderable":false, "targets":[1,8,9]}:{"orderable":false, "targets":[1,9,10]},
        ], 
    });
});
function reload_data_table(element){
    $(element).DataTable().ajax.reload();
}
function update_stock(self) {
    var id=$(self).data('id');
    var stock=$(self).closest('.stock_holder').find("input").val();
    if(id>0 && stock>0){
        if(window.confirm("Are you sure to update the stock?")){
            $.ajax({  
                url:base_url+"/elecxtra_admin/Admin_product/update_stock", 
                method:'POST',  
                data:{[csrfName]:csrfHash, id:id, stock:stock},
                dataType: 'JSON',
                success:function(data){
                    webinaToast({type: data.type, message: data.text});
                    if(data.type!='success'){
                        reload_data_table("#product_datatable");
                    }
                }
            });
        }
    }

}
function status_data(id){
	if($("#"+id+"_status").is(":checked")){
		var status=1;
	}else{
		var status=0;
	}
	$.ajax({  
        url:base_url+"/elecxtra_admin/Admin_product/status_data", 
        method:'POST',  
        data:{[csrfName]:csrfHash, id:id, status:status},
        dataType: 'JSON',
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                reload_data_table("#product_datatable");
            }
        }
    });
}
function feature_data(id){
    if($("#"+id+"_feature").is(":checked")){
        var feature=1;
    }else{
        var feature=0;
    }
    $.ajax({  
        url:base_url+"/elecxtra_admin/Admin_product/feature_data", 
        method:'POST',  
        data:{[csrfName]:csrfHash, id:id, feature:feature},
        dataType: 'JSON',
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                reload_data_table("#product_datatable");
            }
        }
    });
}
function deal_data(id){
    if($("#"+id+"_deal").is(":checked")){
        var deal=1;
    }else{
        var deal=0;
    }
    $.ajax({  
        url:base_url+"/elecxtra_admin/Admin_product/deal_data", 
        method:'POST',  
        data:{[csrfName]:csrfHash, id:id, deal:deal},
        dataType: 'JSON',
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                reload_data_table("#product_datatable");
            }
        }
    });
}
function delete_data(id){
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_product/delete_data", 
            method:'POST',  
            data:{[csrfName]:csrfHash, id:id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#product_datatable");
                }
            }
        });
    }
}
function delete_data_permanent(id){
    if(window.confirm("Are you sure to delete parmanently?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_product/delete_permanently_data", 
            method:'POST',  
            data:{[csrfName]:csrfHash, id:id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#product_datatable");
                }
            }
        });
    }
}
function restore_data(id){
    if(window.confirm("Are you sure to restore?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_product/restore_data", 
            method:'POST',  
            data:{[csrfName]:csrfHash, id:id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#product_datatable");
                }
            }
        });
    }
}
function approve_data(id, seller_id){
    if(window.confirm("Are you sure to approve?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_product/approve_data", 
            method:'POST',  
            data:{[csrfName]:csrfHash, id:id, seller_id:seller_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#product_datatable");
                }
            }
        });
    }
}
function reject_data(id, seller_id){
    alert_box_open("write_text_modal");
    $("#rejectForm").find("textarea").html("").val("");
    $("#rejectForm").find("input[name='id']").val(id);
    $("#rejectForm").find("input[name='seller_id']").val(seller_id);
}
$(document).on("submit", "#rejectForm", function(e){
    e.preventDefault();
    if(window.confirm("Are you sure to reject?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_product/reject_data", 
            method:'POST',  
            data:new FormData(this),
            dataType: 'JSON',
            contentType:false,  
            processData:false,
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    alert_box_close();
                    reload_data_table("#product_datatable");
                }
            }
        });
    }
});
function edit_data(id){
    location.href=base_url+"/admin/edit-product?product_id="+id;
}
$(document).on('click', 'table tr td .img', function(event){
    $('#img_view').attr('src', $(this).find("img").attr('src'));
    $('#img_link').val($(this).find("img").prop('src'));
    $('#caption').html($(this).find("img").attr('alt'));
    alert_box_open('img_prev_modal');
});

function view_general_report(id){
    alert_box_open('data_report');
    $('#generalReport_datatable').DataTable().destroy();
    $('#generalReport_datatable').DataTable({
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
            url:base_url+"/elecxtra_admin/Admin_product/view_general_report",  
            type:"POST",
            data:{[csrfName]:csrfHash, id:id}
        },
        "columnDefs":[
            {"orderable":false, "targets":[2,3]},
        ], 
    });
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