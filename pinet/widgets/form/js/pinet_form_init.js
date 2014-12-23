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
		$('select').on('change', function() {
		})
	}
});
