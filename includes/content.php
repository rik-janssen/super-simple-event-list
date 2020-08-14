<?php


function srv_cpt_agenda() {
    $slug = 'srv_agenda';
    $name = 'Agenda'; // singular
    $name_p = 'Agenda'; // pleural
    $icon = 'dashicons-calendar-alt';
    $pos = 20;
    $show = true;
    $tax = array(  );
    $supports = array( 'title', 'editor', 'thumbnail','custom-fields' );

    $labels = array(
		'name'               => _x( $name_p, 'post type general name', 'commp' ),
		'singular_name'      => _x( $name, 'post type singular name', 'commp' ),
		'menu_name'          => _x( $name_p, 'admin menu', 'commp' ),
		'name_admin_bar'     => _x( $name, 'add new on admin bar', 'commp' ),
		'add_new'            => _x( 'Nieuw', 'plugins', 'commp' ),
		'add_new_item'       => __( 'Nieuwe '.$name, 'commp' ),
		'new_item'           => __( 'Nieuwe '.$name, 'commp' ),
		'edit_item'          => __( 'Bewerk '.$name, 'commp' ),
		'view_item'          => __( 'Bekijk '.$name, 'commp' ),
		'all_items'          => __( 'Alle '.$name_p, 'commp' ),
		'search_items'       => __( 'Zoeken in '.$name_p, 'commp' ),
		'parent_item_colon'  => __( 'Parent '.$name.':', 'commp' ),
		'not_found'          => __( 'Geen '.$name_p.' gevonden.', 'commp' ),
		'not_found_in_trash' => __( 'Geen '.$name_p.' gevonden in Trash.', 'commp' )
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
            'rewrite' 			 => array('slug' => 'agenda','with_front' => true),
            'menu_position'      => $pos,
            'menu_icon' 		 => $icon,
            'taxonomies' 		 =>	$tax,
            'supports'           => $supports
        );
        register_post_type( $slug, $args );

        
}
add_action( 'init', 'srv_cpt_agenda' );

// for the datepicker
//wp_enqueue_script('jquery-ui-datepicker');
//wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
//wp_enqueue_style('jquery-ui');

// box callen 

function srv_agenda_box_call() {

    add_meta_box( 'srv_agenda_box', 'Evenement Datum', 'srv_agenda_box', 'srv_agenda','side');
    
}

add_action( 'add_meta_boxes', 'srv_agenda_box_call' );


// the box markup

function srv_agenda_box(){
    	global $post;

        $a_date = get_post_meta($post->ID, '_a_date', true); 
        $a_time = get_post_meta($post->ID, '_a_time', true); 
        $a_loc = get_post_meta($post->ID, '_a_loc', true); 
        ?>
    	<input type="hidden" name="srv_agenda_meta_nounce" value="<?php echo wp_create_nonce( 'srv_agenda_meta_nounce' ); ?>">
        <div style="margin: 2px 0 !important; ">
            <input type="date" style="width: 100%;" name="agenda_datum" id="agenda_datum" value="<?php if(isset($a_date)){ echo $a_date; } ?>"  />
        </div>
       <div style="margin: 2px 0 !important; ">
            <input type="time" style="width: 100%;" name="agenda_tijd" id="agenda_tijd" value="<?php if(isset($a_time)){ echo $a_time; } ?>" />
        </div>

        <div style="margin: 2px 0 !important; ">
            <input type="text" style="width: 100%;" name="agenda_loc" placeholder="Lokatie / Centrum" id="agenda_loc" value="<?php if(isset($a_loc)){ echo $a_loc; } ?>" />
        </div>

      


        <?php

}

// save the data

add_action('save_post', 'srv_save_event');
 
function srv_save_event($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return;
    }
    
    if ( 'srv_agenda' != $_POST['post_type'] ){
        //die('not post type');
        return;
    }
 
    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['srv_agenda_meta_nounce']) || !wp_verify_nonce($_POST['srv_agenda_meta_nounce'], 'srv_agenda_meta_nounce')){
        //die('no nounce');
        return;
        
    }

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post', $post_id)){
        //die('no rights');
        return;
    }
 
    // add values to the DB
    if (isset($_POST['agenda_datum'])){
        update_post_meta($post_id, '_a_date', $_POST['agenda_datum']);
    }else{
        //die('not saving date');    
    }
    
    if (isset($_POST['agenda_tijd'])){
        update_post_meta($post_id, '_a_time', $_POST['agenda_tijd']);
    }else{
        //die('not saving time');    
    }
    
    if (isset($_POST['agenda_loc'])){
        update_post_meta($post_id, '_a_loc', $_POST['agenda_loc']);
    }else{
        //die('not saving time');    
    }

}


