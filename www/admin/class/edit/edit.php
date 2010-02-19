<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Unset the submitted flag
	unset($_POST['submitted']);
	
	// Grab the inputs
	$id = $_POST['class']['id'];
	$name = trim($_POST['class']['name']);
	$semId = $_POST['class']['semesterId'];
	
	// Validate input
	$errors = array();
	
	if (empty($name)) {
		$errors['name'] = 'Name cannot be empty';
	}
	
	if (empty($semId)) {
		$errors['semesterId'] = 'Must select a semester';
	}
	
	if (!empty($errors)) {
		$_POST['class'] = $_POST['class'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Grab the user input and get it into a format that matches what the DB expects
		$props = array(
				'id' => $id,
				'name' => $name,
				'semesterId' => $semId
			);
		
		// Create a new class object
		$class = new singleClass($id);
		$class->setProps($props);
		
		/*
		echo '<h1>$props</h1>';
		var_dump($props);
		echo '<h1>$semester</h1>';
		var_dump($semester);
		echo '<h1>$_POST</h1>';
		var_dump($_POST);
		die();
		*/
		
		// Save it to the database
		$success = $class->update();
		
		// Check to see if there were errors; if so, inform the user
		if (!$success) {
			$_POST['error'] = true;
			
 			$errorArray = $class->getErrorArray();
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