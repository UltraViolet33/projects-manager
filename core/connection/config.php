<?php

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');


define("DEBUG", true);


if (DEBUG) {
    define('DB_NAME', 'projects-manager-debug');
} else {
    define('DB_NAME', 'projects-manager-test');
}
