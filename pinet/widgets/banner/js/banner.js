$('.pinet_banner').each(function(){
	var self = $(this);
	var src = $(this).attr('src');
	var i = $(document.createElement('img'));
	i.load(function(){
		var img = $(this);
		var height = img.height();
		self.css({
			'background': 'url(' + src + ') center center no-repeat',
			'height': height
		});
		img.remove();
	});
	i.attr('src', src);
	i.css('display', 'none');
	$('body').append(i);
});
