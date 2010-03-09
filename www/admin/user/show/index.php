<?php
	$GLOBALS['rootPath'] = '../../../';
	require_once($GLOBALS['rootPath'] . 'inc/inc.php');
	$themeDir = $GLOBALS['rootPath'] . 'inc/themes/default/';
	
	// Grab the object
	$user = new user($_GET['id']);
	
	// Set the title
	if (!$user)
		$title = 'Admin - Users - User not found';
	else
		$title = 'Admin - Users - ' . $user->username;
	
	// Load the UI
	require_once($GLOBALS['themeDir'] . 'header.php');
?>

<?php if (!$user->id) { ?>
<p>
	<strong>Error:</strong> user not found.
</p>
<?php
	}
	else {
		$userType = new userType($user->userTypeId);
		
		$pastClasses = $user->getPastClasses();
		$currentClasses = $user->getCurrentClasses();
		$futureClasses = $user->getFutureClasses();
?>

<h1><?php echo $user->getRealName(); ?></h1>

<table border="0">
	<tr>
		<td>Type:</td>
		<td><?php echo $userType->name; ?></td>
	</tr>
	<tr>
		<td>Username:</td>
		<td><?php echo $user->username; ?></td>
	</tr>
	<tr>
		<td>Real Name:</td>
		<td><?php echo $user->getRealName(); ?></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></td>
	</tr>
	<tr>
		<td>Theme:</td>
		<td><em><?php echo $user->theme; ?></em></td>
	</tr>
</table>

<?php if (!empty($currentClasses)) { ?>
<p>
	Current Classes:<br />
	<ul>
<?php
	foreach ($currentClasses as $class) {
		$name = $class->name;
		$url = $url = $GLOBALS['rootPath'] . 'admin/class/show/?id=' . $class->id;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';	
	}
?>
	</ul>
</p>
<?php } ?>

<?php if (!empty($futureClasses)) { ?>
<p>
	Future Classes:<br />
	<ul>
<?php
	foreach ($futureClasses as $class) {
		$name = $class->name;
		$url = $url = $GLOBALS['rootPath'] . 'admin/class/show/?id=' . $class->id;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';	
	}
?>
	</ul>
</p>
<?php } ?>

<?php if (!empty($pastClasses)) { ?>
<p>
	Past Classes:<br />
	<ul>
<?php
	foreach ($pastClasses as $class) {
		$name = $class->name;
		$url = $url = $GLOBALS['rootPath'] . 'admin/class/show/?id=' . $class->id;
		
		echo '<li><a href="' . $url . '">' . $name . '</a></li>';	
	}
?>
	</ul>
</p>
<?php } ?>

<p>
	<a href="../edit/password/?id=<?php echo $user->id; ?>">Change Password</a>
	<a href="../edit/?id=<?php echo $user->id; ?>">Edit</a>
	<a href="../delete/?id=<?php echo $user->id; ?>">Delete</a>
</p>

<?php } ?>

<p>
	<a href="../">Back</a>
</p>

<?php
	require_once($GLOBALS['themeDir'] . 'footer.php');
?>
