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
// display front-matter
function activityPop(pid) {
    if (pid) {
        $.ajax({
            url: "/",
            data: "ajax=titan&act=getProgram&p_id="+pid,
            type: "POST",
            cache: false,
            success: function(data){
                var ajaxObj = JSON.parse(data);
                if (ajaxObj.ajaxStatus) {
                    popUp(ajaxObj.returned[0].content);
                } else {

                }
            }
        });
    }
}

// popUp
function popUp(html) {
    // makes blur other than popUp
    $('body').addClass("activityBlurOn");

    // append front-matter content to the page
    $('body').append('<div id="htmlPopDiv"><div id="htmlPopBg"></div><div id="htmlPopWrapper"><div id="htmlPopCloseBtn"></div><div id="htmlPopMenuBar"><button class=\'btn activity-start\'>START ACTIVITY</button></div><div class="htmlPopContent">' + html + '</div></div></div>');

    // position box
    $("#htmlPopWrapper").css("background-color", "white");
    $("#htmlPopWrapper").css("left", "50%");
    $("#htmlPopWrapper").css("margin-left", "-" + ($("#htmlPopWrapper").outerWidth() / 2) + "px");
    $("#htmlPopWrapper").css("top", "50%");
    $("#htmlPopWrapper").css("margin-top", "-" + ($("#htmlPopWrapper").outerHeight() / 2) + "px");

    // resize position box
    $(window).resize(function () {
        $("#htmlPopWrapper").css("left", "50%");
        $("#htmlPopWrapper").css("margin-left", "-" + ($("#htmlPopWrapper").outerWidth() / 2) + "px");
        $("#htmlPopWrapper").css("margin-top", "-" + ($("#htmlPopWrapper").outerHeight() / 2) + "px");
    });

    // any actions
    $('#htmlPopCloseBtn, #htmlPopMenuBar button').click(function () {
        $('#htmlPopDiv').remove();
        $('body').removeClass("activityBlurOn");
        //window.location.href = rd;
    });

}