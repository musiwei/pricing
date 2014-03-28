jQuery(document).ready(function() {

	loadPasswordStrengthMeter("newPassword", "result");
});

jQuery(document).ready(function() {

	// validate signup form on keyup and submit
	$("#passwordUpdateForm").validate({
		
		highlight : function(element, errorClass, validClass) {
			$(element).parent().addClass("has-error");
		},
		unhighlight : function(element, errorClass, validClass) {
			$(element).parent().removeClass("has-error");
		},

		errorPlacement : function(error, element) {
			error.appendTo(element.parent());
		},

		rules : {
			currentPassword : "required",
			newPassword : {
				required : true,
				minlength : 6,
				maxlength : 100,
			},
			confirmPassword : {
				required : true,
				minlength : 6,
				maxlength : 100,
				equalTo : "#newPassword"
			},
		},
		messages : {
			currentPassword : "Please enter your current password",
			newPassword : {
				required : "Please provide a new password",
				minlength : "Your password must be at least 6 characters long",
				maxlength : "Your password cannot exceed 100 characters"
			},
			confirmPassword : {
				required : "Please confirm your new password",
				minlength : "Your password must be at least 6 characters long",
				maxlength : "Your password cannot exceed 100 characters",
				equalTo : "Please enter the same password as above"
			},
		}
	});
});