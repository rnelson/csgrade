
	

<?php 
/**
 * instructorType
 */
class instructorType extends instructorTypeGenerated {
	public function getInstructors() {
		$instructors = array();
		
		$sql = 'SELECT instructorId FROM instructorClassXref WHERE instructorTyepId=:id';
		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
		
		$success = $pdoStatement->execute();
		
		if (!$success) {
			return FALSE;
		}
		
		$count = $pdoStatement->rowCount();
		for ($i = 0; $i < $count; $i++) {
			$instructorId = $pdoStatement->fetchColumn();
			
			$sql = 'SELECT * FROM user WHERE id=:id';
			$innerStatement = $this->prepare($sql);
			$innerStatement->bindValue(':id', $instructorId);
			
			$success = $innerStatement->execute();
			
			if ($success) {
				$instructors[] = $innerStatement->fetchObject('user');
			}
		}
		
		return $instructors;
	}
	
	public function getInstructorsAndClasses() {
		$ret = array();
		
		$sql = 'SELECT instructorId, classId FROM instructorClassXref WHERE instructorTypeId=:id';
		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
		
		$success = $pdoStatement->execute();
		
		if (!$success) {
			return FALSE;
		}
		
		$count = $pdoStatement->rowCount();
		for ($i = 0; $i < $count; $i++) {
			$instructorId = $pdoStatement->fetchColumn(0);
			$classId = $pdoStatement->fetchColumn(1);
			
			// Instructor
			$instructorSQL = 'SELECT * FROM user WHERE id=:id';
			$instructorStatement = $this->prepare($instructorSQL);
			$instructorStatement->bindValue(':id', $instructorId, PDO::PARAM_INT);
			$instructorSuccess = $instructorStatement->execute();
			
			// Class
			$classSQL = 'SELECT * FROM singleClass WHERE id=:id';
			$classStatement = $this->prepare($classSQL);
			$classStatement->bindValue(':id', $classId, PDO::PARAM_INT);
			$classSuccess = $classStatement->execute();
			
			if ($instructorSuccess && $classSuccess) {
				$instructor = $instructorStatement->fetchObject('user');
				$class = $classStatement->fetchObject('singleClass');
				
				$new = array('instructor' => $instructor, 'class' => $class);
				$ret[] = $new;
			}
		}
		
		return $ret;
	}
}
// END class - instructorType