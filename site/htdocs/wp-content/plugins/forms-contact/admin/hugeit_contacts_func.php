<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( function_exists( 'current_user_can' ) ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		die( 'Access Denied' );
	}
}
if ( ! function_exists( 'current_user_can' ) ) {
	die( 'Access Denied' );
}

function hugeit_contact_show_contact() {

	global $wpdb;

	if ( isset( $_POST['search_events_by_title'] ) ) {
		$_POST['search_events_by_title'] = esc_html( stripslashes( $_POST['search_events_by_title'] ) );
	}
	if ( isset( $_POST['asc_or_desc'] ) ) {
		$_POST['asc_or_desc'] = sanitize_text_field( $_POST['asc_or_desc'] );
	}
	if ( isset( $_POST['order_by'] ) ) {
		$_POST['order_by'] = sanitize_text_field( $_POST['order_by'] );
	}
	$where                 = '';
	$sort["custom_style"]  = "manage-column column-autor sortable desc";
	$sort["default_style"] = "manage-column column-autor sortable desc";
	$sort["sortid_by"]     = 'id';
	$sort["1_or_2"]        = 1;
	$order                 = '';

	if ( isset( $_POST['page_number'] ) ) {

		if ( $_POST['asc_or_desc'] ) {
			$sort["sortid_by"] = sanitize_text_field($_POST['order_by']);
			if ( $_POST['asc_or_desc'] == 1 ) {
				$sort["custom_style"] = "manage-column column-title sorted asc";
				$sort["1_or_2"]       = "2";
				$order                = "ORDER BY " . $sort["sortid_by"] . " ASC";
			} else {
				$sort["custom_style"] = "manage-column column-title sorted desc";
				$sort["1_or_2"]       = "1";
				$order                = "ORDER BY " . $sort["sortid_by"] . " DESC";
			}
		}
		if ( $_POST['page_number'] ) {
			$limit = ( (float)$_POST['page_number'] - 1 ) * 20;
		} else {
			$limit = 0;
		}
	} else {
		$limit = 0;
	}
	if ( isset( $_POST['search_events_by_title'] ) ) {
		$search_tag = esc_html( stripslashes( $_POST['search_events_by_title'] ) );
	} else {
		$search_tag = "";
	}

	if ( isset( $_GET["catid"] ) ) {
		$cat_id = esc_html( $_GET["catid"] );
	} else {
		if ( isset( $_POST['cat_search'] ) ) {
			$cat_id = esc_html( $_POST['cat_search'] );
		} else {
			$cat_id = 0;
		}
	}

	if ( $search_tag ) {
		$where = " WHERE name LIKE '%" . $search_tag . "%' ";
	}
	if ( $where ) {
		if ( $cat_id ) {
			$where .= " AND hc_width=" . $cat_id;
		}

	} else {
		if ( $cat_id ) {
			$where .= " WHERE hc_width=" . $cat_id;
		}

	}

	$cat_row_query = "SELECT id,name FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE hc_width=0";
	$cat_row       = $wpdb->get_results( $cat_row_query );

	// get the total number of records
	$query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_contacts" . $where;

	$total            = $wpdb->get_var( $query );
	$pageNav['total'] = $total;
	$pageNav['limit'] = $limit / 20 + 1;

	if ( $cat_id ) {
		$query = "SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM " . $wpdb->prefix . "huge_it_contact_contacts  AS a LEFT JOIN " . $wpdb->prefix . "huge_it_contact_contacts AS b ON a.id = b.hc_width LEFT JOIN (SELECT  " . $wpdb->prefix . "huge_it_contact_contacts.ordering AS ordering," . $wpdb->prefix . "huge_it_contact_contacts.id AS id, COUNT( " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id ) AS prod_count
FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields, " . $wpdb->prefix . "huge_it_contact_contacts
WHERE " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id = " . $wpdb->prefix . "huge_it_contact_contacts.id
GROUP BY " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id) AS c ON c.id = a.id LEFT JOIN
(SELECT " . $wpdb->prefix . "huge_it_contact_contacts.name AS par_name," . $wpdb->prefix . "huge_it_contact_contacts.id FROM " . $wpdb->prefix . "huge_it_contact_contacts) AS g
 ON a.hc_width=g.id WHERE  a.name LIKE '%" . $search_tag . "%' GROUP BY a.id " . $order . " " . " LIMIT " . $limit . ",20";
	} else {
		$query = "SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM " . $wpdb->prefix . "huge_it_contact_contacts  AS a LEFT JOIN " . $wpdb->prefix . "huge_it_contact_contacts AS b ON a.id = b.hc_width LEFT JOIN (SELECT  " . $wpdb->prefix . "huge_it_contact_contacts.ordering AS ordering," . $wpdb->prefix . "huge_it_contact_contacts.id AS id, COUNT( " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id ) AS prod_count
FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields, " . $wpdb->prefix . "huge_it_contact_contacts
WHERE " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id = " . $wpdb->prefix . "huge_it_contact_contacts.id
GROUP BY " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id) AS c ON c.id = a.id LEFT JOIN
(SELECT " . $wpdb->prefix . "huge_it_contact_contacts.name AS par_name," . $wpdb->prefix . "huge_it_contact_contacts.id FROM " . $wpdb->prefix . "huge_it_contact_contacts) AS g
 ON a.hc_width=g.id WHERE a.name LIKE '%" . $search_tag . "%'  GROUP BY a.id " . $order . " " . " LIMIT " . $limit . ",20";
	}

	$rows = $wpdb->get_results( $query );
	global $glob_ordering_in_cat;
	if ( isset( $sort["sortid_by"] ) ) {
		if ( $sort["sortid_by"] == 'ordering' ) {
			if ( $_POST['asc_or_desc'] == 1 ) {
				$glob_ordering_in_cat = " ORDER BY ordering ASC";
			} else {
				$glob_ordering_in_cat = " ORDER BY ordering DESC";
			}
		}
	}
	$rows      = hugeit_contact_open_cat_in_tree( $rows );
	$query     = "SELECT  " . $wpdb->prefix . "huge_it_contact_contacts.ordering," . $wpdb->prefix . "huge_it_contact_contacts.id, COUNT( " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id ) AS prod_count
FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields, " . $wpdb->prefix . "huge_it_contact_contacts
WHERE " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id = " . $wpdb->prefix . "huge_it_contact_contacts.id
GROUP BY " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id ";
	$prod_rows = $wpdb->get_results( $query );

	foreach ( $rows as $row ) {
		foreach ( $prod_rows as $row_1 ) {
			if ( $row->id == $row_1->id ) {
				$row->ordering   = $row_1->ordering;
				$row->prod_count = $row_1->prod_count;
			}
		}

	}


	$query       = "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_styles ORDER BY id ASC";
	$form_styles = $wpdb->get_results( $query );


	$cat_row    = hugeit_contact_open_cat_in_tree( $cat_row );
	$postsbycat = '';
	html_showhugeit_contacts( $rows, $pageNav, $sort, $cat_row, $postsbycat, $form_styles );
}

function hugeit_contact_open_cat_in_tree( $catt, $tree_problem = '', $hihiih = 1 ) {

	global $wpdb;
	global $glob_ordering_in_cat;
	static $trr_cat = array();
	if ( ! isset( $search_tag ) ) {
		$search_tag = '';
	}
	if ( $hihiih ) {
		$trr_cat = array();
	}
	foreach ( $catt as $local_cat ) {
		$local_cat->name = $tree_problem . $local_cat->name;
		array_push( $trr_cat, $local_cat );
		$new_cat_query = "SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM " . $wpdb->prefix . "huge_it_contact_contacts  AS a LEFT JOIN " . $wpdb->prefix . "huge_it_contact_contacts AS b ON a.id = b.hc_width LEFT JOIN (SELECT  " . $wpdb->prefix . "huge_it_contact_contacts.ordering AS ordering," . $wpdb->prefix . "huge_it_contact_contacts.id AS id, COUNT( " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id ) AS prod_count
FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields, " . $wpdb->prefix . "huge_it_contact_contacts
WHERE " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id = " . $wpdb->prefix . "huge_it_contact_contacts.id
GROUP BY " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id) AS c ON c.id = a.id LEFT JOIN
(SELECT " . $wpdb->prefix . "huge_it_contact_contacts.name AS par_name," . $wpdb->prefix . "huge_it_contact_contacts.id FROM " . $wpdb->prefix . "huge_it_contact_contacts) AS g
 ON a.hc_width=g.id WHERE a.name LIKE '%" . $search_tag . "%' AND a.hc_width=" . $local_cat->id . " GROUP BY a.id  " . $glob_ordering_in_cat;
		$new_cat       = $wpdb->get_results( $new_cat_query );
		hugeit_contact_open_cat_in_tree( $new_cat, $tree_problem . "— ", 0 );
	}

	return $trr_cat;

}

