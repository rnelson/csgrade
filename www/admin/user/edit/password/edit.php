<?php
	$GLOBALS['rootPath'] = '../../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Unset the submitted flag
	unset($_POST['submitted']);
	
	// Grab the inputs
	$id = $_POST['user']['id'];
	$password = $_POST['password'];
	
	
	// Validate input
	$errors = array();
	
	if (empty($password)) {
		$errors['password'] = 'Password cannot be empty';
	}
	
	if (!empty($errors)) {
		$_POST['user'] = $_POST['user'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Find the user object
		$user = new user($id);
		$user->passwd = sha1($password);
		
		// Update it in the database
		$success = $user->update();
		
		// Check to see if there were errors; if so, inform the user
		if (!$success) {
			$_POST['error'] = true;
			
 			$errorArray = $user->getErrorArray(); 			
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