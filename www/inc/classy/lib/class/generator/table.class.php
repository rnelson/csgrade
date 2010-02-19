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


class table extends databaseLoadableObject {


	/**
	 * fieldList
	 *
	 * @var array of field class objects for this table
	 **/
	var $columnList;


	/**
	 * tableName
	 *
	 * @var string
	 **/
	var $tableName;


	/**
	 * overridden constructor
	 *
	 * @return object of table
	 * @author Chris McMacken
	 **/
	public function __construct($tableName = '') {
		parent::__construct('generator');

		if($tableName != "") {
			$this->tableName = $tableName;
		}

		$this->columnList = new columnList();
	}
	// end - __construct()


	/**
	 * setColumnList
	 *
	 * @return boolean
	 * @author Chris McMacken
	 **/
	public function setColumnList() {
		return $this->columnList->loadColumnListForTable($this->tableName);
	}
	// end - public function loadColumnListForTable()


} // END class