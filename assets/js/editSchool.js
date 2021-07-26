/**
 * File : editSchool.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editSchoolForm = $("#editSchool");
	
	var validator = editSchoolForm.validate({
		rules:{
			schoollogo :{ required : true },
            schoolname :{ required : true },
            accountId :{ required : true },
            zoomlink :{ required : true }
		},
		messages:{
			schoollogo :{ required : "This field is required" },
            schoolname :{ required : "This field is required" },
            accountId :{ required : "This field is required" },
            zoomlink :{ required : "This field is required" }
		}
	});

});