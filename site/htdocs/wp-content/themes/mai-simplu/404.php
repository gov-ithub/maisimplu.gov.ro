<?php
/**
 * The template for displaying 404 pages (Not Found).
 */
get_header(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75146381-1', 'auto');
  ga('send', 'pageview');

</script>
<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<div id="content" class="site-content">

<div class="container">

<div class="content-left-wrap col-md-9">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<article>

				<header class="entry-header">

					<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'mai-simplu' ); ?></h1>

				</header><!-- .entry-header -->

				<div class="entry-content">

					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mai-simplu' ); ?></p>

				</div><!-- .entry-content -->

			</article><!-- #post-## -->

		</main><!-- #main -->

	</div><!-- #primary -->

</div>

<div class="sidebar-wrap col-md-3 content-left-wrap">

	<?php get_sidebar(); ?>

</div><!-- .sidebar-wrap -->

</div>

<?php get_footer(); ?>