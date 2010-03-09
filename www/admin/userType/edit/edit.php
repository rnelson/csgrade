<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Unset the submitted flag
	unset($_POST['submitted']);
	
	// Grab the inputs
	$id = $_POST['userType']['id'];
	$name = trim($_POST['userType']['name']);
	
	// We have to deal with privileges separately
	$privs = 1;
	foreach ($_POST['privs'] as $bitmask) {
		$privs |= $bitmask;
	}
	
	// Validate input
	$errors = array();
	
	if (empty($name)) {
		$errors['name'] = 'Name cannot be empty';
	}
		
	if (!empty($errors)) {
		$_POST['userType'] = $_POST['userType'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Grab the user input and get it into a format that matches what the DB expects
		$props = array(
				'id' => $id,
				'name' => $name,
				'privs' => $privs
			);
		
		// Find the userType object
		$userType = new userType($id);
		$userType->setProps($props);
		
		// Update it in the database
		$success = $userType->update();
		
		// Check to see if there were errors; if so, inform the user
		if (!$success) {
			$_POST['error'] = true;
			
 			$errorArray = $userType->getErrorArray(); 			
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