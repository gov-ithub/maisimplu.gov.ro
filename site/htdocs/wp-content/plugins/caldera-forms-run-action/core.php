<?php
/**
 * Plugin Name: Caldera Forms - Run Action
 * Plugin URI:  
 * Description: Runs an action on submit
 * Version: 1.0.1
 * Author:      David Cramer
 * Author URI:
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Translation Domain: cf-run-action
 */


add_filter('caldera_forms_get_form_processors', 'cf_run_action_register_processor');
/**
 * Add processor
 *
 * @uses "caldera_forms_get_form_processors" filter
 *
 * @since 1.0.0
 *
 * @return array Processors
 */
function cf_run_action_register_processor($pr){
	$pr['run_action'] = array(
		"name"              =>  __('Run Action'),
		"description"       =>  __("Run Action on submission"),
		"author"            =>  'David Cramer',
		"author_url"        =>  'http://cramer.co.za',
		"pre_processor"     =>  'cf_run_action_pre_process',
		"processor"         =>  'cf_run_action_process',
		"post_processor"    =>  'cf_run_action_post_process',
		"template"          =>  plugin_dir_path(__FILE__) . "config.php",
	);

	return $pr;
}

/**
 * Callback function for the pre processor
 *
 * @since 1.0.0
 *
 * @param array $config Processor settings. Key 'action' has action name.
 * @param array $form Form submission data.
 */
function cf_run_action_pre_process( $config, $form){
	
	// comatability with old version and standard check.
	if( !isset( $config['position'] ) || $config['position'] !== 'pre' ){
		return;
	}

	$data = array();
	foreach($form['fields'] as $field_id=>$field){
		$data[$field['slug']] = Caldera_Forms::get_field_data($field_id, $form);
	}

	if( $config['type'] == 'filter' ){
		/**
		 * The filter this pre processor calls. Named according to form setting.
		 *
		 * @param array $data Array of form data, keyed by field ID.
		 * @param array $form Form submission data.
		 */
		if( has_filter( $config['action'] ) ){
			return apply_filters($config['action'], $data, $form);
		}
	}else{
		/**
		 * The action this pre processor calls. Named according to form setting.
		 *
		 * @param array $data Array of form data, keyed by field ID.
		 * @param array $form Form submission data.
		 */
		do_action($config['action'], $data, $form);
	}

}


/**
 * Callback function for the processor
 *
 * @since 1.0.0
 *
 * @param array $config Processor settings. Key 'action' has action name.
 * @param array $form Form submission data.
 */
function cf_run_action_process( $config, $form){

	// comatability with old version and standard check.
	if( isset( $config['position'] ) && $config['position'] !== 'process' ){
		return;
	}
	
	$data = array();
	foreach($form['fields'] as $field_id=>$field){
		$data[$field['slug']] = Caldera_Forms::get_field_data($field_id, $form);
	}

	if( isset( $config['type'] ) && $config['type'] == 'filter' && has_filter( $config['action'] ) ){
		/**
		 * The filter this processor calls. Named according to form setting.
		 *
		 * @param array $data Array of form data, keyed by field ID.
		 * @param array $form Form submission data.
		 */
		if( has_filter( $config['action'] ) ){
			return apply_filters($config['action'], $data, $form);
		}

	}else{
		/**
		 * The action this processor calls. Named according to form setting.
		 *
		 * @param array $data Array of form data, keyed by field ID.
		 * @param array $form Form submission data.
		 */
		do_action($config['action'], $data, $form);
	}

}


/**
 * Callback function for the post processor
 *
 * @since 1.0.0
 *
 * @param array $config Processor settings. Key 'action' has action name.
 * @param array $form Form submission data.
 */
function cf_run_action_post_process( $config, $form){
	
	// comatability with old version and standard check.
	if( !isset( $config['position'] ) || $config['position'] !== 'post' ){
		return;
	}	
	
	$data = array();
	foreach($form['fields'] as $field_id=>$field){
		$data[$field['slug']] = Caldera_Forms::get_field_data($field_id, $form);
	}

	if( $config['type'] == 'filter' ){
		/**
		 * The filter this post processor calls. Named according to form setting.
		 *
		 * @param array $data Array of form data, keyed by field ID.
		 * @param array $form Form submission data.
		 */
		if( has_filter( $config['action'] ) ){
			return apply_filters($config['action'], $data, $form);
		}

	}else{
		/**
		 * The action this post processor calls. Named according to form setting.
		 *
		 * @param array $data Array of form data, keyed by field ID.
		 * @param array $form Form submission data.
		 */
		do_action($config['action'], $data, $form);
	}

}


