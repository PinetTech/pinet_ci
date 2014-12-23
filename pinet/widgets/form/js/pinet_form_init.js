$(function(){
	if($.isFunction($.fn.selectBoxIt)) {
		$("select").each(function(){
			$(this).selectBoxIt();
		});
	}
	if($.isFunction($.fn.jqBootstrapValidation)) {
    	$("input,textarea").not("[type=image],[type=submit],[type=file]").jqBootstrapValidation();
	}
	if($.isFunction($.fn.inputmask)) {
		$("input[data-inputmask]").not("[type=image],[type=submit],[type=file]").inputmask().addClass('pinet-input-mask');
	}
	if($.isFunction($.fn.pinet_cascadeSelect)) {
		$("select").each(function() {
			$(this).data("dotrans", false);
		});

		$("[data-rel]").each(function(i){
			var self = $(this);
			var relName = self.attr("data-rel");
			$('[name=' + relName + ']').on("change", function(){
				var rel = $(this);
				var val = parseInt(rel.val());
				if (val > 0) {
					data = {};
					data[relName] = val;
				}
				else {
					data = {};
					data[relName] = -1;
				}
				self.changeValue(data);
				self.trigger("change");
			})
		});

		$.fn.changeValue = function(detail) {
			var self = $(this);
			var selectBox = self.data("selectBox-selectBoxIt");
			// self.find('option').remove();

			if (selectBox) {
				var selectRelData 	= {
					"field": self.attr("name"),
					"detail": detail
				};

				$.ajax({
					url: self.attr("url"),
					type: "GET",
					headers: {
						Pinet: "Select"
					},
					dataType: "json",
					data: selectRelData
				}).done(function(data){
					// var dataLength = Object.keys(data).length;
					self.find('option').remove();
					// self.data("dotrans", true);
					// console.log(self.attr('name') );
					// console.log(data);
					// console.log(Object.keys(data).length);
					$.each(data, function(i, option){
							if (i == -1) {
								self.prepend($('<option value=' + i +'>' + option + '</option>'));
							}
							else {
								self.append($('<option value=' + i +'>' + option + '</option>'));
							}
					});
					selectBox.refresh();
				});
			};
		}


		// $("[name=province]").on("change", function(e){
		// 	var self = $(this);
		// 	var val = parseInt(self.val());
		// 	if (val > 0) {
		// 		$("[name=city]").changeValue({
		// 			province: self.val()
		// 		});
		// 		$("[name=city]").trigger("change");
		// 	}
		// });

		// $("[name=city]").on("change", function(e){
		// 	var self = $(this);
		// 	var val = parseInt(self.val());

		// 	if (val > 0) {
		// 		console.log("city " + self.val());
		// 		$("[name=area]").changeValue({
		// 			city: self.val()
		// 		});
		// 	};
		// });

	}
});
