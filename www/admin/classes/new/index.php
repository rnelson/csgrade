<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Classes - New';
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<p>
	<span class="page-title">Create New Class</span>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
