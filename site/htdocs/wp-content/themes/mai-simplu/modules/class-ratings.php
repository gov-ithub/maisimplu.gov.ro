<?php

class GovItHub_Ratings{
	function __construct(){
		add_action('wp_ajax_govithub_vote', array( $this, 'process_vote' ) );
	}

	public function process_vote(){

		// Check if user is logged in
		if( ! is_user_logged_in() ){
			wp_send_json_error(array(
				'message' => __('Trebuie sa fi autentificat ca sa poti vota.', 'mai-simplu' )
			));
		}

		$current_user 	= wp_get_current_user();
		$userId 		= $current_user->ID;
		$postId 		= $_POST['postId'];
		$voteType 		= $_POST['voteType'];
		$vote_value 	= $voteType === 'plus' ? '1' : '-1';

		//  Perform the vote
		$userVoteData = self::getUserVoteData( $userId, $postId );

		// Check if the user already voted for this
		if( $userVoteData && $userVoteData->rating_rating === $vote_value ){
			wp_send_json_error(array(
				'message' => __('Ai votat deja pentru aceasta propunere.', 'mai-simplu' )
			));
		}

		if( $userVoteData && $userVoteData->rating_rating !== $vote_value ) {
			// update the old rating
			$updated = self::update_rating( $vote_value, $postId, $current_user );
		}
		else{
			// Insret a new rating
			$updated = self::insert_rating( $vote_value, $postId, $current_user );
		}

		if( ! $updated ){
			wp_send_json_error(array(
				'message' => __('A aparut o problema. Votul nu a fost inregistrat.', 'mai-simplu' )
			));
		}

		// Subscribe the user if he voted positive
		if( $vote_value === '1' ){
			self::subscribeUser( $userId, $postId, $voteType );
		}

		// Send back the response
		wp_send_json_success( array(
			'voteCount' => self::get_rating_count_text( $postId )
		));
	}

	static function getUserVoteData( $userId, $postId ){
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare(
		"
			SELECT *
			FROM {$wpdb->prefix}ratings
			WHERE rating_postid = %d
			AND rating_userid =  %d
			",
			$postId, $userId
		) );
	}


	/**
	 * Check if the user already voted for a specific post
	 */
	private static function hasUserVoted( $userId, $postId, $voteType ){
		return false;
	}

	private static function get_ipaddress() {
		if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ip_address = $_SERVER["REMOTE_ADDR"];
		} else {
			$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		if(strpos($ip_address, ',') !== false) {
			$ip_address = explode(',', $ip_address);
			$ip_address = $ip_address[0];
		}
		return esc_attr($ip_address);
	}

	private static function insert_rating( $vote_value, $postId, $current_user ){

		global $wpdb;
		$wpdb->show_errors = true;

		$result = $wpdb->insert( $wpdb->prefix . 'ratings',
			array(
				'rating_postid' => $postId,
				'rating_rating' => $vote_value,
				'rating_timestamp' => current_time('timestamp'),
				'rating_ip' => self::get_ipaddress(),
				'rating_host' => @gethostbyaddr( get_ipaddress() ),
				'rating_username' => $current_user->user_login,
				'rating_userid' => $current_user->ID,
			)
		);

		$rating_score = self::get_rating_count( $postId ) + $vote_value;
		$rating_score_meta = update_post_meta( $postId, 'ratings_score', $rating_score );

		return $result && $rating_score_meta;
	}

	private static function update_rating( $vote_value, $postId, $current_user ){

		global $wpdb;
		$wpdb->show_errors = true;

		$result = $wpdb->update( $wpdb->prefix . 'ratings',
			array(
				'rating_rating' => $vote_value,
			),
			array(
				'rating_userid' => $current_user->ID,
				'rating_postid' => $postId
			)
		);

		$rating_score = self::get_rating_count( $postId ) + $vote_value;
		$rating_score_meta = update_post_meta( $postId, 'ratings_score', $rating_score );

		return $result && $rating_score_meta;
	}

	private static function subscribeUser( $userId, $postId ){
		// TODO: Subscribe the user
	}

	/**
	 * Will return the rating text for the current post or a different one
	 */
	public static function get_rating_count( $postId = null ){
		$postId = $postId ? $postId : get_the_ID();
		return get_post_meta( $postId, 'ratings_score', true );
	}

	public static function get_rating_count_text( $postId = null, $rating_count = null ){
		$postId = $postId ? $postId : get_the_ID();
		$rating_count = $rating_count ? $rating_count : self::get_rating_count( $postId );

		if( ! $rating_count ){
			$message = sprintf( esc_html__( 'Nici un vot! Fi primul care voteaza!', 'mai-simplu' ), $rating_count );
		}
		elseif ( 1 === $rating_count ) {
			$message = sprintf( esc_html__( 'Un vot.', 'mai-simplu' ), $rating_count );
		}
		elseif ( $rating_count < 20 ) {
			$message = sprintf( esc_html__( '%d voturi.', 'mai-simplu' ), $rating_count );
		} else {
			$message = sprintf( esc_html( _n( '%d voturi.', '%d de voturi.', $rating_count, 'mai-simplu' ) ), $rating_count );
		}

		return $message;
	}

}

new GovItHub_Ratings();