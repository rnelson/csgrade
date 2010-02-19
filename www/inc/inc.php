<?php

// Configuration
require_once($GLOBALS['rootPath'] . 'inc/csgrade.conf.php');

// Classy
require_once($GLOBALS['rootPath'] . 'inc/classy/lib/setup.php');

/*
// Database
require_once($GLOBALS['rootPath'] . 'inc/database/db.php');
if (!isset($GLOBALS['db'])) {
	$GLOBALS['db'] = new DB($GLOBALS['rootPath'] . 'inc/database/db.ini');
}
*/

// Themes
require_once($GLOBALS['rootPath'] . 'inc/theme.php');
if (!isset($GLOBALS['theme'])) {
	$GLOBALS['theme'] = new Theme();
}

?>