
	
 
<?php
/**
 * assignmentPartGenerated
 *
 *	AUTO GENERATED CODE DO NOT MODIFY
 * 
 *  If you must make modifications make them in
 *	the leaf class so that they don't get overwritten
 * 	if you regenerate your code.
 *
 **/
class assignmentPartGenerated extends databaseLoadableObject {

	
	/**
	 * Primary Key
	 * 
	**/
	const primaryKey = "id";
		
	
	/**
	 * id
	 *
	 * auto_increment
	 * @var int
	 **/
	public $id;


	/**
	 * name
	 *
	 * @var string
	 **/
	public $name;


	/**
	 * totalPoints
	 *
	 * @var int
	 **/
	public $totalPoints;


	/**
	 * weight
	 *
	 **/
	public $weight;


	/**
	 * classAverage
	 *
	 **/
	public $classAverage;


	/**
	 * assignmentId
	 *
	 * @var int
	 **/
	public $assignmentId;


	/**
	 * filePath
	 *
	 * @var string
	 **/
	public $filePath;


	

	/**
	 * This function returns the database data type for a column
	 *
	 * @param string $columnName The name of the column we want to get the type information for
	 * @return string $columnType The data type of the that was passed in. False on an error.
	 **/
	public function getColumnType($columnName) {
		switch($columnName) {
			
			case "id":
				$columnType = PDO::PARAM_INT;
				break;
			
			case "name":
				$columnType = PDO::PARAM_STR;
				break;
			
			case "totalPoints":
				$columnType = PDO::PARAM_INT;
				break;
			
			case "weight":
				$columnType = decimal(7,4);
				break;
			
			case "classAverage":
				$columnType = decimal(7,4);
				break;
			
			case "assignmentId":
				$columnType = PDO::PARAM_INT;
				break;
			
			case "filePath":
				$columnType = PDO::PARAM_STR;
				break;
			default:
				$columnType = FALSE;
		}
		
		return $columnType;
	}
	// end - function getColumnType($columnName)
	
	
	/**
	 * This function returns the maximum column length for a column
	 * 
	 * @param string $columnName The name of the column we want to get the type information for
	 * @return int $columnLength The max. length for this column, FALSE on an error
	 */
	public function getColumnLength($columnName){
		switch($columnName){
			case "id":
				$columnLength = "";
				break;
			case "name":
				$columnLength = "255";
				break;
			case "totalPoints":
				$columnLength = "";
				break;
			case "weight":
				$columnLength = "";
				break;
			case "classAverage":
				$columnLength = "";
				break;
			case "assignmentId":
				$columnLength = "";
				break;
			case "filePath":
				$columnLength = "255";
				break;
			default:
				$columnLength = FALSE;
		}
		
		return $columnLength;
	}
	
	/**
	 * This function returns the name of the primary key column for this table
	 * 
	 * @return string The column name for the primary key of this table
	 */
	public function getPrimaryKeyName() {
		return self::primaryKey;
	}
	// end - function getPrimaryKeyName()
	
	
	/**
	 * This function returns the value of the primary key column for this table
	 * 
	 * @return int The value stored in the primary key column
	 */
	public function getPrimaryKeyValue() {
		return $this->id;
	}
	// end - function getPrimaryKeyValue()
	
	
	/**
	 * getClassAttributeList
	 *
	 * This function returns an array of strings containing all of the names of this classes
	 * attributes except for the identity column
	 * 
	 * @return array An array of strings
	 */
	function getClassAttributeList() {
		$classAttributeList = array(
			"name",
			"totalPoints",
			"weight",
			"classAverage",
			"assignmentId",
			"filePath",
		);
		
		return $classAttributeList;
	}
	// end - getClassAttributeList()
	
	
} 
// END class - assignmentPartGenerated