<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | All Orders</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
<?php echo $link_script; ?>
<style>
/*/Invoice Modal/*/
.ivoice_modal {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background-color: #22222250; z-index: 99999; overflow-y: auto; display: none; padding: 20px;}
.invoice_content {width: 70%; background-color: #fff; margin: auto; padding: 20px;}
.invoice_heading, .invoice_gen {display: flex; justify-content: space-between; border: 1px solid #ccc; border-bottom: none;}
.invoice_gen h5 {font-weight: 700;}
.invoice_heading h6, .invoice_heading i {padding: 15px;}
.invoice_table {border: 1px solid #ccc;}
.invoice_table .item_desp {padding: 15px; border-bottom: 1px solid #ccc; text-align: left;}
.invoice_table table tr th {font-size: 14px;}
.ivoice_modal .p-3 {padding: 15px;}
.ivoice_modal .mb-0 {margin-bottom: 0;}
.ivoice_modal .mb-1 {margin-bottom: 5px;}
.ivoice_modal .text_right {text-align: right;}
.ivoice_modal .table {width: 100%; margin-bottom: 0; color: #212529; border-collapse: collapse;}
.ivoice_modal .table-responsive {display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: none;}

.ivoice_modal tr {border: 1px solid #ccc;}

.ivoice_modal_show {display: block;}


@media only screen and (max-width:576px) {
    .ivoice_modal {padding:0;}
    .invoice_content {width: 100%; padding: 10px;}
}
@media only screen and (max-width:480px) {

}
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
                    <table class="table" id="order_datatable">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Product</th>
                                <th>Product Info</th>
                                <th>Qty & Price</th>
                                <th>Order On</th>
                                <?php if($this->session->userdata('admin_role')=="superadmin"){ ?>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Seller</th>
                                <?php } ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot style="display: none;">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if($this->session->userdata('admin_role')=="superadmin"){ ?>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php } ?>
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
<div class="alert_bg out_deliver_modal">
    <!-- next alert modal -->
    <div class="alert_box alert_md height_auto">
        <form id="outDeliverForm" method="post">
            <input type="hidden" name="order_id" value="" required>
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>" required>
            <div class="alert_header sticky_top">
                <h6 class="mb-0 p-3">Enter Tracking Id <code>(you get from delivery partner)</code></h6>
                <hr class="my-0">
            </div>
            <div class="alert_body">
                <div class="w-100 p-3">
                    <input type="text" class="w-100" name="tracking_id" required>
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


<!-- start invoice modal -->
<div class="ivoice_modal">
    <div class="invoice_content">
        <div class="invoice_heading">
            <h6 class="mb-0">Invoice</h6>
            <i class="fas fa-times close_modal"></i>
        </div>
        <!--load-order-->
            <div id="invBody">
        
            </div>
        <!--load-order-end-->
    </div>
</div>
<!-- end invoice modal -->


<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript">
var base_url="<?php echo base_url(); ?>";
var csrfName="<?php echo $csrfName; ?>";
var csrfHash="<?php echo $csrfHash; ?>";

var is_superadmin="<?php if($session_data['admin_role']=='superadmin'){echo "yes";}else{echo "no";} ?>";
var is_seller="<?php if($session_data['admin_role']=='seller'){echo "yes";}else{echo "no";} ?>";

$(document).ready(function() {
    $('#order_datatable').DataTable({
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
            url:base_url+"/elecxtra_admin/Admin_view_order/fetch_all_order",  
            type:"POST",
            data:{[csrfName]:csrfHash, status:"<?php echo $status; ?>"}
        },
        "columnDefs":[
            (is_seller=="yes")?{"orderable":false, "targets":[1,5]}:{"orderable":false, "targets":[1,6,8]},
        ], 
    });
});
function reload_data_table(element){
    $(element).DataTable().ajax.reload();
}


function order_packaged(order_id){
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_view_order/order_packaged", 
            method:'POST',  
            data:{[csrfName]:csrfHash, order_id:order_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#order_datatable");
                }
            }
        });
    }
}
function order_pickedup(order_id){
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_view_order/order_pickedup", 
            method:'POST',  
            data:{[csrfName]:csrfHash, order_id:order_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#order_datatable");
                }
            }
        });
    }
}
function order_ready_to_deliver(order_id){
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_view_order/order_ready_to_deliver", 
            method:'POST',  
            data:{[csrfName]:csrfHash, order_id:order_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#order_datatable");
                }
            }
        });
    }
}
function order_out_for_deliver(order_id){
    if(window.confirm("Are you sure to perform the action?")){
        alert_box_open('out_deliver_modal');
        $("#outDeliverForm").find("input[name='order_id']").val(order_id);
    }
}
$(document).on('submit', '#outDeliverForm', function(e){
    e.preventDefault();
    $.ajax({  
        url:base_url+"/elecxtra_admin/Admin_view_order/order_out_for_deliver", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,
        success:function(data){
            webinaToast({type:data.type, message:data.text});
            if(data.type=='success'){
                alert_box_close();
                reload_data_table("#order_datatable");
            }
        }
    });
});
function order_complete_deliver(self){
    var order_id=$(self).data('order_id');
    var seller_id=$(self).data('seller_id');
    var user_id=$(self).data('user_id');
    var qty=$(self).data('qty');
    var product_id=$(self).data('product_id');
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_view_order/order_complete_deliver", 
            method:'POST',  
            data:{[csrfName]:csrfHash, order_id:order_id, seller_id:seller_id, user_id:user_id, qty:qty, product_id:product_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#order_datatable");
                }
            }
        });
    }
}
function order_complete_canceled(self){
    var order_id=$(self).data('order_id');
    var seller_id=$(self).data('seller_id');
    var user_id=$(self).data('user_id');
    var qty=$(self).data('qty');
    var product_id=$(self).data('product_id');
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_view_order/order_complete_canceled", 
            method:'POST',  
            data:{[csrfName]:csrfHash, order_id:order_id, seller_id:seller_id, user_id:user_id, qty:qty, product_id:product_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#order_datatable");
                }
            }
        });
    }
}
function order_complete_returned(self){
    var order_id=$(self).data('order_id');
    var seller_id=$(self).data('seller_id');
    var user_id=$(self).data('user_id');
    var qty=$(self).data('qty');
    var product_id=$(self).data('product_id');
    if(window.confirm("Are you sure to perform the action?")){
        $.ajax({  
            url:base_url+"/elecxtra_admin/Admin_view_order/order_complete_returned", 
            method:'POST',  
            data:{[csrfName]:csrfHash, order_id:order_id, seller_id:seller_id, user_id:user_id, qty:qty, product_id:product_id},
            dataType: 'JSON',
            success:function(data){
                webinaToast({type: data.type, message: data.text});
                if(data.type=='success'){
                    reload_data_table("#order_datatable");
                }
            }
        });
    }
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
    $('#htmlNote [class*="clip_txt_"]').removeClass(function(i, c) {
      return c.match(/clip_txt_\d+/g).join(" ");
    });
});


