function addLoader() {
  $("body").append("<div style='position: fixed; top: 0; left: 0; right:0; bottom:0; z-index:99999999; display:grid; align-items:center; justify-content:center; background-color:#c0c0c038;' id='loader'><div class='spinner-border text-primary'></div></div>");
}
function removeLoader(ele){
  $(ele).remove();
}
$(document).on({
  ajaxStart: function(){
    addLoader();
  },
  ajaxStop: function(){
    removeLoader("#loader");
  }    
});

/****For all Form Inputs****/
/*Textarea Height*/
function calcHeight(value) {
    let numberOfLineBreaks = (value.match(/\n/g) || []).length;
    if (numberOfLineBreaks>=2 && numberOfLineBreaks<=12) {
        let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
        return newHeight;
    }
}

$(document).on("keyup", ".text_height", function(){
    $(this).css({"height" : calcHeight($(this).val()) + "px"});
});

/*Minimum Character*/
$(document).on("keyup, keydown", "._minChar", function(){
    $(this).prev("small").find("code").html("("+this.value.length+"/"+$(this).attr("maxlength")+")")
})
/****For all Form Inputs ends here****/

function alert_box_open(show_alert){
    $('.'+show_alert).css({"display" : "flex"});
}
function alert_box_close(){
    $('.alert_bg').css({"display" : "none"});
}
// $(window).on('click', function(e){
//     var close=document.getElementsByClassName('alert_bg')[0];
//     if(event.target==close){
//         alert_box_close();
//     }
// })

$(document).on('click', '.alert_cancel', function(){
    alert_box_close();
});

function copyTextData(ele) {
  var copyText = document.getElementById(ele);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
}

//Action Button Dropdown//
$(document).on("click", "._actionBox", function(){
    $("._actionList_open").not($(this).find("._actionList")).removeClass("_actionList_open")
    if ($(this).offset().top+$(this).height()+$(this).find("._actionList").height()>$(window).height()) {
        $(this).find("._actionList").css({"bottom" : "100%"});
    }else{ $(this).find("._actionList").css({"bottom" : "inherit"}); }
    $(this).find("._actionList").toggleClass("_actionList_open");
});

$(document).click(function(e){
    var container = $("._actionBox");
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    { container.find("._actionList").removeClass("_actionList_open"); }
});

;
