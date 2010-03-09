<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$user = new user($_GET['id']);
	
	// Set the title
	if (!$user->id)
		$title = 'Admin - Users - User not found';
	else {
		$title = 'Admin - Users - ' . $user->username;
		
		if (empty($_POST['user'])) {
			$postArray = array(
					'id' => $user->id,
					'username' => $user->username,
					'firstName' => $user->firstName,
					'lastName' => $user->lastName,
					'email' => $user->email,
					'userTypeId' => $user->userTypeId
				);
			$_POST['user'] = $postArray;
		}
	}
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in edit.php
	if (isset($_POST['submitted'])) {
		require_once($GLOBALS['rootPath'] . 'admin/user/edit/edit.php');
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
		$possibleErrors = array('username', 'firstName', 'lastName', 'email');
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
	$formTitle = 'Edit User';
	$submitLabel = 'Save';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	User updated.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
