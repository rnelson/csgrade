<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Classes - New';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in new.php
	if (!empty($_POST)) {
		require_once($GLOBALS['rootPath'] . 'admin/class/new/new.php');
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
		$possibleErrors = array('name', 'semesterId');
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
	$formTitle = 'Create New Class';
	$submitLabel = 'Create';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	Class successfully added.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
