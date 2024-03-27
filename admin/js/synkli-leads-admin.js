jQuery(document).ready(function($) {
	$('input[name="synkli_form_style_type"]').change(function() {
		if ($(this).val() === 'synkli-style-custom') {
			$('#custom-style-editor').show();
			
		} else {
			$('#custom-style-editor').hide();
		}
	});

	$(".synkli-copy-btn").click(function(){
		// Get the element containing the text to copy
		var textToCopy = document.querySelector(".synkli-shortcode-box");
	
		// Check if the element exists
		if (textToCopy) {
			
			$(".synkli-copy-btn").text("Copied");
			window.setTimeout(function(){
				$(".synkli-copy-btn").text("Copy");
			}, 3000)

			// Create a range to select the text
			var range = document.createRange();
			range.selectNode(textToCopy);
	
			// Select the text within the range
			window.getSelection().removeAllRanges();
			window.getSelection().addRange(range);
	
			// Copy the selected text to the clipboard
			document.execCommand("copy");
	
			// Deselect the text
			window.getSelection().removeAllRanges();
		}
	});
	
});

