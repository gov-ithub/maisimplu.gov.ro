<?php
//ダウンロードフォルダ
$filename = WCE_PLUGIN_DIR . '/download/';

//投稿タイプを取得
$post_types = get_post_types( array(), "objects" );

//特定の投稿タイプを削除
unset(
    $post_types['attachment'],
    $post_types['revision'],
    $post_types['nav_menu_item'],
    $post_types['acf'],
    $post_types['wpcf7_contact_form']
);

//タクソノミーを取得
$post_taxonomies = get_taxonomies( array(), "objects" );

//特定のタクソノミー削除
unset(
    $post_taxonomies['page'],
    $post_taxonomies['post_tag'],
    $post_taxonomies['nav_menu'],
    $post_taxonomies['link_category'],
    $post_taxonomies['post_format']
);

if( $wce_options = get_option('wce_options')){
    $wce_post_type = $wce_options['post_type'];
}
?>
<script type="text/javascript">
jQuery(function($){

    //チェックボックス
    $('.all_checked').click(function(){
        var target = $(this).attr('data-target');
        $(target).prop('checked', true);
    });
    $('.all_checkout').click(function(){
        var target = $(this).attr('data-target');
        $(target).prop('checked', false);
    });

<?php 
foreach ( $post_types as $post_type ):
    if( $post_type->name == 'post' || $post_type->name == 'page' || $wce_post_type ):
?>
$('#form_<?php echo esc_attr( $post_type->name ) ?>').submit(function(){
    var total_check_num = $("#form_<?php echo esc_attr( $post_type->name ) ?> input.post_status:checked").length;
    if(total_check_num == 0){
        alert('<?php $this->e( '"Status" is a required field.', '"ステータス"は必須項目です' ) ?>');
        return false;
    }

    //件数
    if(!$('#form_<?php echo esc_attr( $post_type->name ) ?> input.limit').val().match(/^[0-9]+$/)){
        alert('<?php $this->e( 'The number of posts must be entered in numerical format.', '記事数は数値のみが入力可能です。' ) ?>');
        return false;
    }
});


//offsetの表示
$('input.limit').on({
    'change':function(){
        var target = $(this).attr('data-target');
        if( $(this).val() > 0 ){
            $(target).fadeIn();
        }else{
            $(target).fadeOut();
        }
    }
});
<?php 
    endif;
endforeach;
?>
});
</script>

<div class="wrap plugin-wrap">

<div class="plugin-main-area">
<h2><?php $this->e( 'WP CSV Exporter', 'WP CSV Exporter' ) ?></h2>
<p>
<?php $this->e( 'Please set the fields you would like to export with CSV.', 'CSVでエクスポートする項目を設定してください。' ) ?>
</p>

<?php if ( !is_writable( $filename ) ) : ?>
<div class="error">
    <p>
        <?php $this->e( 'Please adjust your permissions so that you are able to edit the below directory.', '以下のディクレトリに書き込みができるようにパーミッションを変更してください。' ) ?><br>
        <strong><?php echo $filename; ?></strong>
    </p>
</div>
<?php endif; ?>

<ul class="plugin_tab">
<?php foreach ( $post_types as $post_type ): ?>
<li class="plugin_tab-<?php echo $post_type->name;?>"><?php echo $post_type->labels->name;?></li>
<?php endforeach; ?>
</ul>

<div class="plugin_contents">
<?php 
foreach ( $post_types as $post_type ): 
    if( $post_type->name == 'post' || $post_type->name == 'page' || $wce_post_type ):
?>
    <div class="plugin_content">
<form action="<?php echo WCE_PLUGIN_URL .'/admin/download.php'; ?>" method="post" id="form_<?php echo esc_attr( $post_type->name ) ?>" target="_blank">
<?php wp_nonce_field( 'csv_exporter' );?>

