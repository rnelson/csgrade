<?php
	$GLOBALS['rootPath'] = '../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Classes';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	$classes = new singleClassList();
	$classes->load();
?>

<h1>Classes</h1>

<p>
	<ol type="1">

<?php
	foreach ($classes as $class) {
		$url = $GLOBALS['rootPath'] . 'admin/class/show/?id=' . $class->id;
		$name = $class->name;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';	
	}
?>

	</ol>
</p>

<p>
	<a href="new/">Create new class</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
