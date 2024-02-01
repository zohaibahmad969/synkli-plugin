<?php

/**
 * Provide a admin area view for the plugin menu Style
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


<div class="wrap">
    <h2><?php echo __('Synkli Leads Style', 'synkli-leads'); ?></h2>
    <p><?php echo __('Choose a style for your Synkli Leads form:', 'synkli-leads'); ?></p>
    <form method="post" action="options.php">
        <?php settings_fields('synkli_leads_settings'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php echo __('Form Style', 'synkli-leads'); ?></th>
                <td>
                    <label>
                        <input type="radio" name="synkli_form_style_type" value="default-style" <?php checked(get_option('synkli_form_style_type'), 'default-style'); ?>>
                        <?php echo __('Default Style (A basic design of contact form with adaptive theme colors.)', 'synkli-leads'); ?>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="synkli_form_style_type" value="synkli-style-light" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-light'); ?>>
                        <?php echo __("Synkli Style (Light Version)", 'synkli-leads'); ?>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="synkli_form_style_type" value="synkli-style-dark" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-dark'); ?>>
                        <?php echo __("Synkli Style (Dark Version)", 'synkli-leads'); ?>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="synkli_form_style_type" value="custom-style" <?php checked(get_option('synkli_form_style_type'), 'custom-style'); ?>>
                        <?php echo __('Custom Style (Complete customisable form)', 'synkli-leads'); ?>
                    </label>
                </td>
            </tr>
        </table>
        
        <div id="custom-style-editor" <?php echo (get_option('synkli_form_style_type') === 'custom-style' ?  '' : 'style="display: none;"' ) ?>>
            <h3><?php echo __('Custom CSS Editor', 'synkli-leads'); ?></h3>
            <textarea id="css-editor" class="synkli-css-editor" name="synkli_custom_css"><?php echo esc_textarea(get_option('synkli_custom_css')); ?></textarea>
        </div>

        <?php submit_button(); ?>
    </form>
</div>