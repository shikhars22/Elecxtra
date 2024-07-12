var base_url=$("#add_to_cart_script").data('base_url');
var csrfName=$("#add_to_cart_script").data('csrfname');
var csrfHash=$("#add_to_cart_script").data('csrfhash');
if(location.href.split("/").pop()=="cart"){
    var cartPage=true;
}else{
    var cartPage=false;
}
function out_of_stock(){
    webinaToast({type:"warning", message:"out of stock"});
}
function load_cart(){
    $.ajax({  
        url:base_url+"load-cart", 
        method:'POST',  
        data:{[csrfName]:csrfHash},
        dataType: 'JSON', 
        success:function(data){
            if(data.type=='success'){
                $("#load_cart").html(data.data);
            }
        }
    });
}
$(document).on("click", ".qty_down", function(){
    var qty=parseInt($(this).closest(".qty_holder").find("input").val());
    if(qty>1){
        $(this).closest(".qty_holder").find("input").val(qty-1);
        if(cartPage){
            update_cart($(this).closest(".qty_holder").data("cartdata"), (qty-1));
        }
    }else{
        if(cartPage){
            remove_cart_data($(this).closest(".qty_holder").data('cartdata'));
        }
    }
});
$(document).on("click", ".qty_up", function(){
    var qty=parseInt($(this).closest(".qty_holder").find("input").val());
    var maxstock=parseInt($(this).closest(".qty_holder").data('maxstock'));
    if(maxstock <= qty){
        webinaToast({type:"error", message:"Sorry we don't have any more stock for this item!"});
    }else{
        $(this).closest(".qty_holder").find("input").val(qty+1);
        if(cartPage){
            update_cart($(this).closest(".qty_holder").data("cartdata"), (qty+1));
        }   
    }
});
function add_to_wishlist(self){
    var grab_data=$(self).data('cartdata');
    $.ajax({  
        url:base_url+"add-to-wishlist", 
        method:'POST',  
        data:{[csrfName]:csrfHash, grab_data:grab_data},
        dataType: 'JSON', 
        success:function(data){
            webinaToast({type:data.type, message:data.text});
        }
    });
}
function add_to_cart(self){
    var grab_data=$(self).data('cartdata');
    var qty=parseInt($(self).closest(".add_cart_qty").find(".qty_holder").find("input").val());
    var maxstock=parseInt($(self).closest(".add_cart_qty").find(".qty_holder").data('maxstock'));
    if(maxstock < qty){
        webinaToast({type:"error", message:"Sorry we don't have any more stock for this item!"});
    }else{
        $.ajax({
            url:base_url+"add-to-cart", 
            method:'POST',  
            data:{[csrfName]:csrfHash, grab_data:grab_data, qty:qty},
            dataType: 'JSON', 
            success:function(data){
                if(data.type=='success'){
                    if($(self).data('cartalert')=='no'){
                        $(self).closest('.add_cart_qty').append(
                            "<a href='"+base_url+"/cart' class='button_2 bg-success btn_100'>VIEW IN CART</a>"
                        );
                        $(self).closest('.add_cart_qty').find("[data-cartdata='"+grab_data+"']").remove();
                    }else{
                        webinaToast({type:data.type, message:data.text});
                    }
                    $(".cart_count").html(data.cart_count);
                    $(".cart_total").html(data.cart_total);
                    if($(self).data('buynow')=='yes'){
                        location.href=base_url+'/cart';
                    }
                }else{
                    webinaToast({type:data.type, message:data.text});
                }
            }
        });
    }
}
function update_cart(grab_data, qty){
    $.ajax({  
        url:base_url+"update-cart", 
        method:'POST',  
        data:{[csrfName]:csrfHash, grab_data:grab_data, qty:qty},
        dataType: 'JSON', 
        success:function(data){
            // webinaToast({type:data.type, message:data.text});
            if(data.type=='success'){
                load_cart();
                $(".cart_count").html(data.cart_count);
                $(".cart_total").html(data.cart_total);
            }
        }
    });
}
function remove_cart_data(grab_data){
    if(window.confirm("Are you sure to remove?")){
        $.ajax({  
            url:base_url+"remove-cart", 
            method:'POST',  
            data:{[csrfName]:csrfHash, grab_data:grab_data},
            dataType: 'JSON', 
            success:function(data){
                // webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    load_cart();
                    $(".cart_count").html(data.cart_count);
                    $(".cart_total").html(data.cart_total);
                }
            }
        });   
    }
}
function remove_cart(self){
    remove_cart_data($(self).data('cartdata'));
}
function clear_cart(self){
    if(window.confirm("Are you sure to clear?")){
        var grab_data=$(self).data('cartdata');
        $.ajax({  
            url:base_url+"clear-cart", 
            method:'POST',  
            data:{[csrfName]:csrfHash, grab_data:grab_data},
            dataType: 'JSON', 
            success:function(data){
                // webinaToast({type:data.type, message:data.text});
                if(data.type=='success'){
                    load_cart();
                    $(".cart_count").html(data.cart_count);
                    $(".cart_total").html(data.cart_total);
                }
            }
        });
    }
};
