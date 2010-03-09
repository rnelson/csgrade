<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$user = new user($_GET['id']);
	
	// Set the title
	if (!$user)
		$title = 'Admin - Users - User not found';
	else
		$title = 'Admin - Users - ' . $user->username;
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<?php if (!$user->id) { ?>
<p>
	<strong>Error:</strong> user not found.
</p>
<?php
	}
	else {
?>

<h1>Confirmation</h1>

<p>
	Are you sure you want to delete <strong><?php echo $user->username; ?></strong> (<?php echo $user->getRealName(); ?>?
</p>

<p>
	<a href="delete.php?id=<?php echo $user->id; ?>">Yes</a>
	<a href="../show/?id=<?php echo $user->id; ?>">No</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
