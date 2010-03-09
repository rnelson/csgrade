<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$userType = new userType();
	$userType->loadById($_GET['id']);
	
	// Set the title
	if (!$semester)
		$title = 'Admin - User Types - User type not found';
	else
		$title = 'Admin - User Types - ' . $userType->name;
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<?php if (!$userType->id) { ?>
<p>
	<strong>Error:</strong> user type not found.
</p>
<?php
	}
	else {
?>

<h1>Confirmation</h1>

<p>
	Are you sure you want to delete <strong><?php echo $userType->name; ?></strong>?
</p>

<p>
	<a href="delete.php?id=<?php echo $userType->id; ?>">Yes</a>
	<a href="../show/?id=<?php echo $userType->id; ?>">No</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
