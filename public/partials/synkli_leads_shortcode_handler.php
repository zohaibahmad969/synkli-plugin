<?php

	// Generate the HTML for the form
    $output = '<div class="' . (get_option("synkli_form_style_type") !== 'synkli-style-custom' ? 'synkli-form-container' : '') . ' '.get_option("synkli_form_style_type").' ">';

	// Generate the HTML for the form
	$output .= '<form method="post" id="synkli_leads_form" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	$output .= '<h2 class="synkli-form-title">Contact <span>Us</span></h2>';
	$output .= '<p class="synkli-form-description">We would love to hear from you! Please fill out the form below, and we will get back to you as soon as possible.</p>';
	$output .= '<input type="hidden" id="synkli_api_key" name="api_key" value="'.get_option("synkli_api_key").'">';
	
	$output .= '<div class="synkli-form-fields-wrap">';


	$output .= '<div class="synkli-form-field-group">';

	// First Name
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="first_name">First Name:</label>';
	$output .= '<input type="text" name="first_name" id="first_name" required>';
	$output .= '</div>';
	
	// Last Name
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="last_name">Last Name:</label>';
	$output .= '<input type="text" name="last_name" id="last_name" required>';
	$output .= '</div>';

	$output .= '</div>';
	
	// Email
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="email">Email:</label>';
	$output .= '<input type="email" name="email" id="email" required>';
	$output .= '</div>';
	
	// Phone
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="phone">Phone:</label>';
	$output .= '<input type="tel" name="phone" id="phone" required>';
	$output .= '</div>';
	
	// Message
	$output .= '<div class="synkli-form-field">';
	$output .= '<label for="message">Message:</label>';
	$output .= '<textarea name="message" id="message" required></textarea>';
	$output .= '</div>';
	
	// Submit Button
	$output .= '<div class="synkli-form-field synkli-form-field-submit-btn-wrap">';
	$output .= '<input type="submit" value="Submit">';
	$output .= '</div>';

	$output .= '<div class="synkli-form-messages">';
	$output .= '<p class="synkli-form-success-message">'.get_option("synkli_form_success_message", "Your data has been saved.").'</p>';
	$output .= '<p class="synkli-form-error-message">'.get_option("synkli_form_error_message", "Some error occured. Please try again.").'</p>';
	$output .= '</div>';
	
	$output .= '</form>';

    
    $output .= '</div>';


    $output .= '</div>';
	
    
	if(get_option('synkli_form_style_type') === 'synkli-style-custom'){
		$output .=  '<style>' . get_option('synkli_custom_css') . '</style>';
	}