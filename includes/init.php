<?php



// load the CSS files: FE
function bcssel_fe_css() {
    wp_enqueue_style( 'bcssel-style', plugin_dir_url( __DIR__ ).'assets/bcssel.css' );
}
add_action('wp_enqueue_scripts', 'bcssel_fe_css', 50);

// load the CSS files: BE
function bcssel_be_css() {
  wp_enqueue_style('bcssel-style', plugin_dir_url( __DIR__ ).'assets/bcssel-admin.css');
}
add_action('admin_enqueue_scripts', 'bcssel_be_css');


// Create the custom post type
function bcssel_cpt_events() {
    $slug = 'bcssel_events';
    $name = __('Event','bcssel'); // singular
    $name_p = __('Events','bcssel'); ; // pleural
    $icon = 'dashicons-calendar-alt';
    $pos = 20;
    $show = true;
    $tax = array(  );
    $supports = array( 'title', 'editor', 'thumbnail' );

    $labels = array(
		'name'               => _x( $name_p, 'post type general name', 'bcssel' ),
		'singular_name'      => _x( $name, 'post type singular name', 'bcssel' ),
		'menu_name'          => _x( $name_p, 'admin menu', 'bcssel' ),
		'name_admin_bar'     => _x( $name, 'add new on admin bar', 'bcssel' ),
		'add_new'            => _x( 'New', 'plugins', 'bcssel' ),
		'add_new_item'       => __( 'New Event', 'bcssel' ),
		'new_item'           => __( 'New Event', 'bcssel' ),
		'edit_item'          => __( 'Edit Event', 'bcssel' ),
		'view_item'          => __( 'View Event', 'bcssel' ),
		'all_items'          => __( 'All Events', 'bcssel' ),
		'search_items'       => __( 'Search Events', 'bcssel' ),
		'parent_item_colon'  => __( 'Parent Event:', 'bcssel' ),
		'not_found'          => __( 'No events found.', 'bcssel' ),
		'not_found_in_trash' => __( 'No events found in trash.', 'bcssel' )
    );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => $show,
            'query_var'          => true,
            'capability_type'    => 'post',
            'map_meta_cap'       => true,
            'has_archive'        => false,
            'hierarchical'       => false,
            'rewrite' 			 => array('slug' => 'events','with_front' => true),
            'menu_position'      => $pos,
            'menu_icon' 		 => $icon,
            'taxonomies' 		 =>	$tax,
            'supports'           => $supports
        );
        register_post_type( $slug, $args );

        
}
add_action( 'init', 'bcssel_cpt_events' );


