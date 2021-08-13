/**
 * @author Kishor Mali
 */

jQuery(document).ready(function(){
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	$(".judge-dlg").dialog({
		title : "Judge Dialog",
		modal : false,
		autoOpen : false,
		closeOnEscape : true,
		width : 700,
		height : 800
	});
	$(".judge-dlg").siblings(".ui-dialog-titlebar")
				   .prepend("<i class='fa fa-gavel' style='float: left;margin-top: 4px;margin-right: 4px;'></i>")
				   .parent()
				   .css('z-index', 1031);

	isJudgeGamesForCheck();
});

function isJudgeGamesForCheck(){
	$.post(baseURL + "isJudgeGamesForCheck", function(res){
		res = JSON.parse(res);
		if($(".alert-dlg").hasClass("ui-dialog-content"))
			$(".alert-dlg").dialog('destroy');
		if(res.isExist){
			$(".alert-dlg").html(`
				<h4>There are some games for waiting a judgement.</h4>
				<div align="right">
					<button class="btn btn-success" onclick="openJudgeDialog()"><i class="fa fa-gavel"></i> Judge</button>
				</div>
			`);
			$(".alert-dlg").dialog({
				title : "Warning",
				modal : false,
				closeOnEscape : true,
				show : "fadeIn",
				position: { my: 'right bottom', at: 'right bottom', of : window}
			});
			$(".alert-dlg").siblings(".ui-dialog-titlebar").prepend("<i class='fa fa-exclamation-triangle' style='float: left;margin-top: 4px;margin-right: 4px;'></i>")
		}
	});
}
function openJudgeDialog(){
	$(".judge-dlg").dialog("open");
	getOldestSubmittedChallenge();
}

function getOldestSubmittedChallenge(){
	$.get(baseURL + "getOldestSubmittedChallenge", function(res) {
		res = JSON.parse(res);
		let html = "";
		if(!res.data){
			html = `
				<div>
					<div class="successDiv"><h3>You judged all submitted challenges.</h3></div>
					<div class="controlDiv"><button class="btn btn-success" onclick="$('.judge-dlg').dialog('close')"><i class="fa fa-check"></i>OK</button></div>
				</div>
			`;
		}
		else{
			let info = res.data;
			let chg_result = info.chg_type == 1 ? `<img width="500px" src="${info.chg_result}"/>` : info.chg_result;
			html = `
				<div>
					<div class="teamInfo-div">
						<h3>${info.team_name}</h3>
					</div>
					<div class="challengeInfo-div">
						<div class="title">
							<span>${info.chg_name} - <i class="fa fa-star-o"></i> ${info.points} Points</span>
						</div>
						<div class="description">${info.puzzle_page}</div>
					</div>
					<table class="submittedInfo-div">
						<tr>
							<td colspan=2>
								<i class="fa fa-calendar"></i> Submitted Date: ${info.submitted}
							</td>
						</tr>
						<tr>
							<td><i class="fa fa-file-o"></i>&nbsp;&nbsp;Answer:</td>
							<td>${chg_result}</td>
						</tr>
						<tr>
							<td><i class="fa fa-star-o"></i> Points: </td>
							<td><input id="earned_points" type="number" value="0" max="${info.points}" min="0"/></td>
						</tr>
					</table>
					<div class="controlDiv">
						<button class="btn btn-success" onclick="clickJudgeBtn(${info.id})"><i class="fa fa-gavel"></i> Judge</button>
					</div>
				</div>
			`;
		}
		$(".judge-dlg").html(html);
	})
}
function clickJudgeBtn(chgResultId){
	if(!confirm("Are you sure?!"))
		return;
	let el = $("#earned_points");
    let points = $(el).val();
    let maxPoints = $(el).attr("max");
    if(parseInt(points) > parseInt(maxPoints)){
        alert(`Points should be ${maxPoints} at most!`);
        return;
    }
    let post_url = baseURL + "saveChallengePoints";
    $.post(
        post_url, { chgResultId: chgResultId, points: points }, 
        function(res) {
            getOldestSubmittedChallenge();
			isJudgeGamesForCheck();
        }
    );
}