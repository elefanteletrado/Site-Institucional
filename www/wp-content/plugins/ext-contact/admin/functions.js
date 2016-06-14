jQuery(document).ready(function() {
	jQuery('.ext_contact_email_link').click(function() {
		$this = jQuery(this);
		if('mailto' != $this.attr('href').substring(0, 6)) {
			jQuery.get($this.attr('href'), jQuery.proxy(function(data) {
				this.attr('href', data);
				window.location.href = data;
			}, $this));
			return false;
		}
	});
});