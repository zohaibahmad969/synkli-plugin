<?php

/**
 * Provide a admin area view for the plugin menu Content
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
        <h2 class="synkli-header--title">Content</h2>
    </div>
    <div class="synkli-navbar--wrap">
        <?php include(dirname (__FILE__) . '/synkli-leads-admin-navbar.php'); ?>
    </div>
    <div class="synkli-body">
        <h3><?php echo __('You can change form content here:', 'synkli-leads'); ?></h3>
        <form method="post" action="options.php" class="synkli-form synkli-form-emails">
            <?php settings_fields('synkli_leads_content_settings'); ?>
            <div class="form-group">
                <label><?php echo __('Form Title', 'synkli-leads'); ?></label>
                <td><input type="text" name="synkli_form_title" value="<?php echo esc_attr(get_option('synkli_form_title')); ?>" /></td>
            </div>
            <div class="form-group">
                <label><?php echo __('Form Description', 'synkli-leads'); ?></label>
                <textarea name="synkli_form_description" rows="5"><?php echo esc_textarea(get_option('synkli_form_description')); ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="submit" class="synkli-submit-btn" value="Save Changes">
            </div>
        </form>
    </div>
</div>

