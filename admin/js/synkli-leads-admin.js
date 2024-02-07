jQuery(document).ready(function($) {
	$('input[name="synkli_form_style_type"]').change(function() {
		if ($(this).val() === 'synkli-style-custom') {
			$('#custom-style-editor').show();
			
		} else {
			$('#custom-style-editor').hide();
		}
	})
});