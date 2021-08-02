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

	isJudgeGamesForCheck();
});

function isJudgeGamesForCheck(){
	$.post(baseURL + "isJudgeGamesForCheck", function(res){
		res = JSON.parse(res);
		if(res.isExist){
			if($(".alert-dlg").hasClass("ui-dialog-content"))
				$(".alert-dlg").dialog('destroy');
			$(".alert-dlg").html(`<h4>There are some games for waiting a judgement.</h4>`)
			$(".alert-dlg").dialog({
				title : "Warning",
				modal : false,
				closeOnEscape : true,
				show : "fadeIn",
				position: { my: 'right bottom', at: 'right bottom', of : window}
			});
			$(".ui-dialog-titlebar").prepend("<i class='fa fa-exclamation-triangle' style='float: left;margin-top: 4px;margin-right: 4px;'></i>")
		}
	});
}