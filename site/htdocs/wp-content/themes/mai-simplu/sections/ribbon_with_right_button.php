<section class="purchase-now" id="ribbon_right"><div class="container">
<div class="section-header">

			<!-- SECTION TITLE -->

			<h2 class="white-text">Rezultatele iniţiativei </h2>
			<!-- SHORT DESCRIPTION ABOUT THE SECTION -->

			<div class="white-text">Guvernul a adoptat în în data de 28 iunie un pachet de măsuri destinate simplificării procedurilor și reducerii eforturilor cetățenilor de procurare a unor documente, precum și consolidării procesului de digitalizare la nivelul administrației publice centrale. </div>


			</div><!-- / END SECTION HEADER -->



<?php

	echo '<div id="carousel-homepage-latestnews" class="carousel slide" data-ride="carousel">';


					/* Wrapper for slides */

					echo '<div class="carousel-inner" role="listbox">';


						$zerif_latest_loop = new WP_Query( array( 'post_type' => 'post','category_name' =>'Măsuri de simplificare', 'posts_per_page' => $zerif_total_posts, 'order' => 'DESC','ignore_sticky_posts' => true ) );

						$newSlideActive = '<div class="item active">';
						$newSlide 		= '<div class="item">';
						$newSlideClose 	= '<div class="clear"></div></div>';
						$i_latest_posts= 0;

					if ( $zerif_latest_loop->have_posts() ) :

							while ( $zerif_latest_loop->have_posts() ) : $zerif_latest_loop->the_post();

								$i_latest_posts++;

								if ( !wp_is_mobile() ){

										if($i_latest_posts == 1){
											echo $newSlideActive;
										}
										else if($i_latest_posts % 4 == 1){
											echo $newSlide;
										}

										echo '<div class="col-sm-3 latestnews-box">';

											echo '<div class="latestnews-img">';

												echo '<a class="latestnews-img-a" href="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'">';

													if ( has_post_thumbnail() ) :
														the_post_thumbnail('thumbnail');
													else:
														echo '<img src="'.esc_url( get_template_directory_uri() ).'/images/blank-latestposts.png" alt="'.esc_attr( get_the_title() ).'" />';
													endif;

												echo '</a>';

											echo '</div>';

											echo '<div><div class="white-text">';

												//echo '<h3 class="latestnews-title"><a href="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'">'.wp_kses_post( get_the_title() ).'</a></h3>';

												$ismore = @strpos( $post->post_content, '<!--more-->');

												if($ismore) {
													the_content( sprintf( esc_html__('[...]','mai-simplu'), '<span class="screen-reader-text">'.esc_html__('about ', 'mai-simplu').get_the_title().'</span>' ) );
												} else {
													the_excerpt();
												}

											echo '	 </div> </div> ';

										echo '</div><!-- .latestnews-box"> -->';

										/* after every four posts it must closing the '.item' */
										if($i_latest_posts % 4 == 0){
											echo $newSlideClose;
										}

								} else {

									if( $i_latest_posts == 1 ) $active = 'active'; else $active = '';

									echo '<div class="item '.$active.'">';
										echo '<div class="col-md-3 latestnews-box">';
											echo '<div class="latestnews-img">';
												echo '<a class="latestnews-img-a" href="'.get_permalink().'" title="'.get_the_title().'">';
													if ( has_post_thumbnail() ) :
														the_post_thumbnail('thumbnail');
													else:
														echo '<img src="'.esc_url( get_template_directory_uri() ).'/images/blank-latestposts.png" alt="'.esc_attr( get_the_title() ).'" />';
													endif;
												echo '</a>';
											echo '</div>';
											echo '<div><div class="white-text">';
												//echo '<h3 class="latestnews-title"><a href="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'">'.wp_kses_post( get_the_title() ).'</a></h3>';

												$ismore = @strpos( $post->post_content, '<!--more-->');

												if($ismore) {
													the_content( sprintf( esc_html__('[...]','mai-simplu'), '<span class="screen-reader-text">'.esc_html__('about ', 'mai-simplu').get_the_title().'</span>' ) );
												} else {
													the_excerpt();
												}
											echo '</div></div> ';
										echo '</div>';
									echo '</div>';
								}

							endwhile;

						endif;

						if ( !wp_is_mobile() ) {

							// if there are less than 10 posts
							if($i_latest_posts % 4!=0){
								echo $newSlideClose;
							}

						}

						wp_reset_postdata();

					echo '</div><!-- .carousel-inner -->';

					/* Controls */
					echo '<a class="left carousel-control" href="#carousel-homepage-latestnews" role="button" data-slide="prev">';
						echo '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
						echo '<span class="sr-only">'.__('Previous','mai-simplu').'</span>';
					echo '</a>';
					echo '<a class="right carousel-control" href="#carousel-homepage-latestnews" role="button" data-slide="next">';
						echo '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
						echo '<span class="sr-only">'.__('Next','mai-simplu').'</span>';
					echo '</a>';
				echo '</div><!-- #carousel-homepage-latestnews --><a href="http://maisimplu.gov.ro/masuri-de-simplificare/" class="btn btn-primary custom-button green-btn">vezi toate măsurile de simplificare</a>

				<a target="_blank" title="RAPORTEAZA IMPLEMENTAREA DEFECTUOASA !" href="http://maisimplu.gov.ro/formular-monitorizare-implementarea-masurilor/"><img src="http://maisimplu.gov.ro/wp-content/uploads/2016/07/raporteaza-masura.png" height="42" width="42"></a>


				';


		echo '</section>';

 ?>

</div>
</section></div>