<?php

defined('ABSPATH') || die();

class AdsBbpressAdmin {
    public function __construct() {
        add_action('admin_menu', array($this, 'hook_admin_menu'));
        if (isset($_GET['page']) && strpos($_GET['page'], 'ads-bbpress/') === 0) {
            header('X-XSS-Protection: 0');
        }
    }
    
    function hook_admin_menu() {
        add_options_page('Ads for bbPress', 'Ads for bbPRess', 'manage_options', 'ads-bbpress/index.php');
    }
    
}
new AdsBbpressAdmin();
