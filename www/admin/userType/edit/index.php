<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$userType = new userType($_GET['id']);
	
	// Set the title
	if (!$userType->id)
		$title = 'Admin - User Types - User type not found';
	else {
		$title = 'Admin - User Types - ' . $userType->name;
		
		if (empty($_POST['userType'])) {
			$postArray = array(
					'id' => $userType->id,
					'name' => $userType->name,
					'privs' => $userType->privs
				);
			$_POST['userType'] = $postArray;
			$_POST['privs'] = $userType->privs;
		}
	}
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in edit.php
	if (isset($_POST['submitted'])) {
		require_once($GLOBALS['rootPath'] . 'admin/userType/edit/edit.php');
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
		$possibleErrors = array('name');
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
	$formTitle = 'Edit User Type';
	$submitLabel = 'Save';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	User type updated.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
