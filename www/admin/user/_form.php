		<fieldset>
			<legend><?php echo $formTitle; ?></legend>
			<p></p>
			<input type="hidden" name="user[id]" value="<?php echo $_POST['user']['id']; ?>" />
			<input type="hidden" name="submitted" value="<?php echo $_POST['submitted']; ?>" />
			<div class="form-element">
				<label for="user[username]" class="form-element-label">Username:</label>
				<input type="text" name="user[username]" size="20" value="<?php echo $_POST['user']['username']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="user[firstName]" class="form-element-label">First Name:</label>
				<input type="text" name="user[firstName]" size="20" value="<?php echo $_POST['user']['firstName']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="user[lastName]" class="form-element-label">Last Name:</label>
				<input type="text" name="user[lastName]" size="20" value="<?php echo $_POST['user']['lastName']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="user[email]" class="form-element-label">Email:</label>
				<input type="text" name="user[email]" size="20" value="<?php echo $_POST['user']['email']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="user[userTypeId]" class="form-element-label">Type:</label>
				<select name="user[userTypeId]" class="form-element-field">
					<optgroup label="Select a Type">
<?php
	$userTypes = new userTypeList();
	$userTypes->load();
	
	foreach ($userTypes as $type) {
		$name = $type->name;
		$id = $type->id;
		
		$sel = ($_POST['user']['userTypeId'] == $id) ? ' selected' : '';
		
		echo '<option value="' . $id . '"' . $sel . '>' . $name . '</option>';
	}
?>
					</optgroup>
				</select>
			</div>
<?php if ($newUser) { ?>
			<div class="form-element">
				<label for="password" class="form-element-label">Password:</label>
				<input type="password" name="password" size="20" value="<?php echo $_POST['password']; ?>" class="form-element-field" />
			</div>
<?php } ?>
			<div class="form-submit">
				<input type="submit" name="submit" value="<?php echo $submitLabel; ?>" />
			</div>
		</fieldset>