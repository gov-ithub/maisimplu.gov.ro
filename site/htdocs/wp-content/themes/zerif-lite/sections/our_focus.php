<section class="focus" id="focus">
	<div class="container">
		<!-- SECTION HEADER -->
		<div class="section-header">
			<!-- SECTION TITLE -->
			<!-- SECTION HEADER -->
		<div class="section-header">

			<!-- SECTION TITLE -->

			<h2 class="dark-text">pași</h2><div class="section-legend">urmează cu atenție pașii de mai jos pentru a propune o imbunatatire in interactiunea cu administrația</div>
		</div>

		<div class="row">


	<?php
	if ( is_user_logged_in() ) { ;?>   
	<div class="col-lg-3 col-sm-3 focus-box" data-scrollreveal="enter left after 0.15s over 1s">
		<div class="service-icon">
			<a href="http://maisimplu.gov.ro/dashboard/"><i class="pixeden" style="background:url(http://maisimplu.gov.ro/wp-content/uploads/2016/02/login.png) no-repeat center;width:100%; height:100%;"></i> <!-- FOCUS ICON--></a>
		</div>

		<h3 class="red-border-bottom">1. Ești autentificat</h3>
		<!-- FOCUS HEADING -->
		<p>În acest moment ești autentificat.  Poți ieși din cont făcând click <a href="<?php echo wp_logout_url(); ?>">aici</a> </p>	
	</div>
	<div class="col-lg-3 col-sm-3 focus-box" data-scrollreveal="enter left after 0.15s over 1s">

		<div class="service-icon">
			<a href="http://maisimplu.gov.ro/propunere/"><i class="pixeden" style="background:url(http://maisimplu.gov.ro/wp-content/uploads/2016/02/Prop1.png) no-repeat center;width:100%; height:100%;"></i> <!-- FOCUS ICON--></a>
		</div>

		<h3 class="red-border-bottom">2. Spune-ne ce să simplificăm!</h3>
		<!-- FOCUS HEADING -->

		<p>Odată autentificat, descrie-ne ce proceduri putem elimina, reduce sau simplifica pentru ca ție să îți fie mai ușor să interacționezi cu instituțiile statului.</p>	

	</div>
	<?php } else { ?>

	<div class="col-lg-3 col-sm-3 focus-box" data-scrollreveal="enter left after 0.15s over 1s">

				<div class="service-icon">
						<a href="http://maisimplu.gov.ro/inregistrare/"><i class="pixeden" style="background:url(http://maisimplu.gov.ro/wp-content/uploads/2016/02/perso1.png) no-repeat center;width:100%; height:100%;"></i> <!-- FOCUS ICON--></a>
				</div>
				<h3 class="red-border-bottom">1. Creează-ți un cont de utilizator</h3>
				<!-- FOCUS HEADING -->

				<p>Pentru a-ți crea cont, te rugăm să faci click pe imaginea de mai sus și sa introduci numele și penumele tău, adresa de mail la care te putem contacta, județul sau sectorul în care locuiești și numele de utilizator în baza căruia te vei putea autentifica în platformă, alternativ, te poți</p>
				<span class="fbLoginButton"><script type="text/javascript">//<!--
				document.write('<fb:login-button scope="email" v="2" size="large" onlogin="jfb_js_login_callback();">Autentifica cu Facebook</fb:login-button>');
			//--></script></span>

			</div>

				<div class="col-lg-3 col-sm-3 focus-box" data-scrollreveal="enter left after 0.15s over 1s">

					<div class="service-icon">
						<a href="http://maisimplu.gov.ro/cont-nou-autentificare/"><i class="pixeden" style="background:url(http://maisimplu.gov.ro/wp-content/uploads/2016/02/Prop1.png) no-repeat center;width:100%; height:100%;"></i> <!-- FOCUS ICON--></a>
				</div>
				<h3 class="red-border-bottom">2. Spune-ne ce să simplificăm!</h3>
				<!-- FOCUS HEADING -->
				<p>Odată autentificat, descrie-ne ce proceduri putem elimina, reduce sau simplifica pentru ca ție să îți fie mai ușor să interacționezi cu instituțiile statului.</p>	

			</div>
	<?php }
	?>
			<div class="col-lg-3 col-sm-3 focus-box" data-scrollreveal="enter left after 0.15s over 1s">

				<div class="service-icon">
					<a href="http://maisimplu.gov.ro/lista-propuneri/"><i class="pixeden" style="background:url(http://maisimplu.gov.ro/wp-content/uploads/2016/02/intern1.png) no-repeat center;width:100%; height:100%;"></i> <!-- FOCUS ICON--></a>
				</div>
				<h3 class="red-border-bottom">3. Distribuie / susține o propunere!</h3>
				<!-- FOCUS HEADING -->

				<p>Spune-le și prietenilor tăi despre propunerea ta sau exprimă-ți părerea față de o altă propunere din platformă prin formularul de comentarii.</p>	

				<form role="search" method="get" class="search-form" action="http://maisimplu.gov.ro/">
					<label>
						<span class="screen-reader-text">Caută o propunere afată în platforma</span>
						<input type="search" class="search-field" placeholder="Caută o propunere..." value="" name="s" title="Căutare:" />
					</label>
				</form>
			</div>
			<div class="col-lg-3 col-sm-3 focus-box" data-scrollreveal="enter left after 0.15s over 1s">

				<div class="service-icon">
					<a href="http://maisimplu.gov.ro/formular-monitorizare-implementarea-masurilor/"><i class="pixeden" style="background:url(http://maisimplu.gov.ro/wp-content/uploads/2016/07/raporteaza.png) no-repeat center;width:100%; height:100%;"></i> <!-- FOCUS ICON--></a>
				</div>

				<h3 class="red-border-bottom">4. Raporteaza implementarea defectuoasa</h3>
				<!-- FOCUS HEADING -->

				<p>În continuare, Guvernul României va monitoriza implementarea <a target="_blank" href="http://maisimplu.gov.ro/masuri-de-simplificare/">acestor măsuri</a>, colectând informaţii prin intermediul <a target="_blank" href="http://maisimplu.gov.ro/formular-monitorizare-implementarea-masurilor/">acestui formular</a>.</p>	

			</div>
		</div>
	</div><!-- / END CONTAINER -->
</section>  <!-- / END FOCUS SECTION -->