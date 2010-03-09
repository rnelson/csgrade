		<fieldset>
			<legend><?php echo $formTitle; ?></legend>
			<p></p>
			<input type="hidden" name="priv[id]" value="<?php echo $_POST['priv']['id']; ?>" />
			<input type="hidden" name="priv[bitvalue]" value="<?php echo $_POST['priv']['bitvalue']; ?>" />
			<input type="hidden" name="submitted" value="<?php echo $_POST['submitted']; ?>" />
			<div class="form-element">
				<label for="priv[name]" class="form-element-label">Name:</label>
				<input type="text" name="priv[name]" size="20" value="<?php echo $_POST['priv']['name']; ?>" class="form-element-field" />
			</div>
			<div class="form-submit">
				<input type="submit" name="submit" value="<?php echo $submitLabel; ?>" />
			</div>
		</fieldset>