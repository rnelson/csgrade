<?php

$GLOBALS['dateFormat'] = 'm/d/Y';
$GLOBALS['datetimeFormat'] = 'm/d/Y H:i:s';

// http://www.php.net/manual/en/function.strtotime.php#94466
function reformatDate($date, $format='m/d/Y') {
	if (trim($date) == '' || substr($date, 0, 10) == '0000-00-00') {
		return '';
	}
	
	$timestamp = strtotime($date);
	if ($timestamp === false) {
		return '';
	}
	
	return date($format, $timestamp);
}

function dateToTimestamp($date) {
	return strtotime($date);
}

function timestampToDate($timestamp) {
	return date($GLOBALS['dateFormat'], $timestamp);
}

?>