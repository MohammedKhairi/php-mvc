const Arb={
    "close":"خروج",
    "accept":"تاكيد",
    "delete_message":"هل تريد متابعة حذف المحتوى",
    "delete_title":"حذف محتوى",
    "color":"اللون",
    "bg":"الخلفية",
    "format":"التنسيق",
    "fsize":"حجم الخط",
    
};
//
const Eng={
    "close":"Close",
    "accept":"Accept",
    "delete_message":" Are You Shore To Delete This Record ! ",
    "delete_title":"Deleted Record",
    "color":"Color",
    "bg":"Background",
    "format":"Format",
    "fsize":"Font Size",
};
var _Lang={};

//check if the secreen is mbile or ipad
if ($(window).width() < 980) {
    $('#main-wrapper').addClass('menu-toggle');
    $(".hamburger").addClass("is-active");
}
//sidebar toggle
$(document).on("click",".hamburger",function(){
    $(".hamburger").toggleClass("is-active");
    $("#main-wrapper").toggleClass("menu-toggle");
})

//show and hide sub menu of sidebar
$(document).on("click",".sidebar .metismenu li",function(e){
    // e.preventDefault();
    $(this).toggleClass('slided');
    // $(this).children("ul").slideToggle("open").siblings().removeClass('open');
})

//on hover show and hide the sidebar
$(document).on('mouseenter click','.menu-toggle .sidebar', function(e) {
    //do something
    // e.preventDefault();
    $("#main-wrapper").toggleClass("menu-hover");
});
$(document).on('mouseleave click','.menu-toggle .sidebar', function(e) {
    //do something
    // e.preventDefault();
    $("#main-wrapper").toggleClass("menu-hover");
});

//on load page using mode
$(document).ready(function (){
    // check local storage for theme setting
    if(localStorage.getItem("theme"))
    {
        $("body").attr("theme-mode",localStorage.getItem("theme"));
        $("#mode-icon").addClass("icon-"+("dark"==localStorage.getItem("theme")?"sun":"moon"));
    }
    else
    {
        $("body").attr("theme-mode","stander");
        $("#mode-icon").addClass("icon-moon");
    }    
    //set language array
    var dir = $("html").attr("dir");
    if(dir == "rtl")
    {
        _Lang=Arb;
    }
    else
    {
        _Lang=Eng;

    }
});
// change mode on click to mode-icon

$(document).on("click","#toggleMode",function(){
    var mode= $("body").attr("theme-mode");
    var revMode="dark"==mode?"stander":"dark";
    $("body").attr("theme-mode",revMode);
    $("#mode-icon").removeClass();
    $("#mode-icon").addClass("icon-"+("dark"==revMode?"sun":"moon"));
    localStorage.setItem("theme",revMode);
});
// Show and Hide dropdown
$(document).on("click",".dropdown",function(){
    $(this).children("div.dropdown-menu-c").toggleClass("show");
});
//deleted button alert
function DeleteBtnAlert($url="") {
    //alert($url);
    var html='';
    html+='<div class="modal" id="DeleteModal">';
    html+='  <div class="modal-dialog dropdown_menu_anm5">';
    html+='      <div class="modal-content-c">';
    html+='        <div class="modal-header">';
    html+='            <h5 class="modal-title" id="exampleModalLabel">'+_Lang.delete_title+'</h5>';
    html+='        </div>';
    html+='        <div class="modal-body">'+_Lang.delete_message;
    html+='        </div>';
    html+='        <div class="modal-footer">';
    html+='            <button type="button" class="btn btn-secondary  reject-delete">'+_Lang.close+'</button>';
    html+='            <button type="button" value='+$url+' class="btn btn-primary accept-delete">'+_Lang.accept+'</button>';
    html+='        </div>';
    html+='        </div>';
    html+='    </div>';
    html+='</div>';
    $('.modal_content').html(html);
    $("#DeleteModal").show();


}
$(document).on("click touch",".accept-delete",function(){
    var v=$(this).val();
    window.location=v;
});
$(document).on("click touch",".reject-delete",function(){
    $("#DeleteModal").hide();
    $('.modal_content').html("");
});
//Order bar 
$(document).on("click toch", ".order-btn , .order-close-btn", function () {
    $(".order-bar").toggleClass("order-bar-enabled");
});