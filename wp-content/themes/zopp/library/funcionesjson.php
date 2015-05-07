<?php

function pagination($prev = '«', $next = '»') {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'type' => 'plain'
);
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
    return paginate_links( $pagination );
}

// Esta funcion retorna un array objeto con el menu de wordpress por id
function get_menu_json_args_by_id($id_menu="")
{
      if($id_menu == '')
        {
            $id_menu = $_POST['id_menu'];
        }
        
        $args = array(
            'order'                  => 'ASC',
            'orderby'                => 'menu_order',
            'post_type'              => 'nav_menu_item',
            'post_status'            => 'publish',
            'output'                 => ARRAY_A,
            'output_key'             => 'menu_order',
            'nopaging'               => true,
            'update_post_term_cache' => false 
        );
        $items = wp_get_nav_menu_items($id_menu,$args);
        echo json_encode($items);
       die();
}
add_action('wp_ajax_get_menu_json_args_by_id', 'get_menu_json_args_by_id');
add_action('wp_ajax_nopriv_get_menu_json_args_by_id', 'get_menu_json_args_by_id');
// Funcion que retorna un menu en html recibe en nombre del menu en wordpress y la clase css
function get_html_normal_menu($nombre="",$clase="")
{
    if($nombre == '')
    {
        $nombre = $_POST['nombre'];
    }
    if ($clase == '')
    {
        $clase = $_POST['clase'];
    }
    $defaults = array(
    'theme_location'  => '',
    'menu'            => $nombre,
    'container'       => 'div',
    'container_class' => '',
    'container_id'    => '',
    'menu_class'      => $clase,
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
    );
    wp_nav_menu( $defaults );
    die();
}
add_action('wp_ajax_get_html_normal_menu', 'get_html_normal_menu');
add_action('wp_ajax_nopriv_get_html_normal_menu', 'get_html_normal_menu');
//por palabra,categoria,limite
function obtener_post_por_palabra_categoria_limite($palabra="",$categoria="",$limite="")
{
    if($palabra == '')
    {
        $palabra = $_POST['palabra'];
    }
    if ($categoria == '')
    {
        $categoria = $_POST['categoria'];
    }
        if ($limite == '')
    {
        $limite = $_POST['limite'];
    }
    $args = array(
    'posts_per_page' => $limite,
    'post_type' => 'post',
    'category_name' => $categoria,
    'orderby' => 'name',
    'order' => 'ASC',
    's' => $palabra, 
    );
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) {
           
        $datos = array();
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
             $datos[] = datosloop($the_query);
       
        }
        echo json_encode($datos);
        die();
       
    } else {
            $respuesta = array('respuesta' => 0,'respuestatexto' => 'No se encontro ningun parametro');
            echo json_encode($respuesta);
            die();
    }
    
    /* Restore original Post Data */
    wp_reset_postdata();
}
add_action('wp_ajax_obtener_post_por_palabra_categoria_limite', 'obtener_post_por_palabra_categoria_limite');
add_action('wp_ajax_nopriv_obtener_post_por_palabra_categoria_limite', 'obtener_post_por_palabra_categoria_limite');
//obtener todas las categorias desendientes de una categoria por json
function obtener_todas_categorias_desendientes($id_categoria="")
{
    if($id_categoria == '')
    {
        $id_categoria = $_POST['id_categoria'];
    }
    $argumentobusca = array(
      'orderby' => 'name',
      'parent' => $id_categoria
      );
    $categoryagarrada = get_categories( $argumentobusca );
    
    $arrayjs = array();
    for ($i=0; $i < count($categoryagarrada); $i++) { 
        $arrayjs[] = array('id' => $categoryagarrada[$i]->slug,'nombre' => $categoryagarrada[$i]->name, 'slug' => $categoryagarrada[$i]->slug);
        
    }
    echo json_encode($arrayjs);
    die();
}
add_action('wp_ajax_obtener_todas_categorias_desendientes', 'obtener_todas_categorias_desendientes');
add_action('wp_ajax_nopriv_obtener_todas_categorias_desendientes', 'obtener_todas_categorias_desendientes');
//esta funcion retorna un json con los datos de los post recibe un id de post
function select_post_id($id="")
{   
    if($id == '')
    {
        $id = $_POST['id'];
    }
    if (is_numeric($id)) {
        $args = array(
            'post_type' => 'post',
            'p' => $id,
            'posts_per_page' => -1  
        );
    }
    else
    {   
        $args = array(
           'post_type' => 'post',
            'p' => $id,
            'posts_per_page' => -1  
        );
    }
   
    // The Query
    $the_query = new WP_Query( $args );
    // The Loop
    if ( $the_query->have_posts() ) {
           
        $datos = array();
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
             $datos[] = datosloop($the_query);
     
        
        }
        echo json_encode($datos);
        die();
       
    } else {
            $respuesta = array('respuesta' => 0,'respuestatexto' => 'No se encontro ningun parametro');
            echo json_encode($respuesta);
            die();
    }
    
    /* Restore original Post Data */
    wp_reset_postdata();
    
}
add_action('wp_ajax_select_post_id', 'select_post_id');
add_action('wp_ajax_nopriv_select_post_id', 'select_post_id');
//esta funcion retorna un json con los datos de los post recibe un id o slug de categorial
function select_post_cat_slug($slugorid="",$limite ="",$ajax="")
{   
    if($slugorid == '')
    {
        $slugorid = $_POST['slugorid'];
    }
    if($limite == '')
    {
        $limite = $_POST['limite'];
    }
      if($ajax == '')
    {
        $ajax = $_POST['ajax'];
    }
    if (is_numeric($slugorid)) {
        $args = array(
            'post_type' => 'post',
            'cat' => $slugorid,
            'posts_per_page' => $limite
        );
    }
    else
    {   
        $args = array(
            'post_type' => 'post',
            'category_name' =>  $slugorid,
            'posts_per_page' => $limite,
			'paged' => 1
        );
    }
   
    // The Query
    $the_query = new WP_Query( $args );
    // The Loop
    if ( $the_query->have_posts() ) {
           
        $datos = array();
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
             $datos[] = datosloop($the_query);
        
        }
         if($ajax == 1){
              echo  json_encode($datos);
            }
            else{
                return $datos;
            }
            die();
        die();
       
    } else {
            $respuesta = array('respuesta' => 0,'respuestatexto' => 'No se encontro ningun parametro');
            

            if($ajax == 1){
              echo  json_encode($respuesta);
            }
            else{
                return $respuesta;
            }
            die();
    }
    
    /* Restore original Post Data */
    wp_reset_postdata();
    
}
add_action('wp_ajax_select_post_cat_slug', 'select_post_cat_slug');
add_action('wp_ajax_nopriv_select_post_cat_slug', 'select_post_cat_slug');
//function obtener tipos de imagen por id de la imagen
function get_rutas_imagen_id_img($id_imagen)
{
    $imagenes = array();
    for ($i=0; $i < count($id_imagen); $i++) { 
        $attachment = get_post( $id_imagen[$i] );
        
        $imagenes[] = array(
            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'title' => $attachment->post_title,
            'leyenda' => $attachment->post_excerpt,
            'descripcion' => $attachment->post_content,
            'urlfull' => wp_get_attachment_image_src( $attachment->ID,  'full'),
            'urlmedium' => wp_get_attachment_image_src( $attachment->ID, 'medium'),
            'urlthumnail' => wp_get_attachment_image_src( $attachment->ID, 'thumbnail')
        );
        
    }
    
    return $imagenes;
}
//obtener json con todos las imagenes por el id del post
function obtener_imagenes_post_por_post_id($postid="")
{   
    if($postid == '')
    {
        $postid = $_POST['postid'];
    }
    $args = array(
    'post_type' => 'attachment',
    'numberposts' => null,
    'post_status' => null,
    'post_parent' => $postid,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => -1  
    );
    $attachments = get_posts($args);
    
    if ($attachments) {
        $contador = 1;
        foreach ($attachments as $attachment) {
                            
                            if($contador == 1)
                            {
                              $fotos = array(array('id' => $attachment->ID,'titulo'=>  $attachment->post_title, 'ruta'=> $attachment->guid));
                            }
                            else
                            {
                              $fotos2  = array(array('id' => $attachment->ID,'titulo'=>  $attachment->post_title, 'ruta'=> $attachment->guid));
                              $fotos = array_merge($fotos,$fotos2);
                            }
                                
         $contador++;
        }
         
    }
    echo json_encode($fotos);
    die();
}
add_action('wp_ajax_obtener_imagenes_post_por_post_id', 'obtener_imagenes_post_por_post_id');
add_action('wp_ajax_nopriv_obtener_imagenes_post_por_post_id', 'obtener_imagenes_post_por_post_id');
//funcion para consultar una galeria con el contenido de un post o custom field recibe un shortcode devuelve array con ids
function galeria_por_contenido_tipo_shortcode($ids_images)
{
     $galleries = array();
            if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $ids_images, $matches, PREG_SET_ORDER ) ) {
                   foreach ( $matches as $shortcode ) {
                            if ( 'gallery' === $shortcode[2] ) {
                                    $srcs = array();
                                    $count = 1;
    
                                    $gallery = do_shortcode_tag( $shortcode );
                                   
                               
                                            preg_match_all( '#src=([\'"])(.+?)\1#is', $gallery, $src, PREG_SET_ORDER );
                                            if ( ! empty( $src ) ) {
                                                    foreach ( $src as $s )
                                                            $srcs[] = $s[2];
                                            }
    
                                            $data = shortcode_parse_atts( $shortcode[3] );
                                            $data['src'] = array_values( array_unique( $srcs ) );
                                            $galleries[] = $data;
                                    
                            }
                    }
            }
    
            /**
             * Filter the list of all found galleries in the given post.
             *
             * @since 3.6.0
             *
             * @param array   $galleries Associative array of all found post galleries.
             * @param WP_Post $post      Post object.
             */
             $soloids = apply_filters( 'get_post_galleries', $galleries, $post );
             $soloids = $soloids[0]['ids'];
             return explode(',', $soloids);
}
/* FUNCIONES DE WOOCOMERCE */
function consultar_productos()
{
     $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1  
        );
    // The Query
    $the_query = new WP_Query( $args );
    // The Loop
    if ( $the_query->have_posts() ) {
           
        $datos = array();
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
          $datos[] = datosloop($the_query);
        
        }
        echo json_encode($datos);
        die();
       
    } else {
            $respuesta = array('respuesta' => 0,'respuestatexto' => 'No se encontro ningun parametro');
            echo json_encode($respuesta);
            die();
    }
    
    /* Restore original Post Data */
    wp_reset_postdata();
}
add_action('wp_ajax_consultar_productos', 'consultar_productos');
add_action('wp_ajax_nopriv_consultar_productos', 'consultar_productos');
function consultar_productos_destacados()
{
     $args = array(
            'post_type' => 'product',
            'meta_key' => '_featured',  
            'meta_value' => 'yes',  
            'posts_per_page' => -1  
             
        );
    // The Query
    $the_query = new WP_Query( $args );
    // The Loop
    if ( $the_query->have_posts() ) {
           
        $datos = array();
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
               $datos[] = datosloop($the_query);
        
        }
        echo json_encode($datos);
        die();
       
    } else {
            $respuesta = array('respuesta' => 0,'respuestatexto' => 'No se encontro ningun parametro');
            echo json_encode($respuesta);
            die();
    }
    
    /* Restore original Post Data */
    wp_reset_postdata();
}
add_action('wp_ajax_consultar_productos_destacados', 'consultar_productos_destacados');
add_action('wp_ajax_nopriv_consultar_productos_destacados', 'consultar_productos_destacados');
/* FIN FUNCIONES DE WOOCOMERCE */
/* Funciones no json */
function datosloop($the_query)
{   
        $id = get_the_ID();
        $titulo = get_the_title();
        $contenidoinicial = get_the_content('');
        
        $contenidocomleto = $the_query->post->post_content;
        $content = apply_filters( 'the_content', $contenidocomleto );
        $contenidocomleto = str_replace( ']]>', ']]&gt;', $content );
        $urlfull = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
        $urlmedium = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'medium' );
        $urlthumnail = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'thumbnail' );
        $permalink = get_permalink( $id );
        $fecha = get_the_date();
        $custom_fields = get_post_custom($id);
        $author = get_the_author();

        ob_start();
            the_excerpt();
        $excerpt =  ob_get_clean();

		$commentNumber = get_comments_number($id); 
		$t = wp_get_post_tags($id);
		
        if ( has_shortcode( $contenidoinicial, 'gallery' ) ) { 
            $datagallery = array();
            $galeria = galeria_por_contenido_tipo_shortcode($contenidoinicial);
            for ($i=0; $i < count($galeria); $i++) { 
               $datagallery[] = array(
                                      'titulo' => get_the_title($galeria[$i]),
                                      'url' => wp_get_attachment_image_src($galeria[$i],"full")
                                     );
            }

        }else{
            $datagallery = false;
        }


        

        //$custom_fields = get_post_custom($id);
        //$camporeferencia = $custom_fields['Referencia'][0];
       
        return array('id' => $id ,'tags' => $t, 'ncomment'=> $commentNumber, 'resumen' => $excerpt, 'autor' => $author, 'titulo' => $titulo, 'galeria' => $datagallery, 'contenidoinicial' => $contenidoinicial , 'contenidocomleto' => $contenidocomleto , 'urlimg' => $urlfull , 'urlimgmedium' => $urlmedium , 'urlthumnail' => $urlthumnail , 'link' => $permalink,'custom_fields' => $custom_fields,'fecha_post' => $fecha);
         
}
//obtener el id de la categoria actual
function getCurrentCatID(){
    global $wp_query;
    if(is_category() || is_single()){
        $cat_ID = get_query_var('cat');
    }
    return $respuesta = array('Cat_Id' =>  $cat_ID );
   
    
}
add_action('wp_ajax_getCurrentCatID', 'getCurrentCatID');
add_action('wp_ajax_nopriv_getCurrentCatID', 'getCurrentCatID');
//obtener el slug de la categoria del post actual
function getCurrentpostslugcat(){
    $id = get_the_id();
    $slug_cat = get_the_category($id);
    return $slug_cat[0]->slug;
    
}
add_action('wp_ajax_getCurrentpostslug', 'getCurrentpostslug');
add_action('wp_ajax_nopriv_getCurrentpostslug', 'getCurrentpostslug');
//obtener el numero de la pagina actual
function paginaactual(){
        global $wp_query;
        return $respuesta = array('paged' => get_query_var('paged'));
        //echo json_encode($respuesta);
        //die();
}
add_action('wp_ajax_paginaactual', 'paginaactual');
add_action('wp_ajax_nopriv_paginaactual', 'paginaactual');
        
/* fin funcion es no json*/
?>