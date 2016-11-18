<?php
/**
 * Template Name: Blog - tag cu tabel companii
 */
get_header(); ?>
<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<h1>Tabel 300 propuneri Companii </h1>



<div id="content" class="site-content">

	<div class="container">

			<div class="content-left-wrap col-md-12">

			<div id="primary" class="content-area"> 
			
			
			

		
							
					
			
			
			

			<?php //query_posts( array( 'meta_key' => 'ratings_users', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'showposts' => '50' ) ); ?>
			
				<main id="main" class="site-main" role="main">

			
					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$wp_query = new WP_Query( array('post_type' => 'post','cat' => '2', 'showposts' => '300', 'paged' => $paged , 'meta_key' => 'ratings_users', 'orderby' => 'meta_value_num', 'order' => 'DESC',) ); ?>

					<table class="footable" data-auto-columns="false" data-page-size="300" data-sort="false">
							<thead>	<tr>		
			<th>Nr.</th>
			<th>Propunere</th>
			<th>Autoritate</th>	
			<th>Categorie</th>	
			<th>Eticheta</th>
			<th>Timp</th>	
			<th>Cost</th>
		
			<th>Nr. voturi</th>
												

		</tr>
		</thead>
				<tbody>	
						
					
					<?php if( $wp_query->have_posts() ):
					 
						while ($wp_query->have_posts()) : 
						
							$wp_query->the_post();
							get_template_part( 'content-tabel', get_post_format() );
							
							
							

						endwhile;

					endif;

					//zerif_paging_nav();

					wp_reset_postdata();
					?>
					</main><!-- #main -->

				</tbody>
					</table>
				
				<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
			</div><!-- #primary -->

		</div><!-- .content-left-wrap -->

		

	</div><!-- .container -->
<?php get_footer(); ?>