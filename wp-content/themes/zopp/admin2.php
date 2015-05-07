<?php

function remove_menus(){
  
  /*remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  
  add_menu_page('Page title', 'Otras Opciones', 'manage_options', 'my-top-level-handle', 'my_magic_function');
  add_submenu_page( 'my-top-level-handle', 'Page title', 'Crear Post', 'manage_options', 'my-submenu-handle', 'my_magic_function');
  add_submenu_page( 'my-submenu-handle', 'Page title', 'Crear Post', 'manage_options', 'my-submenu-handles', 'my_magic_function');*/
  
}
add_action( 'admin_menu', 'remove_menus' );

function wpsnippy_admin_bar() {
 global $wp_admin_bar;
// var_dump($wp_admin_bar);
   //$wp_admin_bar->remove_menu('wp-logo');
  // $wp_admin_bar->remove_menu('about');
  // $wp_admin_bar->remove_menu('wporg');
   $wp_admin_bar->remove_menu('documentation');
   $wp_admin_bar->remove_menu('support-forums');
   $wp_admin_bar->remove_menu('feedback');
   //$wp_admin_bar->remove_menu('site-name');
   //$wp_admin_bar->remove_menu('view-site');
  // $wp_admin_bar->remove_menu('edit');
   $wp_admin_bar->remove_menu('updates');
   $wp_admin_bar->remove_menu('comments');
   $wp_admin_bar->remove_menu('new-content');
   //$wp_admin_bar->remove_menu('top-secondary');
   $wp_admin_bar->remove_menu('search'); 
   //$wp_admin_bar->remove_menu('user-actions');
   //$wp_admin_bar->remove_menu('user-info');
  // $wp_admin_bar->remove_menu('edit-profile');   
   $wp_admin_bar->remove_menu('itsec_admin_bar_menu');   
   //$wp_admin_bar->remove_menu('logout');
 
}
//http://premium.wpmudev.org/blog/how-to-reorder-or-add-wordpress-admin-menu-items/
add_action( 'wp_before_admin_bar_render', 'wpsnippy_admin_bar' );

add_action( 'admin_bar_menu', 'make_parent_node', 999 );
function make_parent_node( $wp_admin_bar ) {
/*	$args = array(
		'id'     => 'new-post',     // id of the existing child node (New > Post)
		'title'  => 'Herman Andres', // alter the title of existing node
		'parent' => false,          // set parent to false to make it a top level (parent) node
	);
	$wp_admin_bar->add_node( $args );*/
}

add_action('wp_before_admin_bar_render', 'orbisius_child_theme_creator_admin_bar_render', 100);

/**
 * Adds admin bar items for easy access to the theme creator and editor
 */
/*function orbisius_child_theme_creator_admin_bar_render() {
    orbisius_child_theme_creator_add_admin_bar('Opciones'); // Parent item
    orbisius_child_theme_creator_add_admin_bar('Documentacion', 'some_link_to_the_settings', 'Opciones');
    orbisius_child_theme_creator_add_admin_bar('Link del sitio WEB', 'some_link_to_the_settings', 'Opciones');
    orbisius_child_theme_creator_add_admin_bar('Link del sitio WEB', 'some_link_to_the_settings', 'Documentacion');
}

/**
 * Add's menu parent or submenu item.
 * @param string $name the label of the menu item
 * @param string $href the link to the item (settings page or ext site)
 * @param string $parent Parent label (if creating a submenu item)
 *
 * @return void
 * @author Slavi Marinov <http://orbisius.com>
 * */
function orbisius_child_theme_creator_add_admin_bar($name, $href = '', $parent = '', $custom_meta = array()) {
   /* global $wp_admin_bar;

    if (!is_super_admin()
            || !is_admin_bar_showing()
            || !is_object($wp_admin_bar)
            || !function_exists('is_admin_bar_showing')) {
        return;
    }

    // Generate ID based on the current filename and the name supplied.
    $id = str_replace('.php', '', basename(__FILE__)) . '-' . $name;
    $id = preg_replace('#[^\w-]#si', '-', $id);
    $id = strtolower($id);
    $id = trim($id, '-');

    $parent = trim($parent);

    // Generate the ID of the parent.
    if (!empty($parent)) {
        $parent = str_replace('.php', '', basename(__FILE__)) . '-' . $parent;
        $parent = preg_replace('#[^\w-]#si', '-', $parent);
        $parent = strtolower($parent);
        $parent = trim($parent, '-');
    }

    // links from the current host will open in the current window
    $site_url = site_url();

    $meta_default = array();
    $meta_ext = array( 'target' => '_blank' ); // external links open in new tab/window

    $meta = (strpos($href, $site_url) !== false) ? $meta_default : $meta_ext;
    $meta = array_merge($meta, $custom_meta);

    $wp_admin_bar->add_node(array(
        'parent' => $parent,
        'id' => $id,
        'title' => $name,
        'href' => $href,
        'meta' => $meta,
    ));*/
}


