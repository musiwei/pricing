$(function()
{
	// When lose focus on input field
    $("input").blur(function()
    {
        var formElementId = $(this).attr('name');
        
        doValidation(formElementId);
    });
});

/*
 * Validate form with AJAX function
 * 
 * @author Siwei Mu
 * @param String id
 * @return void
 */
function doValidation(id)
{
    var url = 'login/validate';
    var data = {};
    $("input").each(function()
    {
        data[$(this).attr('name')] = $(this).val();
    });
    $.post(url,data,function(resp)
    {
        $("#"+id).parent().parent().find('.alert-sm').remove();
        
            $("#"+id).parent().parent().append(getErrorHtml(resp[id], id));
    },'json');
}

/*
 * Get server validation result, append to form
 * 
 * @author Siwei Mu
 * @param String formErrors
 * @param String id
 * @return void
 */
function getErrorHtml(formErrors , id)
{
	if (formErrors === undefined){
		// Enable submit button
		$("#submit").prop('type', 'submit');
		return null;
	} else{
		// Disable submit button
		$("#submit").prop('type', 'button');
		var o = '<div class="alert-sm alert-danger alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><ul class="fa-ul">';
	    for(errorKey in formErrors)
	    {
	        o += '<li><i class="fa-li fa fa-times"></i>' + formErrors[errorKey] + '</li>';
	    }
	    o += '</ul></div>';
	    return o;
	}
}