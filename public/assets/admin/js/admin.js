//######Language Array#########
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
//############################
function  activeSidebar() {
    $("#open-sidebar").prop("checked", true);
    $(".sidebar").removeClass("toggled");
    $(".page-content").removeClass("toggled");
    $(".ds-container").removeClass("toggled");
}
function  disactiveSidebar() {
    $("#open-sidebar").prop("checked", false);
    $(".sidebar").addClass("toggled");
    $(".page-content").addClass("toggled");
    $(".ds-container").addClass("toggled");
}
$(document).ready(function (){
    // check local storage for theme setting
    if (localStorage.getItem("theme"))
    {
        $("body").addClass(localStorage.getItem("theme"));
        $("#"+localStorage.getItem("theme")).prop("checked", true);
    }
    else
    {
        var v="stander";
        $("#"+v).prop("checked", true);
        $("body").addClass(v);
        localStorage.setItem("theme", v);
    }
    //sidebar show
    if (localStorage.getItem("sidebar"))
    {
        if(1==localStorage.getItem("sidebar"))
            activeSidebar();
        else
            disactiveSidebar();
    }
    else
    {
        activeSidebar();
        localStorage.setItem("sidebar", 1);
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
// toggle theme when button is clicked
$(".toggle-theme").change(function () {
    
    if ($(this).is(":checked")) 
    {
        $(".toggle-theme").prop("checked", false)
        var v=$(this).val();
        $("#"+v).prop("checked", true);
    }
    else
    {
        var v="stander";
        $("#"+v).prop("checked", true);
    }
    $("body").removeClass().addClass(v);
    localStorage.setItem("theme", v);
});
//Toggle Sidebar open or close setting
$("#open-sidebar").change(function () {
    
    if ($(this).is(":checked")) 
    {
        activeSidebar();
        localStorage.setItem("sidebar", 1);
    }
    else
    {
        disactiveSidebar();
        localStorage.setItem("sidebar", 0);
    }
});
//Sidebar Sub slink
$('.sidebar-item').click(function () {
    $(this).toggleClass('slided');
    $(this).find("ul.sidebar-dropdown").slideToggle("open").siblings().removeClass('open');
});

//open and close sidebar
$(document).on("click toch", ".menu-btn-toggler", function () {
    // $(this).toggleClass("open");
    $(".sidebar").toggleClass("toggled");
    //    
    $(".page-content").toggleClass("toggled");
    //
    $(".ds-container").toggleClass("toggled");
    
});
$(document).on("click toch", ".dropdown", function () {
    $(this).find("ul.dropdown-menu").slideToggle("open").siblings().removeClass('open');
});
//Right Sidebar Setting
$(document).on("click toch", ".setting-btn , .setting-close-btn", function () {
    $(".end-bar").toggleClass("end-bar-enabled");
});
$(document).on("click toch", "#resetBtn", function () {
    localStorage.clear();
    location.reload();
});

//deleted button alert
function DeleteBtnAlert($url="") {
    //alert($url);
    var html='';
    html+='<div class="modal" id="DeleteModal">';
    html+='  <div class="modal-dialog">';
    html+='      <div class="modal-content">';
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