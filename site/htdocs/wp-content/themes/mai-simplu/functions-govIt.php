<?php
defined('ABSPATH') or die("Cannot access pages directly.");

// Load Migration script that will run after the theme is activated
require_once(ABSPATH . 'wp-content/themes/mai-simplu/theme-migration.php');

/**
 *  Add google analitycs code
 */
add_action( 'wp_footer', 'govit_add_analytics_code' );
function govit_add_analytics_code(){
	// The old code had 2 Google analytics codes.
	// One for the 404 page and one general
	?>
		<!-- GOOGLE ANALYTICS -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-74265612-1', 'auto');
			ga('send', 'pageview');

			<?php
			// Add 404 page Analytics code
			if( is_404() ) : ?>
				ga('create', 'UA-75146381-1', 'auto');
				ga('send', 'pageview');
			<?php endif; ?>

		</script>
	<?php
}

/**
 *  Add google analitycs code
 *  TODO : Talk to see if we still need the code bellow. Facebook SDK is already added by the WP-FB AutoConnect plugin
 */
add_action( 'wp_footer', 'govit_add_facebook_code' );
function govit_add_facebook_code(){
	?>
		<!-- FACEBOOK SDK -->
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1151519601555654";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	<?php
}


/**
 *  Theme Init functionalities
 *  TODO : Talk to see if we still need the code bellow. Facebook SDK is already added by the WP-FB AutoConnect plugin
 */
function theme_slug_setup() {
	// Theme Supports
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );