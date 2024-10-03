<?php

/**
 * Provide a admin area view for the plugin Navbar
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


<ul class="synkli-navbar">
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli_capture') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli_capture' ) ); ?>'">
        <span class="dashicons dashicons-screenoptions"></span>
        <span class="synkli-navbar--item-title">Dashboard</span>
    </li>
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli-capture-connection') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-connection' ) ); ?>'">
        <span class="dashicons dashicons-admin-network"></span>
        <span class="synkli-navbar--item-title">Connection</span>
    </li>
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli-capture-content') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-content' ) ); ?>'">
        <span class="dashicons dashicons-edit"></span>
        <span class="synkli-navbar--item-title">Content</span>
    </li>
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli-capture-style') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-style' ) ); ?>'">
        <span class="dashicons dashicons-admin-appearance"></span>
        <span class="synkli-navbar--item-title">Style</span>
    </li>
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli-capture-emails') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-emails' ) ); ?>'">
        <span class="dashicons dashicons-email"></span>
        <span class="synkli-navbar--item-title">Emails</span>
    </li>
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli-capture-shortcode') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-shortcode' ) ); ?>'">
        <span class="dashicons dashicons-shortcode"></span>
        <span class="synkli-navbar--item-title">Shortcode</span>
    </li>
    <li class="synkli-navbar--item <?php echo strpos($_SERVER['REQUEST_URI'], 'page=synkli-capture-help') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?php echo esc_url( admin_url( 'admin.php?page=synkli-capture-help' ) ); ?>'">
        <span class="dashicons dashicons-editor-help"></span>
        <span class="synkli-navbar--item-title">Help</span>
    </li>
</ul>