		<fieldset>
			<legend><?php echo $formTitle; ?></legend>
			<p></p>
			<input type="hidden" name="user[id]" value="<?php echo $_POST['user']['id']; ?>" />
			<input type="hidden" name="submitted" value="<?php echo $_POST['submitted']; ?>" />
			<div class="form-element">
				<label for="password" class="form-element-label">Password:</label>
				<input type="password" name="password" size="20" value="<?php echo $_POST['password']; ?>" class="form-element-field" />
			</div>
			<div class="form-submit">
				<input type="submit" name="submit" value="<?php echo $submitLabel; ?>" />
			</div>
		</fieldset>