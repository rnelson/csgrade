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
 * This class is a container class for databaseLoadableObject and it
 * provides some utility functions that are useful for loading lists
 * of items from a database
 *
 * @package ListObject
 * @author Chris McMacken
 **/
class databaseLoadableObjectList extends baseObject implements ArrayAccess, Iterator {


	/**
	 * PDO class object
	 *
	 * @access private
	 * @var PDO
	 **/
	private $databaseConnection;


	/**
	 * items
	 *
	 * This item holds an array of single objects for this container
	 *
	 * @access public
	 * @var array
	 **/
	public $items;


	/**
	 * indicates current position in $this->items
	 *
	 * @access private
	 * @var integer
	 */
	private $position = 0;


	/**
	 * Stores the total number of objects on a page
	 *
	 * @access public
	 * @var integer
	 */
	public $totalItems = 0;


	/**
	 *
	 * @param string $databaseConnectionToUse Indicates which database connection we wante to load data from
	 * @return void
	 */
	public function __construct($databaseConnectionToUse = '') {
		global $dataConnection;
		global $generatorConnection;

		if($databaseConnectionToUse == 'generator') {
			$this->databaseConnection = $generatorConnection;
		} else {
			$this->databaseConnection = $dataConnection;
		}

		$this->position = 0;
	}


	//REQUIRED FUNCTIONS FOR ITERATOR

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->items[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->items[$this->position]);
    }

   	// END REQUIRED FUNCTIONS FOR ITERATOR

	// REQUIRED FUNCTIONS FOR ARRAYACCESS


	public function offsetExists($offset)
    {
        if(isset($this->items[$offset])) {
	  		return TRUE;
		}
        else {
			return FALSE;
		}
    }


    public function offsetGet($offset)
    {
        if($this->offsetExists($offset)) {
			return $this->items[$offset];
		}
        else {
	 		return FALSE;
		}
    }


    public function offsetSet($offset, $value)
    {
        if($offset) {
			$this->items[$offset] = $value;
		}
        else {
	 		$this->items[] = $value;
		}
    }


    public function offsetUnset($offset)
    {
        unset ($this->items[$offset]);
    }

	// END REQUIRED FUNCTIONS FOR ARRAYACCESS


	/**
	 *
	 * This function is used to prepare a PDO statement object
	 *
	 * @access public
	 * @param string $sqlStatement SQL statement being executed
	 * @return PDOStatement or false on error
	 **/
	public function prepare($sqlStatement = "") {
		if($sqlStatement == "") {
			return FALSE;
		}

		return $this->databaseConnection->prepare($sqlStatement);
	}
	// end - prepare($sqlStatement = "")


	/**
	 *
	 * This function executes PDO::query and returns a PDOStatement object
	 *
	 * @access public
	 * @param string $sqlStatement SQL statement being executed
	 * @return PDOStatement
	 **/
	public function query($sqlStatement = "") {
		if($sqlStatement == "") {
			return FALSE;
		}

		return $this->databaseConnection->query($sqlStatement);
	}
	// end - query($sqlStatement = "")


	/**
	 *
	 * This function is used to set the properties of the object that
	 * called it. It matches these properties by columnName to propertyName
	 *
	 * @access public
	 * @param array $resultArray An array containing properties to be assigned to the class attributes
	 * @return void
	 **/
 	public function setProps($resultArray) {
		//strip list from the end of the class
		$className = get_class($this);
		$className = substr($className, 0, strlen($className) - 4);

		//assign the values
		foreach($resultArray as $result) {

			//create a new instance of the class
			$classInstance = new $className();
			$classInstance->setProps($result);

			$this[] = $classInstance;
		}
	}
	// end - setProps($resultArray)


	/**
	 * This function loads every element from a table into a list object for that particular table
	 *
	 * @access public
	 * @param int $page The page number that we're loading from the database, or true if we're loading everything
	 * @param int $itemsPerPage The number of items to display per pagte
	 * @return boolean
	 */
	public function load($page = true, $itemsPerPage = ITEMS_PER_PAGE) {
		// get the class name for the object that this is a collection of (i.e. campList is a collection of camp))
		$className = get_class($this);
		$singleClassName = preg_replace('/List/', '', $className);

		if($page === TRUE) {
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $singleClassName";

		} else {

			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $singleClassName";

			$limitString = $this->_getLimitString($page, $itemsPerPage);

			$sql .= $limitString;
		}


		$pdoStatement = $this->prepare($sql);
		$pdoStatement->setFetchMode(PDO::FETCH_CLASS, $singleClassName);

		$success = $pdoStatement->execute();
		if(! $success) {
			return FALSE;
		}

		$this->items = $pdoStatement->fetchAll();

		$this->setLoadedPropertyArray($pdoStatement);

		$this->totalItems = $this->_setTotalItems($pdoStatement);

		if(sizeof($this->items)) {
			return TRUE;
		}

		return FALSE;
	}


	/**
	 * Sets the _loadedPropertyArray for each item in this container
	 *
	 * @access public
	 * @return void
	 */
	public function setLoadedPropertyArray() {
		foreach($this->items as $item) {
			$item->setLoadedPropertyArray();
		}
	}


	/**
	 * Gets a limit clause for pagination purposes
	 *
	 * @access protected
	 * @param int $page The page number we're loading
	 * @param int $itemsPerPage The number of items per page
	 * @return string The limit clause of a MySQL query
	 */
	protected function _getLimitString($page, $itemsPerPage = ITEMS_PER_PAGE) {
		if($itemsPerPage > MAX_ITEMS_PER_PAGE) {

			$itemsPerPage = MAX_ITEMS_PER_PAGE;
		} else if($itemsPerPage < MIN_ITEMS_PER_PAGE) {

			$itemsPerPage = MIN_ITEMS_PER_PAGE;
		}

		if($page < 0) {
			$page = 1;
		} else if(! filter_var($page, FILTER_VALIDATE_INT)) {
			$page = 1;
		}

		$firstItem = (($page - 1) * $itemsPerPage);

		return " LIMIT $firstItem, $itemsPerPage";
	}


	/**
	 * Gets the total number of items for pagination
	 *
	 * @access protected
	 * @return integer
	 */
	protected function _setTotalItems() {
		$pdoStatement = $this->query('SELECT FOUND_ROWS()');
		$pdoStatement->setFetchMode(PDO::FETCH_ASSOC);

		$results = $pdoStatement->fetchAll();

		return (int)$results[0]['FOUND_ROWS()'];
	}


} // END class databaseLoadableObjectList