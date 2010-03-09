<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$userType = new userType($_GET['id']);
	
	// Set the title
	if (!$user)
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

<h1><?php echo $userType->name; ?></h1>

<table border="0">
	<tr>
		<td>Privileges:</td>
		<td>
<?php
	$privs = new privList();
	$privs->load();
	
	foreach ($privs as $priv) {
		if ($priv->bitvalue & $userType->privs) {
			echo $priv->name . '<br />';
		}
	}
?>
		</td>
	</tr>
</table>

<p>
	<a href="../edit/?id=<?php echo $userType->id; ?>">Edit</a>
	<a href="../delete/?id=<?php echo $userType->id; ?>">Delete</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
