<?php

require_once($GLOBALS['rootPath'] . 'inc/inc.php');

class Grade {
	public $id = 0;
	public $assignmentPartId = 0;
	public $studentID = 0;
	public $points = 0;
	public $percentage = 0.0;
	public $commentId = 0;
	
	public function getAssignmentPart() {
		if ($db == null) return null;
		return $db->getAssignmentPartById($this->assignmentPartId);
	}
	
	public function getClass() {
		if ($db == null) return null;
		return $this->getAssignmentPart()->getClass();
		
	}
	
	public function getComment() {
		if ($db == null) return null;
		return $db->getCommentById($this->commentId);
	}
}

?>
