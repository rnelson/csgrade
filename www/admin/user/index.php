<?php
	$GLOBALS['rootPath'] = '../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Users';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	$users = new userList();
	$users->load();
?>

<h1>Users</h1>

<p>
	<ol type="1">

<?php
	foreach ($users as $user) {
		$url = $GLOBALS['rootPath'] . 'admin/user/show/?id=' . $user->id;
		$realName = $user->getRealName();
		$uname = $user->username;
		
		echo '<li><a href="' . $url . '">' . $realName . '</a> (' . $uname . ')</li>';	
	}
?>

	</ol>
</p>

<p>
	<a href="new/">Create new user</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
