$(function(){
	if(typeof($.fn.picture) === 'function') { // If added the jquery picture, then picture all the figure
		$('figure, picture').ready(function(){
			$('figure, picture').picture();
		});
	}
	
	if((jQuery.browser && jQuery.browser.mobile) || $('body').width() < 1280) {
		$('body').addClass('mobile');
	}
	else {
		$('body').addClass('pc');
	}
});