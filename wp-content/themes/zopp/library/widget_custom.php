<?php
	// Creating the widget 
	/*
    <div class="row">
        <div class="item-body col-md-12 column">
            <div class="image-banner">
                 <img src="http://citricaldas.com.co/wp-content/themes/citricaldas/library/images/bannerfruits.png">
            </div>
        </div>
    </div>  
	*/
	
	class wpb_widget extends WP_Widget {

	function __construct() {
	parent::__construct(
	'wpb_widget', 
	__('Zopp Publicidad', 'wpb_widget_domain'), 
	array( 'description' => __( 'Escoja su publicidad que quiere mostrarse en el sitio web', 'wpb_widget_domain' ), ) 
	);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
		
		//echo $args['before_widget'];

		 //if (!empty($title)){
			// echo $args['before_title'] . $title . $args['after_title'];
		 //}
		
		if (!empty($show_info)){
		
			$args = array(
				'post_type' => 'post',
				'p' => (int)esc_attr($show_info),
			);
			$url = "";
			$the_query = new WP_Query( $args );
			if ($the_query->have_posts()) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
					$ruta_img = get_field("href");
				}
			}
			wp_reset_postdata();
			?>
				<div class="row">
					<div class="item-body col-md-12 column">
						<div class="image-banner">
							<a target="_blank" href="<?php echo $ruta_img; ?>">
								<img src="<?php echo $url; ?>">
							</a>
						</div>
					</div>
				</div>
			<?php
		}
			
			//echo $args['after_widget'];
		}
			
	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
		
		if ( isset( $instance[ 'show_info' ] ) ) {
			$show_info = $instance[ 'show_info' ];
		}
		else {
			$show_info = __( 'Conten id goes here', 'wpb_widget_domain' );
		}

	?>
	<p>
		<script type="text/javascript">
			function changelabel(){
				var s = jQuery("#publicity_loop").val();;
				console.log(s);
				jQuery(".input_selected_").val(""+s);
			}		
		</script>
	<!--
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	-->	
		<div><label for="publicity_loop">Lista de Post</label></div>
		<?php
		
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 99,
			'order'          => 'DESC',
			'orderby'        => 'date',
			'post_status'    => 'publish',
			'category_name' => 'publicidad'
		);
				
		$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				echo '<div>';
				echo '<select onblur="changelabel()" id="publicity_loop">';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
				}
				echo '</select>';
				echo '</div>';
			} else {
				echo "<b>No hay post de categoria publicidad porque no intentas Agregar uno?</b>";
			}
		wp_reset_postdata();
		?>
		<?php
			$args = array(
				'post_type' => 'post',
				'p' => (int)esc_attr($show_info),
			);		
			$url = "";
			$the_query = new WP_Query( $args );
			if ($the_query->have_posts()) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
				}
			}
			wp_reset_postdata();
		?>
		<div>Preview:</div>
		<input class="widefat input_selected_" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'show_info' ); ?>" type="hidden" value="<?php echo esc_attr( $show_info ); ?>" />
		<?php if($url!=""){ ?>
			<img style="width:100%" src="<?php echo $url; ?>" class="full-preview-image">
		<?php }else{ ?>
				<b>Not Image Available Yet</b>
		<?php } ?>
	</p>
	<?php 
	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['show_info'] = (!empty($new_instance['show_info'])) ? strip_tags($new_instance['show_info']) : '';
			return $instance;
		}
	} 
	
	
	function wpb_load_widget() {
		register_widget( 'wpb_widget' );
	}
	
	add_action( 'widgets_init', 'wpb_load_widget' );
?>