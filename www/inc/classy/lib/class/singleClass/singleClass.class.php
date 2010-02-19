
	

<?php 
/**
 * singleClass
 */
class singleClass extends singleClassGenerated {
	public function getSemester() {
		$semester = new semester();
		$semester->loadById($this->semesterId);
		return $semester;
	}
} 
// END class - singleClass