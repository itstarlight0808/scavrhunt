/**
 * File : addSchool.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	var addSchoolForm = $("#addSchool");
	var validator = addSchoolForm.validate({	
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
