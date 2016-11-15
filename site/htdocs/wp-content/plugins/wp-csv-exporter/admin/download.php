<?php
require_once '../../../../wp-load.php';
require_once './functions.php';
$errors = array();
if (
	isset( $_POST['type'] ) &&
	is_user_logged_in() &&
	isset( $_POST['_wpnonce'] ) &&
	wp_verify_nonce( $_POST['_wpnonce'], 'csv_exporter' )
) {
	check_admin_referer( 'csv_exporter' );

	global $wpdb;
	$post_type          = get_post_type_object( $_POST['type'] );
	$posts_values       = esc_htmls( $_POST['posts_values'] );
	$post_status        = esc_htmls( $_POST['post_status'] );
	$limit              = esc_html( $_POST['limit'] );
	$offset             = esc_html( $_POST['offset'] );
	$order_by           = esc_html( $_POST['order_by'] );
	$post_date_from     = esc_html( $_POST['post_date_from'] );
	$post_date_to       = esc_html( $_POST['post_date_to'] );
	$post_modified_from = esc_html( $_POST['post_modified_from'] );
	$post_modified_to   = esc_html( $_POST['post_modified_to'] );
	$string_code        = esc_html( $_POST['string_code'] );

	// SQL文作成
	$query = "";
	//プレースホルダーに代入する値
	$value_parameter = array();

	// wp_postsテーブルから指定したpost_typeの公開記事を取得
	$query_select = 'ID as %s, post_type, post_status';
	$value_parameter[] = $_POST['post_id'];
	if ( !empty($posts_values) ) {
		foreach ( $posts_values as $key => $value ) {
			$query_select .= ', '.$value;
		}
	}
	$query .= "SELECT ".$query_select." ";

	// FROM
	$query .= " FROM ".$wpdb->posts." ";

	//ステータスのSQL
	$query_where = '';
	foreach ( $post_status as $key => $status ) {
		$query_where .= "'%s'";
		$value_parameter[] =  $status;
		if ( $status != end( $post_status ) ) {
			$query_where .= ', ';
		}
	}
	$query .= "WHERE post_status IN (".$query_where.") ";

	//AND
	$query .= "AND post_type LIKE '%s' ";
	$value_parameter[] =  $post_type->name;

	//期間指定-公開日
	if ( !empty( $post_date_from ) && !empty( $post_date_to ) ) {
		$query .= "AND post_date BETWEEN '%s' AND '%s' ";
		$value_parameter[] = $post_date_from;
		$value_parameter[] = $post_date_to;
	}
	//期間指定-更新日
	if ( !empty( $post_modified_from ) && !empty( $post_modified_to ) ) {
		$query .= "AND post_modified BETWEEN '%s' AND '%s' ";
		$value_parameter[] = $post_modified_from;
		$value_parameter[] = $post_modified_to;
	}
	//ソート順
	if ( $order_by == 'DESC' ) {
		$query .= "ORDER BY post_date DESC, post_modified DESC ";
	}elseif ( $order_by == 'ASC' ) {
		$query .= "ORDER BY post_date ASC, post_modified ASC ";
	}
	//記事数が指定されている時
	if ( !empty( $limit ) ) {
		$query .= "LIMIT %d ";
		$value_parameter[] = $limit;
	}

	//開始位置
	if ( !empty( $limit ) && !empty( $offset ) ) {
		$query .= "OFFSET %d ";
		$value_parameter[] = $offset;
	}

	//DBから取得
	$prepare = $wpdb->prepare( $query, $value_parameter );
	$results = $wpdb->get_results( $prepare, ARRAY_A );

	// カテゴリとタグのslugを追加
	$results = array_map( function ( $result ) {
			//マージ用の配列
			$customs_array = array();

			/**
			 * フィルター追加
			 */
			// TODO: フィルター追加処理をまとめる
			// foreach ($posts_values as $key => $value) {
			//  $_result = apply_filters( 'wp_csv_exporter_'.$value, $result[$value], $result['post_id'] );
			//  $customs_array += array( $value => $_result );
			// }

			//スラッグ
			if ( isset( $result['post_name'] ) ) {
				$post_name = apply_filters( 'wp_csv_exporter_post_name', $result['post_name'], $result['post_id'] );
				$customs_array += array( 'post_name' => $post_name );
			}
			//タイトル
			if ( isset( $result['post_title'] ) ) {
				$post_title = apply_filters( 'wp_csv_exporter_post_title', $result['post_title'], $result['post_id'] );
				$customs_array += array( 'post_title' => $post_title );
			}
			//本文
			if ( isset( $result['post_content'] ) ) {
				$post_content = apply_filters( 'wp_csv_exporter_post_content', $result['post_content'], $result['post_id'] );
				$customs_array += array( 'post_content' => $post_content );
			}
			//抜粋
			if ( isset( $result['post_excerpt'] ) ) {
				$post_excerpt = apply_filters( 'wp_csv_exporter_post_excerpt', $result['post_excerpt'], $result['post_id'] );
				$customs_array += array( 'post_excerpt' => $post_excerpt );
			}
			//ステータス
			if ( isset( $result['post_status'] ) ) {
				$post_status = apply_filters( 'wp_csv_exporter_post_status', $result['post_status'], $result['post_id'] );
				$customs_array += array( 'post_status' => $post_status );
			}
			//公開日時
			if ( isset( $result['post_date'] ) ) {
				$post_date = apply_filters( 'wp_csv_exporter_post_date', $result['post_date'], $result['post_id'] );
				$customs_array += array( 'post_date' => $post_date );
			}
			//変更日時
			if ( isset( $result['post_modified'] ) ) {
				$post_modified = apply_filters( 'wp_csv_exporter_post_modified', $result['post_modified'], $result['post_id'] );
				$customs_array += array( 'post_modified' => $post_modified );
			}
			//投稿者
			if ( isset( $result['post_author'] ) ) {
				$post_author = apply_filters( 'wp_csv_exporter_post_author', $result['post_author'], $result['post_id'] );
				$customs_array += array( 'post_author' => $post_author );
			}
			//サムネイル
			if ( !empty( $_POST['post_thumbnail'] ) ) {
				$thumbnail_id = get_post_thumbnail_id( $result['post_id'] );
				$thumbnail_url_array = wp_get_attachment_image_src( $thumbnail_id, true );
				$thumbnail_url = apply_filters( 'wp_csv_exporter_thumbnail_url', $thumbnail_url_array[0], $result['post_id'] );
				$customs_array += array( $_POST['post_thumbnail'] => $thumbnail_url );
			}

			//タグ
			if ( !empty( $_POST['post_tags'] ) ) {
				$tags = get_the_tags( $result['post_id'], esc_html( $_POST['post_tags'] ) );
				if ( is_array( $tags ) ) {
					$post_tags = array_map(
						function ( $tag ) {
							return $tag->slug;
						},
						$tags
					);
					$post_tags = apply_filters( 'wp_csv_exporter_post_tags', $post_tags, $result['post_id'] );
					$post_tags = urldecode( implode( ',', $post_tags ) );
					$customs_array += array( $_POST['post_tags'] => $post_tags );
				}else{
					$customs_array += array( $_POST['post_tags'] => '' );
				}
			}

			//カスタムタクソノミー
			if ( !empty( $_POST['taxonomies'] ) ) {
				foreach ( $_POST['taxonomies'] as $key => $taxonomy ) {
					$terms = get_the_terms( $result['post_id'], esc_html( $taxonomy ) );

					if ( is_array( $terms ) ) {

						// Modify 'head name' for "Really Simple CSV Importer"
						if ( $taxonomy == 'category' ) {
							$head_name = 'post_category';
						}else {
							//カスタムタクソノミー時
							$head_name = 'tax_' . $taxonomy;
						}

						//$term_values
						$term_values = array_map(
							function ( $term ) {
								return $term->slug;
							},
							$terms
						);

						$term_values = apply_filters( 'wp_csv_exporter_'.$head_name , $term_values, $result['post_id'] );
						$term_values = urldecode( implode( ',', $term_values ) );
						$customs_array += array( $head_name => $term_values );

					}else{
						//タクソノミーが空の時
						if ( $taxonomy == 'category' ) {
							$head_name = 'post_category';
						}else {
							$head_name = 'tax_' . $taxonomy;
						}

						$term_values = null;
						$term_values = apply_filters( 'wp_csv_exporter_'.$head_name , $term_values, $result['post_id'] );
						$customs_array += array( $head_name => $term_values );
					}

				}
			}

			// カスタムフィールドを取得
			$fields = get_post_custom( $result['post_id'] );
			if ( !empty( $fields ) && !empty( $_POST['cf_fields'] ) ) {
				foreach ( $_POST['cf_fields'] as $key => $value ) {
					//チェックしたフィールドだけを取得
					$field = $fields[$value];
					//アンダーバーから始まるのは削除
					if ( !preg_match( '/^_.*/', $value ) ) {
						$field = apply_filters( 'wp_csv_exporter_'.$value , $field[0], $result['post_id'] );
						$customs_array += array( $value => $field );
					}
				}
			}

			return array_merge( $result, $customs_array );
		}
		, $results );

	//結果があれば
	if ( !empty( $results ) ) {
		// 項目名を取得
		$head[] = array_keys( $results[0] );

		// 先頭に項目名を追加
		$list = array_merge( $head, $results );

		// ファイルの保存場所を設定
		$filename = 'export-'.$post_type->name.'-'.date_i18n( "Y-m-d_H-i-s" ).'.csv';
		$filepath = WCE_PLUGIN_DIR . '/download/'.$filename;
		$fp = fopen( $filepath, 'w' );

		// 配列をカンマ区切りにしてファイルに書き込み
		foreach ( $list as $fields ) {
			//文字コード変換
			if ( function_exists( "mb_convert_variables" ) ) {
				mb_convert_variables( $string_code, 'UTF-8', $fields );
			}
			fputcsv( $fp, $fields );
		}
		fclose( $fp );

		//ダウンロードの指示
		header( 'Content-Type:application/octet-stream' );
		header( 'Content-Disposition:filename='.$filename );  //ダウンロードするファイル名
		header( 'Content-Length:' . filesize( $filepath ) );   //ファイルサイズを指定
		readfile( $filepath );  //ダウンロード
		unlink( $filepath );

	}else {
		//結果がない場合
		$errors[] = '"' . $post_type->name.'" post type has no posts.';
	}

}else{
	$errors[] = 'エラーが起きました。';
}

//エラー表示
if(!empty($errors)){
	foreach ($errors as $key => $value) {
		echo $value.PHP_EOL;
	}
	return;

}