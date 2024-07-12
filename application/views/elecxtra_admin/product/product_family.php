<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Product's Family</title>
<?php echo $link_script; ?>
<style type="text/css">
/*/PRODUCT FAMILY/*/
.prod_family label {margin-bottom: 5px;}
.prod_family ul {list-style: none; margin: 0; padding: 0; max-height: 413px; overflow-y: auto;}
.prod_family ul li {display: flex; margin-bottom: 6px; width: 100%; grid-column-gap: 2px;}
.prod_family input[type="text"] {font-size: 13px; padding: 6px 10px; border-radius: 3px; background-color: #eee; border: 1px solid #ccc; width: inherit;}
.prod_family ul li i {padding: 5px; width: 35px; border-radius: 3px; display: flex; justify-content: center; align-items: center; background-color: #eee; border: 1px solid #ccc; font-size: 12px; color: #fff; cursor: pointer;}
.prod_family ul li button {background-color: #eee; border: 1px solid #ccc; width: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 3px;}
.prod_family ul li button i {background-color: transparent; border: none;}
.prod_family ul li label {font-size: 14px; margin-bottom: 0;}
.prod_family ul .listActv input {border: 1px solid #f36; outline: none;}

/*/Product Features/*/
#d_f_v_Holder .smlFormInptHld:nth-child(2) {display: none !important;}
#d_f_v_Holder .smlFormInptHld {background-color: #fff; box-shadow: 0 0 10px 0 rgb(183 192 206 / 20%); border-radius: 0.25rem; border: 1px solid #6571ff; margin-bottom: 8px; padding-top: 17px; padding-bottom: 10px;}
#d_f_v_Holder .smlFormInptHld .smlFormInpt {padding: 3px 20px;}
._searchFeatures {width: 250px !important; padding: 6px 10px !important; border: 1px solid #ddd; font-size: 14px; margin-left: auto;}
.smlFormInpt input, .smlFormInpt select {padding: 5px 10px; border: 1px solid #ddd; background-color: #fff; font-size: 14px;}
.feature_title {font-size: 16px !important; font-weight: 500; width: 60%;}
.select_list {height: auto !important;}
.select_list input {border: none !important;}
input:focus {outline: none !important;}

._actionBtns {display: flex; align-items: center; justify-content: center; margin-left: 20px;}
.exOpt {display: flex; grid-column-gap: 15px;}
/*._allBtns {display: flex; justify-content: end;}*/
.upFtrBtn {position: relative; z-index: -10; position: absolute;}
.dltFtrBtn {cursor: pointer; padding: 6px 0 6px 20px; color: #666; transition: all 0.5s;}
.dltFtrBtn:hover {color: #f36;}

@media only screen and (max-width:991px) {
	
}
@media only screen and (max-width:576px) {
	
}
</style>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section id="_wtBdySec" class="_wtThmSec">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<h6 class="adminHead d_flex_evr py-3 m-0"><small class="fs_13 ms-auto">Admin / Product's Family</small></h6>
			</div>

			<div class="row pb-3">
				<div class="col-lg-3 col-md-12 d-none" style="display:none;">
					<div class="prod_family">
						<label>Category</label>
						<ul id="cat" class="listdata _scrollDx">
						</ul>
						<ul class="">
							<form id="catForm">
								<input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
								<li><input type="text" name="name" autocomplete="off" class="mySearch"><button type="submit"><i class="fas fa-plus text-success"></i></button></li>
							</form>
						</ul>
					</div>
				</div>

				<div class="col-lg-6 col-md-6">
					<div class="prod_family">
						<label>Category</label>
						<ul id="subCat" class="listdata _scrollDx">
						</ul>
						<ul>
							<form id="subCatForm">
								<input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
								<input type="hidden" name="cat_id">
								<li><input type="text" name="name" autocomplete="off" class="mySearch"><button type="submit"><i class="fas fa-plus text-success"></i></button></li>
							</form>
						</ul>
					</div>
				</div>

				<div class="col-lg-6 col-md-6">
					<div class="prod_family">
						<label>Sub Category</label>
						<ul id="itm" class="listdata _scrollDx">
						</ul>
						<ul>
							<form id="itmForm">
								<input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
								<input type="hidden" name="sub_cat_id">
								<li><input type="text" name="name" autocomplete="off" class="mySearch"><button type="submit"><i class="fas fa-plus text-success"></i></button></li>
							</form>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>

<script type="text/javascript">
$(document).on("click", ".select_list input", function(){
	$(this).next("ul").slideToggle();
});
$(document).on("click", ".select_list .caret_down", function(){
	$(this).closest(".select_list").find("input").trigger("click");
});
$(document).on("keyup", ".select_list input", function(){
	var value = $(this).val().toLowerCase();
    $(this).next("ul").find("li").filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
$(document).on('submit', '#catForm', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_product_family/add_category'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=="success"){
            	$("#catForm").find("input[type='text']").val("");
            	loadCat();
            }
        }
    });   
});
$(document).on('submit', '#subCatForm', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_product_family/add_sub_category'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=="success"){
            	$("#subCatForm").find("input[type='text']").val("");
            	loadSubCat();
            }
        }
    });   
});
$(document).on('submit', '#itmForm', function(event){ 
    event.preventDefault();  
    $.ajax({  
        url:"<?php echo base_url('elecxtra_admin/admin_product_family/add_item'); ?>", 
        method:'POST',  
        data:new FormData(this),
        dataType: 'JSON',
        contentType:false,  
        processData:false,  
        success:function(data){
            webinaToast({type: data.type, message: data.text});
            if(data.type=="success"){
            	$("#itmForm").find("input[type='text']").val("");
            	loadItem();
            }
        }
    });   
});
function loadCat(){
	$.ajax({
	    url:"<?php echo base_url('elecxtra_admin/admin_product_family/fetch_category'); ?>",
	    method:"POST",
	    data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>'},
	    dataType: "JSON",
	    success:function(data){
	    	var html='';
	        $.each(data, function(i, row) {
	        	html+='<li><input type="text" data-type="category" data-id="'+row.id+'" value="'+row.name+'" readonly="true"><i class="fas fa-trash text-danger delFullOfIt"></i><i class="fas fa-edit text-success edtTxtNdSv"></i></li>';
	        });
	        if(html.trim()==""){ html+='No category found!'; }           
	        $('#cat').html(html);
	        $('#cat').find("li input").trigger("click");
	    }
	});
}
$(document).on("click", ".select_ul li", function(){
	$(this).closest(".select_list").find("input[type='text']").val($(this).text());
	$(this).closest(".select_list").find("input[type='hidden']").val($(this).data("value"));
	$(this).closest(".select_ul").hide();
});
function loadSubCat(){
	$.ajax({
	    url:"<?php echo base_url('elecxtra_admin/admin_product_family/fetch_sub_category'); ?>",
	    method:"POST",
	    data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', cat_id:$("#subCatForm").find('input[name="cat_id"]').val()},
	    dataType: "JSON",
	    success:function(data){
	    	var html='';
	        $.each(data, function(i, row) {
	        	html+='<li><input type="text" data-type="sub_category" data-id="'+row.id+'" value="'+row.name+'" readonly="true"><i class="fas fa-trash text-danger delFullOfIt"></i><i class="fas fa-edit text-success edtTxtNdSv"></i></li>';
	        });  
	        if(html.trim()==""){ html+='No category found!'; }   
	        $('#subCat').html(html);
	    }
	});
}
function loadItem(){
	$.ajax({
	    url:"<?php echo base_url('elecxtra_admin/admin_product_family/fetch_item'); ?>",
	    method:"POST",
	    data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', sub_cat_id:$("#itmForm").find('input[name="sub_cat_id"]').val()},
	    dataType: "JSON",
	    success:function(data){
	    	var html='';
	        $.each(data, function(i, row) {
	        	html+='<li><input type="text" data-type="item" data-id="'+row.id+'" value="'+row.name+'" readonly="true"><i class="fas fa-trash text-danger delFullOfIt"></i><i class="fas fa-edit text-success edtTxtNdSv"></i></li>';
	        });
	        if(html.trim()==""){ html+='No sub category found!'; }
	        $('#itm').html(html);
	    }
	});
}
$(document).on('click', '#cat li input', function(){
	$("#subCatForm").find('input[name="cat_id"]').val($(this).data('id'));
	loadSubCat();
	$('#subCatForm').fadeIn();
	$('#itmForm').fadeOut();
	$('#itm').html("");
});
$(document).on('click', '#subCat li input', function(){
	$("#itmForm").find('input[name="sub_cat_id"]').val($(this).data('id'));
	loadItem();
    $('#itmForm').fadeIn();
    $('#itm').html("");
	$('#brndForm').fadeOut();
	$('#brnd').html("");
	$("#d_f_v_Holder").fadeOut();
});
$(document).on("click", "ul.listdata li", function(){
	$(this).siblings("li").removeClass("listActv");
	$(this).addClass("listActv");
});
$(document).on("click", "ul.listdata li .edtTxtNdSv", function(){
	var ths=$(this);
	if(ths.hasClass('fa-edit')){
		ths.closest("li").find("input").prop("readonly", false).focus();
		ths.removeClass('fa-edit text-success').addClass('fa-save text-primary');
	}else{
		if(ths.hasClass('fa-save')){
			$.ajax({
			    url:"<?php echo base_url('elecxtra_admin/admin_product_family/each_save_data'); ?>",
			    method:"POST",
			    data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', type:ths.closest("li").find("input").data('type'), id:ths.closest("li").find("input").data('id'), val:ths.closest("li").find("input").val()},
			    dataType: "JSON",
			    success:function(data){
			    	webinaToast({type: data.type, message: data.text});
			    	ths.closest("li").find("input").prop("readonly", true);
					ths.removeClass('fa-save text-primary').addClass('fa-edit text-success');
			    }
			});
		}
	}
});

