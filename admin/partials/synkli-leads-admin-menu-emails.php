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


<div class="wrap synkli-admin-menu-page-wrap">
    <h2><?php echo __('Synkli Leads Emails', 'synkli-leads'); ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields('synkli_leads_email_settings'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php echo __('To', 'synkli-leads'); ?></th>
                <td><input type="text" name="synkli_email_to" value="<?php echo esc_attr(get_option('synkli_email_to')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('From', 'synkli-leads'); ?></th>
                <td><input type="text" name="synkli_email_from" value="<?php echo esc_attr(get_option('synkli_email_from')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Subject', 'synkli-leads'); ?></th>
                <td><input type="text" name="synkli_email_subject" value="<?php echo esc_attr(get_option('synkli_email_subject')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Additional Headers', 'synkli-leads'); ?></th>
                <td><input type="text" name="synkli_email_headers" value="<?php echo esc_attr(get_option('synkli_email_headers')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Plain or HTML Email', 'synkli-leads'); ?></th>
                <td>
                    <select name="synkli_email_format">
                        <option value="plain" <?php selected(get_option('synkli_email_format'), 'plain'); ?>><?php echo __('Plain', 'synkli-leads'); ?></option>
                        <option value="html" <?php selected(get_option('synkli_email_format'), 'html'); ?>><?php echo __('HTML', 'synkli-leads'); ?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Message Body', 'synkli-leads'); ?></th>
                <td><textarea name="synkli_email_body"><?php echo esc_textarea(get_option('synkli_email_body')); ?></textarea></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>