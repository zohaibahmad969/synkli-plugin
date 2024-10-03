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





	/************************************ 
	 * Phone Country code starts
	************************************/ 
	var $countryList = $('#synkli-country-list');
    countryData.forEach(function(country) {
      $countryList.append(
        `<li data-code="${country.code}" data-flag="${country.flag}" data-placeholder="${country.placeholder}" data-format="${country.format}">
          <img src="${country.flag}"  loading="lazy" width="18px"> ${country.name} (${country.code})
        </li>`
      );
    });


	// Show the dropdown when the country code wrapper is clicked
	$('.synkli-country-code-wrapper').on('click', function() {
	  $('.synkli-country-list-wrapper').slideDown();
	});
  
	// Hide the dropdown if clicked outside
	$(document).on('click', function(e) {
	  if (!$(e.target).closest('.synkli-country-selector').length) {
		$('.synkli-country-list-wrapper').slideUp();
	  }
	});
  
	// Filter the country list as you type
	$('#synkli-country-search').on('keyup', function() {
	  var value = $(this).val().toLowerCase();
	  $('#synkli-country-list li').each(function() {
		var text = $(this).text().toLowerCase();
		$(this).toggle(text.indexOf(value) > -1);
	  });
	});
  
	// When a country is selected
	$('#synkli-country-list').on('click', 'li', function() {
	  var countryCode = $(this).data('code');
	  var flagUrl = $(this).data('flag');
	  var placeholder = $(this).data('placeholder');
	  var format = $(this).data('format');
  
	  $('#synkli-flag').attr('src', flagUrl);
	  $('#synkli-country-code').val(countryCode);
	  $('#synkli-phone').attr('placeholder', placeholder);
	  $('.synkli-country-list-wrapper').slideUp();
	  $('#synkli-phone').data('format', format);
	  $('#synkli-phone').val("");
	  
	  // Count the number of 'X' characters in the format string
	  var digitCount = (format.match(/[\dX]/g) || []).length;

	  // Set maxlength to limit input to the exact number of digits
	  $('#synkli-phone').attr('maxlength', digitCount);

	  // Optional: Ensure the input is exactly the required length (validation on input)
	  $('#synkli-phone').on('input', function() {
		
		var format = $('#synkli-phone').data('format');
		var value = $('#synkli-phone').val().replace(/\D/g, ''); // Remove non-digit characters
		var requiredLength = (format.match(/[\dX]/g) || []).length;

		if (value.length !== requiredLength) {
			$('#synkli-phone').get(0).setCustomValidity('Phone number must be exactly ' + requiredLength + ' digits.');
		} else {
			$('#synkli-phone').get(0).setCustomValidity('');
		}

	  });

	});

	$('#synkli-country-list li[data-code="+61"]').click();  


	/************************************ 
	 * Phone Country code ends
	************************************/ 





	/************************************ 
	 * APi Call starts from here
	************************************/ 

    $(document).on('submit','#synkli_capture_form',function(event) {
        // Prevent the default form submission
        event.preventDefault();
		$(".synkli-form-error-message").html('');
		$(".synkli-form-success-message, .synkli-form-error-message").hide();

		let crnt = $(this);
        var apiKey = crnt.find("#synkli_api_key").val();
		if (!apiKey) {
			alert('API key is missing');
			return;
		}


		$(".synkli-form-field-submit-btn-wrap").addClass('synkli-loader');
        
	        // Disable button
	        $(".synkli-form-field-submit-btn-wrap input").attr("disabled","true");

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
			url: 'https://api.synkli.com.au/api/third-party/lead/create',
			data: {
				"first_name": $("#leadFirstName").val(),
				"last_name": $("#leadLastName").val(),
				"phone_number": $("#synkli-country-code").val() + $("#synkli-phone").val(),
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
				formData['phone_number'] = leadPhone.getNumber();

				$.ajax({
					type: 'POST',
					url: synkli_plugin_data.ajaxurl, // Use WordPress AJAX URL
					data: formData,
					dataType: 'json',
					success: function(response) {
						// Handle success response

						console.log('Email sent successfully:', response);
						// You can update the UI or show a success message here
						$(".synkli-form-field-submit-btn-wrap").removeClass('synkli-loader');
						$(".synkli-form-success-message").show();
						crnt.find("input[type='text'],input[type='email'],input[type='tel'], textarea").val('');
						
						// Enable Button
						$(".synkli-form-field-submit-btn-wrap input").removeAttr("disabled");
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


/************************************ 
	* APi Call ends here
************************************/ 


// Function to get domain name from URL
function getDomainFromUrl(url) {
    var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
    if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0) {
        return match[2];
    } else {
        return null;
    }
}










var countryData = [
	{ "name": "Afghanistan", "code": "+93", "flag": "https://flagcdn.com/w320/af.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Albania", "code": "+355", "flag": "https://flagcdn.com/w320/al.png", "placeholder": "6X XXX XXXX", "format": "6XXXXXXXX" },
	{ "name": "Algeria", "code": "+213", "flag": "https://flagcdn.com/w320/dz.png", "placeholder": "5X XXX XXXX", "format": "5XXXXXXXX" },
	{ "name": "Andorra", "code": "+376", "flag": "https://flagcdn.com/w320/ad.png", "placeholder": "3XX XXX", "format": "3XXXXXX" },
	{ "name": "Angola", "code": "+244", "flag": "https://flagcdn.com/w320/ao.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Argentina", "code": "+54", "flag": "https://flagcdn.com/w320/ar.png", "placeholder": "11 XXX XXXX", "format": "11XXXXXXXX" },
	{ "name": "Armenia", "code": "+374", "flag": "https://flagcdn.com/w320/am.png", "placeholder": "77 XXXXXXX", "format": "77XXXXXXX" },
	{ "name": "Australia", "code": "+61", "flag": "https://flagcdn.com/w320/au.png", "placeholder": "4XX XXX XXX", "format": "4XXXXXXXX" },
	{ "name": "Austria", "code": "+43", "flag": "https://flagcdn.com/w320/at.png", "placeholder": "6XX XXX XXXX", "format": "6XXXXXXXXX" },
	{ "name": "Azerbaijan", "code": "+994", "flag": "https://flagcdn.com/w320/az.png", "placeholder": "40X XXX XXXX", "format": "40XXXXXXXX" },
	{ "name": "Bahamas", "code": "+1", "flag": "https://flagcdn.com/w320/bs.png", "placeholder": "(242) XXX XXXX", "format": "(242)XXXXXXX" },
	{ "name": "Bahrain", "code": "+973", "flag": "https://flagcdn.com/w320/bh.png", "placeholder": "3XXX XXXX", "format": "3XXXXXXX" },
	{ "name": "Bangladesh", "code": "+880", "flag": "https://flagcdn.com/w320/bd.png", "placeholder": "1X XXX XXX", "format": "1XXXXXXX" },
	{ "name": "Barbados", "code": "+1", "flag": "https://flagcdn.com/w320/bb.png", "placeholder": "(246) XXX XXXX", "format": "(246)XXXXXXX" },
	{ "name": "Belarus", "code": "+375", "flag": "https://flagcdn.com/w320/by.png", "placeholder": "XX XXX XXXX", "format": "XXXXXXXXX" },
	{ "name": "Belgium", "code": "+32", "flag": "https://flagcdn.com/w320/be.png", "placeholder": "4XX XXX XXX", "format": "4XXXXXXXX" },
	{ "name": "Belize", "code": "+501", "flag": "https://flagcdn.com/w320/bz.png", "placeholder": "6XX XXXX", "format": "6XXXXXX" },
	{ "name": "Benin", "code": "+229", "flag": "https://flagcdn.com/w320/bj.png", "placeholder": "9X XX XX XX", "format": "9XXXXXXX" },
	{ "name": "Bhutan", "code": "+975", "flag": "https://flagcdn.com/w320/bt.png", "placeholder": "17X XXX XXX", "format": "17XXXXXXX" },
	{ "name": "Bolivia", "code": "+591", "flag": "https://flagcdn.com/w320/bo.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Bosnia and Herzegovina", "code": "+387", "flag": "https://flagcdn.com/w320/ba.png", "placeholder": "6X XXX XXX", "format": "6XXXXXXX" },
	{ "name": "Botswana", "code": "+267", "flag": "https://flagcdn.com/w320/bw.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Brazil", "code": "+55", "flag": "https://flagcdn.com/w320/br.png", "placeholder": "XX XXXX XXXX", "format": "XXXXXXXXXX" },
	{ "name": "Brunei", "code": "+673", "flag": "https://flagcdn.com/w320/bn.png", "placeholder": "XXX XXXX", "format": "XXXXXXX" },
	{ "name": "Bulgaria", "code": "+359", "flag": "https://flagcdn.com/w320/bg.png", "placeholder": "8X XXX XXX", "format": "8XXXXXXX" },
	{ "name": "Burkina Faso", "code": "+226", "flag": "https://flagcdn.com/w320/bf.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Burundi", "code": "+257", "flag": "https://flagcdn.com/w320/bi.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Cambodia", "code": "+855", "flag": "https://flagcdn.com/w320/kh.png", "placeholder": "1X XX XX XX", "format": "1XXXXXXX" },
	{ "name": "Cameroon", "code": "+237", "flag": "https://flagcdn.com/w320/cm.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Canada", "code": "+1", "flag": "https://flagcdn.com/w320/ca.png", "placeholder": "(XXX) XXX-XXXX", "format": "(XXX)XXX-XXXX" },
	{ "name": "Cape Verde", "code": "+238", "flag": "https://flagcdn.com/w320/cv.png", "placeholder": "9XX XX XX", "format": "9XXXXX" },
	{ "name": "Central African Republic", "code": "+236", "flag": "https://flagcdn.com/w320/cf.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Chad", "code": "+235", "flag": "https://flagcdn.com/w320/td.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Chile", "code": "+56", "flag": "https://flagcdn.com/w320/cl.png", "placeholder": "9 XXXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "China", "code": "+86", "flag": "https://flagcdn.com/w320/cn.png", "placeholder": "1X XXXX XXXX", "format": "1XXXXXXXXX" },
	{ "name": "Colombia", "code": "+57", "flag": "https://flagcdn.com/w320/co.png", "placeholder": "3XX XXX XXXX", "format": "3XXXXXXXXX" },
	{ "name": "Comoros", "code": "+269", "flag": "https://flagcdn.com/w320/km.png", "placeholder": "77 XX XX XX", "format": "77XXXXXXX" },
	{ "name": "Congo", "code": "+242", "flag": "https://flagcdn.com/w320/cg.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Costa Rica", "code": "+506", "flag": "https://flagcdn.com/w320/cr.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Croatia", "code": "+385", "flag": "https://flagcdn.com/w320/hr.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Cuba", "code": "+53", "flag": "https://flagcdn.com/w320/cu.png", "placeholder": "5X XXX XXX", "format": "5XXXXXXX" },
	{ "name": "Cyprus", "code": "+357", "flag": "https://flagcdn.com/w320/cy.png", "placeholder": "9X XX XX XX", "format": "9XXXXXXX" },
	{ "name": "Czech Republic", "code": "+420", "flag": "https://flagcdn.com/w320/cz.png", "placeholder": "6XX XXX XXX", "format": "6XXXXXXXXX" },
	{ "name": "Denmark", "code": "+45", "flag": "https://flagcdn.com/w320/dk.png", "placeholder": "2X XX XX XX", "format": "2XXXXXXX" },
	{ "name": "Djibouti", "code": "+253", "flag": "https://flagcdn.com/w320/dj.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Dominica", "code": "+1", "flag": "https://flagcdn.com/w320/dm.png", "placeholder": "(767) XXX XXXX", "format": "(767)XXXXXXX" },
	{ "name": "Dominican Republic", "code": "+1", "flag": "https://flagcdn.com/w320/do.png", "placeholder": "(809) XXX XXXX", "format": "(809)XXXXXXX" },
	{ "name": "Ecuador", "code": "+593", "flag": "https://flagcdn.com/w320/ec.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Egypt", "code": "+20", "flag": "https://flagcdn.com/w320/eg.png", "placeholder": "1X XXX XXXX", "format": "1XXXXXXXX" },
	{ "name": "El Salvador", "code": "+503", "flag": "https://flagcdn.com/w320/sv.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Equatorial Guinea", "code": "+240", "flag": "https://flagcdn.com/w320/gq.png", "placeholder": "2X XX XX XX", "format": "2XXXXXXX" },
	{ "name": "Eritrea", "code": "+291", "flag": "https://flagcdn.com/w320/er.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Estonia", "code": "+372", "flag": "https://flagcdn.com/w320/ee.png", "placeholder": "5X XXX XXX", "format": "5XXXXXXX" },
	{ "name": "Eswatini", "code": "+268", "flag": "https://flagcdn.com/w320/sz.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Ethiopia", "code": "+251", "flag": "https://flagcdn.com/w320/et.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Fiji", "code": "+679", "flag": "https://flagcdn.com/w320/fj.png", "placeholder": "XX XXX XXX", "format": "XXXXXXXX" },
	{ "name": "Finland", "code": "+358", "flag": "https://flagcdn.com/w320/fi.png", "placeholder": "4X XXX XXXX", "format": "4XXXXXXXX" },
	{ "name": "France", "code": "+33", "flag": "https://flagcdn.com/w320/fr.png", "placeholder": "6X XX XX XX XX", "format": "6XXXXXXXXXX" },
	{ "name": "Gabon", "code": "+241", "flag": "https://flagcdn.com/w320/ga.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Gambia", "code": "+220", "flag": "https://flagcdn.com/w320/gm.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Georgia", "code": "+995", "flag": "https://flagcdn.com/w320/ge.png", "placeholder": "5XX XXX XXX", "format": "5XXXXXXXX" },
	{ "name": "Germany", "code": "+49", "flag": "https://flagcdn.com/w320/de.png", "placeholder": "1XX XXXXXXX", "format": "1XXXXXXXX" },
	{ "name": "Ghana", "code": "+233", "flag": "https://flagcdn.com/w320/gh.png", "placeholder": "2X XXX XXXX", "format": "2XXXXXXXX" },
	{ "name": "Greece", "code": "+30", "flag": "https://flagcdn.com/w320/gr.png", "placeholder": "6X XXX XXXX", "format": "6XXXXXXXX" },
	{ "name": "Grenada", "code": "+1", "flag": "https://flagcdn.com/w320/gd.png", "placeholder": "(473) XXX XXXX", "format": "(473)XXXXXXX" },
	{ "name": "Guatemala", "code": "+502", "flag": "https://flagcdn.com/w320/gt.png", "placeholder": "5X XX XX XX", "format": "5XXXXXXX" },
	{ "name": "Guinea", "code": "+224", "flag": "https://flagcdn.com/w320/gn.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Guinea-Bissau", "code": "+245", "flag": "https://flagcdn.com/w320/gw.png", "placeholder": "5X XXX XXXX", "format": "5XXXXXXXX" },
	{ "name": "Guyana", "code": "+592", "flag": "https://flagcdn.com/w320/gy.png", "placeholder": "6XX XXXX", "format": "6XXXXXX" },
	{ "name": "Haiti", "code": "+509", "flag": "https://flagcdn.com/w320/ht.png", "placeholder": "3X XX XX XX", "format": "3XXXXXXX" },
	{ "name": "Honduras", "code": "+504", "flag": "https://flagcdn.com/w320/hn.png", "placeholder": "9X XX XX XX", "format": "9XXXXXXX" },
	{ "name": "Hungary", "code": "+36", "flag": "https://flagcdn.com/w320/hu.png", "placeholder": "20X XXX XXX", "format": "20XXXXXXX" },
	{ "name": "Iceland", "code": "+354", "flag": "https://flagcdn.com/w320/is.png", "placeholder": "6X XXX XXX", "format": "6XXXXXXX" },
	{ "name": "India", "code": "+91", "flag": "https://flagcdn.com/w320/in.png", "placeholder": "9X XX XXX XXX", "format": "9XXXXXXXXX" },
	{ "name": "Indonesia", "code": "+62", "flag": "https://flagcdn.com/w320/id.png", "placeholder": "8X XX XX XX", "format": "8XXXXXXX" },
	{ "name": "Iran", "code": "+98", "flag": "https://flagcdn.com/w320/ir.png", "placeholder": "9XX XXX XXXX", "format": "9XXXXXXXXX" },
	{ "name": "Iraq", "code": "+964", "flag": "https://flagcdn.com/w320/iq.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Ireland", "code": "+353", "flag": "https://flagcdn.com/w320/ie.png", "placeholder": "8X XXX XXXX", "format": "8XXXXXXXX" },
	{ "name": "Israel", "code": "+972", "flag": "https://flagcdn.com/w320/il.png", "placeholder": "5X XXX XXXX", "format": "5XXXXXXXX" },
	{ "name": "Italy", "code": "+39", "flag": "https://flagcdn.com/w320/it.png", "placeholder": "3X XXX XXXX", "format": "3XXXXXXXX" },
	{ "name": "Jamaica", "code": "+1", "flag": "https://flagcdn.com/w320/jm.png", "placeholder": "(876) XXX XXXX", "format": "(876)XXXXXXX" },
	{ "name": "Japan", "code": "+81", "flag": "https://flagcdn.com/w320/jp.png", "placeholder": "90X XXXX XXXX", "format": "90XXXXXXXX" },
	{ "name": "Jordan", "code": "+962", "flag": "https://flagcdn.com/w320/jo.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Kazakhstan", "code": "+7", "flag": "https://flagcdn.com/w320/kz.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Kenya", "code": "+254", "flag": "https://flagcdn.com/w320/ke.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Kiribati", "code": "+686", "flag": "https://flagcdn.com/w320/ki.png", "placeholder": "XX XXX", "format": "XXXXX" },
	{ "name": "Kuwait", "code": "+965", "flag": "https://flagcdn.com/w320/kw.png", "placeholder": "5X XX XX XX", "format": "5XXXXXXX" },
	{ "name": "Kyrgyzstan", "code": "+996", "flag": "https://flagcdn.com/w320/kg.png", "placeholder": "7XX XXX XXX", "format": "7XXXXXXXX" },
	{ "name": "Laos", "code": "+856", "flag": "https://flagcdn.com/w320/la.png", "placeholder": "20X XXX XXX", "format": "20XXXXXXX" },
	{ "name": "Latvia", "code": "+371", "flag": "https://flagcdn.com/w320/lv.png", "placeholder": "2X XXX XXX", "format": "2XXXXXXX" },
	{ "name": "Lebanon", "code": "+961", "flag": "https://flagcdn.com/w320/lb.png", "placeholder": "3X XXX XXX", "format": "3XXXXXXX" },
	{ "name": "Lesotho", "code": "+266", "flag": "https://flagcdn.com/w320/ls.png", "placeholder": "5X XX XX XX", "format": "5XXXXXXX" },
	{ "name": "Liberia", "code": "+231", "flag": "https://flagcdn.com/w320/lr.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Libya", "code": "+218", "flag": "https://flagcdn.com/w320/ly.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Liechtenstein", "code": "+423", "flag": "https://flagcdn.com/w320/li.png", "placeholder": "79X XXX XXX", "format": "79XXXXXXX" },
	{ "name": "Lithuania", "code": "+370", "flag": "https://flagcdn.com/w320/lt.png", "placeholder": "6X XXX XXX", "format": "6XXXXXXX" },
	{ "name": "Luxembourg", "code": "+352", "flag": "https://flagcdn.com/w320/lu.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Madagascar", "code": "+261", "flag": "https://flagcdn.com/w320/mg.png", "placeholder": "3X XX XX XX", "format": "3XXXXXXX" },
	{ "name": "Malawi", "code": "+265", "flag": "https://flagcdn.com/w320/mw.png", "placeholder": "XX XXXXXXX", "format": "XXXXXXXX" },
	{ "name": "Malaysia", "code": "+60", "flag": "https://flagcdn.com/w320/my.png", "placeholder": "1X XXX XXXX", "format": "1XXXXXXXX" },
	{ "name": "Maldives", "code": "+960", "flag": "https://flagcdn.com/w320/mv.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Mali", "code": "+223", "flag": "https://flagcdn.com/w320/ml.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Malta", "code": "+356", "flag": "https://flagcdn.com/w320/mt.png", "placeholder": "99XX XXXX", "format": "99XXXXXX" },
	{ "name": "Marshall Islands", "code": "+692", "flag": "https://flagcdn.com/w320/mh.png", "placeholder": "XXXXX", "format": "XXXXX" },
	{ "name": "Mauritania", "code": "+222", "flag": "https://flagcdn.com/w320/mr.png", "placeholder": "4X XX XX XX", "format": "4XXXXXXX" },
	{ "name": "Mauritius", "code": "+230", "flag": "https://flagcdn.com/w320/mu.png", "placeholder": "5X XX XX XX", "format": "5XXXXXXX" },
	{ "name": "Mexico", "code": "+52", "flag": "https://flagcdn.com/w320/mx.png", "placeholder": "1XX XXX XXXX", "format": "1XXXXXXXXX" },
	{ "name": "Micronesia", "code": "+691", "flag": "https://flagcdn.com/w320/fm.png", "placeholder": "XXXXX", "format": "XXXXX" },
	{ "name": "Moldova", "code": "+373", "flag": "https://flagcdn.com/w320/md.png", "placeholder": "6XX XXXX", "format": "6XXXXXX" },
	{ "name": "Monaco", "code": "+377", "flag": "https://flagcdn.com/w320/mc.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Mongolia", "code": "+976", "flag": "https://flagcdn.com/w320/mn.png", "placeholder": "8X XXX XXXX", "format": "8XXXXXXXX" },
	{ "name": "Montenegro", "code": "+382", "flag": "https://flagcdn.com/w320/me.png", "placeholder": "6X XXX XXX", "format": "6XXXXXXX" },
	{ "name": "Morocco", "code": "+212", "flag": "https://flagcdn.com/w320/ma.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Mozambique", "code": "+258", "flag": "https://flagcdn.com/w320/mz.png", "placeholder": "8X XXX XXX", "format": "8XXXXXXX" },
	{ "name": "Myanmar", "code": "+95", "flag": "https://flagcdn.com/w320/mm.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Namibia", "code": "+264", "flag": "https://flagcdn.com/w320/na.png", "placeholder": "8X XXX XXX", "format": "8XXXXXXX" },
	{ "name": "Nauru", "code": "+674", "flag": "https://flagcdn.com/w320/nr.png", "placeholder": "XXXXX", "format": "XXXXX" },
	{ "name": "Nepal", "code": "+977", "flag": "https://flagcdn.com/w320/np.png", "placeholder": "98X XXXX XXX", "format": "98XXXXXXXX" },
	{ "name": "Netherlands", "code": "+31", "flag": "https://flagcdn.com/w320/nl.png", "placeholder": "6X XXX XXXX", "format": "6XXXXXXXX" },
	{ "name": "New Zealand", "code": "+64", "flag": "https://flagcdn.com/w320/nz.png", "placeholder": "2X XXX XXXX", "format": "2XXXXXXXX" },
	{ "name": "Nicaragua", "code": "+505", "flag": "https://flagcdn.com/w320/ni.png", "placeholder": "8X XX XX XX", "format": "8XXXXXXX" },
	{ "name": "Niger", "code": "+227", "flag": "https://flagcdn.com/w320/ne.png", "placeholder": "9X XX XX XX", "format": "9XXXXXXX" },
	{ "name": "Nigeria", "code": "+234", "flag": "https://flagcdn.com/w320/ng.png", "placeholder": "8X XXX XXXX", "format": "8XXXXXXXX" },
	{ "name": "North Korea", "code": "+850", "flag": "https://flagcdn.com/w320/kp.png", "placeholder": "19X XXX XXX", "format": "19XXXXXXX" },
	{ "name": "North Macedonia", "code": "+389", "flag": "https://flagcdn.com/w320/mk.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Norway", "code": "+47", "flag": "https://flagcdn.com/w320/no.png", "placeholder": "4XX XX XXX", "format": "4XXXXXXX" },
	{ "name": "Oman", "code": "+968", "flag": "https://flagcdn.com/w320/om.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Pakistan", "code": "+92", "flag": "https://flagcdn.com/w320/pk.png", "placeholder": "3XX XXX XXXX", "format": "3XXXXXXXXX" },
	{ "name": "Palau", "code": "+680", "flag": "https://flagcdn.com/w320/pw.png", "placeholder": "XX XXX", "format": "XXXXX" },
	{ "name": "Palestine", "code": "+970", "flag": "https://flagcdn.com/w320/ps.png", "placeholder": "5X XXX XXXX", "format": "5XXXXXXXX" },
	{ "name": "Panama", "code": "+507", "flag": "https://flagcdn.com/w320/pa.png", "placeholder": "6X XX XX XX", "format": "6XXXXXXX" },
	{ "name": "Papua New Guinea", "code": "+675", "flag": "https://flagcdn.com/w320/pg.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Paraguay", "code": "+595", "flag": "https://flagcdn.com/w320/py.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Peru", "code": "+51", "flag": "https://flagcdn.com/w320/pe.png", "placeholder": "9XX XXX XXX", "format": "9XXXXXXXX" },
	{ "name": "Philippines", "code": "+63", "flag": "https://flagcdn.com/w320/ph.png", "placeholder": "9XX XXX XXXX", "format": "9XXXXXXXXX" },
	{ "name": "Poland", "code": "+48", "flag": "https://flagcdn.com/w320/pl.png", "placeholder": "5XX XXX XXX", "format": "5XXXXXXXX" },
	{ "name": "Portugal", "code": "+351", "flag": "https://flagcdn.com/w320/pt.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Qatar", "code": "+974", "flag": "https://flagcdn.com/w320/qa.png", "placeholder": "3X XX XX XX", "format": "3XXXXXXX" },
	{ "name": "Romania", "code": "+40", "flag": "https://flagcdn.com/w320/ro.png", "placeholder": "7X XX XXX XXX", "format": "7XXXXXXXXX" },
	{ "name": "Russia", "code": "+7", "flag": "https://flagcdn.com/w320/ru.png", "placeholder": "9XX XXX XXXX", "format": "9XXXXXXXXX" },
	{ "name": "Rwanda", "code": "+250", "flag": "https://flagcdn.com/w320/rw.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Saint Kitts and Nevis", "code": "+1", "flag": "https://flagcdn.com/w320/kn.png", "placeholder": "(869) XXX XXXX", "format": "(869)XXXXXXX" },
	{ "name": "Saint Lucia", "code": "+1", "flag": "https://flagcdn.com/w320/lc.png", "placeholder": "(758) XXX XXXX", "format": "(758)XXXXXXX" },
	{ "name": "Saint Vincent and the Grenadines", "code": "+1", "flag": "https://flagcdn.com/w320/vc.png", "placeholder": "(784) XXX XXXX", "format": "(784)XXXXXXX" },
	{ "name": "Samoa", "code": "+685", "flag": "https://flagcdn.com/w320/ws.png", "placeholder": "XX XXXX", "format": "XXXXXX" },
	{ "name": "San Marino", "code": "+378", "flag": "https://flagcdn.com/w320/sm.png", "placeholder": "54 XXXX XXXX", "format": "54XXXXXXXX" },
	{ "name": "Sao Tome and Principe", "code": "+239", "flag": "https://flagcdn.com/w320/st.png", "placeholder": "XX XXX", "format": "XXXXX" },
	{ "name": "Saudi Arabia", "code": "+966", "flag": "https://flagcdn.com/w320/sa.png", "placeholder": "5X XXX XXXX", "format": "5XXXXXXXX" },
	{ "name": "Senegal", "code": "+221", "flag": "https://flagcdn.com/w320/sn.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Serbia", "code": "+381", "flag": "https://flagcdn.com/w320/rs.png", "placeholder": "6X XXX XXXX", "format": "6XXXXXXXX" },
	{ "name": "Seychelles", "code": "+248", "flag": "https://flagcdn.com/w320/sc.png", "placeholder": "X XXX XXX", "format": "XXXXXXX" },
	{ "name": "Sierra Leone", "code": "+232", "flag": "https://flagcdn.com/w320/sl.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Singapore", "code": "+65", "flag": "https://flagcdn.com/w320/sg.png", "placeholder": "8XXX XXXX", "format": "8XXXXXXX" },
	{ "name": "Slovakia", "code": "+421", "flag": "https://flagcdn.com/w320/sk.png", "placeholder": "9XX XXX XXX", "format": "9XXXXXXXX" },
	{ "name": "Slovenia", "code": "+386", "flag": "https://flagcdn.com/w320/si.png", "placeholder": "3X XXX XXX", "format": "3XXXXXXX" },
	{ "name": "Solomon Islands", "code": "+677", "flag": "https://flagcdn.com/w320/sb.png", "placeholder": "XX XXX", "format": "XXXXX" },
	{ "name": "Somalia", "code": "+252", "flag": "https://flagcdn.com/w320/so.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "South Africa", "code": "+27", "flag": "https://flagcdn.com/w320/za.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "South Korea", "code": "+82", "flag": "https://flagcdn.com/w320/kr.png", "placeholder": "1X XX XXXX", "format": "1XXXXXXX" },
	{ "name": "South Sudan", "code": "+211", "flag": "https://flagcdn.com/w320/ss.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Spain", "code": "+34", "flag": "https://flagcdn.com/w320/es.png", "placeholder": "6X XXX XXXX", "format": "6XXXXXXXX" },
	{ "name": "Sri Lanka", "code": "+94", "flag": "https://flagcdn.com/w320/lk.png", "placeholder": "7X XX XX XX", "format": "7XXXXXXX" },
	{ "name": "Sudan", "code": "+249", "flag": "https://flagcdn.com/w320/sd.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Suriname", "code": "+597", "flag": "https://flagcdn.com/w320/sr.png", "placeholder": "8XX XXX", "format": "8XXXXX" },
	{ "name": "Sweden", "code": "+46", "flag": "https://flagcdn.com/w320/se.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Switzerland", "code": "+41", "flag": "https://flagcdn.com/w320/ch.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Syria", "code": "+963", "flag": "https://flagcdn.com/w320/sy.png", "placeholder": "9XX XXXX", "format": "9XXXXXX" },
	{ "name": "Taiwan", "code": "+886", "flag": "https://flagcdn.com/w320/tw.png", "placeholder": "9XX XXX XXX", "format": "9XXXXXXXX" },
	{ "name": "Tajikistan", "code": "+992", "flag": "https://flagcdn.com/w320/tj.png", "placeholder": "77X XX XX", "format": "77XXXXX" },
	{ "name": "Tanzania", "code": "+255", "flag": "https://flagcdn.com/w320/tz.png", "placeholder": "7X XXX XXXX", "format": "7XXXXXXXX" },
	{ "name": "Thailand", "code": "+66", "flag": "https://flagcdn.com/w320/th.png", "placeholder": "8X XXX XXXX", "format": "8XXXXXXXX" },
	{ "name": "Togo", "code": "+228", "flag": "https://flagcdn.com/w320/tg.png", "placeholder": "9X XX XX XX", "format": "9XXXXXXX" },
	{ "name": "Tonga", "code": "+676", "flag": "https://flagcdn.com/w320/to.png", "placeholder": "XXXXX", "format": "XXXXX" },
	{ "name": "Trinidad and Tobago", "code": "+1", "flag": "https://flagcdn.com/w320/tt.png", "placeholder": "(868) XXX XXXX", "format": "(868)XXXXXXX" },
	{ "name": "Tunisia", "code": "+216", "flag": "https://flagcdn.com/w320/tn.png", "placeholder": "2X XXX XXX", "format": "2XXXXXXX" },
	{ "name": "Turkey", "code": "+90", "flag": "https://flagcdn.com/w320/tr.png", "placeholder": "5X XX XX XX", "format": "5XXXXXXX" },
	{ "name": "Turkmenistan", "code": "+993", "flag": "https://flagcdn.com/w320/tm.png", "placeholder": "6X XXX XXX", "format": "6XXXXXXX" },
	{ "name": "Tuvalu", "code": "+688", "flag": "https://flagcdn.com/w320/tv.png", "placeholder": "XXXXX", "format": "XXXXX" },
	{ "name": "Uganda", "code": "+256", "flag": "https://flagcdn.com/w320/ug.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Ukraine", "code": "+380", "flag": "https://flagcdn.com/w320/ua.png", "placeholder": "39 XXX XX XX", "format": "39XXXXXXXX" },
	{ "name": "United Arab Emirates", "code": "+971", "flag": "https://flagcdn.com/w320/ae.png", "placeholder": "5X XXX XXXX", "format": "5XXXXXXXX" },
	{ "name": "United Kingdom", "code": "+44", "flag": "https://flagcdn.com/w320/gb.png", "placeholder": "7XXX XXX XXX", "format": "7XXXXXXXXX" },
	{ "name": "United States", "code": "+1", "flag": "https://flagcdn.com/w320/us.png", "placeholder": "(XXX) XXX XXXX", "format": "(XXX)XXXXXXX" },
	{ "name": "Uruguay", "code": "+598", "flag": "https://flagcdn.com/w320/uy.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Uzbekistan", "code": "+998", "flag": "https://flagcdn.com/w320/uz.png", "placeholder": "9X XXX XXXX", "format": "9XXXXXXXX" },
	{ "name": "Vanuatu", "code": "+678", "flag": "https://flagcdn.com/w320/vu.png", "placeholder": "XXXXX", "format": "XXXXX" },
	{ "name": "Vatican City", "code": "+39", "flag": "https://flagcdn.com/w320/va.png", "placeholder": "69 XX XX", "format": "69XXXX" },
	{ "name": "Venezuela", "code": "+58", "flag": "https://flagcdn.com/w320/ve.png", "placeholder": "4XX XXX XXXX", "format": "4XXXXXXXXX" },
	{ "name": "Vietnam", "code": "+84", "flag": "https://flagcdn.com/w320/vn.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Yemen", "code": "+967", "flag": "https://flagcdn.com/w320/ye.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" },
	{ "name": "Zambia", "code": "+260", "flag": "https://flagcdn.com/w320/zm.png", "placeholder": "9X XXX XXX", "format": "9XXXXXXX" },
	{ "name": "Zimbabwe", "code": "+263", "flag": "https://flagcdn.com/w320/zw.png", "placeholder": "7X XXX XXX", "format": "7XXXXXXX" }
] 
  