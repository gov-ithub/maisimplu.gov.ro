<?php
/**
 * base class
 */
abstract class WCEBase {

    /**
     * esc_htmlの配列対応版
     */
    public function esc_htmls( $str ) {
        if ( is_array( $str ) ) {
            return array_map( "esc_html", $str );
        }else {
            return esc_html( $str );
        }
    }

    /**
     * Load template file
     *
     * @param string $name
     */
    public function get_template($name){
        $path = WCE_PLUGIN_DIR."{$name}.php";
        if( file_exists($path) ){
            include $path;
        }
    }

    /**
     * return $_REQUEST
     *
     * @param string $key
     * @return mixed
     */
    public function request($key){
        if(isset($_REQUEST[$key])){
            return $_REQUEST[$key];
        }else{
            return null;
        }
    }

    /**
     * 翻訳用
     */
    public function e( $text, $ja = null ) {
        _e( $text, $this->textdomain );
    }
    public function _( $text, $ja = null ) {
        return __( $text, $this->textdomain );
    }
}