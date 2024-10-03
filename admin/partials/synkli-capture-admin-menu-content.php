<?php

/**
 * Provide a admin area view for the plugin menu Content
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
        <h2 class="synkli-header--title">Content</h2>
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-capture-admin-navbar.php'; ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo esc_html__( 'You can change form title and short description here:', 'synkli-capture' ); ?></h3>
        <form method="post" action="options.php" class="synkli-form synkli-form-emails">
            <?php settings_fields('synkli_capture_content_settings'); ?>
            <div class="form-group">
                <label><?php echo esc_html__( 'Form Title', 'synkli-capture' ); ?></label>
                <td><input type="text" name="synkli_form_title" value="<?php echo esc_attr(get_option('synkli_form_title')); ?>" /></td>
            </div>
            <div class="form-group">
                <label><?php echo esc_html__( 'Form Description', 'synkli-capture' ); ?></label>
                <textarea name="synkli_form_description" rows="5"><?php echo esc_textarea(get_option('synkli_form_description')); ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="submit" class="synkli-submit-btn" value="Save Changes">
            </div>
        </form>
    </div>
</div>

