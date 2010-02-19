<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$class = $GLOBALS['db']->getClassById($_GET['id']);
	$semester = $class->getSemester();
	
	$title = 'Admin - Classes - ' . $class->name;
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<p>
	<strong><?php echo $class->name; ?></strong>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
