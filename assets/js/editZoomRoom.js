/**
 * File : editZoomRoom.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editZoomRoomForm = $("#editZoomRoom");
	
	var validator = editZoomRoomForm.validate({
		
		rules:{
			statusId :{ required : true }
		},
		messages:{
			statusId :{ required : "This field is required" }
		}
	});

});