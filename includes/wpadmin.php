<?php

////////////////////////////////////////////////////////////////////
// Event post page

function bcssel_event_box_call() {

    add_meta_box( 'bcssel_event_box', 'Evenement Datum', 'bcssel_event_box', 'bcssel_events','side', 'high');
    
}

add_action( 'add_meta_boxes', 'bcssel_event_box_call' );


// the box markup

function bcssel_event_box(){
    	global $post;

        $a_date = get_post_meta($post->ID, '_a_date', true); 
        $a_time = get_post_meta($post->ID, '_a_time', true); 
        $a_loc = get_post_meta($post->ID, '_a_loc', true); 
        $a_adr = get_post_meta($post->ID, '_a_addr', true); 
        ?>
    	<input type="hidden" name="bcssel_event_meta_nounce" value="<?php echo wp_create_nonce( 'bcssel_event_meta_nounce' ); ?>">
        <div style="margin: 0 !important; ">
            <label><?php _e('Event date','bcssel'); ?></label>
            <input type="date" style="width: 100%;" placeholder="<?php _e('YYYY/MM/DD','bcssel'); ?>" name="event_datum" id="event_datum" class="datepicker" value="<?php if(isset($a_date)){ echo esc_html($a_date); } ?>"  />
        </div>
       <div style="margin: 10px 0 0 0 !important; ">
            <label><?php _e('Start time','bcssel'); ?></label>
            <input type="time" style="width: 100%;" name="event_tijd" id="event_tijd" placeholder="<?php _e('HH:MM','bcssel'); ?>" value="<?php if(isset($a_time)){ echo esc_html($a_time); } ?>" />
        </div>

        <div style="margin: 10px 0 0 0 !important; ">
            <label><?php _e('Venue','bcssel'); ?></label>
            <input type="text" style="width: 100%;" name="event_loc" placeholder="<?php _e('where the event is taking place','bcssel'); ?>" id="event_loc" value="<?php if(isset($a_loc)){ echo esc_html($a_loc); } ?>" />
        </div>
        <div style="margin: 10px 0 0 0 !important; ">
            <label><?php _e('Town/city','bcssel'); ?></label>
            <input type="text" style="width: 100%;" name="event_addr" placeholder="<?php _e('town or city name','bcssel'); ?>" id="event_addr" value="<?php if(isset($a_adr)){ echo esc_html($a_adr); } ?>" />
        </div>

        <?php

}

// save the data

add_action('save_post', 'bcssel_save_event');
 
function bcssel_save_event($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return;
    }
    
    if ( !isset($_POST['post_type']) ){
        return;
    }
 
    if ( 'bcssel_events' != $_POST['post_type'] ){
        return;
    }
 
    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['bcssel_event_meta_nounce']) || !wp_verify_nonce($_POST['bcssel_event_meta_nounce'], 'bcssel_event_meta_nounce')){
        return;
        
    }

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post', $post_id)){
        return;
    }
 
    // add values to the DB
    if (isset($_POST['event_datum'])){
        update_post_meta($post_id, '_a_date', sanitize_text_field($_POST['event_datum']));
    }
    
    if (isset($_POST['event_tijd'])){
        update_post_meta($post_id, '_a_time', sanitize_text_field($_POST['event_tijd']));
    }
    
    if (isset($_POST['event_loc'])){
        update_post_meta($post_id, '_a_loc', sanitize_text_field($_POST['event_loc']));
    }
    if (isset($_POST['event_loc'])){
        update_post_meta($post_id, '_a_addr', sanitize_text_field($_POST['event_addr']));
    }

}

////////////////////////////////////////////////////////////////////
// Event post list


// Order list by event date
add_filter( 'parse_query', 'bcssel_be_order_list' );
function bcssel_be_order_list($query) {

    
    if ( ! is_admin() )
        return $query;

    global $current_screen;
    if ( isset( $current_screen ) && 'bcssel_events' === $current_screen->post_type ) {
        $query->query_vars['orderby']  = 'meta_value';
        $query->query_vars['meta_key'] = '_a_date';
        $query->query_vars['order']    = 'DESC';
    }
}


// load the columns

add_action('load-edit.php', 'bcssel_col_load');
function bcssel_col_load(){
    
    $screen = get_current_screen();

    if(!isset($screen->post_type) || 'bcssel_events' != $screen->post_type)
        return;

    add_filter(
        "manage_{$screen->id}_columns",
        'bcssel_col_datetime'
    );

    add_action(
        "manage_{$screen->post_type}_posts_custom_column",
        'bcssel_col_datetime_cb',
        10,
        2
    );
}

// Create the column keys

function bcssel_col_datetime($cols){
       
    $screen = get_current_screen();
    if($screen->post_type=='bcssel_events'){
        $cols['event_datum'] = __('Event date','bcssel');
        $cols['event_loc']   = __('Event location','bcssel');
    }
    return $cols;
}

// Display the date and other things in the list

function bcssel_col_datetime_cb($col, $post_id){
    
    $screen = get_current_screen();
    if($screen->post_type=='bcssel_events'){
        if('event_datum' == $col){
            
            $create_date = date_i18n(get_option('date_format'), strtotime(get_post_meta(get_the_ID(),'_a_date', true)));
            
            if(get_post_meta(get_the_ID(),'_a_date', true)==date('Y-m-d')){
                $note = __('Today','bcssel');
            }elseif(get_post_meta(get_the_ID(),'_a_date', true)<date('Y-m-d')){
                $note = __('Past','bcssel');
            }else{
                $note = __('Upcoming','bcssel');
            }
            
            if(get_post_meta(get_the_ID(),'_a_time', true)==''){
                $create_time = '';
            }else{
                $create_time = date_i18n(get_option('time_format'), strtotime(get_post_meta(get_the_ID(),'_a_time', true)));
            }
            
            echo '<strong>'.__('Date','bcssel').': '.esc_html($create_date).'</strong> - '.esc_html($note).'<br />';
            if($create_time!=''){
                echo ''.__('Time','bcssel').': '.esc_html($create_time);
            }

            $create_date = '';
            $create_time = '';
            $note = '';
            
        }
        if('event_loc' == $col){

            if(get_post_meta(get_the_ID(), '_a_loc', true)!=''){
                echo '<strong>'.esc_html(get_post_meta(get_the_ID(), '_a_loc', true)).'</strong><br />';
            }
            if(get_post_meta(get_the_ID(), '_a_addr', true)!=''){
                echo ''.esc_html(get_post_meta(get_the_ID(), '_a_addr', true)).'';
            }


        }
    }
}

add_filter('manage_posts_columns', 'bcssel_column_order');


// Change the order of the columns to make it more logical

function bcssel_column_order($columns) {
    
    $screen = get_current_screen();

    $n_columns = array();
    $before = 'date'; // move before this

    foreach($columns as $key => $value) {
    if ($key==$before){
        if($screen->post_type=='bcssel_events'){
          $n_columns['event_datum'] = '';
          $n_columns['event_loc'] = '';
        }
    }
      $n_columns[$key] = $value;
    }
    return $n_columns;

}

/*function bcssel_validateDate($date, $format = 'Y/m/d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}*/