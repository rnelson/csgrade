<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Unset the submitted flag
	unset($_POST['submitted']);
	
	// Grab the inputs
	$id = $_POST['user']['id'];
	$username = trim($_POST['user']['username']);
	$firstName = trim($_POST['user']['firstName']);
	$lastName = trim($_POST['user']['lastName']);
	$email = trim($_POST['user']['email']);
	$userTypeId = trim($_POST['user']['userTypeId']);
	
	// Validate input
	$errors = array();
	
	if (empty($username)) {
		$errors['username'] = 'Username cannot be empty';
	}
	
	if (empty($firstName)) {
		$errors['firstName'] = 'First name cannot be empty';
	}
	
	if (empty($lastName)) {
		$errors['lastName'] = 'Last name cannot be empty';
	}
	
	if (empty($email)) {
		$errors['email'] = 'Email address cannot be empty';
	}
	
	if (!empty($errors)) {
		$_POST['user'] = $_POST['user'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Grab the user input and get it into a format that matches what the DB expects
		$props = array(
				'id' => $id,
				'username' => $username,
				'firstName' => $firstName,
				'lastName' => $lastName,
				'email' => $email,
				'userTypeId' => $userTypeId
			);
		
		// Find the user object
		$user = new user($id);
		$user->setProps($props);
		
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