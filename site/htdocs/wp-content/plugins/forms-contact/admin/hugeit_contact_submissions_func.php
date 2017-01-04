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

function hugeit_contact_show_submissions() {

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
		$_POST['page_number'] = sanitize_text_field( $_POST['page_number'] );
		if ( $_POST['asc_or_desc'] ) {
			$sort["sortid_by"] = sanitize_text_field( $_POST['order_by'] );
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
		$search_tag = sanitize_text_field( stripslashes( $_POST['search_events_by_title'] ) );
	} else {
		$search_tag = "";
	}

	if ( isset( $_GET["catid"] ) ) {
		$cat_id = sanitize_text_field( $_GET["catid"] );
	} else {
		if ( isset( $_POST['cat_search'] ) ) {
			$cat_id = sanitize_text_field( $_POST['cat_search'] );
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

	$cat_row_query = "SELECT id, name FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE hc_width=0";
	$cat_row       = $wpdb->get_results( $cat_row_query );

	// get the total number of records
	$query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_contacts" . $where;

	$total            = $wpdb->get_var( $query );
	$pageNav['total'] = $total;
	$pageNav['limit'] = $limit / 20 + 1;

	if($cat_id){
		$query =
			"SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM " . $wpdb->prefix . "huge_it_contact_contacts  AS a LEFT JOIN " . $wpdb->prefix . "huge_it_contact_contacts AS b ON a.id = b.hc_width LEFT JOIN (SELECT  " . $wpdb->prefix . "huge_it_contact_contacts.ordering as ordering," . $wpdb->prefix . "huge_it_contact_contacts.id AS id, COUNT( " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id ) AS prod_count
FROM " . $wpdb->prefix . "huge_it_contact_contacts_fields, " . $wpdb->prefix . "huge_it_contact_contacts
WHERE " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id = " . $wpdb->prefix . "huge_it_contact_contacts.id
GROUP BY " . $wpdb->prefix . "huge_it_contact_contacts_fields.hugeit_contact_id) AS c ON c.id = a.id LEFT JOIN
(SELECT " . $wpdb->prefix . "huge_it_contact_contacts.name AS par_name," . $wpdb->prefix . "huge_it_contact_contacts.id FROM " . $wpdb->prefix . "huge_it_contact_contacts) AS g
 ON a.hc_width=g.id WHERE  a.name LIKE '%" . $search_tag . "%' group by a.id " . $order . " LIMIT " . $limit . ",20";
	}
	else{
	 $query ="SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM ".$wpdb->prefix."huge_it_contact_contacts  AS a LEFT JOIN ".$wpdb->prefix."huge_it_contact_contacts AS b ON a.id = b.hc_width LEFT JOIN (SELECT  ".$wpdb->prefix."huge_it_contact_contacts.ordering as ordering,".$wpdb->prefix."huge_it_contact_contacts.id AS id, COUNT( ".$wpdb->prefix."huge_it_contact_contacts_fields.hugeit_contact_id ) AS prod_count
FROM ".$wpdb->prefix."huge_it_contact_contacts_fields, ".$wpdb->prefix."huge_it_contact_contacts
WHERE ".$wpdb->prefix."huge_it_contact_contacts_fields.hugeit_contact_id = ".$wpdb->prefix."huge_it_contact_contacts.id
GROUP BY ".$wpdb->prefix."huge_it_contact_contacts_fields.hugeit_contact_id) AS c ON c.id = a.id LEFT JOIN
(SELECT ".$wpdb->prefix."huge_it_contact_contacts.name AS par_name,".$wpdb->prefix."huge_it_contact_contacts.id FROM ".$wpdb->prefix."huge_it_contact_contacts) AS g
 ON a.hc_width=g.id WHERE a.name LIKE '%".$search_tag."%'  group by a.id ". $order ." LIMIT ".$limit.",20";
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
	$rows = hugeit_contact_open_cat_in_tree( $rows );
	$query = "SELECT ".$wpdb->prefix."huge_it_contact_contacts.ordering,".$wpdb->prefix."huge_it_contact_contacts.id, COUNT( ".$wpdb->prefix."huge_it_contact_submission.contact_id ) AS prod_count 
FROM ".$wpdb->prefix."huge_it_contact_submission, ".$wpdb->prefix."huge_it_contact_contacts 
WHERE ".$wpdb->prefix."huge_it_contact_submission.contact_id = ".$wpdb->prefix."huge_it_contact_contacts.id 
GROUP BY ".$wpdb->prefix."huge_it_contact_submission.contact_id";
	$prod_rows = $wpdb->get_results($query);

	foreach ( $rows as $row ) {
		foreach ( $prod_rows as $row_1 ) {
			if ( $row->id == $row_1->id ) {
				$row->ordering   = $row_1->ordering;
				$row->prod_count = $row_1->prod_count;
			}
		}

	}


	$query       = "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_styles order by id ASC";
	$form_styles = $wpdb->get_results( $query );


	$cat_row = hugeit_contact_open_cat_in_tree( $cat_row );
	hugeit_contact_html_showhugeit_contacts( $rows, $pageNav, $sort, $cat_row, $form_styles );
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
		$new_cat_query = "SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM " . $wpdb->prefix . "huge_it_contact_contacts  AS a LEFT JOIN " . $wpdb->prefix . "huge_it_contact_contacts AS b ON a.id = b.hc_width LEFT JOIN (SELECT  " . $wpdb->prefix . "huge_it_contact_contacts.ordering AS ordering," . $wpdb->prefix . "huge_it_contact_contacts.id AS id, COUNT( " . $wpdb->prefix . "huge_it_contact_submission.contact_id ) AS prod_count
	FROM " . $wpdb->prefix . "huge_it_contact_submission, " . $wpdb->prefix . "huge_it_contact_contacts
	WHERE " . $wpdb->prefix . "huge_it_contact_submission.contact_id = " . $wpdb->prefix . "huge_it_contact_contacts.id
	GROUP BY " . $wpdb->prefix . "huge_it_contact_submission.contact_id) AS c ON c.id = a.id LEFT JOIN
	(SELECT " . $wpdb->prefix . "huge_it_contact_contacts.name AS par_name," . $wpdb->prefix . "huge_it_contact_contacts.id FROM " . $wpdb->prefix . "huge_it_contact_contacts) AS g
	 ON a.hc_width=g.id WHERE a.name LIKE '%" . $search_tag . "%' AND a.hc_width=" . $local_cat->id . " GROUP BY a.id  " . $glob_ordering_in_cat;
		$new_cat       = $wpdb->get_results( $new_cat_query );
		hugeit_contact_open_cat_in_tree( $new_cat, $tree_problem . "— ", 0 );
	}

	return $trr_cat;

}


