<?php
defined('ABSPATH') or die("Cannot access pages directly.");

add_action('after_switch_theme', 'govit_do_migration');
/**
 *  Will convert various options to work with the mai simplu theme
 */
function govit_do_migration(){

	global $wpdb;

	// Here you can do various actions as soon as the theme is activated
	// If you need DB integrations, you can use $wpdb ( https://codex.wordpress.org/Class_Reference/wpdb )
	// IMPORTANT : This will run every time the theme is activated.

	// delete ratings_average from post meta ( see https://github.com/gov-ithub/maisimplu.gov.ro/issues/14 )
	$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => 'ratings_average' ) );

	// Positive ratings
	govithub_rating_update( '5', '1' );
	govithub_rating_update( '4', '1' );

	// Neutral ratings
	govithub_rating_update( '3', '0' );

	// Negative ratings
	govithub_rating_update( '2', '-1' );
	govithub_rating_update( '1', '-1' );
}


/**
 * Helper function to update the ratings based on new plus/minus system
 */
function govithub_rating_update( $old_value, $new_value ){
	$wpdb->update( $wpdb->prefix.'ratings',
		array(
			'rating_rating' => $new_value
		),
		array(
			'rating_rating' => $old_value
		)
	);
}