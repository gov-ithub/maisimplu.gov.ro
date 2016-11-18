<?php
/**
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<!--hello, did you find a glitch or wish to make this platform better ? drop me a line:
   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _   _
  / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \ / \
 ( v | i | c | t | o | r | . | c | i | o | b | a | n | u | @ | g | o | v | . | r | o )
  \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/  -->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<!--[if lt IE 9]>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ie.css" type="text/css">
<![endif]-->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1151519601555654";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function zerif_old_render_title() {
?>
<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'zerif_old_render_title' );
endif;

wp_head(); ?>

</head>

<?php if(isset($_POST['scrollPosition'])): ?>

	<body <?php body_class(); ?> onLoad="window.scrollTo(0,<?php echo intval($_POST['scrollPosition']); ?>)">

<?php else: ?>

	<body <?php body_class(); ?> >

<?php endif;

	global $wp_customize;

	/* Preloader */

	if(is_front_page() && !isset( $wp_customize ) && get_option( 'show_on_front' ) != 'page' ):

		$zerif_disable_preloader = get_theme_mod('zerif_disable_preloader');

		if( isset($zerif_disable_preloader) && ($zerif_disable_preloader != 1)):
			echo '<div class="preloader">';
				echo '<div class="status">&nbsp;</div>';
			echo '</div>';
		endif;

	endif; ?>


<div id="mobilebgfix">
	<div class="mobile-bg-fix-img-wrap">
		<div class="mobile-bg-fix-img"></div>
	</div>
	<div class="mobile-bg-fix-whole-site">


<header id="home" class="header">

	<div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">

		<div class="container">

			<div class="navbar-header responsive-logo">

				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">

				<span class="sr-only"><?php _e('Toggle navigation','mai-simplu'); ?></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				</button>

				<?php

					$zerif_logo = get_theme_mod('zerif_logo');

					if(isset($zerif_logo) && $zerif_logo != ""):

						echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';

							echo '<img src="'.esc_url( $zerif_logo ).'" alt="'.esc_attr( get_bloginfo('title') ).'">';

						echo '</a>';

					else:

						echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';

							if( file_exists(get_stylesheet_directory()."/images/logo.png")):

								echo '<img src="'.get_stylesheet_directory_uri().'/images/logo.png" alt="'.esc_attr( get_bloginfo('title') ).'">';

							else:

								echo '<img src="'.get_template_directory_uri().'/images/logo.png" alt="'.esc_attr( get_bloginfo('title') ).'">';

							endif;

						echo '</a>';

					endif;

				?>

			</div>

			<nav class="navbar-collapse bs-navbar-collapse collapse" role="navigation"   id="site-navigation">
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'mai-simplu' ); ?></a>
				<a class="screen-reader-text skip-link" href="#content">Sari la continut</a>
				<ul id="menu-meniul-1" class="nav navbar-nav navbar-right responsive-nav main-nav-list">




				<?php if ( current_user_can('contributor') ) : ?>
<li id="menu-item-146" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-146">
<strong><a href="/institutie/">Meniu Institutie</a></strong>
<ul class="sub-menu">

<li><del datetime="2016-07-13T11:57:42+00:00">1. Inregistrare</del>
<br />
<a href="/institutie/editare-informatii-cont/">Editare cont</a></li>

<li><del datetime="2016-07-13T11:57:42+00:00">2. Autentificare</del>
<br />
<a href="<?php echo wp_logout_url(); ?>">Ieşire</a>
</li>

<li>
<a href="/completare-informatii-despre-institutia-care-raporteaza/">3. Completare informatii institutie</a>
</li>


<li>
<a href="/completare-informatii-servicii/">4. Transmitere raport sintetic</a>
</li>

<li>
<a href="/institutie/transmitere-raport-detaliat-cu-privire-la-serviciile-publice/">5. Transmitere raport detaliat</a>
</li>

<li>
<a href="/informatii-privind-pcue/">6. Informatii privind PCUe</a>
</li>


</ul>
</li>
<?php endif; ?>












				<li id="menu-item-135" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-135"><a href="/">Acasă</li>
				<?php
if ( is_user_logged_in() ) { ;?>

<?php } else { ?>

<li id="menu-item-136" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-136"><a href="/inregistrare/">Creează cont !</a>
</li>

<?php }
?>

<?php
if ( is_user_logged_in() ) { ;?>


<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-142"><a href="/propunere/">Propune o îmbunatațire !</a>
<ul class="sub-menu">
	<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144"><a href="/propunere/companie/">Propunere companie</a></li>
	<li id="menu-item-143" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-143"><a href="/propunere/cetateni/">Propunere cetățeni</a></li>
</ul>
</li>
<?php } else { ?>
<?php }
?>
<?php
if ( is_user_logged_in() ) { ;?>
   <li id="menu-item-145" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-145"><a href="/dashboard/">Propunerile mele</a></li>
<?php } else { ?>
<li id="menu-item-145" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-145"><a href="/autentificare/">Autentificare</a></li>
<?php }
?>
<li id="menu-item-146" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-146"><a href="/lista-propuneri/">Toate Propunerile</a>
<ul class="sub-menu">
	<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144"><a href="/lista-propuneri/cele-mai-populare-propuneri/">Cele mai populare</a></li>

</ul></li>




</ul>
				<?php //wp_nav_menu( array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right responsive-nav main-nav-list', 'fallback_cb'     => 'zerif_wp_page_menu')); ?>

			</nav>

		</div>

	</div>
	<!-- / END TOP BAR -->