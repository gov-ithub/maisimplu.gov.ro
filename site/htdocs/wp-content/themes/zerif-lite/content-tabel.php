	
							
				
					<tr>
					<td><?php the_ID(); ?></td>					
					<td><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a> </td>	
					<td><?php echo get_post_meta($post->ID, "autoritate", true); ?></td>
					<td><?php $categories_list = get_the_category_list( __( ', ', 'zerif-lite' ) );printf( __( ' %1$s', 'zerif-lite' ), $categories_list ); ?> </td>
					<td><?php $tags_list = get_the_tag_list( '', __( ', ', 'zerif-lite' ) );printf( __( ' %1$s', 'zerif-lite' ), $tags_list ); ?></td>
					<td><?php echo get_post_meta($post->ID, "timp", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "cost", true); ?><?php echo get_post_meta($post->ID, "cost_suplimentar", true); ?></td>
			
					<td><?php if(function_exists('the_ratings')) { echo expand_ratings_template('<strong>%RATINGS_USERS% voturi</strong>', get_the_ID()); } ?></td>
						</tr>
							
				
