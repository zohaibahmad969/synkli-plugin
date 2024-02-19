<?php

/**
 * Provide a admin area view for the plugin menu Integration
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

<div class="synkli-wrap synkli-dashboard">
    <div class="synkli-header">
        <h2 class="synkli-header--title">Connection</h2>
        <!-- <p class="synkli-header--description">Setup the Synkli connection to plugin. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include(dirname (__FILE__) . '/synkli-leads-admin-navbar.php'); ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo __('Please enter the follwoing details to setup the connection:', 'synkli-leads'); ?></h3>
        <form method="post" action="options.php" class="synkli-form">
            <?php settings_fields( 'synkli_leads_api_settings' ); ?>
            <div class="form-group">
                <label><?php echo __('Synkli API Key', 'synkli-leads'); ?></label>
                <input type="text" name="synkli_api_key" value="<?php echo esc_attr( get_option( 'synkli_api_key' ) ); ?>" />
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="submit" class="synkli-submit-btn" value="Save Changes">
            </div>
        </form>
    </div>
</div>
