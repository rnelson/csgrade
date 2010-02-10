<?php

require_once($rootPath . 'inc/inc.php');

class UserType {
	public $id = 0;
	public $name = '';
	public $privs = 0;
	public $dbh = null;
	
	public function hasPrivilege($name = '') {
		if ($db == null) return false;
		return $db->getUserTypeById($this->id, $name);
	}
}

?>