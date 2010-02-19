<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$semester = new semester($_GET['id']);
	
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
		$classes = $semester->getClasses();
?>

<h1><?php echo $semester->name; ?></h1>

<p>
	<table border="0">
		<tr>
			<td>Starts:</td>
			<td><?php echo timestampToDate($semester->startDate); ?></td>
		</tr>
		<tr>
			<td>Ends:</td>
			<td><?php echo timestampToDate($semester->endDate); ?></td>
		</tr>
	</table>
</p>

<p>
	Description:<br />
	<blockquote>
<?php echo $semester->description; ?>
	</blockquote>
</p>

<?php if (!empty($classes)) { ?>
<p>
	Classes:<br />
	<ul>
<?php
	foreach ($classes as $class) {
		$name = $class->name;
		$url = $url = $GLOBALS['rootPath'] . 'admin/class/show/?id=' . $class->id;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';	
	}
?>
	</ul>
</p>
<?php } ?>

<p>
	<a href="../edit/?id=<?php echo $semester->id; ?>">Edit</a>
	<a href="../delete/?id=<?php echo $semester->id; ?>">Delete</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
