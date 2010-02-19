<?php
	$GLOBALS['rootPath'] = '../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Semesters';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	$semesters = new semesterList();
	$semesters->load();
?>

<h1>Semesters</h1>

<p>
	<ol type="1">

<?php
	foreach ($semesters as $semester) {
		$url = $GLOBALS['rootPath'] . 'admin/semester/show/?id=' . $semester->id;
		$name = $semester->name;
		$startDate = timestampToDate($semester->startDate);
		$endDate = timestampToDate($semester->endDate);
		
		echo '<li><a href="' . $url . '">' . $name . '</a> (' . $startDate . '-' . $endDate . ')</li>';	
	}
?>

	</ol>
</p>

<p>
	<a href="new/">Create new semester</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
