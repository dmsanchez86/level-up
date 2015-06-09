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
			<div class="col-lg-4 col-md-4 col-xs-3">
				<div class="separador compartir">
                    <a href="https://www.facebook.com/tvplayapp"  target="_blank" class="facebook"></a> | <a href="http://twitter.com/playapptv" target="_blank" class="twitter"></a> | <a href="https://instagram.com/playapptv/" target="_blank" class="instagram"></a>
                </div>
			</div>
			<div class="col-lg-4 col-md-4 col-xs-6">
				<a href="/#/">
					<div class="logo__contenedor">
						<img src="/" class="logo__imagen"/>
					</div>
				</a>
			</div>
			<div class="col-lg-4 col-md-4 col-xs-3"></div>
		</section>
	</div>
</header>
<section class="navegador">
	<div class="container">
		<nav class="navegador__contenedor">
			<ul>
				<li><a href="/#/">Home</a></li>
				<li><a href="/#/contacto">Contacto</a></li>
				<li><a href="/#/presentadores">Presentadores</a></li>
				<!--<li><a href="/#/noticias">Noticias</a></li>
				<li><a href="/#/eventos">Eventos</a></li>
				<li><a href="/#/custom">custom</a></li>-->
			</ul>
		</nav>
		<article class="mano mano_loading"></article>
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
	                    <a href="http://facebook.com/tvplayapp" target="_blank" class="facebook"></a> | <a href="http://twitter.com/playapptv"  target="_blank" class="twitter"></a> | <a href="https://instagram.com/playapptv/" target="_blank" class="instagram"></a>
	                </div>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-6">
					<a href="/#/">
						<div class="logo__contenedor">
							<img src="/" class="logo__imagen"/>
						</div>
					</a>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-3"></div>
			</section>
			<div class="soporte">
				<?php poweredby(); ?>
			</div>
		</div>
	</footer>
	<div class="loader">
	    <div>Cargando</div>
	</div>

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

add_action('wp_ajax_nopriv_menu_slider', 'menu_slider');
add_action('wp_ajax_menu_slider', 'menu_slider');

function menu_slider(){
	$datos = select_post_cat_slug("menu-inicio",3,false);
	echo json_encode($datos);
	die();
}

add_action('wp_ajax_nopriv_presentadores', 'presentadores');
add_action('wp_ajax_presentadores', 'presentadores');

function presentadores(){
	
	if(isset($_GET['ref'])){
		$datos = select_post_cat_slug("presentadores",4,false); // Retorna solo cuatro que seran para el inicio
	}else{
		$datos = select_post_cat_slug("presentadores",-1,false); // Retorna todos los presentadores que iran ya en su respectiva página
	}
	
	echo json_encode($datos);
	die();
}

add_action('wp_ajax_nopriv_menu', 'menu');
add_action('wp_ajax_menu', 'menu');

function menu(){
	$categorias = array();
	
	$args = array(
		'parent'                   	=> '5',
		'hide_empty'				=>false
	); 

	$datos = get_categories($args);
	
	foreach($datos as $item){
		$categorias[] = array(
			'img'		=>get_field('imagen','category_'.$item->term_id),
			'titulo'	=>$item->cat_name,
			'id'		=>$item->cat_ID
		);
	}
	
	echo json_encode($categorias);
	die();
}

add_action('wp_ajax_nopriv_slider', 'slider');
add_action('wp_ajax_slider', 'slider');

function slider(){
	$datos = select_post_cat_slug("slider",-1,false);
	
	$newDatos = array();
	
	$counter = 0;
	foreach($datos as $iterable){
		
		if($counter==0){
		    $tmp = $iterable;		
			
			$tmp["isActive"] = true;
			
			$iterable = $tmp;
			
		}
		$newDatos[] = $iterable;
		
		$counter++;
	}
	
	echo json_encode($newDatos);
	
	die();
}

add_action('wp_ajax_nopriv_banner', 'banner');
add_action('wp_ajax_banner', 'banner');

function banner(){
	$data  = array('img'=>get_field('imagen','category_'.'9'));
	echo json_encode($data);
	
	die();
}

add_action('wp_ajax_nopriv_noticias', 'noticias');
add_action('wp_ajax_noticias', 'noticias');

function noticias(){
	$data = array();
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		
		$data = obtener_post_por_palabra_categoria_limite('',$id,'');
	}else if(isset($_GET['ref'])){
		
		$nn = select_post_cat_slug("noticias",-1,false);
		shuffle($nn);
		
		$data = array(
			'entradas'=> $nn
		);
		
	}else{
		$data = array(
			'entradas'=> select_post_cat_slug("noticias",-1,false)
		);
	}
	
	echo json_encode($data);
	die();
	
	
}

add_action('wp_ajax_nopriv_entrada', 'entrada');
add_action('wp_ajax_entrada', 'entrada');

function entrada(){
	$id = $_GET['id'];
	$data = array(
			'metadata'=> get_post($id),
			'url' => wp_get_attachment_url(get_post_meta($id)["imagen"][0]) 
		);
	$data["imagen"] = wp_get_attachment_url( get_post_thumbnail_id($id) );
	echo json_encode($data);
	die();
}

add_action('wp_ajax_nopriv_entrada_', 'entrada_');
add_action('wp_ajax_entrada_', 'entrada_');

function entrada_(){
	$id = $_GET['id'];
	$data = array(
			'data_entrade'=> select_post_id($id)
		);
	echo json_encode($data);
	die();
}

add_action('wp_ajax_nopriv_logo_page', 'logo_page');
add_action('wp_ajax_logo_page', 'logo_page');

function logo_page(){
	$data  = array('img'=>get_field('imagen','category_'.'10'));
	echo json_encode($data);
	
	die();
}

add_action('wp_ajax_nopriv_form', 'form');
add_action('wp_ajax_form', 'form');

function form(){
	$name = $_GET['name'];
	$email = $_GET['email'];
	$message = $_GET['message'];
	
	$email_to = "dmsanchez86@misena.edu.co";
	$email_subject = "Formulario enviado a traves de la pagina web";
	$remitente = $name;
		
		
	
	$email_message = '<html><body>';
	$email_message .= '';
	$email_message .= "Nombre: ".$name."<br>";
	$email_message .= "Email: ".$email."<br>";
	$email_message .= "Asunto: ".$message."<br>";
	$email_message .= "Mensaje: ".$message."<br>";

			
	
	$headers = "From: " . $remitente. "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	

	@mail($email_to, $email_subject, $email_message, $headers);
	
	
		
	echo "Se envio el email al correo $email_to";
	die();
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