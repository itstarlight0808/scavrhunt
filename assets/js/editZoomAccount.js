/**
 * File : editZoomAccount.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editZoomAccountForm = $("#editZoomAccount");
	
	var validator = editZoomAccountForm.validate({
		
		rules:{
			accountname :{ required : true }
		},
		messages:{
			accountname :{ required : "This field is required" }
		}
	});

});