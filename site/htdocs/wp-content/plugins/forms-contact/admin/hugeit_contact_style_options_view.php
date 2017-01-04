<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( function_exists( 'current_user_can' ) ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		die( 'Access Denied' );
	}
}
if ( ! function_exists( 'current_user_can' ) ) {
	die( 'Access Denied' );
}
require_once("hugeit_free_version.php");
function hugeit_contact_html_styles($rows){
	global $wpdb;
	?>
    <script language="javascript">
		function ordering(name,as_or_desc) {
			document.getElementById('asc_or_desc').value=as_or_desc;		
			document.getElementById('order_by').value=name;
			document.getElementById('admin_form').submit();
		}
		function saveorder() {
			document.getElementById('saveorder').value="save";
			document.getElementById('admin_form').submit();
			
		}
		function listItemTask(this_id,replace_id) {
			document.getElementById('oreder_move').value=this_id+","+replace_id;
			document.getElementById('admin_form').submit();
		}
		function doNothing() {
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if( keyCode == 13 ) {

				if(!e) var e = window.event;

				e.cancelBubble = true;
				e.returnValue = false;

				if (e.stopPropagation) {
					e.stopPropagation();
					e.preventDefault();
				}
			}
		}
	</script>

<div class="wrap">
	<?php hugeit_contact_drawFreeBanner('yes');?>
	<div id="poststuff">
		<div id="hugeit_contacts-list-page">
			<form method="post"  onkeypress="doNothing()" action="admin.php?page=hugeit_forms_main_page" id="admin_form" name="admin_form">
				<?php if(!isset($_GET["form_id"]))$_GET["form_id"]='';?>
			<h2>Huge IT Forms Themes
				<a onclick="alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');" class="add-new-h2" >Add New Theme <i>(pro)</i></a>
			</h2>
			
			<?php
			if ( isset( $_POST['serch_or_not'] ) ) {
				$serch_value = $_POST['serch_or_not'] == "search" ? esc_html( stripslashes( $_POST['search_events_by_title'] ) ) : "";
			}
			$serch_fields='<div class="alignleft actions"">				
			<div class="alignleft actions">
				<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
				 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
				 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=hugeit_forms_main_page\'" class="button-secondary action">
			</div>';
			?>
			<table class="wp-list-table widefat fixed pages" style="width:95%">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span>Last Update</span><span class="sorting-indicator"></span></th>
					<th style="width:40px">Delete</th>
				 </tr>
				</thead>
				<tbody>
				 <?php
				 $trcount = 1;
				 for ( $i = 0; $i < count( $rows ); $i ++ ) :
					 $trcount ++;
					 $ka0 = 0;
					 $ka1 = 0;
					 $move_up = "";
					 if ( isset( $rows[ $i - 1 ]->id ) ) {
						 if ( isset( $rows[ $i ]->hc_width ) ) {
							 if ( $rows[ $i ]->hc_width == $rows[ $i - 1 ]->hc_width ) {
								 $x1  = $rows[ $i ]->id;
								 $x2  = $rows[ $i - 1 ]->id;
								 $ka0 = 1;
							 } else {
								 $jj = 2;
								 while ( isset( $rows[ $i - $jj ] ) ) {
									 if ( $rows[ $i ]->hc_width == $rows[ $i - $jj ]->hc_width ) {
										 $ka0 = 1;
										 $x1  = $rows[ $i ]->id;
										 $x2  = $rows[ $i - $jj ]->id;
										 break;
									 }
									 $jj ++;
								 }
							 }

							 if ( $ka0 ) {
								 $move_up = '<span><a href="#reorder" onclick="return listItemTask(\'' . $x1 . '\',\'' . $x2 . '\')" title="Move Up">   <img src="' . plugins_url( 'images/uparrow.png', __FILE__ ) . '" width="16" height="16" border="0" alt="Move Up"></a></span>';
							 }
						 }
					 }
					 if ( isset( $rows[ $i + 1 ]->id ) ) {
						 if ( isset( $rows[ $i ]->hc_width ) ) {
							 if ( $rows[ $i ]->hc_width == $rows[ $i + 1 ]->hc_width ) {
								 $x1  = $rows[ $i ]->id;
								 $x2  = $rows[ $i + 1 ]->id;
								 $ka1 = 1;
							 } else {
								 $jj = 2;
								 while ( isset( $rows[ $i + $jj ] ) ) {
									 if ( $rows[ $i ]->hc_width == $rows[ $i + $jj ]->hc_width ) {
										 $ka1 = 1;
										 $x1  = $rows[ $i ]->id;
										 $x2  = $rows[ $i + $jj ]->id;
										 break;
									 }
									 $jj ++;
								 }
							 }

							 $move_down = "";

							 if ( $ka1 ) {
								 $move_down = '<span><a href="#reorder" onclick="return listItemTask(\'' . $x1 . '\',\'' . $x2 . '\')" title="Move Down">  <img src="' . plugins_url( 'images/downarrow.png', __FILE__ ) . '" width="16" height="16" border="0" alt="Move Down"></a></span>';
							 }
						 }
					 }
					 if ( ! isset( $rows[ $i ]->par_name ) ) {
						 $rows[ $i ]->par_name = '';
					 }
					 $uncat = $rows[ $i ]->par_name;
					 if ( isset( $rows[ $i ]->last_update ) ) {
						 $pr_count = $rows[ $i ]->last_update;
					 } else {
						 $pr_count = 0;
					 }


					 ?>
					<tr <?php if($trcount%2==0) { echo 'class="has-background"';}?>>
						<td><?php echo $rows[$i]->id; ?></td>
						<td><a  href="admin.php?page=hugeit_forms_theme_options&form_id=<?php echo $rows[$i]->id?>"><?php echo esc_html(stripslashes($rows[$i]->name)); ?></a></td>
						<td><?php if(!($pr_count)){echo '0';} else{ echo $rows[$i]->last_update;} ?></td>
						<td><?php if($rows[$i]->id!=1):?><a  href="#" onclick="alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');	" >Delete <i>(pro)</i></a><?php endif; ?></td>
					</tr> 
				 <?php endfor; ?>
				</tbody>
			</table>
			<input type="hidden" name="oreder_move" id="oreder_move" value="" />
			<input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo esc_attr($_POST['asc_or_desc']);?>"  />
			<input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo esc_attr($_POST['order_by']);?>"  />
			<input type="hidden" name="saveorder" id="saveorder" value="" />
			</form>
		</div>
	</div>
</div>
    <?php
}
function hugeit_contact_html_editstyles($param_values, $op_type, $style_themes){?>
<!-- STYLES CUSTOMIZATION PAGE -->
<div class="wrap">
<?php hugeit_contact_drawFreeBanner('yes');?>
<div id="poststuff">
		<?php $path_site = plugins_url("Front_images", __FILE__); ?>
		<input type="hidden" id="type" name="type" value="<?php echo isset($_POST['type']) ? $_POST['type'] : '1'; ?>"/> 
          <script>
        	function hugeit_contact_updateInput(ish){
			    document.getElementById("themeName").value = ish;
			}      
		</script>
		<div class="hugeit_tabs_block">
			
			<ul id="" class="hugeit_contact_top_tabs">
				<?php
				foreach($style_themes as $style_theme){
					if($style_theme->id != $_GET['form_id']){
					?>
						<li>
							<a href="#" onclick="window.location.href='admin.php?page=hugeit_forms_theme_options&form_id=<?php echo $style_theme->id; ?>'" ><?php echo $style_theme->name; ?></a>
						</li>
					<?php
					}
					else{ ?>
						<li class="active" onclick="this.firstElementChild.style.width = ((this.firstElementChild.value.length + 1) * 8) + 'px';" style="background-image:url(<?php echo plugins_url('../images/edit.png', __FILE__) ;?>);cursor:pointer;">
							<input onfocus="this.style.width = ((this.value.length + 2) * 10) + 'px'" onkeyup="hugeit_contact_updateInput(this.value)" class="text_area" type="text" name="name" id="name" maxlength="250" value="<?php echo esc_html(stripslashes($style_theme->name));?>" />
						</li>
					<?php	
					}
				}
				?>
				<li class="add-new">
					<a onclick="alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');	">+</a>
				</li>
			</ul>
		</div>
		<div id="post-body-content">
			<div id="post-body-heading">
				<h3>Theme Options<p class="hugeit_contact_theme_pro_attention">These options are disabled in Lite version. Please, upgrade to PRO license to be able to use.</p></h3>
				<a onclick="alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');" class="save-hugeit_contact-options button-primary">Save  <i>(pro)</i></a>
			</div>
			<div class="hugeit_contact_black_overlay">
				<div class="options-block">
					<form action="admin.php?page=hugeit_forms_theme_options&form_id=<?php echo esc_url($_GET["form_id"]); ?>&task=save" method="post" id="adminForm" name="adminForm">
						<input type="hidden" id="themeName" name="themeName" value="">
						<div class="hugeit-contact-general-options-column hugeit-contact-general-options-left">
							<div class="hugeit-contact-general-options-block">
								<h3>Form Block Styles</h3>
								<div class="has-background">
									<label for="form_wrapper_width">Form Width</label>
									<div class="slider-container">
										<input name="params[form_wrapper_width]" id="form_wrapper_width" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" value="<?php echo $param_values['form_wrapper_width']; ?>" />
										<span><?php echo $param_values['form_wrapper_width']; ?>%</span>
									</div>
								</div>
								<div>
									<label for="form_wrapper_background_type">Form Background Type</label>
									<select id="form_wrapper_background_type" name="params[form_wrapper_background_type]">
										<option <?php if($param_values['form_wrapper_background_type'] == 'color'){ echo 'selected'; } ?> value="color">Color</option>
										<option <?php if($param_values['form_wrapper_background_type'] == 'transparent'){ echo 'selected'; } ?> value="transparent">Transparent</option>
										<option <?php if($param_values['form_wrapper_background_type'] == 'gradient'){ echo 'selected'; } ?> value="gradient">Gradient</option>
									</select>
								</div>
								<div class="has-background">
									<label for="form_wrapper_background_color">Form Background Color</label>
									<?php
									$bg=$param_values['form_wrapper_background_type'];
									$color = explode(',', $param_values['form_wrapper_background_color']);
									?>
									<input name="params[form_wrapper_background_color]" type="text" class="color <?php if($bg == 'gradient'){echo "half";} ?> form_background_color form_first_background_color" value="#<?php echo $color[0]; ?>" size="10" />
									<input name="params[form_wrapper_background_color]" type="text" class="color half <?php if($bg == 'color' or $bg == 'transparent' ){echo "none";} ?> form_background_color form_second_background_color" value="#<?php echo $color[1]; ?>" size="10" />

									<input name="params[form_wrapper_background_color]" id="form_wrapper_background_color" type="hidden" value="<?php echo $param_values['form_wrapper_background_color']; ?>" />
								</div>
								<div>
									<label for="form_border_size">Form Border Size</label>
									<input type="number" name="params[form_border_size]" id="form_border_size" value="<?php echo $param_values['form_border_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_border_color">Form Border Color</label>
									<input name="params[form_border_color]" type="text" class="color" id="form_border_color" value="#<?php echo $param_values['form_border_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_show_title">Form Show Title</label>
									<input type="hidden" value="off" name="params[form_show_title]" />
									<input type="checkbox" id="form_show_title"  <?php if($param_values['form_show_title']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_show_title]" value="on" />
								</div>
								<div>
									<label for="form_title_size">Form Title Size</label>
									<input type="number" name="params[form_title_size]" id="form_title_size" value="<?php echo $param_values['form_title_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_title_color">Form Title Color</label>
									<input name="params[form_title_color]" type="text" class="color" id="form_title_color" value="#<?php echo $param_values['form_title_color']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>Textarea Styles</h3>
								<div>
									<label for="form_textarea_has_background">Textarea Has Background</label>
									<input type="hidden" value="off" name="params[form_textarea_has_background]" />
									<input type="checkbox" id="form_textarea_has_background"  <?php if($param_values['form_textarea_has_background']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_textarea_has_background]" value="on" />
								</div>
								<div>
									<label for="form_textarea_background_color">Textarea Background Color</label>
									<input name="params[form_textarea_background_color]" type="text" class="color" id="form_textarea_background_color" value="#<?php echo $param_values['form_textarea_background_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_textarea_border_size">Textarea Border Size</label>
									<input type="number" name="params[form_textarea_border_size]" id="form_textarea_border_size" value="<?php echo $param_values['form_textarea_border_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_textarea_border_radius">Textarea Border Radius</label>
									<input type="number" name="params[form_textarea_border_radius]" id="form_textarea_border_radius" value="<?php echo $param_values['form_textarea_border_radius']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_textarea_border_color">Textarea Border Color</label>
									<input name="params[form_textarea_border_color]" type="text" class="color" id="form_textarea_border_color" value="#<?php echo $param_values['form_textarea_border_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_textarea_font_size">Textarea Font Size</label>
									<input type="number" name="params[form_textarea_font_size]" id="form_textarea_font_size" value="<?php echo $param_values['form_textarea_font_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_textarea_font_color">Textarea Font Color</label>
									<input name="params[form_textarea_font_color]" type="text" class="color" id="form_textarea_font_color" value="#<?php echo $param_values['form_textarea_font_color']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>Checkbox Styles</h3>
								<div>
									<label for="form_checkbox_size">Checkbox Size</label>
									<select id="form_checkbox_size" name="params[form_checkbox_size]">
										<option <?php if($param_values['form_checkbox_size'] == 'big'){ echo 'selected="selected"'; } ?> value="big">Big</option>
										<option <?php if($param_values['form_checkbox_size'] == 'medium'){ echo 'selected="selected"'; } ?> value="medium">Medium</option>
										<option <?php if($param_values['form_checkbox_size'] == 'small'){ echo 'selected="selected"'; } ?> value="small">Small</option>
									</select>
								</div>
								<div>
									<label for="form_checkbox_type">Checkbox Type</label>
									<select id="form_checkbox_type" name="params[form_checkbox_type]">
										<option <?php if($param_values['form_checkbox_type'] == 'circle'){ echo 'selected="selected"'; } ?> value="circle">Circle</option>
										<option <?php if($param_values['form_checkbox_type'] == 'square'){ echo 'selected="selected"'; } ?> value="square">Square</option>
									</select>
								</div>

								<div>
									<label for="form_checkbox_color">Checkbox Color</label>
									<input name="params[form_checkbox_color]" type="text" class="color" id="form_checkbox_color" value="#<?php echo $param_values['form_checkbox_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_checkbox_hover_color">Checkbox Hover Color</label>
									<input name="params[form_checkbox_hover_color]" type="text" class="color" id="form_checkbox_hover_color" value="#<?php echo $param_values['form_checkbox_hover_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_checkbox_active_color">Checkbox Checked Color</label>
									<input name="params[form_checkbox_active_color]" type="text" class="color" id="form_checkbox_active_color" value="#<?php echo $param_values['form_checkbox_active_color']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>Input-Radio Styles</h3>
								<div>
									<label for="form_radio_size">Input-Radio Size</label>
									<select id="form_radio_size" name="params[form_radio_size]">
										<option <?php if($param_values['form_radio_size'] == 'big'){ echo 'selected="selected"'; } ?> value="big">Big</option>
										<option <?php if($param_values['form_radio_size'] == 'medium'){ echo 'selected="selected"'; } ?> value="medium">Medium</option>
										<option <?php if($param_values['form_radio_size'] == 'small'){ echo 'selected="selected"'; } ?> value="small">Small</option>
									</select>
								</div>
								<div>
									<label for="form_radio_type">Input-Radio Type</label>
									<select id="form_radio_type" name="params[form_radio_type]">
										<option <?php if($param_values['form_radio_type'] == 'circle'){ echo 'selected="selected"'; } ?> value="circle">Circle</option>
										<option <?php if($param_values['form_radio_type'] == 'square'){ echo 'selected="selected"'; } ?> value="square">Square</option>
									</select>
								</div>
								<div>
									<label for="form_radio_color">Input-Radio Color</label>
									<input name="params[form_radio_color]" type="text" class="color" id="form_radio_color" value="#<?php echo $param_values['form_radio_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_radio_hover_color">Input-Radio Hover Color</label>
									<input name="params[form_radio_hover_color]" type="text" class="color" id="form_radio_hover_color" value="#<?php echo $param_values['form_radio_hover_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_radio_active_color">Input-Radio Checked Color</label>
									<input name="params[form_radio_active_color]" type="text" class="color" id="form_radio_active_color" value="#<?php echo $param_values['form_radio_active_color']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>File Uploader Styles</h3>
								<div>
									<label for="form_file_has_background">FileBox Has Background</label>
									<input type="hidden" value="off" name="params[form_file_has_background]" />
									<input type="checkbox" id="form_file_has_background"  <?php if($param_values['form_file_has_background']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_file_has_background]" value="on" />
								</div>
								<div>
									<label for="form_file_background">FileBox Background Color</label>
									<input name="params[form_file_background]" type="text" class="color" id="form_file_background" value="#<?php echo $param_values['form_file_background']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_border_size">FileBox Border Size</label>
									<input type="number" name="params[form_file_border_size]" id="form_file_border_size" value="<?php echo $param_values['form_file_border_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_file_border_radius">FileBox Border Radius</label>
									<input type="number" name="params[form_file_border_radius]" id="form_file_border_radius" value="<?php echo $param_values['form_file_border_radius']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_file_border_color">FileBox Border Color</label>
									<input name="params[form_file_border_color]" type="text" class="color" id="form_file_border_color" value="#<?php echo $param_values['form_file_border_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_font_size">FileBox Font Size</label>
									<input type="number" name="params[form_file_font_size]" id="form_file_font_size" value="<?php echo $param_values['form_file_font_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_file_font_color">FileBox Font Color</label>
									<input name="params[form_file_font_color]" type="text" class="color" id="form_file_font_color" value="#<?php echo $param_values['form_file_font_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_button_text">Button Text</label>
									<input name="params[form_file_button_text]" type="text" id="form_file_button_text" value="<?php echo $param_values['form_file_button_text']; ?>"/>
								</div>
								<div>
									<label for="form_file_button_background_color">Button Background Color</label>
									<input name="params[form_file_button_background_color]" type="text" class="color" id="form_file_button_background_color" value="#<?php echo $param_values['form_file_button_background_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_button_background_hover_color">Button Background Hover Color</label>
									<input name="params[form_file_button_background_hover_color]" type="text" class="color" id="form_file_button_background_hover_color" value="#<?php echo $param_values['form_file_button_background_hover_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_button_text_color">Button Text Color</label>
									<input name="params[form_file_button_text_color]" type="text" class="color" id="form_file_button_text_color" value="#<?php echo $param_values['form_file_button_text_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_button_text_hover_color">Button Text Hover Color</label>
									<input name="params[form_file_button_text_hover_color]" type="text" class="color" id="form_file_button_text_hover_color" value="#<?php echo $param_values['form_file_button_text_hover_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_file_has_icon">FileBox Button Has Icon</label>
									<input type="hidden" value="off" name="params[form_file_has_icon]" />
									<input type="checkbox" id="form_file_has_icon"  <?php if($param_values['form_file_has_icon']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_file_has_icon]" value="on" />
								</div>

								<div class="has-height">
									<label for="form_file_icon_style">Button's Icon Style</label>
									<div class="icons-block">
										<ul>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-paperclip"){echo 'class="active"';} ?> title="Attachment Icon"><i class="hugeicons-paperclip"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-paperclip" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-camera"){echo 'class="active"';} ?> title="Photo Icon"><i class="hugeicons-camera"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-camera" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-picture-o"){echo 'class="active"';} ?> title="Picture Icon"><i class="hugeicons-picture-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-picture-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file"){echo 'class="active"';} ?> title="File Icon"><i class="hugeicons-file"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-dropbox"){echo 'class="active"';} ?> title="Box Add Icon"><i class="hugeicons-dropbox"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-dropbox" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-cloud"){echo 'class="active"';} ?> title="Cloud Icon"><i class="hugeicons-cloud"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-cloud" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-cloud-upload"){echo 'class="active"';} ?> title="Upload Cloud Icon"><i class="hugeicons-cloud-upload"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-cloud-upload" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-download"){echo 'class="active"';} ?> title="Download Icon"><i class="hugeicons-download"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-download" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-cloud-download"){echo 'class="active"';} ?> title="Word Icon"><i class="hugeicons-cloud-download"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-cloud-download" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file-pdf-o"){echo 'class="active"';} ?> title="PDF Icon"><i class="hugeicons-file-pdf-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file-pdf-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file-text"){echo 'class="active"';} ?> title="file-text Icon"><i class="hugeicons-file-text"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file-text" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file-excel-o"){echo 'class="active"';} ?> title="Excel Icon"><i class="hugeicons-file-excel-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file-excel-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file-powerpoint-o"){echo 'class="active"';} ?> title="powerpoint-o Icon"><i class="hugeicons-file-powerpoint-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file-powerpoint-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file-zip-o"){echo 'class="active"';} ?> title="Zip Icon"><i class="hugeicons-file-zip-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file-zip-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-file-audio-o"){echo 'class="active"';} ?> title="CSS Icon"><i class="hugeicons-file-audio-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-file-audio-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-floppy-o"){echo 'class="active"';} ?> title="floppy-o Icon"><i class="hugeicons-floppy-o"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-floppy-o" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-music"){echo 'class="active"';} ?> title="Music Icon"><i class="hugeicons-music"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-music" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-film"){echo 'class="active"';} ?> title="Video Icon"><i class="hugeicons-film"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-film" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-camera-retro"){echo 'class="active"';} ?> title="Camera Icon"><i class="hugeicons-camera-retro"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-camera-retro" /></li>
											<li <?php if($param_values['form_file_icon_style']=="hugeicons-gift"){echo 'class="active"';} ?> title="Upload Gift"><i class="hugeicons-gift"></i><input name="params[form_file_icon_style]" type="radio" value="hugeicons-gift" /></li>
										</ul>
									</div>
								</div>
								<div>
									<label for="form_file_icon_position">Button's Icon Position</label>
									<select id="form_file_icon_position" name="params[form_file_icon_position]">
										<option <?php if($param_values['form_file_icon_position'] == 'left'){ echo 'selected="selected"'; } ?> value="left">Before Text</option>
										<option <?php if($param_values['form_file_icon_position'] == 'right'){ echo 'selected="selected"'; } ?> value="right">After Text</option>
									</select>
								</div>
								<div>
									<label for="form_file_icon_color">Button's Icon Color</label>
									<input name="params[form_file_icon_color]" type="text" class="color" id="form_file_icon_color" value="#<?php echo $param_values['form_file_icon_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_file_icon_hover_color">Button's Icon Hover Color</label>
									<input name="params[form_file_icon_hover_color]" type="text" class="color" id="form_file_icon_hover_color" value="#<?php echo $param_values['form_file_icon_hover_color']; ?>" size="10" />
								</div>
							</div>
						</div>
						<div class="hugeit-contact-general-options-column hugeit-contact-general-options-right">
							<div class="hugeit-contact-general-options-block">
								<h3>Labels Styles</h3>
								<div>
									<label for="form_label_size">Label Size</label>
									<input type="number" name="params[form_label_size]" id="form_label_size" value="<?php echo $param_values['form_label_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_label_font_family">Label Font Family</label>
									<select id="form_label_font_family" name="params[form_label_font_family]">
										<option <?php selected( '', $param_values['form_label_font_family'], true ); ?> value="">Default</option>
										<option <?php selected( 'Arial,Helvetica Neue,Helvetica,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Arial,Helvetica Neue,Helvetica,sans-serif">Arial *</option>
										<option <?php selected( 'Arial Black,Arial Bold,Arial,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Arial Black,Arial Bold,Arial,sans-serif">Arial Black *</option>
										<option <?php selected( 'Arial Nicon,Arial,Helvetica Neue,Helvetica,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Arial Nicon,Arial,Helvetica Neue,Helvetica,sans-serif">Arial Nicon *</option>
										<option <?php selected( 'Courier,Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Courier,Verdana,sans-serif">Courier *</option>
										<option <?php selected( 'Georgia,Times New Roman,Times,serif', $param_values['form_label_font_family'], true ); ?> value="Georgia,Times New Roman,Times,serif">Georgia *</option>
										<option <?php selected( 'Times New Roman,Times,Georgia,serif', $param_values['form_label_font_family'], true ); ?> value="Times New Roman,Times,Georgia,serif">Times New Roman *</option>
										<option <?php selected( 'Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Verdana,sans-serif">Verdana *</option>
										<option <?php selected( 'American Typewriter,Georgia,serif', $param_values['form_label_font_family'], true ); ?> value="American Typewriter,Georgia,serif">American Typewriter</option>
										<option <?php selected( 'Bookman Old Style,Georgia,Times New Roman,Times,serif', $param_values['form_label_font_family'], true ); ?> value="Bookman Old Style,Georgia,Times New Roman,Times,serif">Bookman Old Style</option>
										<option <?php selected( 'Calibri,Helvetica Neue,Helvetica,Arial,Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Calibri,Helvetica Neue,Helvetica,Arial,Verdana,sans-serif">Calibri</option>
										<option <?php selected( 'Cambria,Georgia,Times New Roman,Times,serif', $param_values['form_label_font_family'], true ); ?> value="Cambria,Georgia,Times New Roman,Times,serif">Cambria</option>
										<option <?php selected( 'Candara,Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Candara,Verdana,sans-serif">Candara</option>
										<option <?php selected( 'Century Gothic,Apple Gothic,Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Century Gothic,Apple Gothic,Verdana,sans-serif">Century Gothic</option>
										<option <?php selected( 'Century Schoolbook,Georgia,Times New Roman,Times,serif', $param_values['form_label_font_family'], true ); ?> value="Century Schoolbook,Georgia,Times New Roman,Times,serif">Century Schoolbook</option>
										<option <?php selected( 'Consolas,Andale Mono,Monaco,Courier,Courier New,Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Consolas,Andale Mono,Monaco,Courier,Courier New,Verdana,sans-serif">Consolas</option>
										<option <?php selected( 'Constantia,Georgia,Times New Roman,Times,serif', $param_values['form_label_font_family'], true ); ?> value="Constantia,Georgia,Times New Roman,Times,serif">Constantia</option>
										<option <?php selected( 'Corbel,Lucida Grande,Lucida Sans Unicode,Arial,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Corbel,Lucida Grande,Lucida Sans Unicode,Arial,sans-serif">Corbel</option>
										<option <?php selected( 'Tahoma,Geneva,Verdana,sans-serif', $param_values['form_label_font_family'], true ); ?> value="Tahoma,Geneva,Verdana,sans-serif">Tahoma</option>
										<option <?php selected( 'Rockwell, Arial Black, Arial Bold, Arial, sans-serif', $param_values['form_label_font_family'], true ); ?> value="Rockwell, Arial Black, Arial Bold, Arial, sans-serif">Rockwell</option>
									</select>
								</div>
								<div>
									<label for="form_label_color">Label Color</label>
									<input name="params[form_label_color]" type="text" class="color" id="form_label_color" value="#<?php echo $param_values['form_label_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_label_error_color">Label Error Color</label>
									<input name="params[form_label_error_color]" type="text" class="color" id="form_label_error_color" value="#<?php echo $param_values['form_label_error_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_label_required_color">Label * Color</label>
									<input name="params[form_label_required_color]" type="text" class="color" id="form_label_required_color" value="#<?php echo $param_values['form_label_required_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_label_success_message">Label Success Message Color</label>
									<input name="params[form_label_success_message]" type="text" class="color" id="form_label_success_message" value="#<?php echo $param_values['form_label_success_message']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>Input-Text Styles</h3>
								<div>
									<label for="form_input_text_has_background">Input-Text Has Background</label>
									<input type="hidden" value="off" name="params[form_input_text_has_background]" />
									<input type="checkbox" id="form_input_text_has_background"  <?php if($param_values['form_input_text_has_background']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_input_text_has_background]" value="on" />
								</div>
								<div>
									<label for="form_input_text_background_color">Input-Text Background Color</label>
									<input name="params[form_input_text_background_color]" type="text" class="color" id="form_input_text_background_color" value="#<?php echo $param_values['form_input_text_background_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_input_text_border_size">Input-Text Border Size</label>
									<input type="number" name="params[form_input_text_border_size]" id="form_input_text_border_size" value="<?php echo $param_values['form_input_text_border_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_input_text_border_radius">Input-Text Border Radius</label>
									<input type="number" name="params[form_input_text_border_radius]" id="form_input_text_border_radius" value="<?php echo $param_values['form_input_text_border_radius']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_input_text_border_color">Input-Text Border Color</label>
									<input name="params[form_input_text_border_color]" type="text" class="color" id="form_input_text_border_color" value="#<?php echo $param_values['form_input_text_border_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_input_text_font_size">Input-Text Font Size</label>
									<input type="number" name="params[form_input_text_font_size]" id="form_input_text_font_size" value="<?php echo $param_values['form_input_text_font_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_input_text_font_color">Input-Text Font Color</label>
									<input name="params[form_input_text_font_color]" type="text" class="color" id="form_input_text_font_color" value="#<?php echo $param_values['form_input_text_font_color']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>Selectbox Styles</h3>

								<div>
									<label for="form_selectbox_has_background">Selectbox Has Background</label>
									<input type="hidden" value="off" name="params[form_selectbox_has_background]" />
									<input type="checkbox" id="form_selectbox_has_background"  <?php if($param_values['form_selectbox_has_background']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_selectbox_has_background]" value="on" />
								</div>

								<div>
									<label for="form_selectbox_background_color">Selectbox Background Color</label>
									<input name="params[form_selectbox_background_color]" type="text" class="color" id="form_selectbox_background_color" value="#<?php echo $param_values['form_selectbox_background_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_selectbox_border_size">Selectbox Border Size</label>
									<input type="number" name="params[form_selectbox_border_size]" id="form_selectbox_border_size" value="<?php echo $param_values['form_selectbox_border_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_selectbox_border_radius">Selectbox Border Radius</label>
									<input type="number" name="params[form_selectbox_border_radius]" id="form_selectbox_border_radius" value="<?php echo $param_values['form_selectbox_border_radius']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_selectbox_border_color">Selectbox Border Color</label>
									<input name="params[form_selectbox_border_color]" type="text" class="color" id="form_selectbox_border_color" value="#<?php echo $param_values['form_selectbox_border_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_selectbox_font_size">Selectbox Font Size</label>
									<input type="number" name="params[form_selectbox_font_size]" id="form_selectbox_font_size" value="<?php echo $param_values['form_selectbox_font_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_selectbox_font_color">Selectbox Font Color</label>
									<input name="params[form_selectbox_font_color]" type="text" class="color" id="form_selectbox_font_color" value="#<?php echo $param_values['form_selectbox_font_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_selectbox_arrow_color">Selectbox Arrow Color</label>
									<input name="params[form_selectbox_arrow_color]" type="text" class="color" id="form_selectbox_arrow_color" value="#<?php echo $param_values['form_selectbox_arrow_color']; ?>" size="10" />
								</div>
							</div>
							<div class="hugeit-contact-general-options-block">
								<h3>Button Styles</h3>
								<div>
									<label for="form_button_position">Button Position</label>
									<select id="form_button_position" name="params[form_button_position]">
										<option <?php if($param_values['form_button_position'] == 'left'){ echo 'selected="selected"'; } ?> value="left">Left</option>
										<option <?php if($param_values['form_button_position'] == 'right'){ echo 'selected="selected"'; } ?> value="right">Right</option>
										<option <?php if($param_values['form_button_position'] == 'center'){ echo 'selected="selected"'; } ?> value="center">Center</option>
									</select>
								</div>
								<div>
									<label for="form_button_fullwidth">Make Buttons Full-width</label>
									<input type="hidden" value="off" name="params[form_button_fullwidth]" />
									<input type="checkbox" id="form_button_fullwidth"  <?php if($param_values['form_button_fullwidth']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_button_fullwidth]" value="on" />
								</div>
								<div>
									<label for="form_button_padding">Button Padding</label>
									<input type="number" name="params[form_button_padding]" id="form_button_padding" value="<?php echo $param_values['form_button_padding']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_button_font_size">Buttons Font Size</label>
									<input type="number" name="params[form_button_font_size]" id="form_button_font_size" value="<?php echo $param_values['form_button_font_size']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_button_icons_position">Icons Position</label>
									<select id="form_button_icons_position" name="params[form_button_icons_position]">
										<option <?php if($param_values['form_button_icons_position'] == 'left'){ echo 'selected="selected"'; } ?> value="left">Before Text</option>
										<option <?php if($param_values['form_button_icons_position'] == 'right'){ echo 'selected="selected"'; } ?> value="right">After Text</option>
									</select>
								</div>

								<div>
									<label for="form_button_submit_has_icon">Submit Button Has Icon</label>
									<input type="hidden" value="off" name="params[form_button_submit_has_icon]" />
									<input type="checkbox" id="form_button_submit_has_icon"  <?php if($param_values['form_button_submit_has_icon']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_button_submit_has_icon]" value="on" />
								</div>
								<div class="has-height">
									<label for="form_button_submit_icon_style">Submit Icon Style</label>
									<div class="icons-block">
										<ul>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-mail-forward"){echo 'class="active"';} ?> title="Mail Forward Icon"><i class="hugeicons-mail-forward"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-mail-forward" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-mail-reply"){echo 'class="active"';} ?> title="Mail Replay Icon"><i class="hugeicons-mail-reply"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-mail-reply" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-clock"){echo 'class="active"';} ?> title="Clock Icon"><i class="hugeicons-clock"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-clock" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-bell"){echo 'class="active"';} ?> title="Bell Icon"><i class="hugeicons-bell"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-bell" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-paper-plane"){echo 'class="active"';} ?> title="Paper Plane Icon"><i class="hugeicons-paper-plane"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-paper-plane" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-sign-in"){echo 'class="active"';} ?> title="Sign In Icon"><i class="hugeicons-sign-in"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-sign-in" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-bars"){echo 'class="active"';} ?> title="Bars Icon"><i class="hugeicons-bars"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-bars" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-child"){echo 'class="active"';} ?> title="Child Icon"><i class="hugeicons-child"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-child" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-gift"){echo 'class="active"';} ?> title="Gift Icon"><i class="hugeicons-gift"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-gift" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-rocket"){echo 'class="active"';} ?> title="Rocket Icon"><i class="hugeicons-rocket"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-rocket" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-fire"){echo 'class="active"';} ?> title="Fire Icon"><i class="hugeicons-fire"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-fire" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-anchor"){echo 'class="active"';} ?> title="Anchor Icon"><i class="hugeicons-anchor"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-anchor" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-plus"){echo 'class="active"';} ?> title="Plus Icon"><i class="hugeicons-plus"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-plus" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-envelope-o"){echo 'class="active"';} ?> title="Envelope Icon"><i class="hugeicons-envelope-o"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-envelope-o" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-envelope"){echo 'class="active"';} ?> title="Envelope Icon"><i class="hugeicons-envelope"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-envelope" /></li>
											<li <?php if($param_values['form_button_submit_icon_style']=="hugeicons-cart-plus"){echo 'class="active"';} ?> title="Cart Plus Icon"><i class="hugeicons-cart-plus"></i><input name="params[form_button_submit_icon_style]" type="radio" value="hugeicons-cart-plus" /></li>
										</ul>
									</div>
								</div>
								<div>
									<label for="form_button_submit_icon_color">Submit Icon Color</label>
									<input name="params[form_button_submit_icon_color]" type="text" class="color" id="form_button_submit_icon_color" value="#<?php echo $param_values['form_button_submit_icon_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_submit_icon_hover_color">Submit Icon Hover Color</label>
									<input name="params[form_button_submit_icon_hover_color]" type="text" class="color" id="form_button_submit_icon_hover_color" value="#<?php echo $param_values['form_button_submit_icon_hover_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_button_submit_font_color">Submit Button Font Color</label>
									<input name="params[form_button_submit_font_color]" type="text" class="color" id="form_button_submit_font_color" value="#<?php echo $param_values['form_button_submit_font_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_submit_font_hover_color">Submit Button Font Hover Color</label>
									<input name="params[form_button_submit_font_hover_color]" type="text" class="color" id="form_button_submit_font_hover_color" value="#<?php echo $param_values['form_button_submit_font_hover_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_submit_background">Submit Button Background Color</label>
									<input name="params[form_button_submit_background]" type="text" class="color" id="form_button_submit_background" value="#<?php echo $param_values['form_button_submit_background']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_submit_hover_background">Submit Button Background Hover Color</label>
									<input name="params[form_button_submit_hover_background]" type="text" class="color" id="form_button_submit_hover_background" value="#<?php echo $param_values['form_button_submit_hover_background']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_submit_border_size">Submit Button Border Size</label>
									<input type="number" name="params[form_button_submit_border_size]" id="form_button_submit_border_size" value="<?php echo $param_values['form_button_submit_border_size']; ?>" class="text" />
									<span>px</span>
								</div>

								<div>
									<label for="form_button_submit_border_color">Submit Button Border Color</label>
									<input name="params[form_button_submit_border_color]" type="text" class="color" id="form_button_submit_border_color" value="#<?php echo $param_values['form_button_submit_border_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_submit_border_radius">Submit Button Border Radius</label>
									<input type="number" name="params[form_button_submit_border_radius]" id="form_button_submit_border_radius" value="<?php echo $param_values['form_button_submit_border_radius']; ?>" class="text" />
									<span>px</span>
								</div>
								<div>
									<label for="form_button_reset_has_icon">Reset Button Has Icon</label>
									<input type="hidden" value="off" name="params[form_button_reset_has_icon]" />
									<input type="checkbox" id="form_button_reset_has_icon"  <?php if($param_values['form_button_reset_has_icon']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_button_reset_has_icon]" value="on" />
								</div>
								<div class="has-height">
									<label for="form_button_reset_icon_style">Reset Icon Style</label>
									<div class="icons-block reset-icons-block">
										<ul>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-refresh"){echo 'class="active"';} ?> title="Refresh Icon"><i class="hugeicons-refresh"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-refresh" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-power-off"){echo 'class="active"';} ?> title="Power Off Icon"><i class="hugeicons-power-off"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-power-off" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-minus-circle"){echo 'class="active"';} ?> title="Minus Circle Icon"><i class="hugeicons-minus-circle"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-minus-circle" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-times"){echo 'class="active"';} ?> title="Times Icon"><i class="hugeicons-times"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-times" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-bell-slash"){echo 'class="active"';} ?> title="Bell Icon"><i class="hugeicons-bell-slash"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-bell-slash" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-trash-o"){echo 'class="active"';} ?> title="Trash Icon"><i class="hugeicons-trash-o"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-trash-o" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-user-times"){echo 'class="active"';} ?> title="User Times Icon"><i class="hugeicons-user-times"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-user-times" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-street-view"){echo 'class="active"';} ?> title="Street View Icon"><i class="hugeicons-street-view"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-street-view" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-times-circle-o"){echo 'class="active"';} ?> title="Times Circle O Icon"><i class="hugeicons-times-circle-o"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-times-circle-o" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-reply"){echo 'class="active"';} ?> title="Back Icon"><i class="hugeicons-reply"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-reply" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-fire"){echo 'class="active"';} ?> title="Fire Icon"><i class="hugeicons-fire"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-fire" /></li>
											<li <?php if($param_values['form_button_reset_icon_style']=="hugeicons-retweet"){echo 'class="active"';} ?> title="Refrash Icon"><i class="hugeicons-retweet"></i><input name="params[form_button_reset_icon_style]" type="radio" value="hugeicons-retweet" /></li>
										</ul>
									</div>
								</div>
								<div>
									<label for="form_button_reset_icon_color">Reset Icon Color</label>
									<input name="params[form_button_reset_icon_color]" type="text" class="color" id="form_button_reset_icon_color" value="#<?php echo $param_values['form_button_reset_icon_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_button_reset_icon_hover_color">Reset Icon Hover Color</label>
									<input name="params[form_button_reset_icon_hover_color]" type="text" class="color" id="form_button_reset_icon_hover_color" value="#<?php echo $param_values['form_button_reset_icon_hover_color']; ?>" size="10" />
								</div>
								<div>
									<label for="form_button_reset_font_color">Reset Button Font Color</label>
									<input name="params[form_button_reset_font_color]" type="text" class="color" id="form_button_reset_font_color" value="#<?php echo $param_values['form_button_reset_font_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_reset_font_hover_color">Reset Button Font Hover Color</label>
									<input name="params[form_button_reset_font_hover_color]" type="text" class="color" id="form_button_reset_font_hover_color" value="#<?php echo $param_values['form_button_reset_font_hover_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_reset_background">Reset Button Background Color</label>
									<input name="params[form_button_reset_background]" type="text" class="color" id="form_button_reset_background" value="#<?php echo $param_values['form_button_reset_background']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_reset_hover_background">Reset Button Background Hover Color</label>
									<input name="params[form_button_reset_hover_background]" type="text" class="color" id="form_button_reset_hover_background" value="#<?php echo $param_values['form_button_reset_hover_background']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_reset_border_size">Reset Button Border Size</label>
									<input type="number" name="params[form_button_reset_border_size]" id="form_button_reset_border_size" value="<?php echo $param_values['form_button_reset_border_size']; ?>" class="text" />
									<span>px</span>
								</div>


								<div>
									<label for="form_button_reset_border_color">Reset Button Border Color</label>
									<input name="params[form_button_reset_border_color]" type="text" class="color" id="form_button_reset_border_color" value="#<?php echo $param_values['form_button_reset_border_color']; ?>" size="10" />
								</div>

								<div>
									<label for="form_button_reset_border_radius">Reset Button Border Radius</label>
									<input type="number" name="params[form_button_reset_border_radius]" id="form_button_reset_border_radius" value="<?php echo $param_values['form_button_reset_border_radius']; ?>" class="text" />
									<span>px</span>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		<div style="claer:both;"></div>
			<a onclick="document.getElementById('adminForm').submit()" class="save-hugeit_contact-options button-primary">Save</a>
	</div>
</div>
</div>
<input type="hidden" name="option" value=""/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="controller" value="options"/>
<input type="hidden" name="op_type" value="styles"/>
<input type="hidden" name="boxchecked" value="0"/>

<?php

}