function hugeit_contact_edit_hugeit_contact( $id ) {

	global $wpdb;

	if ( isset( $_GET["removeslide"] ) && $_GET["removeslide"] != '' ) {
		$remove_slide = sanitize_text_field( $_GET["removeslide"] );

		$query = $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields  WHERE id = %d", $remove_slide );
		$wpdb->query( $query );

	}

	if ( isset( $_GET["dublicate"] ) ) {
		if ( absint($_GET["dublicate"]) > 0 ) {
			$_GET["dublicate"] = absint($_GET["dublicate"]);
			$query    = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE id=%d", $_GET["dublicate"] );
			$rowduble = $wpdb->get_row( $query );

			$query        = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id=%d", $id );
			$row          = $wpdb->get_row( $query );
			$query        = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id = %d ORDER BY id ASC", $row->id );
			$rowplusorder = $wpdb->get_results( $query );

			foreach ( $rowplusorder as $key => $rowplusorders ) {
				if ( $rowplusorders->ordering > $rowduble->ordering ) {
					$rowplusorderspl = $rowplusorders->ordering + 1;
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET ordering = %d WHERE id = %d ", $rowplusorderspl, $rowplusorders->id ) );
				}
			}

			$inserttexttype = $wpdb->prefix . "huge_it_contact_contacts_fields";
			$rowdubleorder  = $rowduble->ordering + 1;
			$wpdb->insert( $inserttexttype, array(
					'name'                  => $rowduble->name,
					'hugeit_contact_id'     => $rowduble->hugeit_contact_id,
					'description'           => $rowduble->description,
					'conttype'              => $rowduble->conttype,
					'hc_field_label'        => $rowduble->hc_field_label,
					'hc_other_field'        => $rowduble->hc_other_field,
					'field_type'            => $rowduble->field_type,
					'hc_required'           => $rowduble->hc_required,
					'ordering'              => $rowdubleorder,
					'published'             => $rowduble->published,
					'hc_input_show_default' => $rowduble->hc_input_show_default,
					'hc_left_right'         => $rowduble->hc_left_right,
				), array( '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', ) );

			$apply_safe_link = wp_nonce_url(
				'admin.php?page=hugeit_forms_main_page&id=' . $id . '&task=apply',
				'apply_form_' . $id,
				'hugeit_contact_apply_form_nonce'
			);
			$apply_safe_link = htmlspecialchars_decode($apply_safe_link);
			header( 'Location: ' . $apply_safe_link );
		}

	}

	if ( isset( $_GET["inputtype"] ) ) {
		$_GET["inputtype"] = sanitize_text_field( $_GET["inputtype"] );
		$query             = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id=%d", $id );
		$row               = $wpdb->get_row( $query );
		$inputtype         = esc_html( $_GET["inputtype"] );
		$query             = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id= %d", $id );
		$row               = $wpdb->get_row( $query );
		$query             = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id = %d ORDER BY id ASC", $row->id );
		$rowplusorder      = $wpdb->get_results( $query );

		foreach ( $rowplusorder as $key => $rowplusorders ) {
			$rowplusorderspl = $rowplusorders->ordering + 1;
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET ordering = %d WHERE id = %d ", $rowplusorderspl, $rowplusorders->id ) );
		}

		switch ( $inputtype ) {
			case 'custom_text':
				$inserttexttype = $wpdb->prefix . "huge_it_contact_contacts_fields";
				$wpdb->insert( $inserttexttype, array(
						'name'                  => 'Placeholder',
						'hugeit_contact_id'     => $row->id,
						'description'           => 'on',
						'conttype'              => $_GET["inputtype"],
						'hc_field_label'        => 'Label',
						'hc_other_field'        => '80',
						'field_type'            => 'on',
						'hc_required'           => 'on',
						'ordering'              => 0,
						'published'             => 2,
						'hc_input_show_default' => '1',
						'hc_left_right'         => 'left',
					), array( '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%d', '%s', '%s' ) );
				break;
		}
	}

	$query = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id=%d", $id );
	$row   = $wpdb->get_row( $query );

	if ( ! isset( $row->hc_yourstyle ) ) {
		return 'id not found';
	}
	$images    = explode( ";;;", $row->hc_yourstyle );
	$par       = explode( '	', $row->param );
	$count_ord = count( $images );
	$cat_row   = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id!=" . $id . " AND hc_width=0" );
	$cat_row   = hugeit_contact_open_cat_in_tree( $cat_row );
	$query     = "SELECT name,ordering FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE hc_width=" . $row->hc_width . "  ORDER BY `ordering` ";
	$ord_elem  = $wpdb->get_results( $query );

	$query = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id = %d ORDER BY ordering DESC", $row->id );
	$rowim = $wpdb->get_results( $query );

	if ( isset( $_GET["addslide"] ) && $_GET["addslide"] == 1 ) {

		$table_name = $wpdb->prefix . "huge_it_contact_contacts_fields";

		$wpdb->insert( $table_name, array(
				'name'                  => '',
				'hugeit_contact_id'     => $row->id,
				'description'           => '',
				'hc_field_label'        => '',
				'hc_other_field'        => '',
				'ordering'              => 'par_TV',
				'published'             => 2,
				'hc_input_show_default' => '1',
			), array( '%s', '%d', '%s', '%s', '%s', '%s', '%d', '%s', ) );
	}


	$tablename = $wpdb->prefix . "huge_it_contact_contacts";
	$query     = $wpdb->prepare( "SELECT * FROM %s ORDER BY id ASC", $tablename );
	$query     = str_replace( "'", "", $query );
	$rowsld    = $wpdb->get_results( $query );

	$query     = "SELECT *  FROM " . $wpdb->prefix . "huge_it_contact_general_options ";
	$rowspar   = $wpdb->get_results( $query );
	$paramssld = array();
	foreach ( $rowspar as $rowpar ) {
		$key               = $rowpar->name;
		$value             = $rowpar->value;
		$paramssld[ $key ] = $value;
	}
	$tablename = $wpdb->prefix . "posts";
	$query     = $wpdb->prepare( 'SELECT * FROM %s WHERE post_type = "post" AND post_status = "publish" ORDER BY id ASC', $tablename );
	$query     = str_replace( "'", "", $query );
	$rowsposts = $wpdb->get_results( $query );
	if ( ! isset( $_POST["iframecatid"] ) ) {
		$_POST["iframecatid"] = '';
	}
	$query      = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "term_relationships WHERE term_taxonomy_id = %d ORDER BY object_id ASC", absint($_POST["iframecatid"]) );
	$rowsposts8 = $wpdb->get_results( $query );


	foreach ( $rowsposts8 as $rowsposts13 ) {
		$query      = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "posts WHERE post_type = 'post' AND post_status = 'publish' AND ID = '" . $rowsposts13->object_id . "'  ORDER BY ID ASC", $id );
		$rowsposts1 = $wpdb->get_results( $query );
		$postsbycat = $rowsposts1;

	}

	$query        = "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_styles ORDER BY id ASC";
	$form_styles  = $wpdb->get_results( $query );
	$themeId      = $row->hc_yourstyle;
	$query        = "SELECT *  FROM " . $wpdb->prefix . "huge_it_contact_style_fields WHERE options_name = '" . $row->hc_yourstyle . "' ";
	$rows         = $wpdb->get_results( $query );
	$style_values = array();
	foreach ( $rows as $row ) {
		$key                  = $row->name;
		$value                = $row->value;
		$style_values[ $key ] = $value;
	}

	$query = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id=%d", $id );
	$row   = $wpdb->get_row( $query );
	if ( ! isset( $postsbycat ) ) {
		$postsbycat = '';
	}
	hugeit_contact_html_edithugeit_contact( $id, $ord_elem, $count_ord, $images, $row, $cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat, $form_styles, $style_values, $themeId );
}

