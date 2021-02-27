<h2>.htpassword Schutz für das Redaxo Backend einrichten</h2>
<?php

$htaccessTemplate = rex_file::get(rex_path::addon('htpassword_xtra_protection', 'src/htaccess.template'));
echo '<div class="panel panel-default"><div class="panel-heading">.htaccess Template</div>'
    . '<div class="panel-body"><pre>' . $htaccessTemplate . '</pre></div>'
    . '</div>';
?>
<div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12 col-lg-6">
        <?php
        if (isset($_POST["save"])) {
            $username = $_POST["user"];
            $password = $_POST["password"];
            if (
                isset($username)
                && isset($password)
                && !empty($username)
                && !empty($password)
            ) {
                $wellcomePhrase = 'Bereich ist passwortgeschuetzt';
                if (isset($_POST["wellcome-phrase"]) && !empty($_POST["wellcome-phrase"])) {
                    $wellcomePhrase = $_POST["wellcome-phrase"];
                }
                $htaccessTemplate = str_replace('{path2htpassword}', rex_path::backend(), $htaccessTemplate);
                $htaccessTemplate = str_replace('{wellcome phrase}', $wellcomePhrase, $htaccessTemplate);

                rex_file::put(rex_path::backend() . '.htaccess', $htaccessTemplate);
                rex_file::put(rex_path::backend() . '.htpasswd', ($username . ':' . crypt($password, '$2a$07$' . bin2hex(random_bytes(25)) . '$')));
                echo '<div class="alert alert-success"><strong>Erfolg:</strong> Der Passwortschutz wurde erfolgreich eingerichtet!</div>';
            } else {
                echo '<div class="alert alert-danger"><strong>Error:</strong> Es muss sowhl ein Benutzername als auch ein Passwort hinterlegt werden!</div>';
            }
        }
        if (isset($_POST["delete"])) {
            if ((rex_file::get(rex_path::backend() . '.htaccess') != null)) {
                if (rex_file::delete(rex_path::backend() . '.htaccess')) {
                    echo '<div class="alert alert-success"><strong>Erfolg:</strong> .htaccess wurde erfolgreich entfernt!</div>';
                } else {
                    echo '<div class="alert alert-danger"><strong>Error:</strong> .htaccess konnte nicht entfernt werden!</div>';
                }
            } else {
                echo '<div class="alert alert-info"><strong>Achtung:</strong> .htaccess nicht vorhanden!</div>';
            }
            if ((rex_file::get(rex_path::backend() . '.htpasswd') != null)) {
                if (rex_file::delete(rex_path::backend() . '.htpasswd')) {
                    echo '<div class="alert alert-success"><strong>Erfolg:</strong> .htaccess wurde erfolgreich entfernt!</div>';
                } else {
                    echo '<div class="alert alert-danger"><strong>Error:</strong> .htpasswd konnte nicht entfernt werden!</div>';
                }
            } else {
                echo '<div class="alert alert-info"><strong>Achtung:</strong> .htpasswd nicht vorhanden!</div>';
            }
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
                    <fieldset>
                        <legend>.htaccess:</legend>
                        <div class="form-group">
                            <label for="wellcome">Wellcome Phrase:</label>
                            <input type="text" class="form-control" name="wellcome-phrase" id="wellcome">
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>.htpassword:</legend>
                        <div class="form-group">
                            <label for="usr">Benutzername:</label>
                            <input type="text" class="form-control" name="user" id="usr">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Passwort:</label>
                            <input type="text" class="form-control" name="password" id="pwd">
                        </div>
                        <button type="submit" class="btn btn-primary" name="save">Anlegen</button>
                        <button type="submit" class="btn btn-danger" name="delete">Löschen</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>