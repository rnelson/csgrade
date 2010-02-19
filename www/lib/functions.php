<?php

// The following are only loaded if we're running csgrade code. Classy
// also wants functions.php but doesn't need any of these
if (isset($GLOBALS['rootPath'])) {
	// Date/time functions
	require_once($GLOBALS['rootPath'] . 'lib/date.php');

	function redirect($relativePath) {
		$root = $GLOBALS['rootPath'];
		$path = $root . $relativePath;
		
		header('Location: ' . $path);
	}
}

?>