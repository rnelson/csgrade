<?php

require_once($GLOBALS['rootPath'] . 'inc/inc.php');

class AssignmentPart {
	public $id = 0;
	public $name = '';
	public $totalPoints = 0;
	public $weight = 0.0;
	public $classAveriage = 0.0;
	public $assignmentId = 0;
	public $filePath = '';
	
	public function getAssignment() {
		if ($db == null) return null;
		return $db->getAssignmentById($this->assignmentId);
	}
	
	public function getClass() {
		if ($db == null) return null;
		return $db->getAssignmentById($this->assignmentId)->getClass();
	}
	
	public function getGrades() {
		// TODO: write me
	}
}

?>
