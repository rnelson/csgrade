<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
		
	// Grab the semester object
	$id = $_GET['id'];
	$semester = new semester();
	$semester->loadById($id);
	
	// Load the UI
	$title = 'Admin - Semesters - Delete';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	if (!$semester) {
?>

<p>
	<strong>Error:</strong> semester not found.
</p>

<?php
	}
	else {
		$semesterName = $semester->name;
		$semester->delete();
?>

<p>
	<strong><?php echo $semesterName; ?></strong> was deleted.
</p>

<p>
	<a href="../">Back</a>
</p>

<?php
	}
	
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>