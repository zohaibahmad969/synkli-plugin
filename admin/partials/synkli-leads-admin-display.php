<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://www.synkli.com
 * @since      1.0.0
 *
 * @package    Synkli_Leads
 * @subpackage Synkli_Leads/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="synkli-wrap synkli-dashboard">
    <div class="synkli-header">
        <h2 class="synkli-header--title">Dashboard</h2>
        <!-- <p class="synkli-header--description">Synkli leads dashboard area. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include(dirname (__FILE__) . '/synkli-leads-admin-navbar.php'); ?>
    </div>
    <div class="synkli-body">
        <?php
            if( get_option( 'synkli_api_key' ) !== "" ){
            ?>
                <div class="synkli-activation--notice">
                    <h4 class="synkli-activation--notice-subtitle">Congratulations!</h4>
                    <h2 class="synkli-activation--notice-title">Synkli is now activated and already working for you. Your website should be loading faster now!</h2>
                    <p class="synkli-activation--notice-description">
                        To guarantee fast websites, WP Rocket automatically applies 80% of web performance best practices. We also enable options that provide immediate benefits to your website.
                        <br><br>
                        Continue to the options to further optimize your site!
                    </p>
                    <img class="synkli-activation--notice-bg-image" src="<?= dirname( plugin_dir_url( __FILE__ ) ) . '/images/synkli-logo-icon.png' ?>">
                </div>
            <?php
            }else{
            ?>
                <div class="synkli-activation--notice" style="background-image:url(<?= dirname( plugin_dir_url( __FILE__ ) ) . '/images/notice-bg.png' ?>);min-height: 320px;">
                    <h4 class="synkli-activation--notice-subtitle text-black">Setup!</h4>
                    <h2 class="synkli-activation--notice-title">Please set up the connection to Synkli in order to send leads to our platform.</h2>
                    <a href="<?= admin_url() . '/admin.php?page=synkli-leads-connection' ?>" class="synkli-link-btn">Connect Now</a>
                </div>
            <?php    
            }
        ?>
    </div>
</div>
