jQuery(document).ready(function($) {
    $('#synkli_leads_form').submit(function(event) {
        // Prevent the default form submission
        event.preventDefault();

		let crnt = $(this);
        var apiKey = crnt.find("#synkli_api_key").val();
		if (!apiKey) {
			alert('API key is missing');
			return;
		}


		$(".synkli-form-field-submit-btn-wrap").addClass('synkli-loader');

		// Sanitize form field values
		var formData = {};
		crnt.serializeArray().forEach(function(item) {
			formData[item.name] = item.value.replace(/<[^>]*>?/gm, '');
		});

		// Add the domain name to the formData object
		formData['domain'] = getDomainFromUrl(window.location.href);

		// AJAX request
		$.ajax({
			type: 'POST',
			url: 'https://a522-206-42-117-194.ngrok-free.app/api/third-party/lead/create',
			data: formData,
			dataType: 'json',
			headers: {
				'x-api-key' : apiKey
			},
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
					data: formData,
					dataType: 'json',
					success: function(response) {
						// Handle success response

						console.log('Email sent successfully:', response);
						// You can update the UI or show a success message here
						$(".synkli-form-field-submit-btn-wrap").removeClass('synkli-loader');
						$(".synkli-form-success-message").show();
						crnt.find("input[type='text'],input[type='email'],input[type='tel'], textarea").val('');
					},
					error: function(xhr, status, error) {
						// Handle error response

						console.error('Error:', error);
						// You can display an error message or handle the error as needed
						$(".synkli-form-field-submit-btn-wrap").removeClass('synkli-loader');
						$(".synkli-form-error-message").show();
					}
				});




			},
			error: function(error) {
				// Handle error response

				if(!error.responseText){
					$(".synkli-form-error-message").append('Synkli server is temporarily down.');
					return false;
				}
				// Handle error
				var errors = JSON.parse(error.responseText).errors;
				errors.forEach(function(errorMessage) {
					console.log(errorMessage);
					$(".synkli-form-error-message").append(errorMessage + '<br>');
				});
				$(".synkli-form-field-submit-btn-wrap").removeClass('synkli-loader');
				$(".synkli-form-error-message").show()
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