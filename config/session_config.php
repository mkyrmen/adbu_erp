<?php

ini_set('session.use_only_cookies', 1);

ini_set('session.cookie_httponly', 1);

ini_set('session.cookie_secure', 0);

session_start();

define('SESSION_TIMEOUT', 1800);