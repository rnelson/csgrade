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
 * columnList
 *
 * @package default
 * @author Chris McMacken
 **/
class columnList extends databaseLoadableObjectList {


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Chris McMacken
	 **/
	public function __construct() {
		try {
			parent::__construct('generator');
		}
		catch(PDOException $connectionError) {
			throw $connectionError;
		}
	}
	// end - public function __construct($schemaName ="", $tableName = "")


	/**
	 * loadColumnListForSchema
	 *
	 * @param string $tableName The name of the table we're loading columns from
	 * @return boolean
	 * @author Chris McMacken
	 **/
	public function loadColumnListForTable($tableName) {
		$singleClassName = get_class($this);
		$singleClassName = preg_replace('/List/', '', $singleClassName);

		$sql = 'SELECT
				column_name AS columnName,
				column_type AS columnType,
				column_key AS columnKey,
				extra AS columnExtra,
				character_maximum_length AS columnLength
			FROM
				information_schema.columns
			WHERE
				table_schema= :schemaName
				AND table_name= :tableName
			ORDER BY
				ordinal_position';

		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(':schemaName', DB_NAME);
		$pdoStatement->bindValue(':tableName', $tableName);

		$success = $pdoStatement->setFetchMode(PDO::FETCH_CLASS, $singleClassName);
		//$success = $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
		if(! $success) {
			return FALSE;
		}

		$success = $pdoStatement->execute();
		if(! $success) {
			return FALSE;
		}

		$this->items = $pdoStatement->fetchAll();

		// set the PDO types for each column
		$this->setType();
	}
	// end - public function loadColumnListForTable($schemaName, $tableName)


	/**
	 * setType
	 *
	 * This method sets the columnType attribute to an appropriate PDO class constant
	 *
	 * @author chrism
	 */
	function setType() {
		foreach($this as $column) {
			if(preg_match("/tinyint\(1\)/", $column->columnType)) {

				$column->columnType = 'PDO::PARAM_BOOL';
			} else if(preg_match("/int/", $column->columnType)) {

				$column->columnType = 'PDO::PARAM_INT';
			}  else if(preg_match("/float/", $column->columnType)) {

				$column->columnType = 'PDO::PARAM_INT';
			} else if(preg_match("/char|text/", $column->columnType)) {

				$column->columnType = 'PDO::PARAM_STR';
			} else if(preg_match("/datetime/", $column->columnType)) {

				$column->columnType = 'PDO::PARAM_STR';
			}
		}
	}
	// end - setType()


} // END class