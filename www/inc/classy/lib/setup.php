<?php

/*

 Copyright (c) 2009 Blue Worm Labs.

 This software is provided 'as-is', without any express or implied
 warranty. In no event will the authors be held liable for any damages
 arising from the use of this software.

 Permission is granted to anyone to use this software for any purpose,
 including commercial applications, and to alter it and redistribute it
 freely, subject to the following restrictions:

 1. The origin of this software must not be misrepresented; you must not
 claim that you wrote the original software. If you use this software
 in a product, an acknowledgment in the product documentation would be
 appreciated but is not required.

 2. Altered source versions must be plainly marked as such, and must not be
 misrepresented as being the original software.

 3. This notice may not be removed or altered from any source
 distribution.

 */

require_once("constants.php");
require_once("autoload.php");
require_once(DOCROOT . "lib/functions.php");

//include the smarty class file and then create a smarty object
require_once "smartylib/Smarty.class.php";

$smarty = new Smarty();
$smarty->template_dir = BASE_DIR . "lib/smarty/templates/";
$smarty->compile_dir = BASE_DIR . "lib/smarty/templates_c/";
$smarty->config_dir = BASE_DIR . "lib/smarty/configs/";
$smarty->cache_dir = BASE_DIR . "lib/smarty/cache/";

//make the database connection for the generator
try {
	$generatorConnection = new PDO("mysql:host=".DB_HOST.";dbname=information_schema", DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
	$generatorConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $connectionError) {
	throw $connectionError;
}

//make the database connection for the actual class data
try {
	$dataConnection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
	$dataConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $connectionError) {
	throw $connectionError;
}

/**
 * session / login management code
 */
//session_start();

/*
//login stuff
if(! defined('DISABLE_LOGIN') ) {
	$userLoggedIn = new user();
	$success = $userLoggedIn->login();

	// if login failed and we are not already at login.php
	if(! $success && ! preg_match('/login\.php/', $_SERVER['PHP_SELF'])) {
		if(! preg_match('/login\.php/', $_SERVER['PHP_SELF'])) {
			header("Location: /admin/login.php");
			exit();
		}
	}
}
*/