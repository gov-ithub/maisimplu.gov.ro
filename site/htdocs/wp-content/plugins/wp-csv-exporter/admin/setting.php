<div class="wrap plugin-wrap">

    <div class="plugin-main-area">
        <h2><?php $this->e('WP CSV Exporter', 'WP CSV Exporter') ?></h2>
        <p>
            <?php $this->e( 'WP CSV Exporter Add-Ons' ) ?>
        </p>

        <ul class="plugin_tab">
            <li class="plugin_tab"><a href="<?php echo $this->setting_url(''); ?>">CSV <?php $this->e('Export', 'エクスポート') ?></a></li>    
            <li class="select"><?php $this->e( 'Add-Ons' ) ?></li>
        </ul>

        <div class="plugin_contents">

            <div class="plugin_content">
                <form action="" method="post" id="form">
                    <?php wp_nonce_field( 'csv_exporter' );?>
                    <div class="tool-box">
                        <p>
                            <?php $this->e( 'Add-Ons will enable you to download CSVs for static pages and custom post types in addition to those for posts.', 'アドオンを購入すると「投稿」以外の「固定ページ」や「カスタム投稿タイプ」のCSVもダウンロードが出来るようになります。' ) ?>
                        </p>
                        <p>
                            <?php $this->e( 'Add-Ons can be purchased from the website below.', 'アドオンは、以下のWEBサイトから購入ができます。' ) ?>
                        </p>
                          <table class="setting_table">
                            <tbody>
                                <tr>
                                    <th>- <a href="https://gumroad.com/l/WCE-With-Post-Type" target="_blank">Gumroad</a></th>
                                    <td>$9.8</td>
                                </tr>
                                <tr>
                                    <th>- <a href="https://flipclap.stores.jp/#!/items/5480e8583cd482f22b001f7e" target="_blank">STORES.JP</a></th>
                                    <td>¥980</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.plugin-main-area -->

</div>