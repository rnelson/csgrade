<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$id = $_GET['id']; 
	$class = new singleClass();
	$class->loadById($id);
	
	// Set the title
	if (!$class->id)
		$title = 'Admin - Classes - Class not found';
	else {
		$title = 'Admin - Classes - ' . $class->name;
		
		if (empty($_POST['class'])) {
			$postArray = array(
					'id' => $id,
					'name' => $class->name,
					'semesterId' => $class->semesterId
				);
			$_POST['class'] = $postArray;
		}
	}
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	// If we're getting form data, run the code in edit.php
	if (isset($_POST['submitted'])) {
		require_once($GLOBALS['rootPath'] . 'admin/class/edit/edit.php');
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
	$formTitle = 'Edit Class';
	$submitLabel = 'Save';
	require_once('../_form.php');
?>
	</form>
</p>
<?php } else { ?>
<p>
	Class updated.
</p>

<p>
	<a href="../">Back</a>
</p>
<?php } ?>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
