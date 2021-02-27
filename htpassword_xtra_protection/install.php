<?php
rex_addon::get('htpassword_xtra_protection')->setConfig(HtpasswordStatis::settingsPasswordReset, bin2hex(random_bytes(124)));