add_action( 'init', 'create_custom_post_type' );
 
function create_custom_post_type() {
 
   /* $labels = array(
        'name' => __( 'Noticias' ),
        'singular_name' => __( 'Tax Lien' ),
        'all_items' => __('Todas las noticias'),
        'add_new' => _x('Agregar nueva Noticia', 'Tax Liens'),
        'add_new_item' => __('Add new Tax Lien'),
        'edit_item' => __('Edit Tax Lien'),
        'new_item' => __('New Tax Lien'),
        'view_item' => __('View Tax Lien'),
        'search_items' => __('Search in Tax Liens'),
        'not_found' =>  __('No Tax Liens found'),
        'not_found_in_trash' => __('No Tax Liens found in trash'), 
        'parent_item_colon' => ''
    );
 
    $args = array (
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => '',
        'rewrite' => array('slug' => 'taxlien'),
        'taxonomies' => array( 'category', 'post_tag' ),         
        'query_var' => true,                
        'supports'    => array( 'genesis-cpt-archives-settings', 'thumbnail' , 'custom-fields', 'excerpt', 'comments', 'title', 'editor' ),
        'menu_position' => 5
 
    );
 
    register_post_type( 'tax_lien',$args);   */ 
}







function custom_menu_order($menu_ord) {  
    if (!$menu_ord) return true;  

    return array(  
        'index.php', // Dashboard  
        'separator1', // First separator  
        'edit.php', // Posts  
        'upload.php', // Media  
        'link-manager.php', // Links  
        'edit.php?post_type=page', // Pages  
        'edit-comments.php', // Comments  
        'separator2', // Second separator  
        'themes.php', // Appearance  
        'plugins.php', // Plugins  
        'users.php', // Users  
        'tools.php', // Tools  
        'options-general.php', // Settings  
        'separator-last', // Last separator  
    );  
}  
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order  
add_filter('menu_order', 'custom_menu_order');  




/*add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
    add_menu_page( 'custom menu title', 'custom menu', 'manage_options', 'myplugin/myplugin-admin.php', '', plugins_url( 'myplugin/images/icon.png' ), 6 );
}*/



//http://snippets.webaware.com.au/snippets/add-an-external-link-to-the-wordpress-admin-menu/
//http://wordpress.stackexchange.com/questions/69925/how-to-use-a-wordpress-existing-admin-icon

function custom_admin_logo() {?>
        <style type="text/css">
        
 		#wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before {
			content: '' !important;
		}

		#wp-admin-bar-wp-logo a[aria-haspopup=true]{
			background: url("http://zoppagency.com/ZOPP/o.png");
			background-size: 43px;
		}
		
		li#wp-admin-bar-wp-logo:hover a[aria-haspopup=true]{
		    background: url("http://zoppagency.com/ZOPP/o.png");
			background-size: 43px;
		}
		
		#toplevel_page_options-general{
	        position: absolute;
	        top: 747px;
	        width: 100%;
        }
        
        #collapse-menu {
            display: none;
        }
       
        </style>
<?php }
add_action('admin_head', 'custom_admin_logo');

add_action('admin_menu', function() {
    global $submenu; 
    global $menu;
    global $wp_admin_bar;
    $menu = array();
   // $submenu = array();
   

    $submenu['edit.php'] = array();
    add_menu_page( 'custom menu title', 'Articulos', 'manage_options', 'edit.php', '', screen_icon('edit') ,66 );
    $submenu['edit.php'][] = array('Todos los Articulos', 'manage_options', "edit.php");
    $submenu['edit.php'][] = array('Nuevo Articulo', 'manage_options', "post-new.php");
    $submenu['edit.php'][] = array('Categorias', 'manage_options', "edit-tags.php?taxonomy=category");
    $submenu['edit-tags.php?taxonomy=category'][] = array('Categorias', 'manage_options', "edit-tags.php?taxonomy=category7s");
    
    
    $submenu['edit.php?post_type=page'] = array();
    add_menu_page( 'custom menu title', 'P&aacute;ginas', 'manage_options', 'edit.php?post_type=page', '', screen_icon('edit'), 50 );
    $submenu['edit.php?post_type=page'][] = array('Todos las P&aacute;ginas', 'manage_options', "edit.php");
    $submenu['edit.php?post_type=page'][] = array('Añadir Nueva P&aacute;gina', 'manage_options', "post-new.php?post_type=page");
    
    
    $submenu['upload.php'] = array();
    add_menu_page( 'custom menu title', 'Multimedia', 'manage_options', 'upload.php', '', screen_icon('edit'), 30 );
    $submenu['upload.php'][] = array('Ver Todo', 'manage_options', "upload.php");
    $submenu['upload.php'][] = array('Añadir Nuevo', 'manage_options', "media-new.php");
    
    
    add_menu_page( 'custom menu title', 'Bloques', 'manage_options', 'widgets.php', '', screen_icon('edit'),37 );
    

    $submenu["edit-comments.php"] = array();    
    add_menu_page( 'custom menu title', 'Comentarios', 'manage_options', 'edit-comments.php', '', screen_icon('edit'), 37 );
    $submenu['edit-comments.php'][] = array('Todos los Comentarios', 'manage_options', "edit.php");
    
    
    add_menu_page( 'custom menu title', 'Avanzado', 'manage_options', 'options-general.php', '', screen_icon('edit'), 88 );
    $submenu['options-general.php'][] = array('Acerca de Zopp', 'manage_options', "admin.php?page=zopp");
    
?>
    <script type="text/javascript">
        console.log(<?php echo json_encode($menu); ?>);
        console.log(<?php echo json_encode($submenu); ?>);
        console.log(<?php echo json_encode($wp_admin_bar); ?>);
    </script>
<?php
    
});
 
