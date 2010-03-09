<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Unset the submitted flag
	unset($_POST['submitted']);
	
	// Grab the inputs
	$id = $_POST['priv']['id'];
	$name = trim($_POST['priv']['name']);
	$bitvalue = $_POST['priv']['bitvalue'];
	
	// Validate input
	$errors = array();
	
	if (empty($name)) {
		$errors['name'] = 'Name cannot be empty';
	}
	
	if (!empty($errors)) {
		$_POST['priv'] = $_POST['priv'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Grab the user input and get it into a format that matches what the DB expects
		$props = array(
				'id' => $id,
				'name' => $name,
				'bitvalue' => $bitvalue
			);
		
		// Find the priv object
		$priv = new priv($id);
		$priv->setProps($props);
		
		// Save it to the database
		$success = $priv->update();
		
		// Check to see if there were errors; if so, inform the user
		if (!$success) {
			$_POST['error'] = true;
			
 			$errorArray = $priv->getErrorArray();		
 			foreach ($errorArray as $fieldName => $errorMessage) {
 				$_POST['errors'][$fieldName] = $errorMessage;
 			}
 		}
 		else {
 			$_POST['error'] = false;
 			$_POST['success'] = true;
 		}
	}
?>