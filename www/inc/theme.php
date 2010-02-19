<?php

// TODO: write this. I'm not sure how I want to deal with theming yet, so I'm just going to
//       hardcode the filenames for the default theme in for now and figure this out later

class Theme {
	public $theme = null;
	
	public function __construct($themeName = '') {
		$ini = null;
		
		// Decide where our theme is
		if (!empty($themeName)) {
			// A theme was specified, so try to load that first
			$ini = $GLOBALS['rootPath'] . 'inc/themes/' . $themeName . '/theme.ini';
		}
		else if (!empty($config->defaultTheme)) {
			$ini = $GLOBALS['rootPath'] . 'inc/themes/' . $config->defaultTheme . '/theme.ini';
		}
		else {
			// If all else fails, try "default"
			$ini = $GLOBALS['rootPath'] . 'inc/themes/default/theme.ini';
		}
		
		// Try to parse the config file
		$this->theme = parse_ini_file($ini, TRUE);
		
		// If the theme won't load, all sorts of things are going to break, so let's
		// just die and get it over with :)
		if (!$this->theme) {
			die('Could not load theme from ' . $ini . '. Contact the administrator.');
		}
	}
}

?>