<?php
defined('ABSPATH') or die("Cannot access pages directly.");

add_action('after_switch_theme', 'govit_do_migration');
/**
 *  Will convert various options to work with the mai simplu theme
 */
function govit_do_migration(){

	global $wpdb;

	// Check if the migration already happened
	$migration_done = get_option( 'govithub_v2_migration' );
	if( $migration_done ){
		return;
	}

	// Here you can do various actions as soon as the theme is activated
	// If you need DB integrations, you can use $wpdb ( https://codex.wordpress.org/Class_Reference/wpdb )
	// IMPORTANT : This will run every time the theme is activated.

	// delete ratings_average from post meta ( see https://github.com/gov-ithub/maisimplu.gov.ro/issues/14 )
	$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => 'ratings_average' ) );

	// Negative ratings
	govithub_rating_update( 1, -1 );
	govithub_rating_update( 2, -1 );

	// Neutral ratings
	govithub_rating_update( 3, 0 );

	// Positive ratings
	govithub_rating_update( 4, 1 );
	govithub_rating_update( 5, 1 );

	// Set an option so that we only make the migration once
	update_option( 'govithub_v2_migration', true );

	// Update rating count for all posts
	govithub_recalculate_all_ratings();
}


/**
 * Helper function to update the ratings based on new plus/minus system
 */
function govithub_rating_update( $old_value, $new_value ){
	global $wpdb;

	$result = $wpdb->query(
		$wpdb->prepare(
			"
				UPDATE {$wpdb->prefix}ratings
				SET rating_rating=%d
				WHERE rating_rating=%d
			",
			$new_value, $old_value
		)
	);

}


/**
 * Updates rating count for all posts
 */
function govithub_recalculate_all_ratings(){
	global $wpdb;

	// Get ratings by postID
	$sql_select  = "SELECT rating_postid, sum(rating_rating) as _sum FROM {$wpdb->prefix}ratings WHERE 1=1 GROUP BY rating_postid;";
	$insert_rows = $wpdb->get_results( $sql_select );

	// Remove old values
	$sql_delete = "DELETE FROM `{$wpdb->postmeta}` WHERE `meta_key`='ratings_score';";
	$wpdb->query( $sql_delete );

	// Insert updated ratings
	foreach ( $insert_rows as $insert_row ){
		$sql_insert = "INSERT INTO `{$wpdb->postmeta}` (`post_id`, `meta_key`, `meta_value`) VALUES ('{$insert_row->rating_postid}', 'ratings_score', '{$insert_row->_sum}');";
		$wpdb->query( $sql_insert );
	}
}
