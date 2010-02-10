<?php

require_once($rootPath . 'inc/inc.php');

class Semester {
	public $id = 0;
	public $name = '';
	public $startDate = 0;
	public $endDate = 0;
	
	public function getClasses() {
		if ($db == null) return null;
		return $db->getClassesBySemester($this->id);
	}
}

?>