function hugeit_contact_remove_submissions($id,$subId = 0){
	global $wpdb;
	if ( $subId == 0 ) {
		$sql_remov_tag = $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE contact_id=%d", $id );
	} else {
		$sql_remov_tag = $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE id=%d", $id );
	}
	if ( ! $wpdb->query( $sql_remov_tag ) ) : ?>
		<div id="message" class="error"><p>Submission Not Deleted</p></div>
	<?php else : ?>
		<div class="updated"><p><strong><?php _e( 'Submission Deleted.' ); ?></strong></p></div>
	<?php endif;
}


function hugeit_contact_view_submissions( $id ) {
	global $wpdb;

	$id = absint($id);

	if ( isset( $_POST["search_events_by_title"] ) && trim( $_POST["search_events_by_title"] ) != "" ) {
		$query = "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_submission ORDER BY id DESC";
	} else {
		$queryAll  = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE contact_id = %d  ORDER BY id ASC", $id );
		$count2    = $wpdb->get_results( $queryAll );
		$subCount  = count( $count2 );
		$limitPage = hugeit_contact_sub_pagination( $subCount );
		$query     = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE contact_id = %d  ORDER BY id DESC LIMIT " . $limitPage['start_pos'] . "," . $limitPage['perpage'] . "", $id );
	}
	$submitionsArray = $wpdb->get_results( $query );
	$submitionsCount = $wpdb->get_results( "SELECT count(customer_read_or_not) AS all_count FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE contact_id=" . $id . "" );
	$subName         = $wpdb->get_results( "SELECT name FROM " . $wpdb->prefix . "huge_it_contact_contacts WHERE id = " . $id . "" );
	//$submitionsArray=array_reverse($submitionsArray);
	hugeit_contact_html_view_submissions( $submitionsArray, $submitionsCount, $limitPage, $subName, $id );
}


function hugeit_contact_show_submissions_2( $id, $submissionsId ) {
	global $wpdb;
	if ( is_numeric( $id ) && is_numeric( $submissionsId ) ) {
		$id = absint($id);
		if ( isset( $_GET['read'] ) && $_GET['read'] == 'unread' ) {
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_submission SET customer_read_or_not = '%d'  WHERE id = '%d' ", 1, $id ) );
		}
		$query           = "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE id = '" . $id . "'  ORDER BY id ASC";
		$messageInArray  = $wpdb->get_results( $query );
		$submitionsCount = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE contact_id = " . $submissionsId . " ORDER BY id ASC" );
		$submitionsCount = array_reverse( $submitionsCount );
		hugeit_contact_html_show_messages( $messageInArray, $submitionsCount );
	}
}
