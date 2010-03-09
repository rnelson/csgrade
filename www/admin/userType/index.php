<?php
	$GLOBALS['rootPath'] = '../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - User Types';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	$userTypes = new userTypeList();
	$userTypes->load();
?>

<h1>User Types</h1>

<ol type="1">

<?php
	foreach ($userTypes as $userType) {
		$url = $GLOBALS['rootPath'] . 'admin/userType/show/?id=' . $userType->id;
		$name = $userType->name;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';
	}
?>

</ol>

<p>
	<a href="new/">Create new user type</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
