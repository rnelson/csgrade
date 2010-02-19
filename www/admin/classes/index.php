<?php
	$GLOBALS['rootPath'] = '../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Classes';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	$classes = $GLOBALS['db']->getClasses();
?>

<p>
	Classes:
</p>
<p>
	<ol type="1">

<?php
	foreach ($classes as $class) {
		echo '<li><a href="' . $GLOBALS['rootPath'] . 'admin/classes/show/?id=' . $class->id . '">' . $class->name . '</a></li>';	
	}
?>

	</ol>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
