<?php

/**
 * Provide a admin area view for the plugin
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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="synkli-wrap synkli-dashboard">
    <div class="synkli-header">
        <h2 class="synkli-header--title">Dashboard</h2>
        <!-- <p class="synkli-header--description">Synkli Capture dashboard area. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-capture-admin-navbar.php'; ?>
    </div>
    <div class="synkli-body">
        <?php
            if (get_option('synkli_api_key') !== "" && get_option('synkli_api_key') !== false) {
            ?>
                <div class="synkli-activation--notice">
                    <h4 class="synkli-activation--notice-subtitle">Welcome to SYNKLI Capture Dashboard!</h4>
                    <h2 class="synkli-activation--notice-title">Congratulations on taking the first step towards effortless lead generation and management with SYNKLI CAPTURE.</h2>
                    <p class="synkli-activation--notice-description">
                        SYNKLI Capture seamlessly integrates with SYNKLI CRM, ensuring that every lead captured through your WordPress website is synchronized in real-time, empowering you to nurture and convert leads with ease.
                        <br><br>
                        Explore the intuitive features, streamline your workflow, and maximize the potential of your website to capture and manage leads effectively.
                    </p>
                    <img class="synkli-activation--notice-bg-image" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) . '/images/synkli-logo-icon.png' ); ?>">
                </div>
            <?php
            }else{
            ?>
                <div class="synkli-activation--notice" style="background-image:url(<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) . '/images/notice-bg.png' ); ?>);min-height: 320px;">
                    <h4 class="synkli-activation--notice-subtitle text-black">Setup!</h4>
                    <h2 class="synkli-activation--notice-title">Please set up the connection to Synkli in order to send leads to your Synkli account.</h2>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-connection' ) ); ?>" class="synkli-link-btn">Connect Now</a>
                </div>
            <?php    
            }
        ?>
    </div>
</div>
