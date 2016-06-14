var ext_contact = {
	$form: null,
	multiple_subjects: null,
	on_form_submit: function(event) {
		event.preventDefault();
		var $this = jQuery(this);
		var count = 0;
		wpAjax.invalidateForm( $this.find('.form-required').filter( function() {
			var error = jQuery('input:visible, select, textarea', this).val() == '';
			count += error ? 1 : 0;
			return error;
		} ) ).size();
		if( 0 == count ) {
			var data = {};
			jQuery('input[id^="subject-"]').each(function() {
				var $this = jQuery(this);
				if('checkbox' == $this.attr('type')) {
					if($this.filter(':checked').length) {
						data[$this.attr('id').replace('subject-', '')] = $this.val();
					}
				} else {
					data[$this.attr('id').replace('subject-', '')] = $this.val();
				}
			});
			data['to'] = jQuery('#subject-to').val();
			ext_contact_loading(true);
			jQuery.post($this.attr('action'), data, function(data) {
				ext_contact_loading(false);
				if(data.msg) {
					ext_contact_message(data.msg);
					if(ext_contact.multiple_subjects) {
						ext_contact_form_reset();
					} else {
						jQuery(".row-edit-link:first").click();
					}
				}
				if(data.result) {
					ext_contact_list_loading(true);
					ext_contact_list_update();
				}
			}, 'json');
		}
		return false;
	},
	on_add: function(event) {
		event.preventDefault();
		ext_contact_form_reset();
	},
	init: function () {
		ext_contact.$form = jQuery('#form-ext_contact-subject');
		ext_contact.$table = jQuery('.ext-list-table');
		ext_contact.multiple_subjects = "1" == ext_contact.$form.attr("data-multiple-subjects");

		ext_contact.$table.bind('extEmbed', ext_embed_list);
		ext_contact.$table.bind('extAfterPublish', function() {
			ext_contact_list_loading(true);
			ext_contact_list_update();
		});
		ext_embed_list();
		ext_contact.$form.submit(ext_contact.on_form_submit);

		jQuery('#ext_contact-button-add').click(ext_contact.on_add);

		if(!ext_contact.multiple_subjects) {
			jQuery(".row-edit-link:first").click();
		}
	}
};

function ext_contact_form_reset() {
	jQuery('input[id^="subject-"]:not(#subject-action, #subject-type, input[type="checkbox"])').val('');
	jQuery('input[type="checkbox"]').filter('input[id^="subject-"]').removeAttr('checked');
	jQuery('#subject-to').val('');
	jQuery('#ext-contact-title-edit').fadeOut(function() {
		jQuery('#ext-contact-title-add').show();
	});
}

function ext_contact_loading(status) {
	if(status) {
		jQuery('#ext-contact-loading').fadeIn();
	} else {
		jQuery('#ext-contact-loading').fadeOut();
	}
}

function ext_contact_list_loading(status) {
	if(status) {
		jQuery('#ext_contact-list-loading').fadeIn();
	} else {
		jQuery('#ext_contact-list-loading').fadeOut();
	}
}

function ext_contact_list_update() {
	jQuery('#ext_contact-list').load(jQuery('#link-list').val(), function() {
		ext_contact_list_loading(false);
		jQuery('.ext-list-table').trigger('extEmbed');
	});
}

function ext_contact_message(message) {
	var $message = jQuery('#message');
	$message.children().text(message);
	$message.fadeIn();
	setTimeout(jQuery.proxy(function() {
		this.fadeOut();
	}, $message), 8000);
}

function ext_embed_list() {
	jQuery('.row-edit-link').click(function(event) {
		$this = jQuery(this);
		event.preventDefault();
		ext_contact_loading(true);
		jQuery.get($this.attr('href'), function(data) {
			jQuery('#ext-contact-title-add').fadeOut(function() {
				jQuery('#ext-contact-title-edit').fadeIn();
			});
			ext_contact_loading(false);

			for(var i in data) {
				if('publish' == i) {
					if(data[i]) {
						jQuery('#subject-' + i).attr('checked', 'checked');
					} else {
						jQuery('#subject-' + i).removeAttr('checked');
					}
				} else {
					jQuery('#subject-' + i).val(data[i]);
				}
			}
		}, 'json');
	});
	jQuery('.row-delete-link').click(function(event) {
		event.preventDefault();
		ext_contact_list_loading(true);
		jQuery.get(jQuery(this).attr('href'), function(data) {
			if(data.result) {
				ext_contact_list_update();
			} else {
				alert(data.msg);
				ext_contact_list_loading(false);
			}
		}, 'json');
	});
}

jQuery(document).ready(function() {
	ext_contact.init();
});