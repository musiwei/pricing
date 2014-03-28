jQuery(document).ready(function() {
	
	loadPasswordStrengthMeter("password", "result");
});

jQuery(document).ready(function() {
	
// validate signup form on keyup and submit
	$("#signupForm").validate({
		
		 highlight: function(element, errorClass, validClass) {
			    $(element).parent().addClass("has-error");
			  },
			  unhighlight: function(element, errorClass, validClass) {
			    $(element).parent().removeClass("has-error");
			  },
		
		rules: {
			first_name: "required",
			last_name: "required",
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6,
				maxlength: 100,
			},
			confirm_password: {
				required: true,
				minlength: 6,
				maxlength: 100,
				equalTo: "#password"
			},
			
			terms: {
				required: true
			},
			
		},
		messages: {
			first_name: "Please enter your first name",
			last_name: "Please enter your last name",
			email : {
				required : "Please provide a email address",
				email : "Please enter a valid email address"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Your password cannot exceed 100 characters"
			},
			confirm_password: {
				required : "Please confirm your password",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Your password cannot exceed 100 characters",
				equalTo: "Please enter the same password as above"
			},
			terms: ""
		}
	});
 });
//$(function()
//{
//	
//	$('.checkbox').change(function() {
//        if($(this).is(":checked")) {
//            $(this).val("I agree");
//        }else{
//        	$(this).val("");
//        }
//    });
//	
//
//	
//	// When lose focus on input field
//    $("input").blur(function()
//    {
//        var formElementId = $(this).attr('name');
//        
//        doValidation(formElementId);
//    });
//});
//
///*
// * Validate form with AJAX function
// * 
// * @author Siwei Mu
// * @param String id
// * @return void
// */
//function doValidation(id)
//{
//    var url = 'register/validate';
//    var data = {};
//    $("input").each(function()
//    {
//        data[$(this).attr('name')] = $(this).val();
//    });
//    $.post(url,data,function(resp)
//    {
//		// Enable submit only if form is valid
//    	if(resp.length == 0){
//    		// Enable submit button
//    		$("#submit").removeAttr('disabled');
//    	}else{
//    		// Disable submit button
//    		$("#submit").attr('disabled','disabled');
//    	}
//    	
//        $("#error-report").find('.alert-sm').remove();
//        // Disable highlight on input box
//        $("#" + id).parent().parent().removeClass("has-error");
//        
//        errorHtml = getErrorHtml(resp[id], id);
//        $("#error-report").append(errorHtml);
//        
//        // If there's errors, enable highlight on input box
//        if (errorHtml != null)
//			$("#" + id).parent().parent().addClass("has-error");
//    },'json');
//}
//
///*
// * Get server validation result, append to form
// * 
// * @author Siwei Mu
// * @param String formErrors
// * @param String id
// * @return void
// */
//function getErrorHtml(formErrors , id)
//{
//	if (formErrors === undefined){
//		
//		return null;
//	} else{
//		
//		var o = '<div class="alert-sm alert-danger alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><ul class="fa-ul">';
//	    for(errorKey in formErrors)
//	    {
//	        o += '<li><i class="fa-li fa fa-times"></i>' + formErrors[errorKey] + '</li>';
//	    }
//	    o += '</ul></div>';
//	    return o;
//	}
//}
//
//
