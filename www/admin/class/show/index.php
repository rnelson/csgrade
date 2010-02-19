<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$class = new singleClass($_GET['id']);
	
	// Set the title
	if (!$class)
		$title = 'Admin - Classes - Class not found';
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
		$semester = $class->getSemester();
?>

<h1><?php echo $class->name; ?></h1>

<p>
	Semester: <a href="../../semester/show/?id=<?php echo $semester->id; ?>"><?php echo $semester->name; ?></a>
</p>

<p>
	<a href="../edit/?id=<?php echo $class->id; ?>">Edit</a>
	<a href="../delete/?id=<?php echo $class->id; ?>">Delete</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
