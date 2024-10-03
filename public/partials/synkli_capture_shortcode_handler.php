<?php


	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	// Generate the HTML for the form
    $output = '<div class="' . (get_option('synkli_form_style_type') !== 'synkli-style-custom' ? 'synkli-form-container ' : '') . esc_attr(get_option('synkli_form_style_type', '')) . '">';

	// Generate the HTML for the form
	$output .= '<form method="post" id="synkli_capture_form" action="' . esc_url(admin_url('admin-post.php')) . '">';
	$output .= '<h2 class="synkli-form-title">' . ( !empty(get_option("synkli_form_title")) ? esc_html(get_option("synkli_form_title")) : 'Contact <span>Us</span>' ) . '</h2>';
	$output .= '<p class="synkli-form-description">' . ( !empty(get_option("synkli_form_description")) ? esc_html(get_option("synkli_form_description")) : 'We would love to hear from you! Please fill out the form below, and we will get back to you as soon as possible.' ) . '</p>';
	$output .= '<input type="hidden" id="synkli_api_key" name="api_key" value="' . esc_attr(get_option("synkli_api_key")) . '">';

	
	
	// Capture nonce field output
	ob_start();
	wp_nonce_field( 'synkli_send_email', 'synkli_email_nonce' );
	$output .= ob_get_clean();
	
	$output .= '<div class="synkli-form-fields-wrap">';


	$output .= '<div class="synkli-form-field-group">';

	// First Name
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="first_name">First Name:</label>';
	$output .= '<input type="text" name="first_name" class="text-field-only" id="leadFirstName" maxlength="60" required>';
	$output .= '</div>';
	
	// Last Name
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="last_name">Last Name:</label>';
	$output .= '<input type="text" name="last_name" class="text-field-only" id="leadLastName" maxlength="60" required>';
	$output .= '</div>';

	$output .= '</div>';

	$output .= '<div class="synkli-form-email-phone-field-group">';

	// Email
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="email">Email:</label>';
	$output .= '<input type="email" name="email" id="leadEmail" class="email-field-only" maxlength="60" required>';
	$output .= '</div>';
	
	// Phone
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="phone">Phone:</label>';
	$output .= '<div class="phone-input-container">
					<div class="synkli-country-selector">
						<div class="synkli-country-code-wrapper">
							<img id="synkli-flag" src="https://flagcdn.com/w320/au.png" alt="Country Flag" class="synkli-flag">
							<input type="text" id="synkli-country-code" placeholder="+61" class="synkli-country-code" readonly>
						</div>
						<div class="synkli-country-list-wrapper">
							<div class="synkli-text-center">
							<input type="text" id="synkli-country-search" placeholder="Search here .." class="synkli-country-search">
							</div>
							<ul id="synkli-country-list" class="synkli-country-list">
							<!-- List will come from script -->
							</ul>
						</div>
						</div>
						<input type="text" name="phone_number" id="synkli-phone" class="synkli-phone-field-only" required placeholder="0 0000 0000" maxLength="9">
					</div>';
	$output .= '</div>';
	
	$output .= '</div>';

	// Message
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="message">Message:</label>';
	$output .= '<textarea name="message" id="leadMessage" class="textNumberString-field-only" maxlength="2000" required></textarea>';
	$output .= '</div>';

	// Synkli Messages
	$output .= '<div class="synkli-form-messages">';
	$output .= '<p class="synkli-form-success-message">' . ( !empty(get_option("synkli_form_success_message")) ? esc_html(get_option("synkli_form_success_message")) : 'Your data has been saved.' ) . '</p>';
	$output .= '<p class="synkli-form-error-message"></p>';
	$output .= '</div>';
	
	// Submit Button
	$output .= '<div class="synkli-form-field synkli-form-field-submit-btn-wrap">';
	$output .= '<input type="submit" value="Submit">';
	$output .= '</div>';
	
	$output .= '</form>';

    
    $output .= '</div>';


    $output .= '</div>';
