function ext_base_embed_publish() {
	jQuery('.ext-list-table .publish-button a').click(function(event) {
		event.preventDefault();
		
		jQuery(this).hide();
		jQuery(this).prev().fadeIn();
		jQuery.get(jQuery(this).attr('href') + '&publish=' + (jQuery(this).hasClass('publish-on') ? '0' : '1'), jQuery.proxy(function(data) {
			if(data == '1') {
				this.removeClass('publish-off').addClass('publish-on');
			} else {
				this.removeClass('publish-on').addClass('publish-off');
			}
			this.fadeIn();
			this.prev().hide();
			jQuery('.ext-list-table').trigger('extAfterPublish');
		}, jQuery(this)));
	});

	if(jQuery.browser.msie && jQuery.browser.version < 10) {
		jQuery('input[placeholder]').focus(function() {
			var input = jQuery(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function() {
			var input = jQuery(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();

		jQuery('input[placeholder]').parents('form').submit(function() {
			jQuery(this).find('[placeholder]').each(function() {
				var input = jQuery(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			});
		});
	}
	jQuery('select.placeholder').change(function() {
		var $select = jQuery(this);
		if( '' == $select.children('[value="' + $select.val() + '"]').val() ) {
			$select.addClass('placeholder-selected');
		} else {
			$select.removeClass('placeholder-selected');
		}
	}).change();
}

jQuery(document).ready(function() {
	jQuery('.ext-list-table').bind('extEmbed', ext_base_embed_publish);
	ext_base_embed_publish();
});