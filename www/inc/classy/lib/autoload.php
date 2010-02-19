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

function __autoload($className)
{
	// if the class name ends in "Generated" we need to strip that off for the
	// purposes of searching our directory structure
	$classDir = preg_replace('/Generated|List$/',"", $className);
	
	/*
	echo 'Name: (' . $className . ')  Dir: (' . $classDir . ')<br>';
	$possibles = array(
			DOCROOT . "lib/class/$className.class.php",
			BASE_DIR . "lib/class/$className.class.php",
			BASE_DIR . "lib/class/$classDir/$className.class.php",
			BASE_DIR . "lib/class/$classDir/{$className}List.class.php",
			BASE_DIR . "lib/class/generator/$className.class.php",
			BASE_DIR . "lib/class/generated/$classDir/{$className}.class.php"
		);
	foreach ($possibles as $p) {
		//echo '&nbsp;&nbsp;&nbsp;' . $p . '<br>';
		echo '&nbsp;&nbsp;&nbsp;' . system('file ' . $p) . '<br><br>';
	}
	//*/

	if(preg_match('/soap/', $className)) {
		require_once(DOCROOT . "lib/nuSoap/nusoap.php");

	} else if(file_exists(DOCROOT . "lib/class/$className.class.php")) {
		require_once(DOCROOT . "lib/class/$className.class.php");

	} else if(file_exists(BASE_DIR . "lib/class/$className.class.php")) {
		require_once(BASE_DIR . "lib/class/$className.class.php");

	} else if(file_exists(BASE_DIR . "lib/class/$classDir/$className.class.php")) {
		require_once(BASE_DIR . "lib/class/$classDir/$className.class.php");

	} else if(file_exists(BASE_DIR . "lib/class/$classDir/{$className}List.class.php")) {
		require_once(BASE_DIR . "lib/class/$classDir/{$className}List.class.php");

	} else if(file_exists(BASE_DIR . "lib/class/generator/$className.class.php")) {
		require_once(BASE_DIR . "lib/class/generator/$className.class.php");

	} else if(file_exists(BASE_DIR . "lib/class/generated/$classDir/{$className}.class.php")) {
		require_once(BASE_DIR . "lib/class/generated/$classDir/{$className}.class.php");

	}
	else {
	    //header('Content-type: text/plain');
	    die("Couldn't load class: $className.");
	}
}