function hugeit_contact_add_hugeit_contact() {
	global $wpdb;

//	$query    = "SELECT name,ordering FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE hc_width=0 ORDER BY `ordering`";
//	$ord_elem = $wpdb->get_results( $query ); ///////ordering elements list
//	$cat_row  = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE hc_width=0" );
//	$cat_row  = hugeit_contact_open_cat_in_tree( $cat_row );

	$table_name = $wpdb->prefix . "huge_it_contact_contacts";
	$wpdb->insert(
		$table_name,
		array(
			'name'         => 'My New Form',
			'hc_acceptms'  => '500',
			'hc_width'     => '300',
			'hc_userms'    => 'true',
			'hc_yourstyle' => '1',
			'description'  => '2900',
			'param'        => '1000',
			'ordering'     => '1',
			'published'    => '300',
		)
	);

	$apply_safe_link = wp_nonce_url(
		'admin.php?page=hugeit_forms_main_page&id=' . $wpdb->insert_id . '&task=apply',
		'apply_form_' . $wpdb->insert_id,
		'hugeit_contact_apply_form_nonce'
	);
	$apply_safe_link = htmlspecialchars_decode($apply_safe_link);
	header( 'Location: ' . $apply_safe_link );

	ob_flush();

}

function hugeit_contact_remove_contact( $id ) {

	global $wpdb;

	$id = absint($id);

	$r = $wpdb->delete( $wpdb->prefix . "huge_it_contact_contacts", array( 'id' => $id ), array( '%d' ) );

	if ( $r ) {
		?>
		<div class="updated"><p><strong><?php _e( 'Item Deleted.' ); ?></strong></p></div>
		<?php
	}
	$row  = $wpdb->get_results( $wpdb->prepare( 'UPDATE ' . $wpdb->prefix . 'huge_it_contact_contacts SET hc_width="0"   WHERE hc_width=%d', $id ) );
	$rows = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'huge_it_contact_contacts  ORDER BY `ordering` ASC ' );

	$count_of_rows   = count( $rows );
	$ordering_values = array();
	$ordering_ids    = array();
	for ( $i = 0; $i < $count_of_rows; $i ++ ) {

		$ordering_ids[ $i ] = $rows[ $i ]->id;
		if ( isset( $_POST["ordering"] ) ) {
			$ordering_values[ $i ] = $i + 1 + absint($_POST["ordering"]);
		} else {
			$ordering_values[ $i ] = $i + 1;
		}
	}

	for ( $i = 0; $i < $count_of_rows; $i ++ ) {
		$wpdb->update( $wpdb->prefix . 'huge_it_contact_contacts', array( 'ordering' => $ordering_values[ $i ] ), array( 'id' => $ordering_ids[ $i ] ), array( '%s' ), array( '%s' ) );
	}

}

