<?php

require_once($rootPath . 'inc/inc.php');

class User {
	public $id = 0;
	public $userTypeId = 0;
	public $username = '';
	public $passwd = ''; // hash
	public $firstName = '';
	public $lastName = '';
	public $email = '';
	
	public function getUserType() {
		if ($db == null) return null;
		return $db->getUserTypeById($this->userTypeId);
	}
}

?>