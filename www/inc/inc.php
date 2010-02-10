<?php

// Database
require_once($rootPath . 'inc/database/db.php');
$db = DB();

// Config, used for admin info so we want to cache a global copy
$config = $db->getConfig();

?>