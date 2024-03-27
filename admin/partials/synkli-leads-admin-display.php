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
            if (get_option('synkli_api_key') !== "" && get_option('synkli_api_key') !== false) {
            ?>
                <div class="synkli-activation--notice">
                    <h4 class="synkli-activation--notice-subtitle">Welcome to SYNKLI Leads Dashboard!</h4>
                    <h2 class="synkli-activation--notice-title">Congratulations on taking the first step towards effortless lead generation and management with SYNKLI Leads.</h2>
                    <p class="synkli-activation--notice-description">
                        SYNKLI Leads seamlessly integrates with SYNKLI CRM, ensuring that every lead captured through your WordPress website is synchronized in real-time, empowering you to nurture and convert leads with ease.
                        <br><br>
                        Explore the intuitive features, streamline your workflow, and maximize the potential of your website to capture and manage leads effectively.
                    </p>
                    <img class="synkli-activation--notice-bg-image" src="<?= dirname( plugin_dir_url( __FILE__ ) ) . '/images/synkli-logo-icon.png' ?>">
                </div>
            <?php
            }else{
            ?>
                <div class="synkli-activation--notice" style="background-image:url(<?= dirname( plugin_dir_url( __FILE__ ) ) . '/images/notice-bg.png' ?>);min-height: 320px;">
                    <h4 class="synkli-activation--notice-subtitle text-black">Setup!</h4>
                    <h2 class="synkli-activation--notice-title">Please set up the connection to Synkli in order to send leads to your Synkli account.</h2>
                    <a href="<?= admin_url() . '/admin.php?page=synkli-leads-connection' ?>" class="synkli-link-btn">Connect Now</a>
                </div>
            <?php    
            }
        ?>
    </div>
</div>
