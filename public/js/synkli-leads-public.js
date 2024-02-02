jQuery(document).ready(function($) {
    $('#synkli_leads_form').submit(function(event) {
        // Prevent the default form submission
        event.preventDefault();

		let crnt = $(this);

        // Your API key and secret key
        var apiKey = crnt.find("#synkli_api_key").val();
        var secretKey = crnt.find("#synkli_secret_key").val();

		// Check if apiKey or secretKey is empty
		if (!apiKey || !secretKey) {
			// Handle the case where either apiKey or secretKey is empty
			alert('API key or secret key is missing');
			return;
		}

		// Sanitize form field values
		var formData = {};
		crnt.serializeArray().forEach(function(item) {
			formData[item.name] = item.value.replace(/<[^>]*>?/gm, '');
		});

		// Add API key and secret key to the form data
		formData['api_key'] = apiKey;
		formData['secret_key'] = secretKey;

		// Add the domain name to the formData object
		formData['domain'] = getDomainFromUrl(window.location.href);

		// AJAX request
		$.ajax({
			type: 'POST',
			url: 'https://api.synkli.dev/api/users/external-contact-form',
			data: formData,
			dataType: 'json',
			success: function(response) {
				// Handle success response
				console.log('API call successful:', response);



				// Send user email about form submission
				formData = {};
				crnt.serializeArray().forEach(function(item) {
					formData[item.name] = item.value.replace(/<[^>]*>?/gm, '');
				});
				formData['action'] = 'synkli_send_email';

				$.ajax({
					type: 'POST',
					url: synkli_ajax.ajaxurl, // Use WordPress AJAX URL
					data: {
						formData
					},
					dataType: 'json',
					success: function(response) {
						// Handle success response
						console.log('Email sent successfully:', response);
						// You can update the UI or show a success message here
					},
					error: function(xhr, status, error) {
						// Handle error response
						console.error('Error:', error);
						// You can display an error message or handle the error as needed
					}
				});




			},
			error: function(xhr, status, error) {
				// Handle error response
				console.error('Error:', error);
				// You can display an error message or handle the error as needed
			}
		});

    });
});



// Function to get domain name from URL
function getDomainFromUrl(url) {
    var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
    if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0) {
        return match[2];
    } else {
        return null;
    }
}