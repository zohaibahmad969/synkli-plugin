<?php

	// Generate the HTML for the form
    $output = '<div class="synkli-form-container">';

	// Generate the HTML for the form
	$output .= '<form method="post" id="synkli_leads_form" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	$output .= '<h2 style="text-align: center;">Synkli Form Leads</h2>';
	$output .= '<input type="hidden" name="action" value="synkli_submit_form">';
	$output .= '<input type="hidden" id="synkli_api_key" name="api_key" value="'.get_option("synkli_api_key").'">';
	$output .= '<input type="hidden" id="synkli_secret_key" name="secret_key" value="'.get_option("synkli_secret_key").'">';
	
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
	$output .= '<div class="synkli-form-field">';
	$output .= '<input type="submit" value="Submit">';
	$output .= '</div>';
	
	$output .= '</form>';

    
    $output .= '</div>';
	
    
	