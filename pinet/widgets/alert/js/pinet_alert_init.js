jQuery(fuction(){
	if(!$('.messagesbar').hasClass('no-hide')) {
		setTimeout(function(){
			$(".messagesbar").fadeOut(500);
		},20000);
	}

	if(!$('.messagesbar').hasClass('no-hide')) {
		$(".messagesbar .yes").on('click', function(){
			$(".messagesbar").fadeOut(500);
		});
	}
})