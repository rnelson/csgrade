<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$priv = new priv();
	$priv->loadById($_GET['id']);
	
	// Set the title
	if (!$priv->id)
		$title = 'Admin - Privileges - Privilege not found';
	else
		$title = 'Admin - Privileges - ' . $priv->name;
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<?php if (!$priv->id) { ?>
<p>
	<strong>Error:</strong> privilege not found.
</p>
<?php
	}
	else {
?>

<h1>Confirmation</h1>

<p>
	Are you sure you want to delete <strong><?php echo $priv->name; ?></strong>?
</p>

<p>
	<a href="delete.php?id=<?php echo $priv->id; ?>">Yes</a>
	<a href="../show/?id=<?php echo $priv->id; ?>">No</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
