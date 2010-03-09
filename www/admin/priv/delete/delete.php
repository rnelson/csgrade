<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
		
	// Grab the priv object
	$priv = new priv($_GET['id']);
	
	// Load the UI
	$title = 'Admin - Privileges - Delete';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	if (!$priv->id) {
?>

<p>
	<strong>Error:</strong> privilege not found.
</p>

<?php
	}
	else {
		// Check to make sure it's not one they can't delete
		$bv = $priv->bitvalue;
		if ($bv == GUEST_PRIV || $bv == USER_PRIV || $bv == ADMIN_PRIV) {
?>

<p>
	<strong>Error:</strong> cannot delete <?php echo $priv->name; ?>; you cannot delete 
	the <em>guest</em>, <em>user</em>, or <em>administrator</em> privileges.
</p>

<?php
		}
		else {
			$privName = $priv->name;
			$priv->delete();
?>

<p>
	<strong><?php echo $privName; ?></strong> was deleted.
</p>

<?php	} ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	}
	
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>