<ul class="synkli-navbar">
    <li class="synkli-navbar--item <?= strpos($_SERVER['REQUEST_URI'], 'page=synkli_leads') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?= admin_url() . '/admin.php?page=synkli_leads' ?>'">
        <span class="dashicons dashicons-screenoptions"></span>
        <span class="synkli-navbar--item-title">Dashboard</span>
    </li>
    <li class="synkli-navbar--item <?= strpos($_SERVER['REQUEST_URI'], 'page=synkli-leads-connection') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?= admin_url() . '/admin.php?page=synkli-leads-connection' ?>'">
        <span class="dashicons dashicons-admin-network"></span>
        <span class="synkli-navbar--item-title">Connection</span>
    </li>
    <li class="synkli-navbar--item <?= strpos($_SERVER['REQUEST_URI'], 'page=synkli-leads-style') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?= admin_url() . '/admin.php?page=synkli-leads-style' ?>'">
        <span class="dashicons dashicons-admin-appearance"></span>
        <span class="synkli-navbar--item-title">Style</span>
    </li>
    <li class="synkli-navbar--item <?= strpos($_SERVER['REQUEST_URI'], 'page=synkli-leads-emails') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?= admin_url() . '/admin.php?page=synkli-leads-emails' ?>'">
        <span class="dashicons dashicons-email"></span>
        <span class="synkli-navbar--item-title">Emails</span>
    </li>
    <li class="synkli-navbar--item <?= strpos($_SERVER['REQUEST_URI'], 'page=synkli-leads-help') !== false ? "synkli-navbar--item-active" : ""; ?>" onclick="window.location.href='<?= admin_url() . '/admin.php?page=synkli-leads-help' ?>'">
        <span class="dashicons dashicons-editor-help"></span>
        <span class="synkli-navbar--item-title">Help</span>
    </li>
</ul>