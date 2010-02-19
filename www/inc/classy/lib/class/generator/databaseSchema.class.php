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
 * databaseSchema
 *
 * @package default
 * @author Chris McMacken
 **/
class databaseSchema extends databaseLoadableObject {


	/**
	 * tableList
	 *
	 * @var array of table objects
	 **/
	var $tableList;


	/**
	 * schemaName
	 *
	 * @var string
	 **/
	var $schemaName;


	/**
	 * overridden constructor
	 *
	 * @return void
	 * @author Chris McMacken
	 **/
	public function __construct($schemaName = "") {
		if($schemaName != "") {
			$this->schemaName = $schemaName;
		}
		else {
			$this->schemaName = DB_NAME;
		}

		try{
			parent::__construct('generator');
		}
		catch (PDOException $connectionError) {
			throw $connectionError;
		}


		$this->tableList = new tableList();
	}


	/**
	 * setAllAttributes
	 *
	 * @author chrism
	 * @date Dec 21, 2008
	 */
	function setAllAttributes() {
		$success = $this->tableList->loadTableListForSchema($this->schemaName);

		if(! $success) {
			return 0;
		}

		$success = $this->tableList->loadColumnListForAllTables($this->schemaName);

		return $success;
	}
	// end - setAllAttributes()


} // end - class databaseSchema