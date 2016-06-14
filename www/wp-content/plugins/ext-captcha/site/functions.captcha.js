jQuery(document).ready(function() {
	jQuery('.ext-captcha-update').click(function(event) {
		event.preventDefault();
		
		var data = {'key': jQuery(this).data('key'), 'url_img': jQuery(this).data('url_img')};
		jQuery('#ext-captcha-img-update-' + data.key).show();
		jQuery('#ext-captcha-img-' + data.key).remove();
		jQuery.get(jQuery(this).data('url_key'), {id: jQuery('#input_siwp_captcha_id').val()}, jQuery.proxy(function(new_id) {
			jQuery('#input_siwp_captcha_id').val(new_id);
			
			var key = this.key;
			var url = this.url_img + '?id=' + new_id;
			var image = new Image();
			image.src = url;
			image.title = 'Imagem do captcha';
			image.alt = 'Imagem do captcha';
			image.id = 'ext-captcha-img-' + key;
			image.onload = function() {
				jQuery('#ext-captcha-img-update-' + key)
					.hide()
					.parent().append(image);
			};
		}, data));
	});
	jQuery('.ext-captcha-update').click();
});