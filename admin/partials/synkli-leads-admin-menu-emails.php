<?php

/**
 * Provide a admin area view for the plugin menu Emails
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
        <h2 class="synkli-header--title">Emails</h2>
        <!-- <p class="synkli-header--description">Synkli leads email settings. </p> -->
    </div>
    <div class="synkli-navbar--wrap">
        <?php include plugin_dir_path( __FILE__ ) . 'synkli-leads-admin-navbar.php'; ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo esc_html__( 'Please setup admin email notification:', 'synkli-leads' ); ?></h3>
        <form method="post" action="options.php" class="synkli-form synkli-form-emails">
            <?php settings_fields('synkli_leads_email_settings'); ?>
            <div class="form-group-row">
                <div class="form-group">
                    <label><?php echo esc_html__( 'To', 'synkli-leads' ); ?></label>
                    <input type="text" name="synkli_email_to" value="<?php echo esc_attr(get_option('synkli_email_to')); ?>" />
                </div>
                <div class="form-group">
                    <label><?php echo esc_html__( 'From', 'synkli-leads' ); ?></label>
                    <td><input type="text" name="synkli_email_from" value="<?php echo esc_attr(get_option('synkli_email_from')); ?>" /></td>
                </div>
            </div>
            <div class="form-group">
                <label><?php echo esc_html__( 'Subject', 'synkli-leads' ); ?></label>
                <td><input type="text" name="synkli_email_subject" value="<?php echo esc_attr(get_option('synkli_email_subject')); ?>" /></td>
            </div>
            <div class="form-group" style="display: none;">
                <label><?php echo esc_html__( 'Additional Headers', 'synkli-leads' ); ?></label>
                <td><input type="text" name="synkli_email_headers" value="<?php echo esc_attr(get_option('synkli_email_headers')); ?>" /></td>
            </div>
            <div class="form-group">
                <label><?php echo esc_html__( 'Plain or HTML Email', 'synkli-leads' ); ?></label>
                <select name="synkli_email_format">
                    <option value="plain" <?php selected(get_option('synkli_email_format'), 'plain'); ?>><?php echo esc_html__( 'Plain', 'synkli-leads' ); ?></option>
                    <option value="html" <?php selected(get_option('synkli_email_format'), 'html'); ?>><?php echo esc_html__( 'HTML', 'synkli-leads' ); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label><?php echo esc_html__( 'Email Success Message', 'synkli-leads' ); ?></label>
                <input type="text" name="synkli_form_success_message" value="<?php echo esc_attr(get_option('synkli_form_success_message')); ?>" />
            </div>
            <div class="form-group" style="display: none;">
                <label><?php echo esc_html__( 'Email Error Message', 'synkli-leads' ); ?></label>
                <input type="text" name="synkli_form_error_message" value="<?php echo esc_attr(get_option('synkli_form_error_message')); ?>" />
            </div>
            <div class="form-group" style="display: none;">
                <label><?php echo esc_html__( 'Message Body', 'synkli-leads' ); ?></label>
                <textarea name="synkli_email_body"><?php echo esc_textarea(get_option('synkli_email_body')); ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="submit" class="synkli-submit-btn" value="Save Changes">
            </div>
        </form>
    </div>
</div>

