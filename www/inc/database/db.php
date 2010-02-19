<?php

require_once($GLOBALS['rootPath'] . 'inc/database/classes/assignment.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/assignmentPart.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/comment.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/config.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/grade.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/priv.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/semester.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/singleClass.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/user.php');
require_once($GLOBALS['rootPath'] . 'inc/database/classes/userType.php');

class DB extends PDO {	
	public function __construct($iniFile	) {
		// Read in the INI file
		$settings = parse_ini_file($iniFile, TRUE);
		if (!$settings) {
			throw new exception('Unable to open db.ini');
		}
		
		// Set up our DSN
		$driver = $settings['database']['driver'];
		$host = $settings['database']['host'];
		$port = $settings['database']['port'];
		$dbname = $settings['database']['dbname'];
		$user = $settings['database']['user'];
		$pass = $settings['database']['password'];
		$dsn = $driver . ':host=' . $host . (!empty($port) ? ';port=' . $port : '') . ';dbname=' . $dbname;
		
		// Call the parent constructor to actually connect to the database
		parent::__construct($dsn, $user, $pass);
	}
	
	public function getAllClasses() {
		return $this->getCollectionFromDatabase('*', 'class', 'Class');
	}
	
	public function getAllUsers() {
		return $this->getCollectionFromDatabase('*', 'user', 'User');
	}
	
	public function doesUserTypeHavePrivilege($userType, $privilegeName) {
		$has = false;
		
		// Get the privileges for the specific user type
		$userTypePrivs = $this->getUserTypeById($userType)->privs;
		
		// Look up the numeric value for this privilege
		$priv = $this->getSingleObjectFromDatabase('*', 'priv', 'Priv', 'name', $privilegeName);
		
		// If this type has that privilege, flip $has
		if ($userTypePrivs & $priv->bitvalue) {
			$has = true;
		}
	}
	
	
	
	
	
	
	protected function getSingleObjectFromDatabase($what, $table, $class, $whereField = null, $whereValue = null) {
		$returnObject = null;
		
		try {
			$sql = '';
			
			// If they don't want a WHERE (just getConfig()), we need a different query
			if ($whereField == null || $whereValue == null) {
				$sql = 'SELECT ' . $what . ' FROM ' . $table;
			}
			else {
				$sql = 'SELECT ' . $what . ' FROM ' . $table . ' WHERE ' . $whereField . '=' . $whereValue;
			}
			
			// Query the database
			$statement = $this->query($sql);
			
			// Get the object out as type $class
			$returnObject = $statement->fetchObject($class);
		}
		catch (PDOException $e) {
			echo 'Database error: ' . $e->getMessage();
			$returnObject = null;
		}
		
		return $returnObject;
	}
	
	protected function getSingleColumnFromDatabase($what, $table, $columnNumber, $whereField = null, $whereValue = null) {
		$returnObject = null;
		
		try {
			$sql = '';
			
			// If they don't want a WHERE (just getConfig()), we need a different query
			if ($whereField == null || $whereValue == null) {
				$sql = 'SELECT ' . $what . ' FROM ' . $table;
			}
			else {
				$sql = 'SELECT ' . $what . ' FROM ' . $table . ' WHERE ' . $whereField . '=' . $whereValue;
			}
			
			// Query the database
			$statement = $this->query($sql);
			
			// Get the object out as type $class
			$returnObject = $statement->fetchColumn($columnNumber);
		}
		catch (PDOException $e) {
			echo 'Database error: ' . $e->getMessage();
			$returnObject = null;
		}
		
		return $returnObject;
	}

	protected function getColumnCollectionFromDatabase($what, $table, $columnNumber, $whereField = null, $whereValue = null) {
		$returnArray = array();

		try {
			$sql = '';

			// If they don't want a WHERE (just getConfig()), we need a different query
			if ($whereField == null || $whereValue == null) {
				$sql = 'SELECT ' . $what . ' FROM ' . $table;
			}
			else {
				$sql = 'SELECT ' . $what . ' FROM ' . $table . ' WHERE ' . $whereField . '=' . $whereValue;
			}

			// Query the database
			$statement = $this->query($sql);

			// Get the objects out as type $class
			for ($i = 0; $i < $stmt->rowCount(); $i++) {
				$returnArray[] = $statement->fetchColumn($columnNumber);
			}
		}
		catch (PDOException $e) {
			echo 'Database error: ' . $e->getMessage();
			$returnArray = array();
		}

		return $returnArray;
	}
	
