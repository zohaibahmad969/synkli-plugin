<?php

/**
 * Provide a admin area view for the plugin menu Style
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
        <h2 class="synkli-header--title">Style</h2>
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-capture-admin-navbar.php'; ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo esc_html__( 'Choose a style for your Synkli Capture form:', 'synkli-capture' ); ?></h3>
        <form method="post" action="options.php" class="synkli-form synkli-form-style">
            <?php settings_fields('synkli_capture_style_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <h3 class="synkli-form-table-th-title"><?php echo esc_html__( 'Form Style', 'synkli-capture' ); ?></h3>
                    </th>
                    <td>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-default" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-default'); ?>>
                            <?php echo esc_html__( 'Default Style (A basic design of contact form with adaptive theme colors.)', 'synkli-capture' ); ?>
                        </label>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-light" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-light'); ?>>
                            <?php echo esc_html__( "Synkli Style (Light Version)", 'synkli-capture' ); ?>
                        </label>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-dark" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-dark'); ?>>
                            <?php echo esc_html__( "Synkli Style (Dark Version)", 'synkli-capture' ); ?>
                        </label>
                        <label>
                            <input type="radio" name="synkli_form_style_type" value="synkli-style-custom" <?php checked(get_option('synkli_form_style_type'), 'synkli-style-custom'); ?>>
                            <?php echo esc_html__( 'Custom Style (Complete customisable form)', 'synkli-capture' ); ?>
                        </label>
                    </td>
                </tr>
                <tr scope="row"  id="custom-style-editor" <?php echo (get_option('synkli_form_style_type') === 'synkli-style-custom' ?  '' : 'style="display: none;"' ) ?>>
                    <th>
                        <h3 class="synkli-form-table-th-title"><?php echo esc_html__( 'Custom CSS Editor', 'synkli-capture' ); ?></h3>
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

