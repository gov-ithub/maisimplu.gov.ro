<section class="about-us" id="aboutus">
	<div class="container">

		<!-- SECTION HEADER -->

		<div class="section-header">

			<!-- SECTION TITLE -->

			<h2 class="white-text">Despre inițiativă</h2>
			<!-- SHORT DESCRIPTION ABOUT THE SECTION -->

			<div class="white-text section-legend">obiectivul principal al proiectului este reducerea numărului de documente cerut la interacțiunea cu administrația </div>		</div><!-- / END SECTION HEADER -->

		<!-- 3 COLUMNS OF ABOUT US-->

		<div class="row">

			<!-- COLUMN 1 - BIG MESSAGE ABOUT THE COMPANY-->

		<div class="col-lg-4 col-md-4 column zerif-rtl-big-title"><div class="big-intro" data-scrollreveal="enter left after 0s over 1s"><img src="http://maisimplu.gov.ro/wp-content/uploads/2016/02/Comisia-de-taiat-harti.png" alt="Comisia de taiat harti" width="425" height="356" class="alignnone size-full wp-image-180" /></div></div><div class="col-lg-4 col-md-4 column zerif_about_us_center text_and_skills" data-scrollreveal="enter bottom after 0s over 1s"><p> Guvernul României a demarat un proiect de debirocratizare a administrației publice în relația cu cetățeanul. Un task force pentru simplificare administrativă va fi convocat de Cancelaria Prim-Ministrului în mod regulat, aducând laolaltă instituțiile din administrația centrală. Avem nevoie de dumneavoastră să ne ajutați cu teme de lucru pentru acest task force.</p></div>		<div class="col-lg-4 col-md-4 column zerif-rtl-skills ">

			<ul class="skills" data-scrollreveal="enter right after 0s over 1s">

				<!-- SKILL ONE -->

				
				<li class="skill skill_1">
					<?php
$args=array(
  'include' => 1,
  'orderby' => 'name',
  'order' => 'ASC'
  );
$categories=get_categories($args);
  foreach($categories as $category) {
    
  }
?>
<?php $a = $category->count ;
	  $b= get_category_link( $category->term_id );
	  $c= sprintf( __( "Toate %s" ), $category->name ) ;
	  ?>
					<div class="skill-count"><input type="text" value="<?php echo $a; ?>" data-thickness=".2" class="skill1" tabindex="-1"></div><div class="section-legend"><a title="<?php echo $c ;?>" href="<?php echo $b ;?>"><?php echo $a; ?> Propuneri de simplificare pentru cetățeni</a></div>
				</li>

				
				<!-- SKILL TWO -->

				
				<li class="skill skill_2">
				<?php
$args=array(
  'include' => 2,
  'orderby' => 'name',
  'order' => 'ASC'
  );
$categories=get_categories($args);
  foreach($categories as $category) {
   
  }
?>
<?php $a = $category->count ; 
	  $b= get_category_link( $category->term_id );
	  $c= sprintf( __( "Toate %s" ), $category->name ) ;
	   ?>
					<div class="skill-count"><input type="text" value="<?php echo $a; ?>" data-thickness=".2" class="skill2" tabindex="-1"></div><div class="section-legend"><a title="<?php echo $c ;?>" href="<?php echo $b ;?>"><?php echo $a; ?> Propuneri de simplificare pentru companii</a></div>
		
		
	
		
				</li>
				
	

				
				<!-- SKILL THREE -->
				
				<!-- SKILL FOUR -->
				
			</ul>

		</div> <!-- / END SKILLS COLUMN-->

		
	</div> <!-- / END 3 COLUMNS OF ABOUT US-->

	<!-- CLIENTS -->
	<?php
		if(is_active_sidebar( 'sidebar-aboutus' )):
			echo '<div class="our-clients">';
				echo '<h2><span class="section-footer-title">'.__('OUR HAPPY CLIENTS','zerif-lite').'</span></h2>';
			echo '</div>';

			echo '<div class="client-list">';
				echo '<div data-scrollreveal="enter right move 60px after 0.00s over 2.5s">';
				dynamic_sidebar( 'sidebar-aboutus' );
				echo '</div>';
			echo '</div> ';
		endif;
	?>

</div> <!-- / END CONTAINER -->

</section> <!-- END ABOUT US SECTION -->