<div class="tool-box">
<h3><?php echo $post_type->labels->name;?> <?php $this->e( 'Settings', '設定' ) ?></h3>
<ul class="setting_list">
    <li><label><input type="radio" name="post_id" value="post_id" checked="checked" required>*<?php $this->e( 'Post ID', '投稿ID' ) ?></label></li>
    <li><label><input type="radio" name="type" value="<?php echo esc_attr( $post_type->name ) ?>" checked="checked" required>*<?php $this->e( 'Post Type', '投稿タイプ' ) ?></label></li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_name" checked="checked"><?php $this->e( 'Slug', 'スラッグ' ) ?></label></li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_title" checked="checked"><?php $this->e( 'Post Title', '記事タイトル' ) ?></label></li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_content" checked="checked"><?php $this->e( 'Post Content', '記事本文' ) ?></label></li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_excerpt"><?php $this->e( 'Post Excerpt', '抜粋' ) ?></label></li>
    <li><label><input type="checkbox" name="post_thumbnail" value="post_thumbnail"><?php $this->e( 'Thumbnail', 'アイキャッチ画像' ) ?></label></li>
    <li><?php $this->e( 'Status', 'ステータス' ) ?>
    <ul>
        <li><label><input type="checkbox" name="post_status[]" value="publish" class="post_status" checked="checked"><?php $this->e( 'Publish', '公開済み（publish）' ) ?></label></li>
        <li><label><input type="checkbox" name="post_status[]" value="pending" class="post_status" ><?php $this->e( 'Pending', 'レビュー待ち（pending）' ) ?></label></li>
        <li><label><input type="checkbox" name="post_status[]" value="draft" class="post_status" ><?php $this->e( 'Draft', '下書き（draft）' ) ?></label></li>
        <li><label><input type="checkbox" name="post_status[]" value="future" class="post_status" ><?php $this->e( 'Future', 'スケジュール済み（future）' ) ?></label></li>
        <li><label><input type="checkbox" name="post_status[]" value="private" class="post_status" ><?php $this->e( 'Private', '非公開（private）' ) ?></label></li>
        <li><label><input type="checkbox" name="post_status[]" value="trash" class="post_status" ><?php $this->e( 'Trash', 'ゴミ箱入り（trash）' ) ?></label></li>
        <li><label><input type="checkbox" name="post_status[]" value="inherit" class="post_status" ><?php $this->e( 'Inherit', 'inherit' ) ?></label></li>
    </ul>
    </li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_author"><?php $this->e( 'Author', '投稿者' ) ?></label></li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_date"><?php $this->e( 'Post Date', '公開日時' ) ?></label></li>
    <li><label><input type="checkbox" name="posts_values[]" value="post_modified"><?php $this->e( 'Date Modified', '変更日時' ) ?></label></li>
    <li><label><input type="checkbox" name="post_tags" value="post_tags"><?php $this->e( 'Tags', 'タグ' ) ?></label></li>
</ul>
</div>

<hr>

<div class="tool-box">
<h3><?php $this->e( 'Taxonomies', 'タクソノミー' ) ?>
<span class="all_checks">
[
<a href="javascript:void(0);" class="all_checked" data-target="#form_<?php echo esc_attr( $post_type->name ) ?> .cf_taxonomy"><?php $this->e( 'Select all', '全選択' ) ?></a>
<a href="javascript:void(0);" class="all_checkout" data-target="#form_<?php echo esc_attr( $post_type->name ) ?> .cf_taxonomy"><?php $this->e( 'Unselect all', '全解除' ) ?></a>
]
</span>
</h3>
<ul class="setting_list">
<?php
$num = 0;
foreach ( $post_taxonomies as $post_taxonomy ):

    //オブジェクトタイプがタクソノミーを使用できるか調べる
    if ( !is_object_in_taxonomy( $post_type->name, $post_taxonomy->name ) ) {
        continue;
    }
?>
    <li><label><input type="checkbox" name="taxonomies[]" class="cf_taxonomy" checked="checked" value="<?php echo $post_taxonomy->name;?>" > <?php echo $post_taxonomy->labels->name;?></label></li>
<?php
$num ++;
endforeach;

if ( $num == 0 ):
?>
<li><?php $this->e( 'There are no registered custom taxonomies.', '登録されているカスタムタクソノミーはありません。' ) ?></li>
<?php endif; ?>
</ul>
</div>

<hr>

<div class="tool-box">
<h3><?php $this->e( 'Custom Fields', 'カスタムフィールド' ) ?>
<span class="all_checks">
[
<a href="javascript:void(0);" class="all_checked" data-target="#form_<?php echo esc_attr( $post_type->name ) ?> .cf_checkbox"><?php $this->e( 'Select all', '全選択' ) ?></a>
<a href="javascript:void(0);" class="all_checkout" data-target="#form_<?php echo esc_attr( $post_type->name ) ?> .cf_checkbox"><?php $this->e( 'Unselect all', '全解除' ) ?></a>
]
</span>
</h3>

