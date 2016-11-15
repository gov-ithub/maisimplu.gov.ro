<?php
/**
 * Template Name: Blog
 */
get_header(); ?>
<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<h1 class="page-title">Toate propunerile</h1><a href="http://maisimplu.gov.ro/lista-propuneri/cele-mai-populare-propuneri/">(vezi populare)</a>

<div id="content" class="site-content">

	<div class="container">

		<div class="content-left-wrap col-md-9">

			<div id="primary" class="content-area">
			
			
				<main id="main" class="site-main" role="main">
					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$wp_query = new WP_Query( array('post_type' => 'post', 'showposts' => '10', 'paged' => $paged) );

					if( $wp_query->have_posts() ):
					 
						while ($wp_query->have_posts()) : 
						
							$wp_query->the_post();
							get_template_part( 'content', get_post_format() );

						endwhile;

					endif;

					//zerif_paging_nav();

					wp_reset_postdata();
					?>
				</main><!-- #main -->
<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
			</div><!-- #primary -->

		</div><!-- .content-left-wrap -->

		<div class="sidebar-wrap col-md-3 content-left-wrap">

			<?php get_sidebar(); ?>

		</div><!-- .sidebar-wrap -->

	</div><!-- .container -->
<?php get_footer(); ?>