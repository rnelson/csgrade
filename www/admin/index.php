<?php
	$GLOBALS['rootPath'] = '../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin';
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

Hi from /admin

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