function hugeit_contact_captcha_keys( $id ) {
	global $wpdb;
	$idsave       = absint( $_GET["id"] );
	$query        = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id=%d", $idsave );
	$rowall       = $wpdb->get_results( $query );
	$leftRightPos = 'left';
	foreach ( $rowall as $value ) {
		if ( $value->hc_left_right == 'right' ) {
			$leftRightPos = 'right';
		}
	}
	$queryMax  = $wpdb->prepare( "SELECT MAX(ordering) AS res FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id=%d AND hc_left_right=%s", $idsave, $leftRightPos );
	$row8      = $wpdb->get_results( $queryMax );
	$finRes    = $row8[0]->res;
	$queryType = $wpdb->prepare( "SELECT conttype FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id=%d AND ordering=%d AND hc_left_right=%s", $idsave, $finRes, $leftRightPos );
	$rowType   = $wpdb->get_results( $queryType );
	$toCheck   = $rowType[0]->conttype;
	$resOfMax  = $row8[0]->res;
	$resOfMax  = (int) $resOfMax;
	if ( $toCheck != 'buttons' ) {
		$resOfMax = $resOfMax + 1;
	} else {
		$resOfMax3 = (int) $resOfMax + 1;
		$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET ordering = %d WHERE hugeit_contact_id = %d AND ordering=%d", $resOfMax3, $idsave, $resOfMax ) );
	}
	/////////////////////////
	$query        = "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_general_options ";
	$rows         = $wpdb->get_results( $query );
	$param_values = array();
	foreach ( $rows as $row ) {
		$key                  = $row->name;
		$value                = $row->value;
		$param_values[ $key ] = $value;
	}

	if ( isset( $_POST['params'] ) ) {
		$params = $_POST['params'];
		foreach ( $params as $key => $value ) {
			$wpdb->update( $wpdb->prefix . 'huge_it_contact_general_options', array( 'value' => $value ), array( 'name' => $key ), array( '%s' ) );
		}

		$inserttexttype = $wpdb->prefix . "huge_it_contact_contacts_fields";
		$wpdb->insert(
			$inserttexttype,
			array(
				'name' => 'image',
				'hugeit_contact_id' => $idsave,
				'description' => '',
				'conttype' => 'captcha',
				'hc_field_label' => '',
				'hc_other_field' => '',
				'field_type' => '',
				'hc_required' => 'light',
				'ordering' => $resOfMax,
				'published' => 2,
				'hc_input_show_default' => '1',
				'hc_left_right' => $leftRightPos,
			),
			array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s')
		);
	}
	html_captcha_keys( $param_values );
}

