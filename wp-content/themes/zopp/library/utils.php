<?php

function ibfy_post_image() {
global $post;
 //QUE TODOS LOS POST TENGAN LA IMAGEN DESTACADA -- COMO CREAR IMAGEN SIZE CUSTOM
    //setup thumbnail image args to be used with genesis_get_image();rein
    $size = 'post-image'; // Change this to whatever add_image_size you want
    $default_attr = array(
            'class' => "alignleft attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
        );
 
    // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
    if ( has_post_thumbnail()) {
        echo  genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) );
    }
}

function content($num) {
	$theContent = get_the_content();
	$output = preg_replace('/<img[^>]+./','', $theContent);
	$output = preg_replace( '/<blockquote>.*<\/blockquote>/', '', $output );
	$output = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );
	$limit = $num+1;
	$content = explode(' ', $output, $limit);
	array_pop($content);
	$content = implode(" ",$content)."...";
	echo $content;
}

function poweredby() {
	echo "<div class='clear clearfix'> </div>";
	$zopp = file_get_contents("http://www.zoppagency.com/poweredbyzopp/powered.php");
	echo ($zopp); 
}
 
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if ( !is_page() ) {
    $post_meta = '[post_categories before="Categoria : "] [post_tags before="Tagged: "]';
    return $post_meta;
}} 
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );


add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
    $post_info = '[post_date] Creado por [post_author_posts_link] [post_comments zero="Dejar un comentario" one="1 Comment" more="% Comments"] [post_edit] ';
    return $post_info;
}
 
add_filter ( 'genesis_newer_link_text' , 'custom_new_link_text' );
function custom_new_link_text ( $text ) {
    $text = '� P&aacute;gina anterior';
    return $text;
}
 
 
 
 
remove_action('genesis_loop_else', 'genesis_do_noposts');
add_action('genesis_loop_else', 'genesis_nopostspanis');
/**
 * No Posts
 */
function genesis_nopostspanis() {
 
  echo '<p>No se encontraron articulos en esta categoria.</p>';
 
}
 
 
 
 
/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'child_viewport_meta_tag' );
function child_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}
 
 
 
 
/** Modify the WordPress read more link */
add_filter( 'the_content_more_link', 'custom_read_more_link' );
function custom_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">Mas informaci�n</a>';
}
 
 
 
 
add_filter( 'genesis_breadcrumb_args', 'child_breadcrumb_args' );
/**
 * Amend breadcrumb arguments.
 * 
 * @author Gary Jones
 *
 * @param array $args Default breadcrumb arguments
 * @return array Amended breadcrumb arguments
 */
function child_breadcrumb_args( $args ) {
    $args['home']                    = 'Inicio';
    $args['sep']                     = ' / ';
    $args['list_sep']                = ', '; // Genesis 1.5 and later
    $args['prefix']                  = '<div class="breadcrumb">';
    $args['suffix']                  = '</div>';
    $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
    $args['heirarchial_categories']  = true; // Genesis 1.5 and later
    $args['display']                 = true;
    $args['labels']['prefix']        = 'Usted esta en : ';
    $args['labels']['author']        = 'Art&iacute;culos para ';
    $args['labels']['category']      = 'Art&iacute;culos para '; // Genesis 1.6 and later
    $args['labels']['tag']           = 'Art&iacute;culos para ';
    $args['labels']['date']          = 'Art&iacute;culos para ';
    $args['labels']['search']        = 'B&uacute;squeda para ';
    $args['labels']['tax']           = 'Art&iacute;culos para ';
    $args['labels']['post_type']     = 'Art&iacute;culos para ';
    $args['labels']['404']           = 'No se encontraron resulados: '; // Genesis 1.5 and later
    return $args;
}

function registerWidget($name="", 
						  $id="", 
						  $description="",
						  $before_widget='<div id="%1$s"><div class="widget %2$s">',
						  $after_widget='</div></div>\n',
						  $before_title='<h4><span>',
						  $after_title='</span></h4>\n'
						  ){

	register_sidebar(array(
		'name'=>$name,
		'id' => $id,
		'description' => $description,
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title
	));

} 

register_widgets();
 

 
?>