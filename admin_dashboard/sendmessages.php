<?php
// admin_dashboard/sendmessages.php

// Funktion zum Verarbeiten der Nachrichten und zum Senden an alle oder ausgewählte IDs
function sn_process_message() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $message = sanitize_text_field($_POST['sn_message']);
    $recipients = sanitize_text_field($_POST['sn_recipients']);

    $where_clause = '';

    if (!empty($recipients)) {
        $recipients_array = array_map('intval', explode(',', $recipients));
        $recipients_str = implode(',', $recipients_array);

        $where_clause = "WHERE id IN ($recipients_str)";
    }

    $subscribers = $wpdb->get_results("SELECT * FROM $table_name $where_clause", ARRAY_A);

    foreach ($subscribers as $subscriber) {
        $to = $subscriber['email'];
        $subject = 'Newsletter Nachricht';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Your Name <your-email@example.com>',
        );

        $attachments = array();

        if (!empty($_FILES['sn_attachment']['tmp_name'])) {
            $file_name = $_FILES['sn_attachment']['name'];
            $file_tmp = $_FILES['sn_attachment']['tmp_name'];
            $attachments[] = $file_tmp;
        }

        wp_mail($to, $subject, $message, $headers, $attachments);
    }

    // Hier könntest du eine Bestätigungsnachricht oder Weiterleitung hinzufügen
}

// Code für die Anzeige der Liste im Dashboard
function sn_newsletter_send_message_page() {
    if (isset($_POST['sn_send_message'])) {
        sn_process_message();
    }

    ?>
    <div class="wrap" style="
    width : 100%; height : 100%;
    display : flex; flex-direction : column; justify-items : center; align-items : center;">
        <h1>Nachrichten senden</h1>

        <form method="post" action="" enctype="multipart/form-data" style="display : flex; flex-direction : column; justify-items : center; align-items : center;">
            <label for="sn_message">Nachricht:</label>
            <textarea name="sn_message" id="sn_message" required></textarea>

            <label for="sn_recipients">Empfänger (leer lassen für alle oder IDs durch Komma getrennt eingeben):</label>
            <input type="text" name="sn_recipients" id="sn_recipients">

            <label for="sn_attachment">Datei anhängen:</label>
            <input type="file" name="sn_attachment" id="sn_attachment">

            <input type="submit" name="sn_send_message" value="Nachricht senden">
        </form>
    </div>
    <?php
}
?>
