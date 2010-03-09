<?php
	$jQueryUiJsDir = $themeDir . 'js/jquery-ui-1.7.2';
	$jQueryUiCssDir = $themeDir . 'css/jquery-ui-themes-1.7.2/themes/flick';
?>
<html>
	<head>
<?php
	$pageTitle = '';
	if (isset($title)) {
		$left = $GLOBALS['theme']->theme['defaultTitle']['titleLeft'];
		$right = $GLOBALS['theme']->theme['defaultTitle']['titleRight'];
		$pageTitle = $left . $title . $right;
	}
	else {
		$pageTitle = $GLOBALS['theme']->theme['defaultTitle']['emptyTitle'];
	}
?>
		<title><?php echo $pageTitle; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $themeDir; ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $jQueryUiCssDir; ?>/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $jQueryUiCssDir; ?>/ui.all.css" />
		<script type="text/javascript" src="<?php echo $jQueryUiJsDir; ?>/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="<?php echo $jQueryUiJsDir; ?>/ui/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo $jQueryUiJsDir; ?>/ui/ui.datepicker.js"></script>
<?php
	if (isset($jqueryCode)) {
?>
		<script type = "text/javascript">
<?php echo $jqueryCode; ?>
		</script>
<?php
	}
?>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<h1>csgrade</h1>
			</div>
			<div id="nav">
				<ul>
					<li><a href="<?php echo $GLOBALS['rootPath'] ?>index.php">Home</a> |</li>
					<li><a href="<?php echo $GLOBALS['rootPath'] ?>admin/index.php">Admin</a></li>
					<!--
					
					<li><a href="<?php echo $GLOBALS['rootPath'] ?>schedule.php">Schedule</a> |</li>
					<li><a href="<?php echo $GLOBALS['rootPath'] ?>resources.php">Resources</a> |</li>
					<li><a href="http://cse.unl.edu/~cse150efl/handin">Handin</a></li>
					
					-->
				</ul>
			</div>
			<div id="content">
