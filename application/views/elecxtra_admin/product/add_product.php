<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo site_title(); ?> | Admin | Add Product</title>
<?php echo $link_script; ?>
<body>
<?php echo $header; ?>
<?php echo $left_nav; ?>
<?php echo $right_nav; ?>
<section id="_wtBdySec" class="_wtThmSec">
	<div class="w-100 px-3">
		<h5 class="adminHead d_flex_evr m-0 py-3"><small class="fs_13">Admin / Add Product</small></h5>
	</div>

	<div class="_w_35 sticky_top">
		<div class="prodAdd ms-3">
			<h5 class="adminHead mb-3 p-0 fs_16">Product Family</h5>
			<form class="row prodInputs" id="globalFrm">
				<div class="col-lg-12 col-md-6 mb-3 d-none" style="display:none;">
					<label>Category *</label>
					<div class="select_list">
						<input type="hidden" name="cat_id">
						<input type="text" placeholder="Select Category">
						<ul class="select_ul _scrollDx">
						</ul>
						<div class="caret_down"><i class="fas fa-angle-down"></i></div>
					</div>
				</div>

				<div class="col-lg-12 col-md-6 mb-3">
					<label>Category *</label>
					<div class="select_list">
						<input type="hidden" name="sub_cat_id">
						<input type="text" placeholder="Select Category">
						<ul class="select_ul _scrollDx">
						</ul>
						<div class="caret_down"><i class="fas fa-angle-down"></i></div>
					</div>
				</div>

				<div class="col-lg-12 col-md-6 mb-3">
					<label>Sub Category *</label>
					<div class="select_list">
						<input type="hidden" name="item_id">
						<input type="text" placeholder="Select Sub Category">
						<ul class="select_ul _scrollDx">
						</ul>
						<div class="caret_down"><i class="fas fa-angle-down"></i></div>
					</div>
				</div>

				<div class="col-lg-12 col-md-6 d-none" style="display:none;">
					<input type="text" placeholder="Select Model" name="group_id" value="<?php echo time(); ?>">
				</div>

			</form>
		</div>
	</div>
					
	<div class="_w_65">
		<div class="bg-white mx-3">
			<h5 class="adminHead mb-0 p-3 fs_15 mb-1">Product Details</h5>
			<div id="shwFrm">
				<form class="addProductForm py-3">
					<input type="hidden" name="id">
					<input type="hidden" name="<?php echo $csrfName; ?>" value="<?php echo $csrfHash; ?>">
					<div class="px-3 prodInputs">
						<div class="row">
							<div class="col-12 mb-2">
		  						<label>Product Name* <code>(0/180)</code></label>
		  						<textarea class="_minChar" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit." maxlength="180" name="name" required></textarea>
		  					</div>
							<div class="col-12 mb-2">
		  						<label>Description <code>(0/255)</code></label>
		  						<textarea rows="3" class="text_height" placeholder="Add Description" name="description"></textarea>
		  					</div>
		  					<div class="col-lg-6 mb-2 d-none" style="display:none;">
		  						<label>SKU ID <span class="fs_10 txt_Green">(E.g. P00123)</span></label>
		  						<input type="text" name="sku">
		  					</div>
		  					<div class="col-lg-3 mb-2 d-none" style="display:none;">
		  						<label>Waranty <span class="fs_10 txt_Green">(E.g. 1 Year)</span></label>
		  						<input type="text" name="warranty">
		  					</div>
		  					<div class="col-lg-3 mb-2 d-none" style="display:none;">
		  						<label>Return In <span class="fs_10 txt_Green">(E.g. 7 Days)</span></label>
		  						<input type="number" name="return_day">
		  					</div>
						</div>
					</div>
					<hr class="hr">
					<div class="px-3 prodInputs">
						<div class="col-12">
							<h5 class="adminHead pt-0 fs_15 mb-1">Price & Stock</h5>
						</div>
						<div class="row prodInputs">
								<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
		  						<label>Price* <strike class="fs_10 txt_Green">(E.g. 100)</strike></label>
		  						<input type="number" step="0.01" name="price" required>
		  					</div>

		  					<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
		  						<label>Selling Price* <span class="fs_10 txt_Green commission"></span></label>
		  						<input type="number" step="0.01" name="sell_price" required readonly>
		  					</div>

		  					<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
		  						<label>Final Price* <span class="fs_10 txt_Green other_charge"></span></label>
		  						<input type="number" step="0.01" name="final_price" required readonly>
		  					</div>
						</div>
					</div>
					<hr class="hr">
					<div class="px-3 prodInputs">
						<div class="col-12">
							<h5 class="adminHead pt-0 fs_15 mb-1">General Feature</h5>
						</div>
						<div class="row prodInputs">
							<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
		  						<label>Manufacturer</label>
		  						<input type="text" name="manufacturer">
		  					</div>
		  					<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
		  						<label>Manufacturer Part Number</label>
		  						<input type="text" name="manufacturer_pro_num">
		  					</div>
		  					<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3 d-none" style="display:none;">
		  						<label>Manufacturer Standard Lead Time</label>
		  						<input type="text" name="manufacturer_lead_time">
		  					</div>
		  					<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-1 mb-2">
		  						<label>Stock*</label>
		  						<input type="number" name="stock" required>
		  					</div>
						</div>
					</div>
					<hr class="hr">
					<div class="px-3 prodInputs">
						<div class="col-12">
							<h5 class="adminHead pt-0 mb-0 fs_15 mb-1">Product Images</h5>
						</div>
						<div class="row prod_imgs pt-2">
							<div class="col-lg-5 imgClk">
								<div class="del_img"><i class="fas fa-trash"></i></div>
								<div class="prod_main_img">
									<img src="">
								</div>
								<input type="file" name="main_img" placeholder="Click to Upload Image">
							</div>
							<div class="col-lg-7">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-6 col-6 imgClk">
										<div class="del_img"><i class="fas fa-trash"></i></div>
										<div class="prod_other_img">
											<img src="">
										</div>
										<input type="file" placeholder="Click to Upload Image" name="1_img">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-6 imgClk">
										<div class="del_img"><i class="fas fa-trash"></i></div>
										<div class="prod_other_img">
											<img src="">
										</div>
										<input type="file" placeholder="Click to Upload Image" name="2_img">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-6 imgClk">
										<div class="del_img"><i class="fas fa-trash"></i></div>
										<div class="prod_other_img">
											<img src="">
										</div>
										<input type="file" placeholder="Click to Upload Image" name="3_img">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-6 imgClk">
										<div class="del_img"><i class="fas fa-trash"></i></div>
										<div class="prod_other_img">
											<img src="">
										</div>
										<input type="file" placeholder="Click to Upload Image" name="4_img">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-6 imgClk">
										<div class="del_img"><i class="fas fa-trash"></i></div>
										<div class="prod_other_img">
											<img src="">
										</div>
										<input type="file" placeholder="Click to Upload Image" name="5_img">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-6 imgClk">
										<div class="del_img"><i class="fas fa-trash"></i></div>
										<div class="prod_other_img">
											<img src="">
										</div>
										<input type="file" placeholder="Click to Upload Image" name="6_img">
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr class="hr">
					<div class="px-3 prodInputs">
						<div class="col-12">
							<h5 class="adminHead pt-0 fs_15 mb-1">Product Attachments</h5>
						</div>
						<div class="row prodInputs">
							<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
		  						<label>Add Attachments</label>
		  						<input type="file" name="attachments[]" multiple>
		  					</div>
						</div>
					</div>
					<hr class="hr">
					<div class="px-3 prodInputs">
						<div class="col-12">
							<h5 class="adminHead pt-0 fs_15 mb-1">Product Attributes</h5>
							<div class="row prodInputs">
								<div class="col-6 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
			  						<label>Attribute</label>
			  					</div>
			  					<div class="col-6 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
			  						<label>Value</label>
			  					</div>
							</div>
						</div>
						<div class="proAttr">
							<div class="row prodInputs attrLoop">
								<div class="col-5 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
			  						<input type="text" name="attr_name[]">
			  					</div>
			  					<div class="col-5 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
			  						<input type="text" name="attr_value[]">
			  					</div>
			  					<div class="col-2 mb-lg-1 mb-md-1 mb-sm-3 mb-3">
			  						<button type="button" class="btn btn-primary btn-sm" onclick="addAttr(this)">+</button>
			  						<button type="button" class="btn btn-warning btn-sm" onclick="delAttr(this)">-</button>
			  					</div>
							</div>
						</div>
					</div>
					<hr class="hr">
											
					<div class="px-3 prodInputs">
						<div class="col-12 text-end addMenuContnt">
	  						<button type="button" class="_wtBtnLg bg_theme_3 canCelFrm">CANCEL</button>
	  						<button type="submit" class="_wtBtnLg bg_theme_2">ADD</button>
	  					</div>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
