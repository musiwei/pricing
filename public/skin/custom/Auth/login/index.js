jQuery(document).ready(function() {
	// validate signup form on keyup and submit
	$("#loginForm").validate({
		highlight : function(element, errorClass, validClass) {
			$(element).parent().parent().addClass("has-error");
		},
		unhighlight : function(element, errorClass, validClass) {
			$(element).parent().parent().removeClass("has-error");
		},

		errorPlacement : function(error, element) {
			error.appendTo(element.parent().parent());
		},

		rules : {
			email : {
				required : true,
				email : true
			},
			password : {
				required : true
			},

		},
		messages : {
			email : {
				required : "Please provide a email address",
				email : "Please enter a valid email address"
			},
			password : {
				required : "Please provide a password"
			},
		}
	});
});

// $(function()
// {
//	
// // When click on input field
// $("input").click(function() {
// var formElementId = $(this).attr('name');
//
// doValidation(formElementId);
// });
//	
// // When lose focus on input field
// $("input").blur(function()
// {
// var formElementId = $(this).attr('name');
//        
// doValidation(formElementId);
// });
// });
//
// /*
// * Validate form with AJAX function
// *
// * @author Siwei Mu
// * @param String id
// * @return void
// */
// function doValidation(id) {
// var url = 'login/validate';
// var data = {};
// $("input").each(function() {
// data[$(this).attr('name')] = $(this).val();
// });
// $.post(url, data, function(resp) {
// // Enable submit only if form is valid
// if(resp.length == 0){
// // Enable submit button
// $("#submit").removeAttr('disabled');
// }else{
// // Disable submit button
// $("#submit").attr('disabled','disabled');
// }
//    	
// $("#error-report").find('.alert-sm').remove();
// // Disable highlight on input box
// $("#" + id).parent().parent().removeClass("has-error");
//        
// errorHtml = getErrorHtml(resp[id], id);
// $("#error-report").append(errorHtml);
//        
// // If there's errors, enable highlight on input box
// if (errorHtml != null)
// $("#" + id).parent().parent().addClass("has-error");
// }, 'json');
// }
//
// /*
// * Get server validation result, append to form
// *
// * @author Siwei Mu @param String formErrors @param String id @return void
// */
// function getErrorHtml(formErrors , id)
// {
// if (formErrors === undefined){
//		
// return null;
// } else{
//		
// var o = '<div class="alert-sm alert-danger alert-dismissable animated
// fadeInDown"><button type="button" class="close" data-dismiss="alert"
// aria-hidden="true">×</button><ul class="fa-ul">';
// for(errorKey in formErrors)
// {
// o += '<li><i class="fa-li fa fa-times"></i>' + formErrors[errorKey] +
// '</li>';
// }
// o += '</ul></div>';
// return o;
// }
// }
