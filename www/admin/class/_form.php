		<fieldset>
			<legend><?php echo $formTitle; ?></legend>
			<p></p>
			<input type="hidden" name="class[id]" value="<?php echo $_POST['class']['id']; ?>" />
			<input type="hidden" name="submitted" value="<?php echo $_POST['submitted']; ?>" />
			<div class="form-element">
				<label for="class[name]" class="form-element-label">Name:</label>
				<input type="text" name="class[name]" size="20" value="<?php echo $_POST['class']['name']; ?>" class="form-element-field" />
			</div>
			<div class="form-element">
				<label for="class[semesterId]" class="form-element-label">Semester:</label>
				<select name="class[semesterId]" class="form-element-field">
					<optgroup label="Select a Semester">
<?php
	$semesters = new semesterList();
	$semesters->load();
	
	foreach ($semesters as $semester) {
		$name = $semester->name;
		$id = $semester->id;
		
		$sel = ($_POST['class']['semesterId'] == $id) ? ' selected' : '';
		
		echo '<option value="' . $id . '"' . $sel . '>' . $name . '</option>';
	}
?>
					</optgroup>
				</select>
			</div>
			<div class="form-submit">
				<input type="submit" name="submit" value="<?php echo $submitLabel; ?>" />
			</div>
		</fieldset>