$(function(){
	$('.iframe-lazy').each(function(){
		$(this).attr('src', $(this).attr('data-src'));
	});
});