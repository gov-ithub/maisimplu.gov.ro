<?php
defined('ABSPATH') or die("Cannot access pages directly.");

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