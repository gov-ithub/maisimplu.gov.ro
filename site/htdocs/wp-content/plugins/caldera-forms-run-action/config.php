<div class="caldera-config-group">
	<label><?php echo __('Position'); ?> </label>
	<div class="caldera-config-field">
		<select class="block-input field-config" name="{{_name}}[position]">

		<option value="pre" {{#is position value="pre"}}selected="selected"{{/is}}><?php _e('Pre-Process'); ?></option>
		<option value="process" {{#is position value="process"}}selected="selected"{{/is}}><?php _e('Process'); ?></option>
		<option value="post" {{#is position value="post"}}selected="selected"{{/is}}><?php _e('Post-Process'); ?></option>

		</select>
	</div>
</div>
<div class="caldera-config-group">
	<label><?php echo __('type'); ?> </label>
	<div class="caldera-config-field">
		<select class="block-input field-config" name="{{_name}}[type]">

			<option value="filter" {{#is type value="filter"}}selected="selected"{{/is}}><?php _e('Filter'); ?></option>
			<option value="action" {{#is type value="action"}}selected="selected"{{/is}}><?php _e('Action'); ?></option>

		</select>
	</div>
</div>

<div class="caldera-config-group">
	<label><?php echo __('Action / Filter'); ?> </label>
	<div class="caldera-config-field">
		<input type="text" class="block-input field-config" name="{{_name}}[action]" value="{{action}}">
	</div>
</div>