function hugeit_contact_apply_cat( $id ) {
	global $wpdb;

	$id = absint($id);

	if ( isset( $_POST["name"] ) ) {
		if ( $_POST["name"] != '' ) {
			$_POST["name"] = sanitize_text_field($_POST["name"]);
			$_POST["select_form_theme"] = sanitize_text_field($_POST["select_form_theme"]);
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts SET  name = %s  WHERE id = %d ", $_POST["name"], $id ) );
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts SET  hc_yourstyle = %s  WHERE id = %d ", $_POST["select_form_theme"], $id ) );
		}
	}


	$query = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id=%d", $id );
	$row   = $wpdb->get_row( $query );

	$query = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields WHERE hugeit_contact_id = %d ORDER BY id ASC", $row->id );
	$rowim = $wpdb->get_results( $query );

	foreach ( $rowim as $key => $rowimages ) {
		$id = absint($rowimages->id);
		if ( isset( $_POST ) && isset( $_POST[ "hc_left_right" . $id . "" ] ) ) {
			if ( $_POST[ "hc_left_right" . $id . "" ] ) {
				if ( isset( $_POST[ "field_type" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  field_type = %s WHERE id = %d", sanitize_text_field($_POST[ "field_type" . $id ]), $id ) );
				}
				if ( isset( $_POST[ "hc_other_field" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  hc_other_field = %s WHERE id = %d", sanitize_text_field($_POST[ "hc_other_field" . $id ]), $id ) );
				}
				if ( isset( $_POST[ "titleimage" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  name = %s  WHERE id = %d", stripslashes( sanitize_text_field($_POST[ "titleimage" . $id ]) ), $id ) );
				}
				if ( isset( $_POST[ "im_description" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  description = %s  WHERE id = %d", sanitize_text_field($_POST[ "im_description" . $id ]), $id ) );
				}
				if ( isset( $_POST[ "hc_required" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  hc_required = %s WHERE id = %d", sanitize_text_field($_POST[ "hc_required" . $id ]), $id ) );
				}
				if ( isset( $_POST[ "imagess" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  hc_field_label = %s  WHERE id = %d", stripslashes( sanitize_text_field($_POST[ "imagess" . $id ]) ), $id ) );
				}
				if ( isset( $_POST[ "hc_left_right" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  hc_left_right = %s  WHERE id = %d", sanitize_text_field($_POST[ "hc_left_right" . $id ]), $id ) );
				}
				if ( isset( $_POST[ "hc_ordering" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  ordering = %s  WHERE id = %d", sanitize_text_field($_POST[ "hc_ordering" . $id ]), $id ) );
				}
				if ( isset( $_POST[ "hc_input_show_default" . $id . "" ] ) ) {
					$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_contacts_fields SET  hc_input_show_default = %s  WHERE id = %d", sanitize_text_field($_POST[ "hc_input_show_default" . $id ]), $id ) );
				}
			}
		}
	}

	if ( isset( $_POST["imagess"] ) && trim($_POST["imagess"]) != '' ) {

		$table_name = $wpdb->prefix . "huge_it_contact_contacts_fields";
		$_POST['imagess'] = sanitize_text_field($_POST['imagess']);

		$wpdb->insert(
			$table_name,
			array(
				'name' => '',
				'hugeit_contact_id' => $row->id,
				'description' => '',
				'hc_field_label' => $_POST["imagess"],
				'hc_other_field' => '',
				'ordering' => 'par_TV',
				'published' => 2,
				'hc_input_show_default' => '1',
			),
			array('%s', '%d', '%s', '%s', '%s', '%s', '%d', '%s')
		);
	}

	if ( ! isset( $_POST["posthuge-it-description-length"] ) ) {
		$_POST["posthuge-it-description-length"] = '';
	}
	$_GET['id'] = absint( $_GET['id'] );
	$wpdb->update(
		$wpdb->prefix . "huge_it_contact_contacts",
		array('published' => sanitize_text_field($_POST["posthuge-it-description-length"])),
		array('id' => $_GET['id'])
	);

	return true;

}
