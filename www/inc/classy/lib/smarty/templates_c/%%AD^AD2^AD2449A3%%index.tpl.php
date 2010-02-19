<?php /* Smarty version 2.6.23-dev, created on 2010-02-15 13:03:19
         compiled from generator/index.tpl */ ?>

	

<link rel="stylesheet" type="text/css" href="/worthlessevents/lib/style.css" /> 
<script src="/worthlessevents/lib/js/generator/index.js"></script>

<form method="POST" action="generate.php" onSubmit="return validateGenerator()">
	<label for="tableName">Table Name:</label><br>
	
	<select name="tableName" id="tableName">
		<option value="" selected>--Select a Table--</option>
	<?php $_from = $this->_tpl_vars['tableList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['table']):
?>
		<option value="<?php echo $this->_tpl_vars['table']->tableName; ?>
"><?php echo $this->_tpl_vars['table']->tableName; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	</select>

	<input type="hidden" name="action" value="generate">
	<input type="submit" name="generate" value="Generate">
</form>