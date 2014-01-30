 jQuery(document).ready(function() {

	// Init Theme Core 	  
	Core.init();
	
	// add class to body tag
	$( "body" ).addClass( "minimal error-page" );
	
	$('.icon-option-menu li a').click(function () {
		iconName = $(this).children('i').attr('class');	
		
	$('.error-icon span').removeClass('fadeIn animated').animate({
		opacity: 0
		}, 350,
		 function() {
			$(this).removeClass().addClass(iconName).animate({opacity: 1}, 350);
		});	
     });


 });