var base_url="<?php echo base_url(); ?>";
var csrfName="<?php echo $csrfName; ?>";
var csrfHash="<?php echo $csrfHash; ?>";
var price_commission=JSON.parse('<?php echo price_commission(); ?>');

$(document).on("click", ".del_img", function(){
	if(window.confirm("Are you sure to remove?")){
		$(this).closest(".imgClk").find("img").attr("src", "");
		$(this).closest(".imgClk").find("input[type='file']").val("");
	}
});
$(document).on("change", ".addProductForm input[type='file']", function(e){
	$(this).closest(".imgClk").find("img").attr("src", URL.createObjectURL(e.target.files[0]));
});
$(document).on("submit", ".addProductForm", function(event){
	event.preventDefault();
	var getThis=$(this);
	var frmData = new FormData($(getThis)[0]);
	frmData.append('cat_id', $("#globalFrm").find("input[name='cat_id']").val());
	frmData.append('sub_cat_id', $("#globalFrm").find("input[name='sub_cat_id']").val());
	frmData.append('item_id', $("#globalFrm").find("input[name='item_id']").val());
	frmData.append('group_id', $("#globalFrm").find("input[name='group_id']").val());
	$.ajax({  
	    url:base_url+"/elecxtra_admin/Admin_product/add_product_data", 
	    method:'POST',  
	    data:frmData,
	    dataType: 'JSON', 
	    contentType: false, 
 			processData: false, 
	    success:function(data){
	    	webinaToast({type: data.type, message: data.text});
	        if(data.type=='success'){
	        	$("#globalFrm").find("input").prop('readonly', true);
	        	$("#globalFrm").find(".select_ul").remove();
	        	getThis.find('input[name="id"]').val(data.product_id);
	        	getThis.find('.addMenuContnt').hide();
	        }
	    }
	});
});

