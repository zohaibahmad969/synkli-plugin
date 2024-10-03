<?php

/**
 * Provide a admin area view for the plugin menu Integration
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
        <h2 class="synkli-header--title">Connection</h2>
        <!-- <p class="synkli-header--description">Setup the Synkli connection to plugin. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-capture-admin-navbar.php'; ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo esc_html( __( 'Please enter the following details to setup the connection:', 'synkli-capture' ) ); ?></h3>
        <form method="post" action="options.php" class="synkli-form">
            <?php settings_fields( 'synkli_capture_api_settings' ); ?>
            <div class="form-group">
                <label><?php echo esc_html__( 'Synkli API Key', 'synkli-capture' ); ?></label>
                <input type="text" name="synkli_api_key" value="<?php echo esc_attr( get_option( 'synkli_api_key' ) ); ?>" />
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="submit" class="synkli-submit-btn" value="Save Changes">
            </div>
        </form>
    </div>
</div>
