<?php
	$GLOBALS['rootPath'] = '../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin';
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<ol>
	<li><a href="priv/">Privileges</a></li>
	<li><a href="userType/">User Types</a></li>
	<li><a href="user/">Users</a></li>
	<li><a href="semester/">Semesters</a></li>
	<li><a href="class/">Classes</a></li>
</ol>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
