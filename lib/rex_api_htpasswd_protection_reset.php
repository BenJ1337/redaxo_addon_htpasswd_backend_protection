<?php

// URL /index.php?rex_api_htpasswd_protextion_reset&nonce=
class rex_api_htpasswd_protection_reset extends rex_api_function
{
    protected $published = true;

    function execute()
    {
        $nonce = rex_config::get('htpassword_xtra_protection', HtpasswordStatis::settingsPasswordReset);
        if ($nonce == $_GET['nonce']) {
            if (rex_file::delete(rex_path::backend() . '.htaccess') && rex_file::delete(rex_path::backend() . '.htpasswd')) {
                echo '<p>.htpasswd Schutz erfolgreich entfernt.</p>';
            } else {
                echo '<p>Der .htpasswd Schutz konnte nicht entfernt werden.</p>';
            }
        } else {
            echo '<p>Die Nonce ist fehlerhaft!</p>';
        }
        echo '<a href="/redaxo">Zum Backend</a>';
        exit;
    }
}
