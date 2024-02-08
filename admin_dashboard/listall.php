<?php
// admin_dashboard/listall.php

// Code für die Anzeige der Liste im Dashboard
function sn_newsletter_dashboard() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $subscribers = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    echo '<div class="wrap">';
    echo '<h1>Newsletter Abonnenten</h1>';

    if ($subscribers) {
        echo '<table class="widefat">';
        echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($subscribers as $subscriber) {
            echo '<tr>';
            echo '<td>' . esc_html($subscriber['id']) . '</td>';
            echo '<td>' . esc_html($subscriber['name']) . '</td>';
            echo '<td>' . esc_html($subscriber['email']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Keine Abonnenten gefunden.</p>';
    }

    echo '</div>';
}
?>
