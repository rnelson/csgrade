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

/**
 * A base object that everything else extends from. Provides many utility functions such as error
 * storage and checking.
 *
 * @package Object
 * @author Chris McMacken
 */
class baseObject {


	/**
	 * A private error array containing an errors that have occurred
	 *
	 * @access protected
	 * @var array An array of strings
	 */
	protected $_error;


	/**
	 * This function checks to see if an error occurred in this class somewhere.
	 *
	 * @access public
	 * @return boolean
	 */
	public function isError() {
		if(sizeof($this->_error) > 0) {
			return TRUE;
		}

		return FALSE;
	}


	/**
	 * This function returns the _error array as a single string separated by
	 * the delimiter that is passed in.
	 *
	 * @access public
	 * @param string $delimiter The string that will be used to glue these array items together
	 * @return string
	 */
	public function getErrorMessagesAsString($delimiter) {
		return implode($delimiter, $this->_error);
	}


	/**
	 * This function fetches the _error array
	 *
	 * @access public
	 * @return array An array of strings
	 */
	public function getErrorArray() {
		return $this->_error;
	}
}