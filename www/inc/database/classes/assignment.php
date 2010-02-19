<?php

require_once($GLOBALS['rootPath'] . 'inc/inc.php');

class Assignment {
	public $id = 0;
	public $name = '';
	public $totalPoints = 0;
	public $weight = 0.0;
	public $classAveriage = 0.0;
	public $classId = 0;
	
	public function getSemester() {
		if ($db == null) return null;
		return $db->getClassById($this->classId)->getSemester();
	}
	
	public function getClass() {
		if ($db == null) return null;
		return $db->getClassById($this->classId);
	}
	
	public function getParts() {
		if ($db == null) return null;
		return $db->getAssignmentPartsByAssignmentId($this->id);
	}
}

?>
