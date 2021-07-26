/**
 * File : addZoomAccount.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addZoomAccountForm = $("#addZoomAccount");
	
	var validator = addZoomAccountForm.validate({
		
		rules:{
			accountname :{ required : true },
		},
		messages:{
			accountname :{ required : "This field is required" },
		}
	});
});
