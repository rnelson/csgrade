		<fieldset>
			<legend><?php echo $formTitle; ?></legend>
			<p></p>
			<input type="hidden" name="semester[id]" value="<?php echo $_POST['semester']['id']; ?>" />
			<input type="hidden" name="submitted" value="<?php echo $_POST['submitted']; ?>" />
			<div class="form-element">
				<label for="semester[name]" class="form-element-label">Name:</label>
				<input type="text" name="semester[name]" size="20" value="<?php echo $_POST['semester']['name']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="semester[startDate]" class="form-element-label">Start Date:</label>
				<input type="text" name="semester[startDate]" size="20" value="<?php echo $_POST['semester']['startDate']; ?>" class="form-element-field" id="semester-start-date" />
			</div>
			<div class="form-element">
				<label for="semester[endDate]" class="form-element-label">End Date:</label>
				<input type="text" name="semester[endDate]" size="20" value="<?php echo $_POST['semester']['endDate']; ?>" class="form-element-field" id="semester-end-date" />
			</div>
			<div class="form-element">
				<label for="semester[description]" class="form-element-label">Description:</label>
				<textarea name="semester[description]" rows="7" cols="80"><?php echo $_POST['semester']['description']; ?></textarea>
			</div>
			<div class="form-submit">
				<input type="submit" name="submit" value="<?php echo $submitLabel; ?>" />
			</div>
		</fieldset>