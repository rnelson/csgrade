<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$jqueryCode = <<<EOT
			$(document).ready(function() {
				$('#semester-start-date').datepicker();
				$('#semester-end-date').datepicker();
			});
EOT;
	
	// Grab the object
	$semester = new semester();
	$semester->loadById($_GET['id']);
	
	// Set the title
	if (!$semester)
		$title = 'Admin - Semesters - Semester not found';
	else {
		$title = 'Admin - Semesters - ' . $semester->name;
		
		if (empty($_POST['semester'])) {
			$postArray = array(
					'id' => $semester->id,
					'name' => $semester->name,
					'startDate' => timestampToDate($semester->startDate),
					'endDate' => timestampToDate($semester->endDate),
					'description' => $semester->description
				);
			$_POST['semester'] = $postArray;
		}
	}
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in edit.php
	if (isset($_POST['submitted'])) {
		require_once($GLOBALS['rootPath'] . 'admin/semester/edit/edit.php');
	}
?>

<?php
	if ($_POST['error']) {
?>

<p>
	<div class="error-box">
		<h3>Errors:</h3>
		<ol>
<?php
		$possibleErrors = array('name', 'startDate', 'endDate');
		foreach ($possibleErrors as $error) {
			if (isset($_POST['errors'][$error])) {
				echo '<li>' . $_POST['errors'][$error] . '</li>';
			}
		}
?>
		</ol>
	</div>
</p>

<?php
	}
?>

<?php if (!$_POST['success']) { ?>
<p>
	<form action="index.php" method="post" class="form">
<?php
	$formTitle = 'Edit Semester';
	$submitLabel = 'Save';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	Semester updated.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
