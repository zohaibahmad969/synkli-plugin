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


<div class="wrap synkli-admin-menu-page-wrap">
    <h2><?php echo __('Synkli Leads Settings', 'synkli-leads'); ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'synkli_leads_api_settings' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php echo __('Synkli API Key', 'synkli-leads'); ?></th>
                <td><input type="text" name="synkli_api_key" value="<?php echo esc_attr( get_option( 'synkli_api_key' ) ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Synkli Secret Key', 'synkli-leads'); ?></th>
                <td><input type="text" name="synkli_secret_key" value="<?php echo esc_attr( get_option( 'synkli_secret_key' ) ); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>