var modal = document.querySelector(".ivoice_modal");
var closeButton = document.querySelector(".close_modal");
function toggleModal() {
  modal.classList.toggle("ivoice_modal_show");
  $("body").toggleClass("no_scroll")
}
function windowOnClick(event) {
  if (event.target === modal) {
    toggleModal();
  }
}
closeButton.addEventListener("click", toggleModal);
function windowOnClick(event) {
  if (event.target === modal) {
    toggleModal();
  }
}

function view_invoice(self){
    var user_id=$(self).data('user_id');
    var order_id=$(self).data('order_id');
    $.ajax({  
        url:base_url+"/elecxtra_admin/Admin_view_order/view_invoice", 
        method:'POST',
        data:{[csrfName]:csrfHash, order_id:order_id, user_id:user_id},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
                toggleModal()
                $("#invBody").html(data.data);
            }
        }
    });
}
</script>



<script language="javascript">
function PrintMe(DivID) {
var inv_id="0000000";
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
   var content_vlue = document.getElementById(DivID).innerHTML;
   var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
   docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head><title>'+inv_id+'</title>');
  docprint.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">');
  
   docprint.document.write('<style>.ivoice_modal {position: fixed; left: 0; top: 0; right: 0; bottom: 0; background-color: #22222250; z-index: 99999; overflow-y: auto; display: none; padding: 20px;} .invoice_content {width: 70%; background-color: #fff; margin: auto; padding: 20px;} .invoice_heading, .invoice_gen {display: flex; justify-content: space-between; border: 1px solid #ccc; border-bottom: none;} .invoice_gen h5 {font-weight: 700;} .invoice_heading h6, .invoice_heading i {padding: 15px;} .invoice_table {border: 1px solid #ccc;} .invoice_table .item_desp {padding: 15px;  border-bottom: 1px solid #ccc; text-align: left;} .invoice_table table tr th {font-size: 14px;} .ivoice_modal .p-3 {padding: 15px;} .ivoice_modal .mb-0 {margin-bottom: 0;} .ivoice_modal .mb-1 {margin-bottom: 5px;} .ivoice_modal .text_right {text-align: right;} .ivoice_modal .table {width: 100%; margin-bottom: 0; color: #212529; border-collapse: collapse;} .ivoice_modal .table-responsive {display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: none;} .ivoice_modal td, .ivoice_modal th {border: 1px solid #ddd;} .ivoice_modal_show {display: block;} @media only screen and (max-width:576px) { .ivoice_modal {padding:0;} .invoice_content {width: 100%; padding: 10px;} }</style>');
  
   docprint.document.write('</head><body onLoad="self.print()"><center>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}
</script>
</body>
</html>