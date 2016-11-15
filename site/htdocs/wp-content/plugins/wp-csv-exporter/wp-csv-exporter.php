<?php
/*
Plugin Name: WP CSV Exporter
Plugin URI: http://www.kigurumi.asia
Description: You can export posts in CSV format for each post type. It is compatible with posts' custom fields and custom taxonomies. It is also possible to set the number or date range of posts to download.
Author: Nakashima Masahiro
Version: 1.1.1
Author URI: http://www.kigurumi.asia
License: GPLv2 or later
Text Domain: wce
Domain Path: /languages/
 */
require('classes/wce-base.php');

define( 'WCE_VERSION', '1.1.1' );
define( 'WCE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WCE_PLUGIN_NAME', trim( dirname( WCE_PLUGIN_BASENAME ), '/' ) );
define( 'WCE_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'WCE_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

class WP_CSV_Exporter extends WCEBase{
	protected $textdomain = 'wce';

	public function __construct() {
		$this->init();

		// 管理メニューに追加するフック
		add_action( 'admin_menu', array( $this, 'admin_menu', ) );

		// css, js
		add_action( 'admin_print_styles', array( $this, 'head_css', ) );
		add_action( 'admin_print_scripts', array( $this, "head_js", ) );

	}


	public function init() {
		//他言語化
		load_plugin_textdomain( $this->textdomain, false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * メニューを表示
	 */
	public function admin_menu() {
		add_submenu_page( 'tools.php', $this->_( 'CSV Export', 'CSVエクスポート' ), $this->_( 'CSV Export', 'CSVエクスポート' ), 'level_7', WCE_PLUGIN_NAME, array( $this, 'show_options_page', ) );
	}

    /**
     * プラグインのメインページ
     */
	public function show_options_page() {
		require_once WCE_PLUGIN_DIR . '/admin/index.php';
	}

    /**
     * Get admin panel URL
     */
    public function setting_url($view = ''){
        $query = array(
            'page' => 'wp-csv-exporter',
        );
        if( $view ){
            $query['view'] = $view;
        }
        return admin_url('tools.php?'.http_build_query($query));
    }

	/**
	 * 管理画面CSS追加
	 */
	public function head_css() {
		if (  isset($_REQUEST["page"]) && $_REQUEST["page"] == WCE_PLUGIN_NAME ) {
			wp_enqueue_style( "wce_css", WCE_PLUGIN_URL . '/css/style.css' );
			wp_enqueue_style('jquery-ui-style',  WCE_PLUGIN_URL . '/css/jquery-ui.css');
		}
	}

	/*
	 * 管理画面JS追加
	 */
	public function head_js() {
		if ( isset($_REQUEST["page"]) && $_REQUEST["page"] == WCE_PLUGIN_NAME && $_REQUEST["view"] != 'setting' ) {
			wp_enqueue_script('jquery');
			wp_enqueue_script( "jquery-ui-core" );
			wp_enqueue_script( "jquery-ui-datepicker" );
			wp_enqueue_script( "wce_admin_js", WCE_PLUGIN_URL . '/js/admin.js', array('jquery'), '', true );
		}
	}

	/**
	 * カスタムフィールドリストを取得
	 */
	public function get_custom_field_list( $type ) {
		global $wpdb;
		$value_parameter = esc_html( $type );
		$pattern = "\_%";
		$query = <<< EOL
SELECT DISTINCT meta_key
FROM $wpdb->postmeta
INNER JOIN $wpdb->posts
        ON $wpdb->posts.ID = $wpdb->postmeta.post_id
WHERE $wpdb->posts.post_type = '%s'
AND $wpdb->postmeta.meta_key NOT LIKE '%s'
EOL;
		return $wpdb->get_results( $wpdb->prepare( $query, array( $value_parameter, $pattern ) ), ARRAY_A );
	}

}
$wp_csv_exporter = new WP_CSV_Exporter();
