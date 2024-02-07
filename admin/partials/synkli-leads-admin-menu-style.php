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


<div class="synkli-wrap synkli-dashboard">
    <div class="synkli-header">
        <h2 class="synkli-header--title">Style</h2>
        <!-- <p class="synkli-header--description"><?php echo __('Go ahead and change form style settings.', 'synkli-leads'); ?></p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include(dirname (__FILE__) . '/synkli-leads-admin-navbar.php'); ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo __('Choose a style for your Synkli Leads form:', 'synkli-leads'); ?></h3>
        <form method="post" action="options.php" class="synkli-form synkli-form-style">
            <?php settings_fields('synkli_leads_style_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <h3 class="synkli-form-table-th-title"><?php echo __('Form Style', 'synkli-leads'); ?></h3>
                        <p class="synkli-form-table-th-description"><?php echo __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'synkli-leads'); ?></p>
                    </th>
                    <td>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-default" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-default'); ?>>
                            <?php echo __('Default Style (A basic design of contact form with adaptive theme colors.)', 'synkli-leads'); ?>
                        </label>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-light" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-light'); ?>>
                            <?php echo __("Synkli Style (Light Version)", 'synkli-leads'); ?>
                        </label>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-dark" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-dark'); ?>>
                            <?php echo __("Synkli Style (Dark Version)", 'synkli-leads'); ?>
                        </label>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-custom" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-custom'); ?>>
                            <?php echo __('Custom Style (Complete customisable form)', 'synkli-leads'); ?>
                        </label>
                    </td>
                </tr>
                <tr scope="row"  id="custom-style-editor" <?php echo (get_option('synkli_form_style_type') === 'synkli-style-custom' ?  '' : 'style="display: none;"' ) ?>>
                    <th>
                        <h3 class="synkli-form-table-th-title"><?php echo __('Custom CSS Editor', 'synkli-leads'); ?></h3>
                    </th>
                    <td>
                    <textarea id="css-editor" class="synkli-css-editor" name="synkli_custom_css"><?php echo esc_textarea(get_option('synkli_custom_css')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td class="text-right">
                        <input type="submit" name="submit" id="submit" class="synkli-submit-btn" value="Save Changes">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

