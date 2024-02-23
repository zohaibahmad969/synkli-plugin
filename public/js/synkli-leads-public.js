jQuery(document).ready(function($) {


	// Validations
	$("textarea.maxlength-textarea").on("input", function() {
		var maxLength = parseInt($(this).attr('maxlength'));
		var currentLength = $(this).val().length;
		var remainingLength = maxLength - currentLength;
		
		if (remainingLength >= 0) {
			$(".textarea-char-limit .charCount").text(currentLength);
		} else {
			// If the user exceeds the character limit, truncate the input
			var trimmedText = $(this).val().substr(0, maxLength);
			$(this).val(trimmedText);
		}
	});

	$(document).on('input', '.email-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression for email validation
		var emailRegex = /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
		// Regular expression to check for special characters other than "@"
		var specialCharRegex = /[^\w.+@-]/g;
		if (!emailRegex.test(inputValue) || specialCharRegex.test(inputValue)) {
			// Input does not match email pattern or contains invalid characters, remove them
			$(this).val(inputValue.replace(/[^\w.+@-]/g, ''));
		}
	});

	$(document).on('input', '.text-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression to allow only letters and spaces
		var textRegex = /^[a-zA-Z\s]*$/;
		if (!textRegex.test(inputValue)) {
			// Input contains invalid characters, remove them
			$(this).val(inputValue.replace(/[^a-zA-Z\s]/g, ''));
		}
	});


	$(document).on('input', '.phone-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression to allow only numbers and limit to 15 digits
		var regex = /^\d{0,15}$/;
		if (!regex.test(inputValue)) {
			// Input contains invalid characters or exceeds 15 digits, remove them
			$(this).val(inputValue.replace(/\D/g, '').substring(0, 15));
		}
	});

	var inputPhone = document.querySelectorAll(".phone-field-only");
	var iti_el = $('.iti.iti--allow-dropdown.iti--separate-dial-code');
	for(var i = 0; i < inputPhone.length; i++){
	      leadPhone = intlTelInput(inputPhone[i], {
	          autoHideDialCode: false,
	          autoPlaceholder: "aggressive" ,
	          initialCountry: "auto",
	          separateDialCode: true,
	          preferredCountries: ['ru','th'],
	          customPlaceholder:function(selectedCountryPlaceholder,selectedCountryData){
	              return ''+selectedCountryPlaceholder.replace(/[0-9]/g,'X');
	          },
	          geoIpLookup: function(callback) {
	              $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
	              var countryCode = (resp && resp.country) ? resp.country : "";
	                callback(countryCode);
	            });
	          },
	          utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js" // just for 
	      });
	    
	      $('.phone-field-only').on("focus click countrychange", function(e, countryData) {
	          var pl = $(this).attr('placeholder') + '';
	          var res = pl.replace( /X/g ,'9');
	          if(res != 'undefined'){
	              $(this).inputmask(res, {placeholder: "X", clearMaskOnLostFocus: true});
	          }
	      }); 
	}



	$(document).on('input', '.textNumber-field-only', function(e) {
		var inputValue = $(this).val();
		var keyCode = e.which || e.keyCode;
		
		// Check if the entered character is alphanumeric
		if (/^[a-zA-Z0-9]$/.test(inputValue)) {
			// Move focus to the next input field with class ".textNumber-field-only"
			$(this).next('.textNumber-field-only').focus();
		} else if (keyCode === 8) { // Backspace key
			// Move focus to the previous input field with class ".textNumber-field-only"
			$(this).prev('.textNumber-field-only').focus();
		} else {
			// Remove any invalid characters entered
			$(this).val('');
		}
	});

	$(document).on('input', '.textNumberString-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression to allow only letters, digits, and spaces
		var textNumberRegex = /^[a-zA-Z0-9\s]*$/;
		if (!textNumberRegex.test(inputValue)) {
			// Input contains invalid characters, remove them
			$(this).val(inputValue.replace(/[^a-zA-Z0-9\s]/g, ''));
		}
	});


    $('#synkli_leads_form').submit(function(event) {
        // Prevent the default form submission
        event.preventDefault();
		$(".synkli-form-error-message").html('');

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
			url: 'https://api.synkli.dev/api/third-party/lead/create',
			data: {
				"first_name": $("#leadFirstName").val(),
				"last_name": $("#leadLastName").val(),
				"phone_number": leadPhone.getNumber(),
				"email": $("#leadEmail").val(),
				"message": $("#leadMessage").val(),
			  },
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

						if(!error.responseText || error === undefined){
							$(".synkli-form-error-message").append("Synkli server is temporarily down.");
							return false;
						} 
							
						let errors = JSON.parse(error.responseText).errors;
						$(".synkli-form-error-message").html('');
						errors.forEach(function(errorMessage) {
							console.log(errorMessage); 
							$(".synkli-form-error-message").append(errorMessage + '<br>');
						});

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