
	
 
<?php
/**
 * gradeGenerated
 *
 *	AUTO GENERATED CODE DO NOT MODIFY
 * 
 *  If you must make modifications make them in
 *	the leaf class so that they don't get overwritten
 * 	if you regenerate your code.
 *
 **/
class gradeGenerated extends databaseLoadableObject {

	
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
	 * assignmentPartId
	 *
	 * @var int
	 **/
	public $assignmentPartId;


	/**
	 * studentId
	 *
	 * @var int
	 **/
	public $studentId;


	/**
	 * points
	 *
	 * @var int
	 **/
	public $points;


	/**
	 * percentage
	 *
	 **/
	public $percentage;


	/**
	 * commentId
	 *
	 * @var int
	 **/
	public $commentId;


	

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
			
			case "assignmentPartId":
				$columnType = PDO::PARAM_INT;
				break;
			
			case "studentId":
				$columnType = PDO::PARAM_INT;
				break;
			
			case "points":
				$columnType = PDO::PARAM_INT;
				break;
			
			case "percentage":
				$columnType = decimal(7,4);
				break;
			
			case "commentId":
				$columnType = PDO::PARAM_INT;
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
			case "assignmentPartId":
				$columnLength = "";
				break;
			case "studentId":
				$columnLength = "";
				break;
			case "points":
				$columnLength = "";
				break;
			case "percentage":
				$columnLength = "";
				break;
			case "commentId":
				$columnLength = "";
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
			"assignmentPartId",
			"studentId",
			"points",
			"percentage",
			"commentId",
		);
		
		return $classAttributeList;
	}
	// end - getClassAttributeList()
	
	
} 
// END class - gradeGenerated