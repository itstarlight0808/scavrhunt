

function displayCounter(huntStatus, remainTime, huntInfo) {
    $("body").append("<div class='alert-dlg'></div>");
    huntStatus = huntStatus.toUpperCase();
    let msg = "";

    let html = `
    <div class="alert alert-danger alert-dismissible counter-dlg">
        <span href="#" class="close" data-dismiss="alert" aria-label="close">&times;</span>
        <strong>${msg}</strong>
    </div>`;
    $(".alert-dlg").append(html);
    
    if(huntStatus == "READY") {
        startCount(huntStatus, remainTime, huntInfo);
    }
    else if(huntStatus === "STARTED") {
        if(parseInt(remainTime/60) <= 30)
            startCount(huntStatus, remainTime, huntInfo);
        else {
            msg = `STARTED (${huntInfo.start_date}&nbsp;&nbsp;&nbsp;${huntInfo.start_time} - ${huntInfo.end_date}&nbsp;&nbsp;&nbsp;${huntInfo.end_time})`;
            $(".counter-dlg strong").html(msg);
        }
    }
    else {
        msg = `ENDED - Registration is closed for this event. (${huntInfo.start_date}&nbsp;&nbsp;&nbsp;${huntInfo.start_time} - ${huntInfo.end_date}&nbsp;&nbsp;&nbsp;${huntInfo.end_time})`;
        $(".counter-dlg strong").html(msg);
    }
    $(".counter-dlg").hide().fadeIn();
}
function startCount(huntStatus, remainTime, huntInfo) {
    setInterval(function() {
        remainTime--;
        let hms = new Date(remainTime*1000).toISOString().substr(11, 8);
        msg = `${huntStatus}&nbsp;&nbsp;${hms} (${huntInfo.start_date}&nbsp;&nbsp;&nbsp;${huntInfo.start_time} - ${huntInfo.end_date}&nbsp;&nbsp;&nbsp;${huntInfo.end_time})`;
        $(".counter-dlg strong").html(msg);
    }, 1000)
}
function displayError(msg) {
    if(!$(".alert-dlg").length)
        $("body").append("<div class='alert-dlg'></div>");
    $(".error-dlg[style*='display: none']").remove();

    let dlg_id = parseInt(Math.random()*10000);
    let error_html = `
        <div id="dlg_${dlg_id}" class="alert alert-danger alert-dismissible error-dlg">
            <span href="#" class="close" data-dismiss="alert" aria-label="close">&times;</span>
            <strong>${msg}. EST</strong>
        </div>`;
    $(".alert-dlg").append(error_html);
    $(`#dlg_${dlg_id}`).hide().fadeIn();
    setTimeout(function(){
        $(`#dlg_${dlg_id}`).fadeOut();
    }, 10000);
}
function displaySuccess(status, msg) {
    if(!$(".alert-dlg").length)
        $("body").append("<div class='alert-dlg'></div>");
    let html = `
        <div class="alert ${status ? 'alert-success' : 'alert-danger'} alert-dismissible success-dlg">
            <span href="#" class="close" data-dismiss="alert" aria-label="close">&times;</span>
            <strong>${msg}</strong>
        </div>`;
    $(".alert-dlg").append(html);
    $(`.success-dlg`).hide().fadeIn();
}
function startTeamGameCount(remainTime, huntInfo) {
    let html = `
        <div class="counter-dlg" style="margin-left: auto;width: 280px;">
            <span></span>
        </div>`;
    $(".navbar").append(html);
    
    setInterval(function() {
        remainTime--;
        let hms = new Date(remainTime*1000).toISOString().substr(11, 8);
        msg = `Times remaining : ${hms}`;
        $(".counter-dlg span").html(msg);
    }, 1000)
}