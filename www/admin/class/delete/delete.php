<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
		
	// Grab the class object
	$id = $_GET['id'];
	$class = new singleClass($id);
	
	// Load the UI
	$title = 'Admin - Classes - Delete';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	if (!$class->id) {
?>

<p>
	<strong>Error:</strong> class not found.
</p>

<?php
	}
	else {
		$className = $class->name;
		$class->delete();
?>

<p>
	<strong><?php echo $className; ?></strong> was deleted.
</p>

<p>
	<a href="../">Back</a>
</p>

<?php
	}
	
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>