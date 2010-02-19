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
 * This class is provides some general purpose functions that are useful for
 * loading objects from a database
 *
 * @package Object
 * @author Chris McMacken
 **/
class databaseLoadableObject extends baseObject {


	/**
	 * PDO class object
	 *
	 * @var PDO
	 **/
	protected $databaseConnection;


	/**
	 * An array containing the values for each property as it was loaded from the database
	 * of the form propertyName => value
	 *
	 * @var array
	 */
	protected $_loadedPropertyArray;


	/**
	 * An array containing the values of this class which have changed since it was loaded from the database
	 * of the form propertyName => newValue
	 *
	 * @var array
	 */
	protected $_changedPropertyArray;


	/**
	 * @access public
	 * @param int $id The integer of the object we want to load
	 * @return void;
	 **/
	public function __construct($id = '') {
		global $dataConnection;
		global $generatorConnection;

		if($id == 'generator') {
			$this->databaseConnection = $generatorConnection;
		} else {
			$this->databaseConnection = $dataConnection;

			if($id) {
				$success = $this->loadById($id);

				if(! $this->id) {
					$this->_error['id'] = "Unable to load the referenced " . get_class($this) . ", it may not exist.";
				}
			}
		}
	}


	/**
	 * This function is used to prepare a PDO statement object
	 *
	 * @access public
 	 * @param string $sqlStatement sql statement being executed
	 * @return PDOStatement or false on error
	 **/
	public function prepare($sqlStatement = "") {
		if($sqlStatement == "") {
			return false;
		}

		return $this->databaseConnection->prepare($sqlStatement);
	}


	/**
	 * This function executes PDO::query and returns a PDOStatement object
	 *
	 * @access public
	 * @param string $sqlStatement sql statement being executed
	 * @return PDOStatement
	 **/
	public function query($sqlStatement) {
		return $this->databaseConnection->query($sqlStatement);
	}


	/**
	 * setProps
	 *
	 *	This function is used to set the properties of the object that
	 *	called it. It matches these properties by columnName to propertyName
	 *
	 * @access public
	 * @param array $resultArray An array of values that will be used to populate the class attributes with values
	 * @return void
	 **/
	public function setProps($resultArray) {
		$variableNameList = $this->getClassAttributeList();
		$propertyNameArray = array_keys($resultArray);

		foreach($resultArray as $name => $value) {

			if(in_array($name, $variableNameList)){

				$this->{$name} = $value;
			}
		}
	}


	/**
	 * This function is used to load an individual item from the database
	 * by the value of it's identity column.
	 *
	 * @access public
	 * @param int $id The identity column value of the object being loaded
	 * @return boolean
	 */
	public function loadById($id = "") {
		$primaryKeyName = $this->getPrimaryKeyName();

		//if we match anything that is NOT a decimal digit, return 0
		if(! filter_var($id, FILTER_VALIDATE_INT) || $id == 0) {
			return FALSE;
		}

		$where = " WHERE $primaryKeyName=:$primaryKeyName";

		$sql = "SELECT * FROM " . get_class($this) . $where;
		$pdoStatement = $this->prepare($sql);

		$pdoStatement->bindValue(":$primaryKeyName", $id, PDO::PARAM_INT);

		$success = $pdoStatement->setFetchMode(PDO::FETCH_INTO, $this);
		if(! $success) {
			return FALSE;
		}

		$success = $pdoStatement->execute();
		if(! $success) {
			return FALSE;
		}

		$resultSize = $pdoStatement->fetchAll();

		$this->setLoadedPropertyArray($pdoStatement);

		if($resultSize) {
			return TRUE;
		}

		return FALSE;
	}
	// end - loadById()


	/**
	 * insert
	 *
	 * This function handles inserting values into the class table
	 *
	 * @access public
	 * @return boolean $success True on success and False on failure
	 */
	public function insert() {
		$classAttributeList = $this->getClassAttributeList();
		$primaryKeyName = $this->getPrimaryKeyName();
		$primaryKeyValue = $this->getPrimaryKeyValue();

		$sql = "INSERT " . get_class($this) . "  (" . implode(',', $classAttributeList) . ") VALUES (";
		foreach($classAttributeList as $classAttribute) {
			$sql .= ":$classAttribute, ";
		}
		$sql = rtrim($sql, ', ');
		$sql .= ")";

		$pdoStatement = $this->prepare($sql);

		foreach($classAttributeList as $classAttribute){
			$success = $pdoStatement->bindValue(":$classAttribute", $this->{$classAttribute}, $this->getColumnType($classAttribute));
		}

		$success = $pdoStatement->execute();

		//it was successfully inserted, now set the ID value
		if($success) {
			$this->id = $this->databaseConnection->lastInsertId();
		}

		return $success;
	}
	// end - insert()


	/**
	 *
	 * This function updates the record for the current object in the database
	 * with any of the new values
	 *
	 * @access public
	 * @return boolean True on success false on failure
	 */
	public function update() {
		$primaryKeyName = $this->getPrimaryKeyName();
		$primaryKeyValue = $this->getPrimaryKeyValue();

		//if we match anything that is NOT a decimal digit, return 0
		if(! filter_var($primaryKeyValue, FILTER_VALIDATE_INT)) {
			return FALSE;
		}

		$this->setChangedPropertyArray();

		if(sizeof($this->_changedPropertyArray) == 0) {
			return TRUE;
		}

		$sql = "UPDATE " . get_class($this) . " SET ";
		foreach($this->_changedPropertyArray as $name => $value) {
			$sql .= "$name=:$name, ";
		}
		$sql = rtrim($sql, ', ');

		$sql .= " WHERE $primaryKeyName=:$primaryKeyName";

		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(":$primaryKeyName", $primaryKeyValue, PDO::PARAM_INT);

		foreach($this->_changedPropertyArray as $name => $value){
			// now bind the values

			$pdoStatement->bindValue(":$name", $value, $this->getColumnType($name));
		}

		return $pdoStatement->execute();
	}
	// end - update()


	/**
	 * This function deletes the record for the current object from the database.
	 *
	 * @access public
	 * @return boolean True on success false on failure
	 */
	public function delete() {
		$primaryKeyName = $this->getPrimaryKeyName();
		$primaryKeyValue = $this->getPrimaryKeyValue();

		//if we match anything that is NOT a decimal digit, return 0
		if(! filter_var($primaryKeyValue, FILTER_VALIDATE_INT)) {
			return FALSE;
		}

		$sql = "DELETE FROM " . get_class($this) . " WHERE $primaryKeyName=:$primaryKeyName";

		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(":$primaryKeyName", $primaryKeyValue, PDO::PARAM_INT);

		return $pdoStatement->execute();
	}
	// end - delete()


	/**
	 * load
	 *
	 * @author Chris McMacken
	 * @date Jan 19, 2009
	 *
	 * This function sets the _loadedPropertyArray class attribute which is used to determine which class attributes have
	 * changed when update() is called.
	 *
	 * @access protected
	 * @return void
	 */
	public function setLoadedPropertyArray() {

		$attributeList = $this->getClassAttributeList();

		foreach($attributeList as $attribute) {
			$this->_loadedPropertyArray[$attribute] = $this->{$attribute};
		}
	}


	/**
	 * This funciton sets the _changedPropertyArray class property
	 *
	 * @access public
	 * @return void
	 */
	public function setChangedPropertyArray() {

		foreach($this->_loadedPropertyArray as $name => $value) {

			if($this->{$name} != $value) {

				$this->_changedPropertyArray[$name] = $this->{$name};
			}
		}
	}


} // END class databaseLoadableObject