//  Author: Louis Holladay
//  Website: AdminDesigns.com
//  Last Updated: 01/01/14 
// 
//  This file is reserved for changes made by the user 
//  as it's often a good idea to seperate your work from 
//  the theme. It makes modifications, and future theme
//  updates much easier 
// 

//  Place custom styles below this line 
///////////////////////////////////////
jQuery(document).ready(function() {

	// Init Theme Core
	Core.init();

});

function loadPasswordStrengthMeter(passwordFieldId, resultFieldId) {

	$('#' + passwordFieldId).keyup(
			function() {
				$('#' + resultFieldId).html(
						checkStrength($('#' + passwordFieldId).val()));
			});

	function checkStrength(password) {

		// initial strength
		var strength = 0;

		// if the password length is less than 6, return message.
		if (password.length < 6) {
			$('#' + resultFieldId).removeClass();
			$('#' + resultFieldId).removeAttr("style");
			$('#' + resultFieldId).css("width", "10%");
			$('#' + resultFieldId).addClass('progress-bar progress-bar-danger');
			return '';
			// return 'Too short';
		}

		// length is ok, lets continue.

		// if length is 8 characters or more, increase strength value
		if (password.length > 7)
			strength += 1;

		// if password contains both lower and uppercase characters, increase
		// strength value
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
			strength += 1;

		// if it has numbers and characters, increase strength value
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))
			strength += 1;

		// if it has one special character, increase strength value
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))
			strength += 1;

		// if it has two special characters, increase strength value
		if (password
				.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/))
			strength += 1;

		// now we have calculated strength value, we can return messages

		// if value is less than 2
		if (strength < 2) {
			$('#' + resultFieldId).removeClass();
			$('#' + resultFieldId).removeAttr("style");
			$('#' + resultFieldId).css("width", "30%");
			$('#' + resultFieldId)
					.addClass('progress-bar progress-bar-warning');
			return '';
			// return 'Weak';
		} else if (strength >= 2 && strength <= 3) {
			$('#' + resultFieldId).removeClass();
			$('#' + resultFieldId).removeAttr("style");
			$('#' + resultFieldId).css("width", "55%");
			$('#' + resultFieldId)
					.addClass('progress-bar progress-bar-warning');
			return '';
			// return 'Good';
		} else if (strength == 4) {
			$('#' + resultFieldId).removeClass();
			$('#' + resultFieldId).removeAttr("style");
			$('#' + resultFieldId).css("width", "75%");
			$('#' + resultFieldId)
					.addClass('progress-bar progress-bar-success');
			return '';
		} else {
			$('#' + resultFieldId).removeClass();
			$('#' + resultFieldId).removeAttr("style");
			$('#' + resultFieldId).css("width", "100%");
			$('#' + resultFieldId)
					.addClass('progress-bar progress-bar-success');
			return '';
			// return 'Strong';
		}

	}

	$('#' + passwordFieldId).focus(function() {
		$("#password-strength-meter").show();
	});

	$('#' + passwordFieldId).blur(function() {
		$("#password-strength-meter").hide();
	});
}
