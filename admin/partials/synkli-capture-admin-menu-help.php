<?php

/**
 * Provide a admin area view for the plugin menu Dashboard
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.synkli.com.au
 * @since      1.0.0
 *
 * @package    Synkli_Capture
 * @subpackage Synkli_Capture/admin/partials
 */


 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
?>

<div class="synkli-wrap synkli-dashboard">
    <div class="synkli-header">
        <h2 class="synkli-header--title">Help</h2>
        <!-- <p class="synkli-header--description">Reach out to us anytime. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-capture-admin-navbar.php'; ?>
    </div>
    <p class="synkli-activation--notice-description">
        If you ever find yourself in need of assistance or have any questions, please don't hesitate to reach out to us. 
        <br><br>
        We're here to help! You can easily get in touch with us by visiting our website at <a href="https://synkli.com.au">https://synkli.com.au</a>. 
        <br><br>
        Whether you have inquiries about our products, need technical support, or have any other concerns, we're ready to assist you. Your satisfaction is our top priority, and we're committed to providing you with the best possible assistance
    </p>
</div>