/**
* add external link to Tools area
*/
function example_admin_menu() {
    global $submenu;
    $url = 'http://www.example.com/';
    $submenu['tools.php'][] = array('Example', 'manage_options', $url);
}


/**** Agrega la pagina adminsitrativa de zopp ****/
add_action( 'admin_menu', 'register_newpage' );

function register_newpage(){
    add_submenu_page( 
          null   //or 'options.php' 
        , 'My Custom Submenu Page' 
        , 'My Custom Submenu Page'
        , 'manage_options'
        , 'zopp'
        , 'custom'
    );
}

function custom(){?>
<style type="text/css">
    .section {
    float: left;
    width: 48%;
    float: left;
    margin: 1%;
    position:relative;
}
.zopp_container {
    max-width: 1360px;
    width:100%;
}

.iframe_content iframe {
    width: 100%;
    min-height: 489px;
    /*-webkit-filter: blur(2px); 
    -moz-filter: blur(2px); 
    -o-filter: blur(2px); 
    -ms-filter: blur(2px); 
    filter: blur(2px);*/
}

.mask-hover {
    background: rgba(9, 9, 9, 0.3);
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-filter: blur(2px); 
    -moz-filter: blur(2px); 
    -o-filter: blur(2px); 
    -ms-filter: blur(2px); 
    filter: blur(2px);
    z-index: 1;
}
.iframe_content {
    position: relative;
}
.label_form {
    font-size: 17px;
}
.control_form input {
    width: 230px;
}
.control_form {
    margin-top: 10px;
    margin-bottom: 12px;
}

.colum_50 {
    width: 50%;
    float: left;
    position: relative;
}

h1.big_text {
    margin-bottom: 40px;
    font-size:36px;
    line-height: 1.04;
}

.section_cotizacion {
width: 20% !important;
}

.section_soporte {
width: 70% !important;
}

.flotante{
    float: left;
    width: 100%;
    max-width: 1360px;
}

@media only screen and (max-width:1280px){
    
    .section_cotizacion {
        width: 100% !important;
    }

.section_soporte {
    width: 100% !important;
    }
    
    .control_form input {
        width: 95% !important;
    }
    
}

.square {
    width: 91px;
    float: left;
    position: relative;
    margin: 5px;
    text-align: center;
}

.square p {
    font-size: 24px;
    color:#fff;
}

.one{
    background: #C80082;
}

.two{
    background: #D8502D;
}

.three{
    background: #94D14E;
}

.four{
    background: #31CAE7;
}

.menssage {
    float: left;
    position: relative;
    margin: 5px;
    text-align: center;
    background:#FFCA28;
}

.menssage p {
    font-size: 24px;
    color: #fff;
}

.logo_zopp {
}

.content_sup {
    width: 100%;
    float: left;
    text-align: center;
    margin-top: 8px;
    margin-bottom: 1px;
}

.search_support {
    /* background: red; */
    width: 56%;
    height: 82px;
    font-size: 34px;
}

.search_button {
    /* background: red; */
    width: 11%;
    height: 44px;
}

.section_base_conocimiento {
float: left;
width: 100%;
}

.form_name {
    width: 70%;
    float: left;
}
.form_button {
    width: 20%;
    float: left;
}
.form_name input {
    width: 100%;
}
.form_button input {
    width: 90%;
    margin: 4%;
    height: 68px;
}

.textframe_caption {
    width: 100%;
    float: left;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  
<script type="text/javascript">

var availableTags = [
    "Mejoramiento del sitio web actual",
    "Desarrollo de un sitio web nuevo",
    "Campaña de Pauta Digital",
    "Consultoria para la implementacion de un software",
    "Adquisicion de Hosting", 
    "Compra de dominio",
    "Correos Corporativos"
    ];
    

    
$(document).ready(function(){

  $.ajax({
            type: "GET",
            url: 'http://zoppagency.com/ZOPP/services.txt',
            data: null,
            success: function (dataCheck) {
                alert(dataCheck);
            }
        });
        
        $(".search_button").click(function(){
        
            /*$(".link_support").attr("href",
                                    "https://zoppagency.zendesk.com/hc/es/search?utf8=%E2%9C%93&query="+ $(".search_support").val() + "&commit=Buscar" 
                                    );*/
            
            window.open("https://zoppagency.zendesk.com/hc/es/search?utf8=%E2%9C%93&query="+ $(".search_support").val() + "&commit=Buscar", '_blank');
            
            //$(".link_support").click();
            
        });
                
$( ".servicio" ).autocomplete({
      source: availableTags
    });
    
$(".cuando").datepicker();
    
       $(".for_sub").submit(function(e){
            e.preventDefault();
                var servivio = $(".servicio").val(); 
                var cuando = $(".cuando").val(); 
                var mensaje = $(".message").val()
                var presupuesto = $(".presupuesto").val(); 
                var name = $(".name").val();
                var correo = $(".correo").val();
                
                var params = {
                  "icon": "http://i.ytimg.com/vi/uTq6eBRFqzQ/maxresdefault.jpg",
                  "activity": "Cotizacion",
                  "title": "Solicitud Cotizacion",
                  "body": "> Servicio:" + servivio + " \n > Cuando:" + cuando + " \n > Mensaje: " + mensaje + " \n > Presupuesto: " + presupuesto + " \n > Nombre:" + name + "  \n > Correo:" + correo
                }

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: 'https://hooks.glip.com/webhook/f093ab68-1753-419d-9737-1e53b2fcb634',
                    contentType: "application/json",
                    data: JSON.stringify(params),
                    success: function (dataCheck) {
                    }
                });
                return false;
        }); 
});

