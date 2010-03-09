		<fieldset>
			<legend><?php echo $formTitle; ?></legend>
			<p></p>
			<input type="hidden" name="userType[id]" value="<?php echo $_POST['userType']['id']; ?>" />
			<input type="hidden" name="currentMask" value="<?php echo $_POST['userType']['privs']; ?>" />
			<input type="hidden" name="submitted" value="<?php echo $_POST['submitted']; ?>" />
			<div class="form-element">
				<label for="userType[name]" class="form-element-label">Name:</label>
				<input type="text" name="userType[name]" size="20" value="<?php echo $_POST['userType']['name']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="privs[]" class="form-element-label">Privileges:</label>
<?php
	$privs = new privList();
	$privs->load();
	
	foreach ($privs as $priv) {
		$name = $priv->name;
		$id = $priv->id;
		$bitvalue = $priv->bitvalue;
		
		$sel = ($_POST['userType']['privs'] & $bitvalue) ? ' checked' : '';
		
		echo '<span class="form-element-indent"><input type="checkbox" name="privs[]" value="' . $bitvalue . '"' . $sel . ' />' . $name . '</span>';
	}
?>
			</div>
			<div class="form-submit">
				<input type="submit" name="submit" value="<?php echo $submitLabel; ?>" />
			</div>
		</fieldset>