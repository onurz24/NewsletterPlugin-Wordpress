<?php
// admin_dashboard/menu.php

// Funktion zum Hinzufügen des Menüs im Dashboard
function sn_add_dashboard_menu() {
    add_menu_page('Newsletter Abonnenten', 'Newsletter', 'manage_options', 'sn-newsletter-dashboard', 'sn_newsletter_dashboard');
    add_submenu_page('sn-newsletter-dashboard', 'Nachrichten senden', 'Nachrichten senden', 'manage_options', 'sn-send-message', 'sn_newsletter_send_message_page');
}

add_action('admin_menu', 'sn_add_dashboard_menu');
?>
