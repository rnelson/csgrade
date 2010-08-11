
	

<?php 
/**
 * singleClass
 */
class singleClass extends singleClassGenerated {
	public function getLink($root=$GLOBALS['rootPath'], $admin=TRUE) {
		$showPath = '';
		
		if ($admin) {
			$showPath = 'admin/class/show/';
		}
		
		$link = '<a href="' . $root . $showPath . '?id=' . $this->id . '">' $this->name . '</a>';
		
		return $link;
	}
	
	public function getSemester() {
		$semester = new semester();
		$semester->loadById($this->semesterId);
		return $semester;
	}
} 
// END class - singleClass