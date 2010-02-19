<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$semester = new semester();
	$semester->loadById($_GET['id']);
	
	// Set the title
	if (!$semester)
		$title = 'Admin - Semesters - Semester not found';
	else
		$title = 'Admin - Semesters - ' . $semester->name;
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<?php if (!$semester->id) { ?>
<p>
	<strong>Error:</strong> semester not found.
</p>
<?php
	}
	else {
?>

<h1>Confirmation</h1>

<p>
	Are you sure you want to delete <strong><?php echo $semester->name; ?></strong>?
</p>

<p>
	<a href="delete.php?id=<?php echo $semester->id; ?>">Yes</a>
	<a href="../show/?id=<?php echo $semester->id; ?>">No</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
