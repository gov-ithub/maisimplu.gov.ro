<?php
defined('ABSPATH') or die("Cannot access pages directly.");

add_action('after_switch_theme', 'govit_do_migration');
/**
 *  Will convert various options to work with the mai simplu theme
 */
function govit_do_migration(){
	// Here you can do various actions as soon as the theme is activated
	// If you need DB integrations, you can use $wpdb ( https://codex.wordpress.org/Class_Reference/wpdb )
	// IMPORTANT : This will run every time the theme is activated.
}