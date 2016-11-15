<?php
/* 
 * Handle field output.
 * 
 * @since 1.0.0
 *
 * @param string $output Contains the HTML to display the select2 field.
 * @param string $form_location
 * @param array $field
 * @param integer $user_id
 * @param array $field_check_errors
 * @param array $request_data
 * @return string Filtered output of the HTML to display the select2 field.
 */
function wppb_select2_handler( $output, $form_location, $field, $user_id, $field_check_errors, $request_data ){
	if ( $field['field'] == 'Select2' ){
        wp_enqueue_script( 'wppb_sl2_lib_js', WPPBSL2_PLUGIN_URL . 'assets/select2-lib/dist/js/select2.min.js', array( 'jquery' ) );
        wp_enqueue_style( 'wppb_sl2_lib_css', WPPBSL2_PLUGIN_URL . 'assets/select2-lib/dist/css/select2.min.css');
        wp_enqueue_style( 'wppb_sl2_css',  WPPBSL2_PLUGIN_URL . 'assets/css/style-front-end.css');

		$field['labels']= apply_filters( 'wppb_select2_labels', $field['labels'], $form_location, $field, $user_id, $field_check_errors, $request_data );
        $field['options'] = apply_filters( 'wppb_select2_options', $field['options'], $form_location, $field, $user_id, $field_check_errors, $request_data );
        $arguments = apply_filters('wppb_select2_arguments', '', $form_location, $field);

       	$init_script = "<script>";
		$init_script .= "jQuery( document ).ready(function() {	jQuery('#" . wppb_sl2_handle_meta_name( $field['meta-name'] ) . ".custom_field_select2').select2(";
		$init_script .= $arguments;									
		$init_script .= ");});</script>";
		
        echo $init_script;

		$item_title = apply_filters( 'wppb_'.$form_location.'_select2_custom_field_'.$field['id'].'_item_title', wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_title_translation', $field['field-title'] ) );
		$item_description = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_description_translation', $field['description'] );
		$item_option_labels = wppb_icl_t( 'plugin profile-builder-pro', 'custom_field_'.$field['id'].'_option_labels_translation', $field['labels'] );

		$select2_labels = explode( ',', $item_option_labels );
		$select2_values = explode( ',', $field['options'] );

		$extra_attr = apply_filters( 'wppb_extra_attribute', '', $field );

        if( $form_location != 'register' )
		    $input_value = ( ( wppb_user_meta_exists ( $user_id, $field['meta-name'] ) != null ) ? stripslashes( get_user_meta( $user_id, $field['meta-name'], true ) ) : $field['default-option'] );
        else
            $input_value = ( !empty( $field['default-option'] ) ? trim( $field['default-option'] ) : '' );

        $input_value = ( isset( $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] ) ? stripslashes( trim( $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] ) ) : $input_value );

		if ( $form_location != 'back_end' ){
			$error_mark = ( ( $field['required'] == 'Yes' ) ? '<span class="wppb-required" title="'.wppb_required_field_error($field["field-title"]).'">*</span>' : '' );
						
			if ( array_key_exists( $field['id'], $field_check_errors ) )
				$error_mark = '<img src="'.WPPB_PLUGIN_URL.'assets/images/pencil_delete.png" title="'.wppb_required_field_error($field["field-title"]).'"/>';
        
			$output = '
				<label for="'.$field['meta-name'].'">'.$item_title.$error_mark.'</label>
				<select name="'.$field['meta-name'].'" id="'.$field['meta-name'].'" class="custom_field_select2" '. $extra_attr .'>';
				
				foreach( $select2_values as $key => $value){
					$output .= '<option value="'.esc_attr( trim( $value ) ).'" class="custom_field_select2_option '. apply_filters( 'wppb_fields_extra_css_class', '', $field ) .'" ';

					if ( $input_value === trim( $value ) )
						$output .= ' selected';

					$output .= '>'.( ( !isset( $select2_labels[$key] ) || !$select2_labels[$key] ) ? trim( $select2_values[$key] ) : trim( $select2_labels[$key] ) ).'</option>';
				}
				
				$output .= '
				</select>';
            if( !empty( $item_description ) )
                $output .= '<span class="wppb-description-delimiter">'.$item_description.'</span>';

		}else{
            $item_title = ( ( $field['required'] == 'Yes' ) ? $item_title .' <span class="description">('. __( 'required', 'profile-builder' ) .')</span>' : $item_title );
			$output = '
				<table class="form-table wppb-select2">
					<tr>
						<th><label for="'.$field['meta-name'].'">'.$item_title.'</label></th>
						<td>
							<select name="'.$field['meta-name'].'" class="custom_field_select2" id="'.$field['meta-name'].'" '. $extra_attr .'>';
							
							foreach( $select2_values as $key => $value){
								$output .= '<option value="'.esc_attr( trim( $value ) ).'" class="custom_field_select2_option" ';
								
								if ( $input_value === trim( $value ) )
									$output .= ' selected';

								$output .= '>'.( ( !isset( $select2_labels[$key] ) || !$select2_labels[$key] ) ? trim( $select2_values[$key] ) : trim( $select2_labels[$key] ) ).'</option>';
							}

							$output .= '</select>
							<span class="description">'.$item_description.'</span>
						</td>
					</tr>
				</table>';
		}
			
		return apply_filters( 'wppb_'.$form_location.'_select2_custom_field_'.$field['id'], $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value );
	}
}
add_filter( 'wppb_output_form_field_select2', 'wppb_select2_handler', 10, 6 );
add_filter( 'wppb_admin_output_form_field_select2', 'wppb_select2_handler', 10, 6 );

/* 
 * Handle field save.
 * 
 * @since 1.0.0
 *
 * @param array $field
 * @param integer $user_id
 * @param array $request_data
 * @param string $form_location
 */
function wppb_save_select2_value( $field, $user_id, $request_data, $form_location ){
	if( $field['field'] == 'Select2' ){
		if ( isset( $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] ) )
			update_user_meta( $user_id, $field['meta-name'], $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] );
	}
}
add_action( 'wppb_save_form_field', 'wppb_save_select2_value', 10, 4 );
add_action( 'wppb_backend_save_form_field', 'wppb_save_select2_value', 10, 4 );

/* 
 * Handle field validation.
 * 
 * @since 1.0.0
 *
 * @param string $message
 * @param array $field
 * @param array $request_data
 * @param $form_location
 * @return string Message to display on field validation
 */
function wppb_check_select2_value( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Select2' ){
        if( $field['required'] == 'Yes' ){
            if ( ( isset( $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] ) && ( trim( $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] ) == '' ) ) || !isset( $request_data[wppb_sl2_handle_meta_name( $field['meta-name'] )] ) ){
                return wppb_required_field_error($field["field-title"]);
            }
        }
	}

    return $message;
}
add_filter( 'wppb_check_form_field_select2', 'wppb_check_select2_value', 10, 4 );

/* 
 * For meta-names with spaces in them PHP converts the space to underline in the $_POST.
 * 
 * @since 1.0.0
 *
 * @param string $meta_name
 * @return string
 */
/* for meta-names with spaces in them PHP converts the space to underline in the $_POST  */
function wppb_sl2_handle_meta_name( $meta_name ){
    $meta_name = str_replace( ' ', '_', $meta_name );
    return $meta_name;
}