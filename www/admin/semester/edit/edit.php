<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Unset the submitted flag
	unset($_POST['submitted']);
	
	// Grab the inputs
	$id = $_POST['semester']['id'];
	$name = trim($_POST['semester']['name']);
	$startDate = trim(reformatDate($_POST['semester']['startDate'], $GLOBALS['datetimeFormat']));
	$endDate = trim(reformatDate($_POST['semester']['endDate'], $GLOBALS['datetimeFormat']));
	$desc = $_POST['semester']['description'];
	
	// Validate input
	$errors = array();
	
	if (empty($name)) {
		$errors['name'] = 'Name cannot be empty';
	}
	
	if (empty($startDate)) {
		$errors['startDate'] = 'Invalid start date';
	}
	
	if (empty($endDate)) {
		$errors['endDate'] = 'Invalid end date';
	}
	
	if (!empty($errors)) {
		$_POST['semester'] = $_POST['semester'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Grab the user input and get it into a format that matches what the DB expects
		$props = array(
				'name' => $name,
				'startDate' => dateToTimestamp($startDate),
				'endDate' => dateToTimestamp($endDate),
				'description' => $desc
			);
		
		// Create a new semester object
		$semester = new semester();
		$semester->setProps($props);
		
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
		$success = $semester->insert();
		
		// Check to see if there were errors; if so, inform the user
		if (!$success) {
			$_POST['error'] = true;
			
 			$errorArray = $semester->getErrorArray(); 			
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