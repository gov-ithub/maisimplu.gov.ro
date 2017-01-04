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

function hugeit_contact_styles(){
	 global $wpdb;
	 
	if(isset($_GET["delete"])){
		$deleteID=absint($_GET["delete"]);
		$wpdb->query("DELETE FROM ".$wpdb->prefix."huge_it_contact_style_fields  WHERE options_name = '".$deleteID."' ");
		$wpdb->query("DELETE FROM ".$wpdb->prefix."huge_it_contact_styles  WHERE id = '".$deleteID."' ");
		$wpdb->query("UPDATE ".$wpdb->prefix."huge_it_contact_contacts SET `hc_yourstyle` = '1' WHERE `hc_yourstyle` = '".$deleteID."'");
	}
	
	$query = "SELECT * FROM ".$wpdb->prefix."huge_it_contact_styles order by id Asc";
	$rows = $wpdb->get_results($query);
	hugeit_contact_html_styles($rows);
}


function hugeit_contact_editstyles($op_type = "0"){
    global $wpdb;
	
	if(isset($_GET["delete"])){
		$deleteID=absint($_GET["delete"]);
		$wpdb->query("DELETE FROM ".$wpdb->prefix."huge_it_contact_style_fields  WHERE options_name = '".$deleteID."' ");
		$wpdb->query("DELETE FROM ".$wpdb->prefix."huge_it_contact_styles  WHERE id = '".$deleteID."' ");
		$wpdb->query("UPDATE ".$wpdb->prefix."huge_it_contact_contacts SET `hc_yourstyle` = '1' WHERE `hc_yourstyle` = '".$deleteID."'");
	}
	if(isset($_GET["form_id"])){
		$formID=absint($_GET["form_id"]);
	    $query = "SELECT *  from " . $wpdb->prefix . "huge_it_contact_style_fields where options_name = '".$formID."'";
	    $rows = $wpdb->get_results($query);
	    $param_values = array();
	    foreach ($rows as $row) {
	        $key = $row->name;
	        $value = $row->value;
	        $param_values[$key] = $value;
	    }
	}
	//$optids = 'style '.$optids;
	if(isset($_GET["task"])&&$_GET["task"] == 'add_styles'){
	$today = getdate();
	$dateupdate = $today['wday'].'/'.$today['mon'].'/'.$today['year'];
	
	$table_name = $wpdb->prefix . "huge_it_contact_styles";
	$wpdb->insert(
		$table_name,
		array(
			'name' => 'New Theme',
			'last_update' => $dateupdate,
			'ordering' => 1,
			'published' => '',
		),
		array('%s', '%s', '%d', '%s')
	);
	$query="SELECT id FROM ".$wpdb->prefix."huge_it_contact_styles order by id Desc";
	$style_ids=$wpdb->get_results($query);
	$style_id = $style_ids[0]->id;

	$table_name = $wpdb->prefix . "huge_it_contact_style_fields";
    $options_sql1 = "
INSERT INTO `$table_name` (`name`, `title`,`description`, `options_name`, `value`) VALUES
('form_selectbox_font_color', 'Form Selectbox Font Color', 'Form Selectbox Font Color', '".$style_id."' , '393939'),
('form_label_success_message', 'Form Label Success Color', 'Form Label Success Color', '".$style_id."' , '3DAD48'),
('form_button_reset_icon_hover_color', 'Form Button Reset Icon Hover Color', 'Form Button Reset Icon Hover Color', '".$style_id."' , 'FFFFFF'),
('form_label_required_color', 'Form Label Required Color', 'Form Label Required Color', '".$style_id."' , 'FE5858'),
('form_button_reset_icon_color', 'Form Button Reset Icon Color', 'Form Button Reset Icon Color', '".$style_id."' , 'FFFFFF'),
('form_button_reset_icon_style', 'Form Button Reset Icon Style', 'Form Button Reset Icon Style', '".$style_id."' , 'hugeicons-retweet'),
('form_button_reset_has_icon', 'Form Reset Button Has Icon', 'Form Reset Button Has Icon', '".$style_id."' , 'off'),
('form_button_reset_border_radius', 'Form Button Reset Border Radius', 'Form Button Reset Border Radius', '".$style_id."' , '1'),
('form_button_reset_border_size', 'Form Button Reset Border Size', 'Form Button Reset Border Size', '".$style_id."' , '1'),
('form_button_reset_border_color', 'Form Button Reset Border Color', 'Form Button Reset Border Color', '".$style_id."' , 'FE5858'),
('form_button_reset_background', 'Form Button Reset Background', 'Form Button Reset Background', '".$style_id."' , 'FFFFFF'),
('form_button_reset_hover_background', 'Form Button Reset Hover Background', 'Form Button Reset Hover Background', '".$style_id."' , 'FFFFFF'),
('form_button_reset_font_color', 'Form Button Reset Font Color', 'Form Button Reset Font Color', '".$style_id."' , 'FE5858'),
('form_button_reset_font_hover_color', 'Form Button Reset Font Hover Color', 'Form Button Reset Font Hover Color', '".$style_id."' , 'FE473A'),
('form_button_submit_icon_color', 'Form Button Submit Icon Color', 'Form Button Submit Icon Color', '".$style_id."' , 'FFFFFF'),
('form_button_submit_icon_hover_color', 'Form Button Submit Icon Hover Color', 'Form Button Submit Icon Hover Color', '".$style_id."' , 'FFFFFF'),
('form_button_submit_icon_style', 'Form Button Submit Icon Style', 'Form Button Submit Icon Style', '".$style_id."' , 'hugeicons-rocket'),
('form_button_submit_border_radius', 'Form Button Border Submit Radius', 'Form Button Submit Border Radius', '".$style_id."' , '2'),
('form_button_submit_has_icon', 'Form Submit Button Has Icon', 'Form Submit Button Has Icon', '".$style_id."' , 'off'),
('form_button_submit_border_color', 'Form Button Submit Border Color', 'Form Button Submit Border Color', '".$style_id."' , 'FE5858'),
('form_button_submit_border_size', 'Form Button Submit Border Size', 'Form Button Submit Border Size', '".$style_id."' , '1'),
('form_button_submit_hover_background', 'Form Button Submit Hover Background', 'Form Button Submit Hover Background', '".$style_id."' , 'FE473A'),
('form_button_submit_font_hover_color', 'Form Button Submit Font Hover Color', 'Form Button Submit Font Hover Color', '".$style_id."' , 'FFFFFF'),
('form_button_submit_background', 'Form Button Submit Background', 'Form Button Submit Background', '".$style_id."' , 'FE5858'),
('form_button_icons_position', 'Form Button Icons Position', 'Form Button Icons Position', '".$style_id."' , 'left'),
('form_button_submit_font_color', 'Form Button Submit Font Color', 'Form Button Submit Font Color', '".$style_id."' , 'FFFFFF'),
('form_button_font_size', 'Form Button Font Size', 'Form Button Font Size', '".$style_id."' , '14'),
('form_button_padding', 'Form Button Padding', 'Form Button Padding', '".$style_id."' , '8'),
('form_file_icon_hover_color', 'Form File Icon Hover Color', 'Form File Icon Hover Color', '".$style_id."' , 'FFFFFF'),
('form_file_icon_position', 'Form File Icon Position', 'Form File Icon Position', '".$style_id."' , 'left'),
('form_button_position', 'Form Button Position', 'Form Button Position', '".$style_id."' , 'left'),
('form_button_fullwidth', 'Form Button Fullwidth', 'Form Button Fullwidth', '".$style_id."' , 'off'),
('form_file_icon_color', 'Form File Icon Color', 'Form File Icon Color', '".$style_id."' , 'DFDFDF'),
('form_file_has_icon', 'Form File Button Has Icon', 'Form File Button Has Icon', '".$style_id."' , 'on'),
('form_file_icon_style', 'Form File Icon Style', 'Form File Icon Style', '".$style_id."' , 'hugeicons-cloud-upload'),
('form_file_button_text_color', 'Form File Button Text Color', 'Form File Button Text Color', '".$style_id."' , 'F7F4F4'),
('form_file_button_text_hover_color', 'Form File Button Text Hover Color', 'Form File Button Text Hover Color', '".$style_id."' , 'FFFFFF'),
('form_file_button_background_color', 'Form File Button Background Color', 'Form File Button Background Color', '".$style_id."' , '393939'),
('form_file_button_background_hover_color', 'Form File Button Background Hover Color', 'Form File Button Background Hover Color', '".$style_id."' , 'FE5858'),
('form_file_button_text', 'Form File Button Text', 'Form File Button Text', '".$style_id."' , 'Upload'),
('form_file_font_size', 'Form File Font Size', 'Form File Font Size', '".$style_id."' , '14'),
('form_file_font_color', 'Form File Font Color', 'Form File Font Color', '".$style_id."' , '393939'),
('form_file_border_color', 'Form File Border Color', 'Form File Border Color', '".$style_id."' , 'DEDFE0'),
('form_file_border_radius', 'Form File Border Radius', 'Form File Border Radius', '".$style_id."' , '2'),
('form_file_background', 'Form File Background', 'Form File Background', '".$style_id."' , 'FFFFFF'),
('form_file_border_size', 'Form File Border Size', 'Form File Border Size', '".$style_id."' , '1'),
('form_file_has_background', 'Form File Has Background', 'Form File Has Background', '".$style_id."' , 'on'),
('form_radio_active_color', 'Form Radio Active Color', 'Form Radio Active Color', '".$style_id."' , 'FE5858'),
('form_radio_hover_color', 'Form Radio Hover Color', 'Form Radio Hover Color', '".$style_id."' , 'A9A6A6'),
('form_radio_type', 'Form Radio Type', 'Form Radio Type', '".$style_id."' , 'circle'),
('form_radio_color', 'Form Radio Color', 'Form Radio Color', '".$style_id."' , 'C6C3C3'),
('form_radio_size', 'Form Radio Size', 'Form Radio Size', '".$style_id."' , 'medium'),
('form_checkbox_active_color', 'Form Checkbox Active Color', 'Form Checkbox Active Color', '".$style_id."' , 'FE5858'),
('form_checkbox_hover_color', 'Form Checkbox Hover Color', 'Form Checkbox Hover Color', '".$style_id."' , 'A9A6A6'),
('form_checkbox_type', 'Form Checkbox Type', 'Form Checkbox Type', '".$style_id."' , 'square'),
('form_checkbox_color', 'Form Checkbox Color', 'Form Checkbox Color', '".$style_id."' , 'C6C3C3'),
('form_checkbox_size', 'Form Checkbox Size', 'Form Checkbox Size', '".$style_id."' , 'medium'),
('form_input_text_has_background', 'Form Input Text Has Background', 'Form Input Text Has Background', '".$style_id."' , 'on'),
('form_input_text_background_color', 'Form Input Text Background Color', 'Form Input Text Background Color', '".$style_id."' , 'FFFFFF'),
('form_input_text_border_color', 'Form Input Text Border Color', 'Form Input Text Border Color', '".$style_id."' , 'DEDFE0'),
('form_input_text_border_size', 'Form Input Text Border Size', 'Form Input Text Border Size', '".$style_id."' , '2'),
('form_input_text_border_radius', 'Form Input Text Border Radius', 'Form Input Text Border Radius', '".$style_id."' , '3'),
('form_input_text_font_size', 'Font Input Text Font Size', 'Font Input Text Font Size', '".$style_id."' , '12'),
('form_input_text_font_color', 'Form Input Text Font Color', 'Form Input Text Font Color', '".$style_id."' , '393939'),
('form_textarea_has_background', 'Form Textarea Has Background', 'Form Textarea Has Background', '".$style_id."' , 'on'),
('form_textarea_background_color', 'Form Textarea Background Color', 'Form Textarea Background Color', '".$style_id."' , 'FFFFFF'),
('form_textarea_border_size', 'Form Textarea Border Size', 'Form Textarea Border Size', '".$style_id."' , '1'),
('form_textarea_border_color', 'Form Textarea Border Color', 'Form Textarea Border Color', '".$style_id."' , 'C7C5C5'),
('form_textarea_border_radius', 'Form Textarea Border Radius', 'Form Textarea Border Radius', '".$style_id."' , '1'),
('form_textarea_font_size', 'Form Textarea Font Size', 'Form Textarea Font Size', '".$style_id."' , '12'),
('form_textarea_font_color', 'Form Textarea Font Color', 'Form Textarea Font Color', '".$style_id."' , '393939'),
('form_selectbox_arrow_color', 'Form Selectbox Arrow Color', 'Form Selectbox Arrow Color', '".$style_id."' , 'FE5858'),
('form_selectbox_has_background', 'Form Selectbox Has Background', 'Form Selectbox Has Background', '".$style_id."' , 'on'),
('form_selectbox_background_color', 'Form Selectbox Background Color', 'Form Selectbox Background Color', '".$style_id."' , 'FFFFFF'),
('form_selectbox_font_size', 'Form Selectbox Font Size', 'Form Selectbox Font Size', '".$style_id."' , '14'),
('form_selectbox_border_size', 'Form Selectbox Border Size', 'Form Selectbox Border Size', '".$style_id."' , '1'),
('form_selectbox_border_color', 'Form Selectbox Border Color', 'Form Selectbox Border Color', '".$style_id."' , 'C7C5C5'),
('form_selectbox_border_radius', 'Form Selectbox Border Radius', 'Form Selectbox Border Radius', '".$style_id."' , '2'),
('form_label_error_color', 'Form Label Error Color', 'Form Label Error Color', '".$style_id."' , 'C2171D'),
('form_label_color', 'Form Label Color', 'Form Label Color', '".$style_id."' , '3B3B3B'),
('form_label_font_family', 'Form Label Font Family', 'Form Label Font Family', '".$style_id."' , 'Calibri,Helvetica Neue,Helvetica,Arial,Verdana,sans-serif'),
('form_label_size', 'Form Label Size', 'Form Label Size', '".$style_id."' , '16'),
('form_title_color', 'Form Title Color', 'Form Title Color', '".$style_id."' , 'FE5858'),
('form_title_size', 'Form Title Size', 'Form Title Size', '".$style_id."' , '22'),
('form_show_title', 'Form Show Title', 'Form Show Title', '".$style_id."' , 'on'),
('form_border_size', 'Form Border Size', 'Form Border Size', '".$style_id."' , '1'),
('form_border_color', 'Form Border Color', 'Form Border Color', '".$style_id."' , 'DEDFE0'),
('form_wrapper_width', 'Form Wrapper Width', 'Form Wrapper Width', '".$style_id."' , '100'),
('form_wrapper_background_type', 'Form Wrapper Background Type', 'Form Wrapper Background Type', '".$style_id."' , 'color'),
('form_wrapper_background_color', 'Form Background Color', 'Form Background Color', '".$style_id."' , 'fcfcfc,E6E6E6')";

	$wpdb->query($options_sql1);
	
	$query="SELECT * FROM ".$wpdb->prefix."huge_it_contact_styles order by id ASC";
	$rowsldcc=$wpdb->get_results($query);
	$last_key = key( array_slice( $rowsldcc, -1, 1, TRUE ) );
			   
			   
	foreach($rowsldcc as $key=>$rowsldccs){
		if($last_key == $key){
			header('Location: admin.php?page=hugeit_forms_theme_options&form_id='.$rowsldccs->id.'');
		}
	}
	}
		
	$query="SELECT * FROM ".$wpdb->prefix."huge_it_contact_styles order by id ASC";
	$style_themes=$wpdb->get_results($query);

	if ( !empty($param_values) ) {
		hugeit_contact_html_editstyles( $param_values, $op_type, $style_themes );
	}
}

function hugeit_contact_save_styles_options() {
	global $wpdb;
	if ( isset( $_POST['params'] ) ) {
		if ( isset( $_POST["themeName"] ) ) {
			$_POST["themeName"] = sanitize_text_field($_POST["themeName"]);
			$_GET['form_id'] = absint($_GET['form_id']);
			if ( trim($_POST["themeName"]) != '' ) {
				$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_styles SET  name = %s  WHERE id = %d ", $_POST["themeName"], $_GET['form_id'] ) );
			}
		}
		$params = $_POST['params'];
		foreach ( $params as $key => $value ) {
			$value = sanitize_text_field($value);
			$key = sanitize_text_field($key);
			$wpdb->query( "UPDATE " . $wpdb->prefix . "huge_it_contact_style_fields SET  value = '" . $value . "'  WHERE name = '" . $key . "' and options_name = '" . $_GET['form_id'] . "' " );
		}
		?>
		<div class="updated"><p><strong><?php echo 'Item Saved'; ?></strong></p></div>
		<?php
	}
}