$(document).on("click", "ul.listdata li .delFullOfIt", function(){
	var id=$(this).closest("li").find("input").data('id');
	var type=$(this).closest("li").find("input").data('type');
	$.ajax({
	    url:"<?php echo base_url('elecxtra_admin/admin_product_family/delete_check'); ?>",
	    method:"POST",
	    data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', type:type, id:id},
	    dataType: "JSON",
	    success:function(data){
	    	if(data.type=="success"){
	    		if(window.confirm("Are you sure to delete all "+data.products+" products and others retalted data parmanently?")){
	    			delete_parmanent(id, type);
	    		}
	    	}
	    }
	});
});
function delete_parmanent(id, type){
	$.ajax({
	    url:"<?php echo base_url('elecxtra_admin/admin_product_family/delete_parmanent'); ?>",
	    method:"POST",
	    data:{'<?php echo $csrfName; ?>':'<?php echo $csrfHash; ?>', id:id, type:type},
	    dataType: "JSON",
	    success:function(data){
	    	if(data.type=="success"){
	    		location.reload();
	    	}
	    }
	});
}



$(document).ready(function(){
	$('#subCatForm').hide();
	$('#itmForm').hide();
	loadCat();
});

/*/Search/*/
$(document).on("keyup", ".mySearch", function() {
	var value = $(this).val().toLowerCase();
	$(this).closest(".prod_family").find("ul").find("li").filter(function() {
		$(this).toggle($(this).find("input").val().toLowerCase().indexOf(value) > -1)
	});
});
</script>
</body>
</html>