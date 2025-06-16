function start() {
    $("#capaprogress").html(
        `<img src="/assets/img/loading01.svg" style="width:25px"/> cargando`
    );
    $("#loading-super").css("width", $(document).width());
    $("#loading-super").css("height", $(document).height());
    $("#loading-super").show();
    $("#loading-progress").show();
}

function stop() {
    window.setTimeout(() => {
        $("#capaprogress").empty();
        $("#loading-super").hide();
        $("#loading-progress").hide();
    }, 1000);
}



jQuery.ajaxSetup({ cache: !1 });

$().ready(function () {
    $(".uc-alert_close").click(function () {
        console.log('click');
        id = $(this).attr("data-id");
        $("#" + id).hide("slow");
    });

    $('.select2').select2({
        width: '100%'
    });

    $('#startdate').datepicker({
        changeMonth: true,
        changeYear: true,
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dateFormat: "yy-mm-dd",
        yearRange: "1950:2030",
    });
    $('#enddate').datepicker({
        changeMonth: true,
        changeYear: true,
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dateFormat: "yy-mm-dd",
        yearRange: "1950:2030"
    });
    $('.uc-date').datepicker({
        changeMonth: true,
        changeYear: true,
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dateFormat: "yy-mm-dd",
        yearRange: "1950:2030"
    });
});

/* drawer's */
document.addEventListener("DOMContentLoaded", function (e) {
    htmlCollection = document.getElementsByClassName('offcanvas');
    const arr = Array.prototype.slice.call(htmlCollection);
    arr.forEach(e => {
        e.addEventListener('show.bs.offcanvas', function () {
            $('.nav-link').one('focus', function (e) { $(this).blur(); });
        });
    });
});