	protected function getCollectionFromDatabase($what, $table, $class, $whereField = null, $whereValue = null) {
		$returnArray = array();

		try {
			$sql = '';

			// If they don't want a WHERE (just getConfig()), we need a different query
			if ($whereField == null || $whereValue == null) {
				$sql = 'SELECT ' . $what . ' FROM ' . $table;
			}
			else {
				$sql = 'SELECT ' . $what . ' FROM ' . $table . ' WHERE ' . $whereField . '=' . $whereValue;
			}

			// Query the database
			$statement = $this->query($sql);

			// Get the objects out as type $class
			$objectCount = $statement->rowCount();
			for ($i = 0; $i < $objectCount; $i++) {
				$returnArray[] = $statement->fetchObject($class);
			}
		}
		catch (PDOException $e) {
			echo 'Database error: ' . $e->getMessage();
			$returnArray = array();
		}

		return $returnArray;
	}
	
	public function getAssignmentById($assignmentId) {
		return $this->getSingleObjectFromDatabase('*', 'assignment', 'Assignment', 'id', $assignmentId);
	}
	
	public function getAssignmentsByClassId($classId) {
		return $this->getCollectionFromDatabase('*', 'assignment', 'Assignment', 'classId', $classId);
	}
	
	public function getAssignmentPartsByAssignmentId($assignmentId) {
		return $this->getCollectionFromDatabase('*', 'assignmentPart', 'AssignmentPart', 'assignmentId', $assignmentId);
	}
	
	public function getAssignmentPartById($assignmentPartId) {
		return $this->getSingleObjectFromDatabase('*', 'assignmentPart', 'AssignmentPart', 'id', $assignmentPartId);
	}
	
	public function getClassById($classId) {
		return $this->getSingleObjectFromDatabase('*', 'singleClass', 'SingleClass', 'id', $classId);
	}
	
	public function getClassesByInstructorId($instructorId) {
		$classes = array();
		
		// Get all of the IDs for classes that this instructor is involved in
		$classIds = $this->getColumnCollectionFromDatabase('classId', 'instructorClassXref', 0, 'instructorId', $instructorId);
		
		// Now get all of the class objects
		$classCount = count($classIds);
		for ($i = 0; $i < $classCount; $i++) {
			$classes[] = $this->getSingleObjectFromDatabase('*', 'singleClass', 'SingleClass', 'id', $classIds[$i]);
		}
		
		return $classes;
	}
	
	public function getClasses() {
		return $this->getCollectionFromDatabase('*', 'singleClass', 'SingleClass');
	}
	
	public function getClassesBySemester($semesterId) {
		return $this->getCollectionFromDatabase('*', 'singleClass', 'SingleClass', 'semesterId', $semesterId);
	}
	
	public function getCommentById($commentId) {
		return $this->getSingleObjectFromDatabase('*', 'comment', 'Comment', 'id', $commentId);
	}
	
	public function getConfig() {
		return $this->getSingleObjectFromDatabase('*', 'config', 'Config');
	}
	
	public function getGradeById($gradeId) {
		return $this->getSingleObjectFromDatabase('*', 'grade', 'Grade', 'id', $gradeId);
	}
	
	public function getInstructorsByClassId($classId) {
		$instructors = array();
		
		// Get all of the IDs for instructors attached to this class
		$instructorIds = $this->getColumnCollectionFromDatabase('instructorId', 'instructorClassXref', 0, 'classId', $classId);
		
		// Now get all of the instructor objects
		$instructorCount = count($instructorIds);
		for ($i = 0; $i < $instructorCount; $i++) {
			$instructors[] = $this->getSingleObjectFromDatabase('*', 'user', 'User', 'id', $instructorIds[$i]);
		}
		
		return $instructors;
	}
	
	public function getSemesterById($semesterId) {
		return $this->getSingleObjectFromDatabase('*', 'semester', 'Semester', 'id', $semesterId);
	}
	
	public function getStudentsInClass($classId) {
		$students = array();
		
		// Get all of the IDs for students in this class
		$studentIds = $this->getColumnCollectionFromDatabase('studentId', 'studentClassXref', 0, 'classId', $classId);
		
		// Now get all of the student objects
		$studentCount = count($studentIds);
		for ($i = 0; $i < $studentCount; $i++) {
			$students[] = $this->getSingleObjectFromDatabase('*', 'user', 'User', 'id', $studentIds[$i]);
		}
		
		return $students;
	}
	
	public function getUserById($userId) {
		return $this->getSingleObjectFromDatabase('*', 'user', 'User', 'id', $userId);
	}
	
	public function getUserTypeById($userTypeId) {
		return $this->getSingleObjectFromDatabase('*', 'userType', 'UserType', 'id', $userTypeId);
	}
}

?>