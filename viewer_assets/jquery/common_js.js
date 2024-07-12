function _open_loader(){
  // $("body").append("<div style='position: fixed; top: 45%; left: 45%; z-index:9999; opacity:1;' id='loader'><i class='fa fa-spinner fa-spin' style='font-size:50px'></i></div>");
  $("body").append("<div style='opacity:1; position: fixed; top: 0; left: 0; right:0; bottom:0; z-index:99999999; display:grid; align-items:center; justify-content:center; background-color:#c0c0c038;' id='loader'><div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div></div>");
}

$(document).on("click", "._showPassword", function(){
    var toggleType = $(this).prev("input").attr("type") == "text" ? "password" : "text";
    $(this).prev("input").attr("type", toggleType);
    $(this).toggleClass("fa-eye fa-eye-slash");
});

function read_toggle(self){
    $(self).prev(".read_toggle").toggleClass("clip_txt_8");
    $(self).text($(self).text() == 'Read More' ? 'Read Less' : 'Read More');
}
function _close_loader(){
  $("#loader").remove();
}
$(document).on({
  ajaxStart: function(){
    _open_loader();
  },
  ajaxStop: function(){
    _close_loader();
  }    
});;
