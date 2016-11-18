<?php
/**
 * The template for displaying Archive pages.
 */
get_header(); ?>

<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<div id="content" class="site-content">

<div class="container">

<div class="content-left-wrap col-md-9">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">

				<h1 class="page-title">

					<?php

						if ( is_category() ) :

							single_cat_title();

						elseif ( is_tag() ) :

							single_tag_title();

						elseif ( is_author() ) :

							printf( __( 'Author: %s', 'mai-simplu' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :

							printf( __( 'Day: %s', 'mai-simplu' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :

							printf( __( 'Month: %s', 'mai-simplu' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'mai-simplu' ) ) . '</span>' );

						elseif ( is_year() ) :

							printf( __( 'Year: %s', 'mai-simplu' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'mai-simplu' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :

							_e( 'Asides', 'mai-simplu' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :

							_e( 'Galleries', 'mai-simplu');

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :

							_e( 'Images', 'mai-simplu');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :

							_e( 'Videos', 'mai-simplu' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :

							_e( 'Quotes', 'mai-simplu' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :

							_e( 'Links', 'mai-simplu' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :

							_e( 'Statuses', 'mai-simplu' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :

							_e( 'Audios', 'mai-simplu' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :

							_e( 'Chats', 'mai-simplu' );

						else :

							_e( 'Archives', 'mai-simplu' );

						endif;

					?>

				</h1>

				<?php

					// Show an optional term description.

					$term_description = term_description();

					if ( ! empty( $term_description ) ) :

						printf( '<div class="taxonomy-description">%s</div>', $term_description );

					endif;

				?>

			</header><!-- .page-header -->

			<?php while ( have_posts() ) : the_post();

					/* Include the Post-Format-specific template for the content.

					 * If you want to override this in a child theme, then include a file

					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.

					 */

					get_template_part( 'content', get_post_format() );

				endwhile;  
				
				//zerif_paging_nav(); 
				
			else:
			
				get_template_part( 'content', 'none' );
				
			endif; ?>

		</main><!-- #main -->
<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
	</div><!-- #primary -->

</div><!-- .content-left-wrap -->

<div class="sidebar-wrap col-md-3 content-left-wrap">

	<?php get_sidebar(); ?>

</div><!-- .sidebar-wrap -->

</div><!-- .container -->

<?php get_footer(); ?>