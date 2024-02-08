<?php
// shortcodes/subscribe_form.php

// Füge das Formular zum Anmelden hinzu
function sn_newsletter_form() {
    ob_start(); ?>
<div style="
    width : 100%; height : 100%;
    display : flex; flex-direction : column; justify-items : center; align-items : center;">
    <form method="post" action="">
        <label for="sn_name">Name:</label>
        <input type="text" name="sn_name" id="sn_name" required>
        
        <label for="sn_email">E-Mail:</label>
        <input type="email" name="sn_email" id="sn_email" required>
        
        <input type="submit" name="sn_submit" value="Abonnieren">
    </form>
</div>

    <?php
    $output = ob_get_clean();

    if (isset($_POST['sn_submit'])) {
        sn_process_subscription();
    }

    return $output;
}

add_shortcode('sn_newsletter_form', 'sn_newsletter_form');

// Verarbeite die Abonnementdaten und speichere sie in der Datenbank
function sn_process_subscription() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $name = sanitize_text_field($_POST['sn_name']);
    $email = sanitize_email($_POST['sn_email']);

    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
        ),
        array('%s', '%s')
    );

    // Als nächstes : Bestätigungsnachricht anzeigen
}
?>
