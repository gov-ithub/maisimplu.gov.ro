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

function hugeit_contact_show_emails() {
	global $wpdb;
	$genOptions       = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_general_options ORDER BY id" );
	$mailing_progress = $genOptions[33]->value;
	$mailerParams     = array(
		'sub_count_by_parts' => $genOptions[30]->value,
		'sub_interval'       => $genOptions[31]->value,
		'email_subject'      => $genOptions[32]->value,
		'mailing_progress'   => $genOptions[33]->value,
	);
	$count            = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers" );
	$subscribers      = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_subscribers ORDER BY subscriber_id DESC", ARRAY_A );
	$fieldInfo        = $wpdb->get_results( "SELECT DISTINCT subscriber_form_id FROM " . $wpdb->prefix . "huge_it_contact_subscribers", ARRAY_A );
	$formsToShow      = array();
	foreach ( $fieldInfo as $key => $value ) {
		$res = $wpdb->get_results( "SELECT name,id FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id=" . $value['subscriber_form_id'], ARRAY_A );
		if ( $res ) {
			$formsToShow[ $res[0]['id'] ] = $res[0]['name'];
		}
	}
	$mailing = array();
	if ( $mailing_progress == 'start' ) {
		$formsID  = $genOptions[29]->value;
		$limit    = $genOptions[30]->value;
		$schedule = $genOptions[31]->value;
		if ( $formsID == 'all' ) {
			$count_subscribers     = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE `send`='1'" );
			$total_total_percent   = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE send='1' OR send='3'" );
			$current_total_percent = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE send='3'" );
			$need_time             = ceil( $count_subscribers / $limit ) * $schedule;
			$need_time             = date( "H:i:s", mktime( 0, 0, $need_time ) );
			$percent               = round( $current_total_percent / $total_total_percent * 100 );
			$mailing['need_time']  = $need_time;
			$mailing['percent']    = $percent;
		} else {
			$count_subscribers     = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers  WHERE `send`='1' AND subscriber_form_id=" . $formsID . "" );
			$total_total_percent   = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE subscriber_form_id=" . $formsID . " AND (send='1' OR send='3')" );
			$current_total_percent = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE subscriber_form_id=" . $formsID . " AND send='3'" );
			$need_time             = ceil( $count_subscribers / $limit ) * $schedule;
			$need_time             = date( "H:i:s", mktime( 0, 0, $need_time ) );
			$percent               = round( $current_total_percent / $total_total_percent * 100 );
			$mailing['need_time']  = $need_time;
			$mailing['percent']    = $percent;

		}
	}
	hugeit_contact_html_show_emails( $subscribers, $mailerParams, $count, $formsToShow, $mailing );
}

function hugeit_contact_save_global_options() {
	global $wpdb;
	if ( isset( $_POST['mailerParams'] ) ) {
		$mailerParams = esc_html( $_POST['mailerParams'] );
		$mailerParams = huge_it_subscriber_sanitize( $mailerParams );
		foreach ( $mailerParams as $key => $value ) {
			$wpdb->update( $wpdb->prefix . 'huge_it_contact_general_options', array( 'value' => $value ), array( 'name' => $key ), array( '%s' ) );
		}
		?>
		<div class="updated"><p><strong><?php _e( 'Settings Saved' ); ?></strong></p></div>
		<?php
	}
}

function huge_it_subscriber_sanitize($options){
	$clean_options = array();
	$schedule = array(60, 120, 1800, 3600);
	$clean_options['sub_count_by_parts'] = ( (int)$options['sub_count_by_parts'] > 0 ) ? $options['sub_count_by_parts'] : 10;
	if( in_array($options['sub_interval'], $schedule) ){
		$clean_options['sub_interval'] = $options['sub_interval'];
	}else{
		$clean_options['sub_interval'] = 120;
	}
	return $clean_options;
}
  