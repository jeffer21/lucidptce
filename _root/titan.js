/**
 * Created by DSong on 3/5/2018.
 * all async call return json
 *
 */

$(document).ready(function(){

    // get program detail
    $(".ajaxQuestionAnswer").click(function(){

    });


});




// program ID required to start
function activityPop(pid) {
    if (pid) {
        $.ajax({
            url: "/",
            data: "ajax=titan&act=getProgram&p_id="+pid,
            type: "POST",
            cache: false,
            success: function(data){
                var returnedObj = JSON.parse(data);

                if (returnedObj.status) {
                    console.log(returnedObj);
                } else {
                    
                }



            }
        });
    }
}

// popUp
function popUp(html) {
    $('body').append('<div id="contentPopDiv"><div id="contentPopBg"></div><div id="htmlPopContent"><div class="closeBtn"><div class="hamburgerLine"></div><div class="hamburgerLine"></div></div>' + html + '</div></div>');
    $("#htmlPopContent").css("background-color", "white");
    $("#htmlPopContent").css("left", "50%");
    $("#htmlPopContent").css("margin-left", "-" + ($("#htmlPopContent").outerWidth() / 2) + "px");
    $("#htmlPopContent").css("top", "50%");
    $("#htmlPopContent").css("margin-top", "-" + ($("#htmlPopContent").outerHeight() / 2) + "px");
    $("#htmlPopContent .popWrapper").css("max-height", ($("#htmlPopContent").height()) + "px");
    $('.headShotBar').css("left", ($('#htmlPopContent').width()-$('#htmlPopContent .headShotBar').width())/2);
    $(window).resize(function () {
        $("#htmlPopContent").css("left", "50%");
        $("#htmlPopContent").css("margin-left", "-" + ($("#htmlPopContent").outerWidth() / 2) + "px");
        $("#htmlPopContent").css("margin-top", "-" + ($("#htmlPopContent").outerHeight() / 2) + "px");
        $('.headShotBar').css("left", ($('#htmlPopContent').width()-$('#htmlPopContent .headShotBar').width())/2);
    });
    $('#contentPopBg, .closeBtn').click(function () {
        $('#contentPopDiv').remove();
    });
}