<?php

require_once($rootPath . 'inc/inc.php');

class Comment {
	public $id = 0;
	public $gradeId = 0;
	public $assignmentPartId = 0;
	public $userId = 0;
	public $replyId = 0;
	public $commentText = '';
	
	public function getAssignmentPart() {
		if ($db == null) return null;
		return $db->getAssignmentPartById($this->assignmentPartId);
	}
	
	public function getGrade() {
		if ($db == null) return null;
		return $db->getGradeById($this->gradeId);
		
	}
	
	public function getAuthor() {
		if ($db == null) return null;
		return $db->getUserById($this->userId);
	}
	
	public function getReply() {
		if ($this->commentId < 1) return null;
		if ($db == null) return null;
		return $db->getCommentById($this->replyId);
	}
}

?>
