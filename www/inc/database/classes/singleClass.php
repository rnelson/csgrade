<?php

require_once($GLOBALS['rootPath'] . 'inc/inc.php');

class SingleClass {
	public $id = 0;
	public $name = '';
	public $semesterId = 0;
	
	public function getSemester() {
		if ($db == null) return null;
		return $db->getSemesterById($this->semesterId);
	}
	
	public function getInstructors() {
		$instructors = array();
		
		if ($db != null) {
			$instructors = $db->getInstructorsByClassId($this->id);
		}
		
		return $instructors;
	}
	
	public function getAssignments() {
		$assignments = array();
		
		if ($db != null) {
			$assignments = $db->getAssignmentsByClassId($this->id);
		}
		
		return $assignments;
	}
}

?>