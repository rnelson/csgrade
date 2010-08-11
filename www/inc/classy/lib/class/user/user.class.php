
	

<?php 
/**
 * user
 */
class user extends userGenerated {
	public function getLink($root=$GLOBALS['rootPath'], $admin=TRUE) {
		$showPath = '';
		
		if ($admin) {
			$showPath = 'admin/user/show/';
		}
		
		$link = '<a href="' . $root . $showPath . '?id=' . $this->id . '">' $this->getRealName() . '</a>';
		
		return $link;
	}
	
	public function getRealName() {
		$realName = '';
		$firstName = trim($this->firstName);
		$lastName = trim($this->lastName);
		
		if (!empty($firstName)) {
			$realName .= $firstName;
		}
		
		if (!empty($firstName) && (!empty($lastName))) {
			$realName .= ' ';
		}
		
		if (!empty($lastName)) {
			$realName .= $lastName;
		}
		
		return $realName;
	}
	
	public function getClasses() {
		// Get the IDs for classes this student is in
		$pdoStatement = $this->getSqlForClasses();
		$success = $pdoStatement->execute();
		
		if (!$success) {
			return FALSE;
		}
		
		$classes = array();
		$count = $pdoStatement->rowCount();
		
		for ($i = 0; $i < $count; $i++) {
			// Set up a query to find that specific class
			$sql = 'SELECT * FROM singleClass WHERE classId=:id';
			$internalStatement = $this->prepare($sql);
			$internalStatement->bindValue(':id', $pdoStatement->fetchColumn());
			
			$success = $internalStatement->execute();
			
			if ($success) {
				$classes[] = $internalStatement->fetchObject('singleClass');
			}
		}
		
		return $classes;
	}
	
	public function getCurrentClasses() {
		$allClasses = $this->getClasses();
		$classes = array();
		$now = time();
		
		// Add any class that started before now and ended after now
		foreach ($allClasses as $class) {
			$semester = $class->getSemester();
			
			if ($semester->startDate <= $now && $semester->endDate >= $now) {
				$classes[] = $class;
			}
		}
		
		return $classes;
	}
	
	public function getPastClasses() {
		$allClasses = $this->getClasses();
		$classes = array();
		$now = time();
		
		// Add any class that ended before now
		foreach ($allClasses as $class) {
			$semester = $class->getSemester();
			
			if ($semester->endDate < $now) {
				$classes[] = $class;
			}
		}
		
		return $classes;
	}
	
	public function getFutureClasses() {
		$allClasses = $this->getClasses();
		$classes = array();
		$now = time();
		
		// Add any class that start after now
		foreach ($allClasses as $class) {
			$semester = $class->getSemester();
			
			if ($semester->startDate > $now) {
				$classes[] = $class;
			}
		}
		
		return $classes;
	}
	
	private function getSqlForClasses() {
		$sql = 'SELECT classId FROM studentClassXref WHERE studentId=:id';
		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
		
		return $pdoStatement;
	}
} 
// END class - user