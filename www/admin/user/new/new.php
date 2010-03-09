<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	
	// Grab the inputs
	$username = trim($_POST['user']['username']);
	$firstName = trim($_POST['user']['firstName']);
	$lastName = trim($_POST['user']['lastName']);
	$email = trim($_POST['user']['email']);
	$userType = $_POST['user']['userTypeId'];
	$password = $_POST['password'];
	
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
		$errors['email'] = 'Email cannot be empty';
	}
	
	if (empty($password)) {
		$errors['password'] = 'Password cannot be empty';
	}
	
	if (!empty($errors)) {
		$_POST['user'] = $_POST['user'];
		$_POST['errors'] = $errors;
		$_POST['error'] = true;
	}
	else {
		// Grab the user input and get it into a format that matches what the DB expects
		$props = array(
				'username' => $username,
				'firstName' => $firstName,
				'lastName' => $lastName,
				'email' => $email,
				'userTypeId' => $userType,
				'passwd' => sha1($password),
				'theme' => DEFAULT_THEME,
			);
		
		// Create a new user object
		$user = new user();
		$user->setProps($props);
		
		// Add it to the database
		$success = $user->insert();
		
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