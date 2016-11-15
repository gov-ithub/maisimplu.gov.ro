<?php
    /*
    Plugin Name: Profile Builder - Select2 Add-On
    Plugin URI: http://www.cozmoslabs.com/wordpress-profile-builder/
    Description: Add an improved select field to Profile Builder fields list. It allows you to create select fields with search & filter and multiple selection. All of this in a good looking, responsive select box.
    Version: 1.0.2
    Author: Cozmoslabs, Razvan Mocanu
    Author URI: http://www.cozmoslabs.com/
    License: GPL2

    == Copyright ==
    Copyright 2015 Cozmoslabs (www.cozmoslabs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
    */

    /*
     * Define plugin path and include dependencies.
     *
     * @since 1.0.0
     */
    define('WPPBSL2_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename(__FILE__) ));
    define('WPPBSL2_PLUGIN_URL', plugin_dir_url(__FILE__) );

    // Include the file that manages manage fields
    if (file_exists(WPPBSL2_PLUGIN_DIR . '/admin/manage-fields.php'))
        include_once(WPPBSL2_PLUGIN_DIR . '/admin/manage-fields.php');

    // Include the files for the custom field
    if (file_exists(WPPBSL2_PLUGIN_DIR . '/front-end/select2-field.php'))
        include_once(WPPBSL2_PLUGIN_DIR . '/front-end/select2-field.php');
    if (file_exists(WPPBSL2_PLUGIN_DIR . '/front-end/select2-multiple-field.php'))
        include_once(WPPBSL2_PLUGIN_DIR . '/front-end/select2-multiple-field.php');

    /*
     * Check for updates
     *
     * @since 1.0.1
     */
    if (file_exists(WPPBSL2_PLUGIN_DIR . '/update/update-checker.php')) {
        include_once(WPPBSL2_PLUGIN_DIR . '/update/update-checker.php');

        $wppb_sl2_update = new wppb_PluginUpdateChecker('http://updatemetadata.cozmoslabs.com/?uniqueproduct=CLPBSL', __FILE__, 'wppb-sl2-add-on');
    }



    /*
     * Function that enqueues the necessary scripts in the admin area.
     *
     * @since 1.0.0
     *
     * @param string $current_page Identifies the current admin page to enqueue only the necessary scripts. 
     */
    function wppb_sl2_scripts_admin($current_page) {
        if( $current_page == 'profile-builder_page_manage-fields' ){
            wp_enqueue_script( 'wppb_sl2_main', plugin_dir_url(__FILE__) . 'assets/js/main.js', array( 'jquery', 'wppb-manage-fields-live-change' ) );
        }

        if( $current_page == 'user-edit.php' || $current_page == 'profile.php'){
            wp_enqueue_script( 'wppb_sl2_lib_js', plugin_dir_url(__FILE__) . 'assets/select2-lib/dist/js/select2.min.js', array( 'jquery' ) );
            wp_enqueue_style( 'wppb_sl2_css', plugin_dir_url(__FILE__) . 'assets/css/style-back-end.css');
            wp_enqueue_style( 'wppb_sl2_lib_css', plugin_dir_url(__FILE__) . 'assets/select2-lib/dist/css/select2.min.css');       
        }
    }
    add_action( 'admin_enqueue_scripts', 'wppb_sl2_scripts_admin' );