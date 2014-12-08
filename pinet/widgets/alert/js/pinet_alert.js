;(function($){
  	$.fn.alertMap = function(){
		var option = {
			indicator_template: '<ul class="nav indicator"></ul>',
			indicator_item_template: '<li><a class="indicator-item"></a></li>',
			indicator_container_height: 20,
			item_selector: '.alert-map-item'
		}

		this.each(function(){
			var self = $(this);
			var self_width = self.width();
			var self_height = self.height();
			var self_items = self.find(option.item_selector);
			var last_index = 0;
			var jq_document = $(document);
			var jq_document_scrollTop = jq_document.scrollTop();
			var interval = null;

			if(self_items.length < 2) {
				self_items.eq(0).show();
				return this;
			}

			self_items.eq(0).show();
			self.height(self_height + option.indicator_container_height);

			self.off('mousewheel').on('mousewheel', function(e){
				var index = last_index;
				if(e.deltaY < 0) {
					index++;
					if(index > self_items.length - 1) {
						index = 0;
					}
				}else if(e.deltaY > 0) {
					index--;
					if(index < 0) {
						index = self_items.length - 1;
					}  
				}
				changeAlert(index);
				return false;
			});

			var indicator = $(option.indicator_template);
			var indicator_items = [];

			for (var i = 0; i < self_items.length; i++) {
				indicator_items[i] = $(option.indicator_item_template);
				if(i == 0){
					indicator_items[i].addClass('active');
				}

				indicator_items[i].find('a').attr('item-index', i);
				indicator.append(indicator_items[i]);
			}

			self.append(indicator);
			var indicator_width = indicator.width();
			indicator.css('left', (self_width - indicator_width) / 2);

			indicator.on('click', '.indicator-item', function(e){
				var item = $(e.target);
				var index = $(e.target).attr('item-index');
				changeAlert(index);
			});

			self.on('mouseenter', function(){
				clearInterval(interval);
			});

			self.on('mouseleave', function(){
				interval = setInterval(function(){
					var index = last_index;
					index++;
					if(index > self_items.length - 1) {
						index = 0;
					}
					changeAlert(index);
				}, 6000);				
			}).trigger('mouseleave');

			function changeAlert(index) {
				indicator_items[last_index].removeClass('active');
				self_items.eq(last_index).fadeOut();

				self_items.eq(index).fadeIn();

				last_index = index;
				indicator_items[index].addClass('active');
			}

		});
	}
})(jQuery)