<?php
 require_once('wp_bootstrap_navwalker.php');
 require_once('widget_custom.php');
 require_once('GCal.class.php');
 require_once('utils.php');
 require_once('RainTplConnect.php');

add_action('wp_head','ajaxurl');
function ajaxurl() { ?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
<?php } 
 
function register_widgets(){
	registerWidget("logo","logo","Logo de la pagina web");
}
 
//Add Widgets
function logo() {
        ?> <div class="logo divhtml"> <?php
            if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'logo' ) ){}
        ?> </div> <?php
}

function custom_header(){?>
<header>
	<div class="container">
		<section class="logo">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<a href="/#/">
					<div class="logo__contenedor">
						<img src="/wp-content/uploads/2015/04/logo-alta-level-up.png" class="logo__imagen"/>
					</div>
				</a>
			</div>
		</section>
	</div>
</header>
<section class="navegador">
	<div class="container">
		<nav class="navegador__contenedor">
			<ul>
				<li><a href="/#/">Home</a></li>
				<li><a href="/#/contacto">Contacto</a></li>
				<li><a href="/#/noticias">Noticias</a></li>
				<li><a href="/#/eventos">Eventos</a></li>
				<li><a href="/#/custom">custom</a></li>
			</ul>
		</nav>
		<article class="mano"></article>
	</div>
</section>
<?php
}

function pie_de_pagina(){?>
	<footer>
		<div class="container">
			<section class="logo">
				<div class="col-lg-4 col-md-4 col-xs-3">
					<div class="separador compartir">
	                    <a href="http://facebook.com/OnlineLevelUp" class="facebook"></a> | <a href="http://twitter.com/LevelUpOnline" class="twitter"></a> | <a href="http://facebook.com/OnlineLevelUp" class="google"></a>
	                </div>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-6">
					<div class="logo__contenedor">
						<img src="/wp-content/uploads/material/logo.png" class="logo__imagen"/>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-3"></div>
			</section>
			<div class="soporte">
				<?php poweredby(); ?>
			</div>
		</div>
	</footer>
	<style>
		.soporte{background-color:white}
		#centro{min-height: 60px!important;}
	</style>
<?php
}

function custom_loop(){
	$tpl = new RaintTplConnect("wp-content/themes/zopp/library/plantillas/");
	$tpl->dibujarPlantilla("index",array("1"));
}

include_once "funcionesjson.php";

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//remove the header and nav add Custom header 
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'custom_header' );

//remove the loop and add the custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'custom_loop' );

//remove the sidebar?
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

//remove the footer and add the custom footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'pie_de_pagina' );
remove_action('wp_head', 'genesis_load_favicon');
?>