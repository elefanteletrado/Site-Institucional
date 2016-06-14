jQuery(document).ready(function() {
	jQuery('#form-ext_base_recaptcha').submit(function(event) {
		var count = 0;
		wpAjax.invalidateForm( jQuery(this).find('.form-required').filter( function() {
			var error = jQuery('input:visible, select, textarea', this).val() == '';
			count += error ? 1 : 0;
			return error;
		} ) ).size();
		return count == 0;
	});
});