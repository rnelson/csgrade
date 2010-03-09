<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
		
	// Grab the semester object
	$user = new user($_GET['id']);
	
	// Load the UI
	$title = 'Admin - Users - Delete';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	if (!$user->id) {
?>

<p>
	<strong>Error:</strong> user not found.
</p>

<?php
	}
	else {
		// Check to make sure it's not the default admin
		if ($_GET['id'] == 1) {
?>

<p>
	<strong>Error:</strong> cannot delete <em><?php echo $user->username; ?></em>. You cannot delete 
	the default administrator account.
</p>

<?php
		}
		else {
			$userUsername = $user->username;
			$userRealname = $user->getRealName();
			$user->delete();
?>

<p>
	<strong><?php echo $userUsername; ?></strong> (<?php echo $userRealname; ?>) was deleted.
</p>

<?php	} ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	}
	
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>