<?php
/**
 * esc_htmlの配列対応版
 */
function esc_htmls( $str ) {
    if ( is_array( $str ) ) {
        return array_map( "esc_html", $str );
    }else {
        return esc_html( $str );
    }
}

/**
 * エラー表示
 */
function display_messages( $_messages, $_state ) {
?>
    <div class="<?php echo $_state; ?>">
        <ul>
            <?php foreach ( $_messages as $message ): ?>
                <li><?php echo esc_html( $message ); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php
}