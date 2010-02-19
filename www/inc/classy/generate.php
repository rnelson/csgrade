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

/*
 * include the global setup file
 */
require_once("lib/setup.php");

//get the action
$action = $_POST['action'];

//get the index for the table we want to generate
$tableName = $_POST['tableName'];

$table = new table($tableName);
$table->setColumnList();

//here we generate the actual file
if($action == "generate") {
	//create some directory variables
	$generatedClassDirectory = BASE_DIR . "/lib/class/generated/{$table->tableName}";
	$leafClassDirectory = BASE_DIR . "/lib/class/{$table->tableName}";

	$smarty->assign('table', $table);
	$generatedClassContents = $smarty->fetch('generator/generatedClass.tpl');
	$leafClassContents = $smarty->fetch('generator/leafClass.tpl');
	$leafClassListContents = $smarty->fetch('generator/leafClassList.tpl');

	$success = 1;
	// create the generated class directory if it doesn't exist
	if(! file_exists($generatedClassDirectory)) {
		$success = mkdir($generatedClassDirectory, 0770, 1);
	}

	// create the leaf class directory if it doesn't exist
	if(! file_exists($leafClassDirectory)) {
		$success = mkdir($leafClassDirectory, 0770, 1);
	}

	if($success) {
		// write the classGenerated.class.php file
		$success = file_put_contents($generatedClassDirectory . "/{$table->tableName}Generated.class.php", $generatedClassContents);
		chmod($generatedClassDirectory . "/{$table->tableName}Generated.class.php", 0770);

		// now if writing the generated class was a success we test to see if the leaf classes have been
		// generated already. We want to make sure we don't write them again if they have because
		// this is where methods will be overridden and the code we actually write will live.
		if($success) {
			//if this file doesn't exist we need to write the leaf class
			if(! file_exists($leafClassDirectory . "/{$table->tableName}.class.php")) {
				$success = file_put_contents($leafClassDirectory . "/{$table->tableName}.class.php", $leafClassContents);
				chmod($leafClassDirectory . "/{$table->tableName}.class.php", 0770);
			}

			//if this file doesn't exist we need to write the list leaf class
			if(! file_exists($leafClassDirectory . "/{$table->tableName}List.class.php")) {
				$success = file_put_contents($leafClassDirectory . "/{$table->tableName}List.class.php", $leafClassListContents);
				chmod($leafClassDirectory . "/{$table->tableName}List.class.php", 0770);
			}
		}
	}

	if(! $success) {
		die("Problem writing file.<br>");
	}

	print "Class successfully written.";
}