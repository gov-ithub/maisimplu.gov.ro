<?php
	// Social share buttons. An UTM_SOURCE is added for Google Analytics
	$encoded_url = urlencode( get_permalink() );
	$facebook_share_url = 'https://www.facebook.com/sharer/sharer.php?display=popup&amp;u=' . $encoded_url . '%3Futm_source%3Dsharefb';
	$google_share_url = 'https://plus.google.com/share?url='.$encoded_url.'%3Futm_source%3Dsharegp';
    // Get status of subscription for a specific post
    switch(follow_status(get_the_ID())):
        case 'follow':
            $status = 'abonează-te';
            break;
        case 'unfollow':
            $status = 'dezabonează-te';
            break;
    endswitch;
?>

<div class="govithub-proposal-rating-wrapper">
	<div class="govithub-proposal-rating-status">
		<span class="govithub-proposal-rating-status-holder"><?php echo GovItHub_Ratings::get_rating_count_text(); ?></span>
	</div>
	<div class="govithub-votebar-placeholder"></div>
	<div class="row govithub-vote-share-bar">
		<div class="col-sm-6">
			<a href="#" class="govithub-bubble-button govithub-rating-plus-button govithub-rating-trigger" data-postId="<?php the_ID(); ?>" data-rating="plus" title="Voteaza pozitiv"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
			<a href="#" class="govithub-bubble-button govithub-rating-minus-button govithub-rating-trigger" data-postId="<?php the_ID(); ?>" data-rating="minus" title="Voteaza negativ"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
			<a href="<?php echo get_permalink(); ?>#disqus_thread" class="govithub-bubble-button govithub-rating-comments-button"><i class="fa fa-comments" aria-hidden="true"></i></a>
			<?php if(is_user_logged_in()): ?>
			    <?php if(is_single(get_the_ID())): ?>
			<a href="javascript:void(0);" class="govithub-bubble-button govithub-follow-trigger" data-postId="<?php the_ID(); ?>" data-follow="<?=follow_status(get_the_ID())?>" title="<?=ucfirst($status)?>"><?=ucfirst($status)?></a>
			    <?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="col-sm-6 govithub-proposal-share-buttons-container">
			<a onclick="javascript:window.open('<?php echo $facebook_share_url; ?>','SHARE','width=600,height=400'); return false;" href="<?php echo $facebook_share_url; ?>" class="govithub-facebook-share-button" title="Share on facebook"><i class="fa fa-facebook"></i>Facebook</a>
			<a onclick="javascript:window.open('<?php echo $google_share_url; ?>','SHARE','width=600,height=400'); return false;" href="<?php echo $google_share_url; ?>" class="govithub-google-share-button" title="Share on google"><i class="fa fa-google"></i>Google</a>
		</div>
	</div>
</div>
