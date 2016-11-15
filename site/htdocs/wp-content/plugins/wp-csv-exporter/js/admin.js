jQuery(function($) {
    //1つ目以外を見えなくする
    $('.plugin_tab li:first-child').addClass('select');
    $('.plugin_content:not(:first-child)').addClass('hide');

    //クリックしたときのファンクションをまとめて指定
    $('.plugin_tab li').click(function() {

        //.index()を使いクリックされたタブが何番目かを調べ、
        //indexという変数に代入します。
        var index = $('.plugin_tab li').index(this);

        //コンテンツを一度すべて非表示にし、
        $('.plugin_contents .plugin_content').css('display','none');

        //クリックされたタブと同じ順番のコンテンツを表示します。
        $('.plugin_contents .plugin_content').eq(index).css('display','block');

        //一度タブについているクラスselectを消し、
        $('.plugin_tab li').removeClass('select');

        //クリックされたタブのみにクラスselectをつけます。
        $(this).addClass('select')
    });

    //カレンダー
    $( '.post_date-datepicker' ).datepicker({
        'dateFormat':'yy-m-d'
    });

});