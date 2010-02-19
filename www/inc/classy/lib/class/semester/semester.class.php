
	

<?php 
/**
 * semester
 */
class semester extends semesterGenerated {
	public function getClasses() {
		$sql = 'SELECT * FROM singleClass WHERE semesterId=:id';
		
		$pdoStatement = $this->prepare($sql);
		$pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
		$success = $pdoStatement->execute();
		
		if (!$success) {
			return FALSE;
		}
		
		$classes = array();
		
		$count = $pdoStatement->rowCount();
		for ($i = 0; $i < $count; $i++) {
			$classes[] = $pdoStatement->fetchObject('singleClass');
		}
		
		return $classes;
	}
} 
// END class - semester