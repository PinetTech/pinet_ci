$(function(){
	if($.isFunction($.fn.selectBoxIt)) {
		$("select").selectBoxIt();
	}
	if($.isFunction($.fn.jqBootstrapValidation)) {
    	$("input,select,textarea").not("[type=image],[type=submit],[type=file]").jqBootstrapValidation();
	}
	if($.isFunction($.fn.inputmask)) {
		$("input[data-inputmask]").not("[type=image],[type=submit],[type=file]").inputmask().addClass('pinet-input-mask');
	}
	if($.isFunction($.fn.pinet_cascadeSelect)) {
		$("select[data-rel]").each(function(){
			var self = $(this);
			var selectRels 		= [];
			var selectRelNames 	= '';
			var selectRelData 	= {
				"field": $(this).attr("name"),
				"detail": {}
			};

			selectRels = $(this).attr('data-rel').split(',');

			$.each(selectRels, function(i, rel){
				if ($.trim(rel) != "") {
					$rel = $('[name=' + rel + ']');
					console.log(selectRelData);
					var onRelSelectChange = function(e) {
						selectRelData['detail'][rel] = $rel.val();
						$.ajax({
							url: $(this).attr("url"),
							type: "GET",
							headers: {
								Pinet: "Select"
							},
							dataType: "json",
							data: selectRelData
						}).done(function(data){
							var selectBox = self.data("selectBox-selectBoxIt");
							selectBox.destroy();
							console.log('done');
							self.find('option').remove();
							$.each(data, function(i, option){
								if (i == -1) {
									self.prepend($('<option value=' + i +'>' + option + '</option>'));
								}
								else {
									self.append($('<option value=' + i +'>' + option + '</option>'));
								}
							});
							self.selectBoxIt();
						});
					}
					$rel.on("change", onRelSelectChange);
				};
			});

		});
	}
});
