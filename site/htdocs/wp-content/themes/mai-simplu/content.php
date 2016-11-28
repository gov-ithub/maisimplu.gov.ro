<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_search() ) : ?>
	<?php if ( has_post_thumbnail()) : ?>
		<div class="post-img-wrap">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail("post-thumbnail"); ?>
			</a>
		</div>
		<div class="listpost-content-wrap">
	<?php else: ?>
		<div class="listpost-content-wrap-full">
	<?php endif; ?>
	<?php else:  ?>
		<div class="listpost-content-wrap-full">
	<?php endif; ?>

		<div class="list-post-top">
			<header class="entry-header">
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<?php
					get_template_part( 'sections/proposal', 'meta' );
					do_action( 'govithub_after_post_title' );
					// if(function_exists('the_ratings')) { the_ratings(); }
				?>
			</header><!-- .entry-header -->
			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			<?php else : ?>
			<div class="entry-content">
				<?php
					$ismore = @strpos( $post->post_content, '<!--more-->');

					if($ismore) {
						the_content( sprintf( esc_html__('[...]','mai-simplu'), '<span class="screen-reader-text">'.esc_html__('about ', 'mai-simplu').get_the_title().'</span>' ) );
					} else {
						the_excerpt();
					}

					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'mai-simplu' ),
						'after'  => '</div>',
					) );
				endif; ?>

				<footer class="entry-footer">

					<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>

						<?php

							/* translators: used between list items, there is a space after the comma */
							$categories_list = get_the_category_list( __( ', ', 'mai-simplu' ) );

							if ( $categories_list && zerif_categorized_blog() ) :

						?>

						<span class="cat-links">
							<?php printf( __( 'Categoria: %1$s', 'mai-simplu' ), $categories_list ); ?>
						</span>
						<?php endif; // End if categories ?>

						<?php
							/* translators: used between list items, there is a space after the comma */
							$tags_list = get_the_tag_list( '', __( ', ', 'mai-simplu' ) );
							if ( $tags_list ) :
						?>

						<span class="tags-links">
							<?php printf( __( 'Etichetat: %1$s', 'mai-simplu' ), $tags_list ); ?>
						</span>

						<?php endif; // End if $tags_list ?>
					<?php endif; // End if 'post' == get_post_type() ?>

					<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
						<span class="comments-link"><?php //comments_popup_link( __( 'Leave a comment', 'mai-simplu' ), __( '1 Comment', 'mai-simplu' ), __( '% Comments', 'mai-simplu' ) ); ?></span>
					<?php endif; ?>

					<?php edit_post_link( __( 'Edit', 'mai-simplu' ), '<span class="edit-link">', '</span>' ); ?>

				</footer><!-- .entry-footer -->
			</div><!-- .entry-content --><!-- .entry-summary -->
		</div><!-- .list-post-top -->
	</div><!-- .listpost-content-wrap -->
</article><!-- #post-## -->