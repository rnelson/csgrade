<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
		
	// Grab the userType object
	$userType = new userType($_GET['id']);
	
	// Load the UI
	$title = 'Admin - User Types - Delete';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	if (!$userType->id) {
?>

<p>
	<strong>Error:</strong> user type not found.
</p>

<?php
	}
	else {
		$userTypeName = $userType->name;
		$userType->delete();
?>

<p>
	<strong><?php echo $userTypeName; ?></strong> was deleted.
</p>

<p>
	<a href="../">Back</a>
</p>

<?php
	}
	
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>