<?php

	global $wp_customize;

	$zerif_bottomribbon_text = get_theme_mod('zerif_bottomribbon_text');

	if( !empty($zerif_bottomribbon_text) ):

		echo '<section class="separator-one" id="ribbon_bottom">';

			echo '<div class="color-overlay">';

				echo '<h3 class="container text" data-scrollreveal="enter left after 0s over 1s">';

					echo wp_kses_post( $zerif_bottomribbon_text );

				echo '</h3>';

				$zerif_bottomribbon_buttonlabel = get_theme_mod('zerif_bottomribbon_buttonlabel');

				$zerif_bottomribbon_buttonlink = get_theme_mod('zerif_bottomribbon_buttonlink');

				if( !empty($zerif_bottomribbon_buttonlabel) && !empty($zerif_bottomribbon_buttonlink) ):

					echo '<div data-scrollreveal="enter right after 0s over 1s">';

						echo '<a href="'.esc_url( $zerif_bottomribbon_buttonlink ).'" class="btn btn-primary custom-button green-btn">'.wp_kses_post( $zerif_bottomribbon_buttonlabel ).'</a>';

					echo '</div>';

				elseif ( isset( $wp_customize ) ):

					echo '<div data-scrollreveal="enter right after 0s over 1s">';

						echo '<a href="" class="btn btn-primary custom-button green-btn zerif_hidden_if_not_customizer"></a>';

					echo '</div>';

				endif;

			echo '</div>';

		echo '</section>';

	elseif ( isset( $wp_customize ) ):

		echo '<section class="separator-one zerif_hidden_if_not_customizer" id="ribbon_bottom">';

			echo '<div class="color-overlay">';

				/* text */

				echo '<h3 class="container text" data-scrollreveal="enter left after 0s over 1s"></h3>';

				$zerif_bottomribbon_buttonlabel = get_theme_mod('zerif_bottomribbon_buttonlabel');

				$zerif_bottomribbon_buttonlink = get_theme_mod('zerif_bottomribbon_buttonlink');


				if( !empty($zerif_bottomribbon_buttonlabel) && !empty($zerif_bottomribbon_buttonlink) ):


					echo '<div data-scrollreveal="enter right after 0s over 1s">';


						echo '<a href="'.$zerif_bottomribbon_buttonlink.'" class="btn btn-primary custom-button green-btn">'.wp_kses_post($zerif_bottomribbon_buttonlabel).'</a>';


					echo '</div>';


				elseif ( isset( $wp_customize ) ):

					echo '<div data-scrollreveal="enter right after 0s over 1s">';


						echo '<a href="" class="btn btn-primary custom-button green-btn zerif_hidden_if_not_customizer"></a>';


					echo '</div>';

				endif;


			echo '</div>';


		echo '</section>';

	endif;
?>