<?php
//カスタムフィールドリストを取得
$cf_results = $this->get_custom_field_list( $post_type->name );
?>
<ul class="setting_list">
<?php if ( !empty( $cf_results ) ): ?>
<?php foreach ( $cf_results as $key => $value ) :?>
<li><label><input type="checkbox" name="cf_fields[]" class="cf_checkbox" checked="checked" value="<?php echo $value['meta_key']; ?>"> <?php echo $value['meta_key']; ?></label></li>
<?php endforeach;?>
<?php else: ?>
<li><?php $this->e( 'There are not registered custom fields.', '登録されているカスタムフィールドはありません。' ) ?></li>
</ul>
<?php endif; ?>
</div>

<hr>

<div class="tool-box">
<h3><?php $this->e( 'Others', 'その他' ) ?></h3>
<table class="setting_table">
<tbody>
<tr>
<th style="vertical-align:top;"><?php $this->e( 'Number of posts to download.', 'ダウンロードする記事件数' ) ?></th>
<td>

<input type="number" name="limit" class="limit" value="0" data-target=".offset-<?php echo $post_type->name ?>"> <?php $this->e( '*All downloaded if "0" selected.', '※0の場合はすべてダウンロード' ) ?>
<div class="offset offset-<?php echo $post_type->name ?>" style="display:none;">
<br><input type="number" name="offset" class="offset_input" value="0"> <?php $this->e( '*Number of posts to start', '※ダウンロードする記事の開始位置' ) ?>
</div>

</td>
</tr>
<tr>
<th><?php $this->e( 'Sorting by date.' ) ?></th>
<td class="vt">
<label style="margin-right:3em;"><input type="radio" name="order_by" value="DESC" checked="checked"> <?php $this->e( 'DESC' ) ?></label>
<label><input type="radio" name="order_by" value="ASC"> <?php $this->e( 'ASC' ) ?></label>
</td>
</tr>
<tr>
    <th><?php $this->e( 'Select period to display.', '公開日の期間指定' ) ?></th>
    <td id="post_date-datepicker-wrap">
    <label for="post_date-datepicker-from">From</label>
    <input type="text" name="post_date_from" class="post_date-datepicker" placeholder="yyyy-mm-dd" />
    <label for="post_date-datepicker-to">To</label>
    <input type="text" name="post_date_to" class="post_date-datepicker" placeholder="yyyy-mm-dd" />
    </td>
</tr>
<tr>
    <th><?php $this->e( 'Select date modified.', '変更日の期間指定' ) ?></th>
    <td id="post_modified-datepicker-wrap">
    <label for="post_modified-datepicker-from">From</label>
    <input type="text" name="post_modified_from" class="post_date-datepicker" placeholder="yyyy-mm-dd" />
    <label for="post_modified-datepicker-to">To</label>
    <input type="text" name="post_modified_to" class="post_date-datepicker" placeholder="yyyy-mm-dd" />
    </td>
</tr>
<tr class="vt">
    <th><span><?php $this->e( 'Character Code', '文字コード' ) ?></span></th>
    <td>
<ul class="setting_list">
<li><label><input type="radio" name="string_code" value="UTF-8" checked="checked"> UTF-8</label></li>
<li><label><input type="radio" name="string_code" value="SJIS"> Shift_JIS</label></li>
</ul>
    </td>
</tr>
</tbody>
</table>
</div>

<p class="submit"><input type="submit" class="button-primary" value="<?php $this->e( 'Export', 'エクスポート' ) ?> <?php echo $post_type->labels->name;?> CSV" <?php if ( !is_writable( $filename ) ) : ?>disabled<?php endif; ?> /></p>
</form>
</div>
<?php else: ?>
    <div class="plugin_content">
        <p><?php $this->e( 'Please use Add-Ons to download CSVs for custom post types.', 'カスタム投稿タイプのCSVをダウンロードするにはアドオンを使用してください。' ) ?></p> 
        <p><a href="<?php echo $this->setting_url('setting'); ?>"><?php $this->e( 'WP CSV Exporter Add-Ons' ) ?></a></p>
    </div>
<?php 
    endif;
endforeach;
?>
</div>
</div><!-- /.plugin-main-area -->

<!-- .plugin-side-area -->
<div class="plugin-side-area">
<div class="plugin-side">
<div class="inner">


</div>
</div>
</div>
<!-- /.plugin-side-area -->

</div>
