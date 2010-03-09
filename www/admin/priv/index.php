<?php
	$GLOBALS['rootPath'] = '../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	$title = 'Admin - Privileges';
	require_once($GLOBALS['themeDir'] . 'header.php');
	
	$privs = new privList();
	$privs->load();
?>

<h1>Privileges</h1>

<ol type="1">

<?php
	foreach ($privs as $priv) {
		$url = $GLOBALS['rootPath'] . 'admin/priv/show/?id=' . $priv->id;
		$name = $priv->name;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';	
	}
?>

</ol>

<p>
	<a href="new/">Create new privilege</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
