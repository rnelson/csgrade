
	

<?php
/**
 * privList
 **/
class privList extends databaseLoadableObjectList {
	public function getNextBitvalue() {
		$sql = 'SELECT MAX(bitvalue) AS MaxBitValue FROM priv';
		$pdoStatement = $this->prepare($sql);
		$success = $pdoStatement->execute();
		
		if (!$success) {
			return FALSE;
		}
		
		$max = $pdoStatement->fetchColumn();
		return $max * 2;
	}
} 
// END class - privList