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
	
	$title = 'Admin - Semesters - New';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in new.php
	if (!empty($_POST)) {
		require_once($GLOBALS['rootPath'] . 'admin/semester/new/new.php');
	}
	
	// Create default start/end dates. Today - today + 15 weeks
	$today = time();
	$todayPlusFifteen = time() + (15 * 7 * 24 * 60 * 60);
	
	if (empty($_POST['semester']['startDate'])) {
		$_POST['semester']['startDate'] = date($GLOBALS['dateFormat'], $today);
	}
	if (empty($_POST['semester']['endDate'])) {
		$_POST['semester']['endDate'] = date($GLOBALS['dateFormat'], $todayPlusFifteen);
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
	$formTitle = 'Create New Semester';
	$submitLabel = 'Create';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	Semester successfully added.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
