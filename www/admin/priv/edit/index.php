<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$priv = new priv();
	$priv->loadById($_GET['id']);
	
	// Set the title
	if (!$priv->id)
		$title = 'Admin - Privileges - Privileges not found';
	else {
		$title = 'Admin - Privileges - ' . $priv->name;
		
		if (empty($_POST['priv'])) {
			$postArray = array(
					'id' => $priv->id,
					'name' => $priv->name,
					'bitvalue' => $priv->bitvalue
				);
			$_POST['priv'] = $postArray;
		}
	}
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in edit.php
	if (isset($_POST['submitted'])) {
		require_once($GLOBALS['rootPath'] . 'admin/priv/edit/edit.php');
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
	$formTitle = 'Edit Privilege';
	$submitLabel = 'Save';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	Privilege updated.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
