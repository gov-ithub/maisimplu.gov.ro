<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php
			get_template_part( 'sections/proposal', 'meta' );
			// if(function_exists('the_ratings')) { the_ratings(); }
		?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php

			if( has_post_thumbnail() ){

				$thumb   = get_post_thumbnail_id();
				$feature_image = wp_get_attachment_url( $thumb );

				echo '<span class="govithub-featured-image">';
					echo '<a href="' . $feature_image . '" class="govithub-image-popup" >';
						the_post_thumbnail( 'govithub-blog' );
					echo '</a>';
				echo '</span>';

			}

			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'mai-simplu' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php

			/* translators: used between list items, there is a space after the comma */

			$category_list = get_the_category_list( __( ', ', 'mai-simplu' ) );

			/* translators: used between list items, there is a space after the comma */

			$tag_list = get_the_tag_list( '', __( ', ', 'mai-simplu' ) );

			if ( ! zerif_categorized_blog() ) {

				// This blog only has 1 category so we just need to worry about tags in the meta text

				if ( '' != $tag_list ) {

					$meta_text = __( 'Categoria:  %2$s. ', 'mai-simplu' );

				} else {

					//$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'mai-simplu' );

				}

			} else {

				// But this blog has loads of categories so we should probably display them here

				if ( '' != $tag_list ) {

					$meta_text = __( 'Categoria:  %1$s .', 'mai-simplu' );

				} else {

					$meta_text = __( 'Categoria: %1$s.', 'mai-simplu' );

				}

			} // end check for categories on this blog

			printf(

				$meta_text,

				$category_list,

				$tag_list,

				get_permalink()

			);

		?>

		<?php edit_post_link( __( 'Edit', 'mai-simplu' ), '<span class="edit-link">', '</span>' ); ?>
<br />&nbsp;<br />
		<div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="600" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
		<?php
	if ( get_post_status ( get_the_ID() ) == 'private' ) {
		if(function_exists('show_publish_button')) { show_publish_button(); }
	} else {
		echo '';
	}
?>

		<?php //if(function_exists('show_publish_button')) { show_publish_button(); } ?>


	</footer><!-- .entry-footer -->

</article><!-- #post-## -->