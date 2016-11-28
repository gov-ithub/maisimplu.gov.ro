<?php
defined('ABSPATH') or die("Cannot access pages directly.");

add_action('after_switch_theme', 'govit_do_migration');

/**
 *  Will convert various options to work with the mai simplu theme
 */
function govit_do_migration(){

	// Check if the migration already happened
	$migration_done = get_option( 'govithub_v2_migration' );
	if( $migration_done ){
		return;
	}

	// Create focus group category
	wp_insert_term(
		'Focus grup',
		'category',
		array(
		  'description'	=> 'Categorie pentru focus grup.',
		  'slug' 		=> 'focus-grup'
		)
	);

	// Set an option so that we only make the migration once
	update_option( 'govithub_v2_migration', true );

}