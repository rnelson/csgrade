<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$class = new singleClass();
	$class->loadById($_GET['id']);
	
	// Set the title
	if (!$class->id)
		$title = 'Admin - Class - Class not found';
	else
		$title = 'Admin - Classes - ' . $class->name;
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<?php if (!$class->id) { ?>
<p>
	<strong>Error:</strong> class not found.
</p>
<?php
	}
	else {
?>

<h1>Confirmation</h1>

<p>
	Are you sure you want to delete <strong><?php echo $class->name; ?></strong>?
</p>

<p>
	<a href="delete.php?id=<?php echo $class->id; ?>">Yes</a>
	<a href="../show/?id=<?php echo $class->id; ?>">No</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
