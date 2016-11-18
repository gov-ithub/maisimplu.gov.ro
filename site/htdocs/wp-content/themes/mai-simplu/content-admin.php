<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1><?php edit_post_link( __( 'Editeaza', 'mai-simplu' ), '<span class="edit-link">', '</span>' ); ?>
		<div class="entry-meta">
			<?php //zerif_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<div class="entry-content">

	<?php
		the_content();

		if ( get_post_status ( $ID ) == 'private' ) {
			if(function_exists('show_publish_button')) { show_publish_button(); }
			if(function_exists('show_trash_button')) { show_trash_button(); }
		} else {
			echo '';
		}
	?>
	<span class="tags-links">
		<?php printf( __( 'Etichetat: %1$s', 'mai-simplu' ), $tags_list ); ?>
	</span>
	</div><!-- .entry-content -->
</article><!-- #post-## -->