$(document).on("click", ".select_list input[type='text']", function(){
	$('.select_list').find("ul").not($(this).next("ul")).fadeOut();
	$(this).next("ul").toggle();
});
$(document).on("click", ".select_list .caret_down", function(){
	$(this).closest(".select_list").find("input[type='text']").trigger("click");
});
$(document).on("keyup", ".select_list input[type='text']", function(){
	var value = $(this).val().toLowerCase();
    $(this).next("ul").find("li").filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
$(document).on("click", ".select_ul li", function(){
	$(this).closest(".select_list").find("input[type='text']").val($(this).text());
	$(this).closest(".select_list").find("input[type='hidden']").val($(this).data("value"));
	$(this).closest(".select_ul").hide();
	if($(this).closest(".select_list").find("input[type='hidden']").attr('name')=="cat_id"){
		fetch_sub_cat($(this).data("value"));
	}
	if($(this).closest(".select_list").find("input[type='hidden']").attr('name')=="sub_cat_id"){
		fetch_item($(this).data("value"));
	}
});

function fetch_sub_cat(cat_id){
	var temp=$("#globalFrm [name='sub_cat_id']").closest('.select_list');
	temp.find("input").val("");
	temp.find(".select_ul").html("");
	$.ajax({  
        url:base_url+"/elecxtra_admin/Admin_product/fetch_sub_cat", 
        method:'POST',  
        data:{[csrfName]:csrfHash, cat_id:cat_id},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
            	temp.find(".select_ul").html(data.select_data);
            }
        }
    });
}
function fetch_item(sub_cat_id){
	var temp=$("#globalFrm [name='item_id']").closest('.select_list');
	temp.find("input").val("");
	temp.find(".select_ul").html("");
	$.ajax({  
        url:base_url+"/elecxtra_admin/Admin_product/fetch_item", 
        method:'POST',  
        data:{[csrfName]:csrfHash, sub_cat_id:sub_cat_id},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
            	temp.find(".select_ul").html(data.select_data);
            }
        }
    });
}
function fetch_cat(){
	var temp=$("#globalFrm [name='cat_id']").closest('.select_list');
	temp.find("input").val("");
	temp.find(".select_ul").html("");
	$.ajax({  
        url:base_url+"/elecxtra_admin/Admin_product/fetch_cat", 
        method:'POST',  
        data:{[csrfName]:csrfHash},
        dataType: 'JSON',
        success:function(data){
            if(data.type=='success'){
				temp.find(".select_ul").html(data.select_data);
				temp.find(".select_ul").find("li:first").trigger("click");
            }
        }
    });
}

function addAttr(self) {
	$(self).closest(".attrLoop").after($(self).closest(".attrLoop").clone());
}
function delAttr(self) {
	if($(self).closest(".addProductForm").find(".attrLoop").length>1){
		$(self).closest(".attrLoop").remove();
	}
}
$(document).on("keyup blur", ".addProductForm input[name='price']", function(){
	var price=parseFloat($(this).closest(".addProductForm").find("input[name='price']").val());
	for (var i = 0; i < price_commission.length; i++){
		if(price <= parseFloat(price_commission[i].max_price)){
			var other_charge=2;
			var comms=parseFloat(price_commission[i].commission);
			var webViewPrice=parseFloat(price+(price*comms/100)).toFixed(2);
			$(this).closest(".addProductForm").find("input[name='sell_price']").val(webViewPrice);
			$(this).closest(".addProductForm").find(".commission").html("("+comms+"% added!)");
			var finalPrice=(parseFloat(webViewPrice)+parseFloat(webViewPrice*other_charge/100)).toFixed(2);
			$(this).closest(".addProductForm").find("input[name='final_price']").val(finalPrice);
			$(this).closest(".addProductForm").find(".other_charge").html("("+other_charge+"% including all taxes!)");
			break;
		}
	}
});
$(document).ready(function(){
	fetch_cat();
});

</script>
</body>
</html>