<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Email</title>
<?php echo $link_script; ?>
</head>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section  id="_wtBdySec" class="_wtWdArea _wtThmSec">
    <div class="_wtH54"></div>
    <div class="fixed_box display_none open_email_form">
        <form id="send_email_form">
            <input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                
                <div class="prod_board my-2">
                    <h5 class="mb-0">Compose New Email <span style="float:right; padding: 5px; cursor: pointer; font-size:30px; color:red;" onclick="close_email_form()">&times;</span></h5>
                    <small>Dashboard / Compose New Email</small>
                </div>

                <div class="prod_board">
                    <div class="row formInput">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label>To</label><br>
                            <input type="text" name="email_to" required>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label>From</label><br>
                            <select name="email_from" required>
                                <option value="">Select</option>
                                <option value="">your mail list here</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Subject</label><br>
                            <input type="text" name="email_subject" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Message</label><br>
                            <div id="email_message_div" style="border: 1px solid #767676; min-height: 100px; padding: 5px 10px;" contenteditable>Enter your message here..</div>
                                <textarea style="display: none;" name="email_message" value=""></textarea>
                        </div>

                        <div class="col-12">
                            <button type="button" onclick="close_email_form()" class="_wtBtnMd bg_Grey">Cancel</button>
                            <button type="submit" class="_wtBtnMd bg_Green">Send Email</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>

    <div class="col-lg-12">  
        <div class="prod_board my-2">
            <button type="button" class="_wtBtnMd bg_Theme" onclick="open_email_form()">New Email</button>
        </div>
        
        <div class="table-responsive prod_board">
            <table class="table table-sm history-wrapper w-100" id="email_datatable" style="width:100%;">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Heading</th>
                        <th>Message</th>
                        <th>DateTime</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>From</th>
                       <th>To</th>
                        <th>Heading</th>
                        <th>Message</th>
                        <th>DateTime</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</section>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    //datatable loading
    $('#email_datatable').DataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax":{
            data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>'},
            url:"<?php echo base_url('admin/admin_view_notification/fetch_all_email'); ?>",  
            type:"POST"
        },  
        "columnDefs":[
            {  
                "orderable":false, "targets":[0,1,2,3,4,5],  
            },  
        ],  
    });
});
function reload_data_table(ele){
    $(ele).DataTable().ajax.reload();
}
function open_email_form(){
    $(".open_email_form").slideDown(500);
    $('body').css({'overflow-y' : 'hidden'});
}
function close_email_form(){
    $('.fixed_box').animate({scrollTop:0},300);
    $("#send_email_form").find("input[type='text'],input[type='file'],input[type='number'],select,textarea").val("");
    $("#email_message_div").html("Enter your message here..")
    $(".open_email_form").slideUp(500);
    $('body').css({'overflow-y' : 'auto'});
}
$(document).on('submit', '#send_email_form', function(event){ 
    event.preventDefault();
    $("#send_email_form textarea").val($("#email_message_div").html());
    $.ajax({  
        url:"<?php echo base_url('admin/admin_view_notification/send_email'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                close_email_form();
                reload_data_table("#email_datatable");
            }
        }
    });
});
function resend_email(email_id){
    open_email_form();
    $.ajax({
        url:"<?php echo base_url('admin/admin_view_notification/get_saved_email_fetch'); ?>",
        method:"POST",
        data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', id:email_id},
        dataType: "JSON",
        success:function(data){
            $.each(data, function(i, row) {
                if(i=="email_message"){
                    $("#email_message_div").html(row);
                }else{
                    $('#send_email_form [name="' + i + '"]').val(row);
                }
            });            
        }
    });
}
function delete_send_email(email_id){
    $.ajax({
        url:"<?php echo base_url('admin/admin_view_notification/delete_send_email'); ?>",
        method:"POST",
        data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', id:email_id},
        dataType: "JSON",
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=='success'){
                reload_data_table("#email_datatable");  
            }         
        }
    });
}
</script>

</body>
</html>