add_filter( 'parse_query', 'srv_custom_sort' );
function srv_custom_sort($query) {

    if ( ! is_admin() )
        return $query;

    global $current_screen;
    if ( isset( $current_screen ) && 'srv_agenda' === $current_screen->post_type ) {
        $query->query_vars['orderby']  = 'meta_value';
        $query->query_vars['meta_key'] = '_a_date';
        $query->query_vars['order']    = 'DESC';
    }
}



///

add_action('load-edit.php', 'srv_col_load');
function srv_col_load()
{
    $screen = get_current_screen();

    if(!isset($screen->post_type) || 'srv_agenda' != $screen->post_type)
        return;

    add_filter(
        "manage_{$screen->id}_columns",
        'srv_col_datetime'
    );

    add_action(
        "manage_{$screen->post_type}_posts_custom_column",
        'srv_col_datetime_cb',
        10,
        2
    );
}

function srv_col_datetime($cols)
{
    // pay attention to the key, you'll use it later.
    $cols['agenda_datum'] = "Evenement op";
    $cols['agenda_loc'] = "Locatie";
    return $cols;
}

function srv_col_datetime_cb($col, $post_id)
{
    
    if('agenda_datum' == $col){

        echo '<strong>'.get_post_meta(get_the_ID(), '_a_date', true).'</strong><br>Tijd: '.get_post_meta(get_the_ID(), '_a_time', true);
        
        
    }
    if('agenda_loc' == $col){

        echo '<strong>'.get_post_meta(get_the_ID(), '_a_loc', true).'</strong>';
        
        
    }
}

add_filter('manage_posts_columns', 'srv_column_order');
function srv_column_order($columns) {
  $n_columns = array();
  $before = 'date'; // move before this
 
  foreach($columns as $key => $value) {
    if ($key==$before){
      $n_columns['agenda_datum'] = '';
      $n_columns['agenda_loc'] = '';
    }
      $n_columns[$key] = $value;
  }
  return $n_columns;
}



// shortcode: list

function srv_short_agendalist($atts, $content = null) {
    global $wpdb;
?>
<div class="agenda-items-sc">
<?php
    

/* The custom post types query */
$args = array(
        'post_type' => 'srv_agenda',
        'posts_per_page' => '-1',
        'meta_key' => '_a_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    
    'meta_query' => array(
      array(
        'key' => '_a_date',
        'value' => date('Y-m-d'),
        'compare' => '>=',
      )
    )
        
    );
    $query = new WP_Query( $args );
    while($query -> have_posts()) : $query -> the_post();

?>

        
        <div class="news-list-item-page is-pb-m is-pt-m">
            <a href="<?php the_permalink(); ?>">
                <div class="is-news-image">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="is-round-news-image">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php }else{ ?>
                    <div class="is-round-news-image no-image-found">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/srv-logo.svg" class="logo" alt="<?php bloginfo('name'); ?> <?php bloginfo('description'); ?>">
                    </div>
                <?php } ?>
                </div>
                <div class="is-agenda-content is-mt-s">
                    <div class="is-meta is-meta-agenda is-uppercase">
                        <?php 
    echo date_i18n(get_option('date_format'), strtotime(get_post_meta(get_the_ID(), '_a_date', true))); ?> 
                        <?php if(get_post_meta(get_the_ID(), '_a_time', true)!=''){ 
                        ?> om <?php echo date_i18n(get_option('time_format'), get_post_meta(get_the_ID(), '_a_time', true)); } ?>
                    </div>
                    <h4 class="is-uppercase is-mb-s"><?php the_title(); ?></h4>
                    <?php the_excerpt(); ?>
                    
                </div>
            </a>
        </div>
        

<?php

    endwhile; 
    
?>
</div>
<?php

}
add_shortcode('agenda-lijst', 'srv_short_agendalist');


/*
add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 1 );
 
function filter_the_content_in_the_main_loop( $content ) {
 
    // Check if we're inside the main loop in a single Post.
    if ( is_singular() && in_the_loop() && is_main_query() ) {
        return esc_html__( 'I’m filtering the content inside the main loop', 'wporg').$content;
    }
 
    return $content;
}*/