</script>

<div class="content_sup">
    <img src="http://www.zoppagency.com/ZOPP/img/logo_cuadrado.png?v=3" class="logo_zopp">
</div>


<div class="updated flotante">
    <div class="square one">
        <p>Que</p>
    </div>
    <div class="square two">
        <p>Bueno</p>
    </div>
    <div class="square three">
        <p>Que</p>
    </div>
    <div class="square four">
        <p>Volviste</p>
    </div>
    <div class="menssage">
        <p> "A barriga Llena Corazon Contento" </p>
    </div>
</div>
 

<form class="for_sub">
<div class="zopp_container">

     <div class="section_base_conocimiento">
        <h1 class="big_text">Busca en nuestra Documentacion</h1>
        <div class="textframe_caption">
        
        <div class="form_name">
            <input type="text" name="" class="search_support" placelholder="busca Aca"/>
        </div>
        <div class="form_button">
             <input type="button" value="buscar" class="search_button"/>
        </div>
        
            
           
        </div>
        <a href="http://example.com" target="_blank" class="link_support">&nbsp;</a>
    </div>

    <div class="section section_cotizacion">
        <h1 class="big_text">Solicitar Cotizacion</h1>
        <div class="form_content">
        
            <div class="row">
                <div class="label_form">
                    Servicio a solicitar.
                </div>
                <div class="control_form">
                    <input type="text" class="servicio"/>
                </div>
            </div>
            
            <div class="row">
                <div class="label_form">
                   Cuando debe de estar Listo.
                </div>
                <div class="control_form">
                    <input type="text" class="cuando"/>
                </div>
            </div>
                        
            <div class="row">
                <div class="label_form">
                   Presupuesto
                </div>
                <div class="control_form">
                    <input type="text" class="presupuesto"/>
                </div>
            </div>
            
            <div class="row">
                    <div class="label_form">
                       Nombre
                    </div>
                    <div class="control_form">
                        <input type="text" class="name"/>
                    </div>
            </div>    
            
            <div class="row">
                    <div class="label_form">
                       Correo
                    </div>
                    <div class="control_form">
                        <input type="text" class="correo"/>
                    </div>
                
            </div>
            
            <div class="row">
                <div class="label_form">
                   Mensaje
                </div>
                <div class="control_form">
                     <textarea class="message">
                         df   
                     </textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="control_form">
                    <input type="submit" value="enviar"/>
                </div>
            </div>
            
            
        </div>
    </div>
    <div class="section section_soporte">
        <h1 class="big_text">Soporte Premiun</h1>
        <div class="iframe_content">
            <!--<div class="mask-hover">&nbsp;</div>-->
            <iframe id="zenbox_body" frameborder="0" scrolling="auto" allowtransparency="true" src="https://zoppagency.zendesk.com/account/dropboxes/20130635?x=1"></iframe>
        </div>
    </div>
    
    
</div>
</form>

<?php
}