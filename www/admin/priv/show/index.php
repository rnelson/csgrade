<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$priv = new priv($_GET['id']);
	
	// Set the title
	if (!$priv)
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

<h1><?php echo $priv->name; ?></h1>

<table border="0">
	<tr>
		<td>Bit value:</td>
		<td><?php echo $priv->bitvalue; ?></td>
	</tr>
</table>

<p>
	<a href="../edit/?id=<?php echo $priv->id; ?>">Edit</a>
	<a href="../delete/?id=<?php echo $priv->id; ?>">Delete</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
