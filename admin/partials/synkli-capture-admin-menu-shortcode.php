<?php

/**
 * Provide a admin area view for the plugin menu Shortcode
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
        <h2 class="synkli-header--title">Shortcode</h2>
        <!-- <p class="synkli-header--description">Reach out to us anytime. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-capture-admin-navbar.php'; ?>
    </div>
    <p class="synkli-activation--notice-description">
        Here is your shortcode <span class="synkli-flexbox"><span class="synkli-shortcode-box">[synkli_capture_form]</span> <span class="synkli-copy-btn">Copy</span></span>
        <br>
        Use this shortcode to embed the Synkli Capture form on your page.
    </p>
</div>
