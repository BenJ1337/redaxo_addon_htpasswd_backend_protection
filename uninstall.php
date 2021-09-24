<?php
rex_addon::get('htpassword_xtra_protection')->removeConfig(HtpasswordStatis::settingsPasswordReset);
rex_file::delete(rex_path::backend() . '.htaccess');
rex_file::delete(rex_path::backend() . '.htpasswd');
