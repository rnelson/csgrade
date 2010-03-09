<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Grab the inputs
	$name = trim($_POST['userType']['name']);
	
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
				'name' => $name
			);
		
		// Create a new userType object
		$userType = new userType();
		$userType->setProps($props);
		
		/*
		echo '<h1>$props</h1>';
		var_dump($props);
		echo '<h1>$semester</h1>';
		var_dump($semester);
		echo '<h1>$_POST</h1>';
		var_dump($_POST);
		die();
		*/
		
		// Add it to the database
		$success = $userType->insert();
		
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