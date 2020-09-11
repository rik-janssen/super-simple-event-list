<?php


// shortcode: upcoming event list

function bcssel_upcoming_events($atts, $content = null) {
global $wpdb;

$html = '<div id="bcssel" class="bcssel bcssel_upcoming_events bcssel_list">';

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    
    if(isset($atts['items'])){
        $post_per_page = $atts['items'];  
    }else{
        $post_per_page = 10;    
    }

    if(isset($atts['disable_paginate'])){
        
    }

/* The custom post types query */
    $args = array(
        'post_type' => 'bcssel_events',
        'posts_per_page' => $post_per_page,
        'paged' => $paged,
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
    
    if(get_post_meta(get_the_ID(), '_a_date', true)!=''){
        $bcssel_date = '<span class="bcssel_meta_item bcssel_list_date">'.__('Date','bcssel').': <span class="bcssel_value">'.esc_html(date_i18n(get_option('date_format'), strtotime(get_post_meta(get_the_ID(), '_a_date', true)))).'</span></span>';
    }
    
    if(get_post_meta(get_the_ID(), '_a_time', true)!=''){
        $bcssel_time = '<span class="bcssel_meta_item bcssel_list_time">'.__('Time','bcssel').': <span class="bcssel_value">'.esc_html(date_i18n(get_option('time_format'), strtotime(get_post_meta(get_the_ID(), '_a_time', true)))).'</span></span>';
    }
    
    if(get_post_meta(get_the_ID(), '_a_loc', true)!=''){
        $bcssel_loc = '<span class="bcssel_meta_item bcssel_list_loc">'.__('Venue','bcssel').': <span class="bcssel_value">'.esc_html(get_post_meta(get_the_ID(), '_a_loc', true)).'</span></span>';
    }


    $html .= '<div class="bcssel_list_item">';
        if (!isset($atts['no_link'])){ 
            $html .= '<a href="'. get_the_permalink() .'" class="bcssel_list_link">';
        }
            $html .= '<div class="bcssel_col_img">';

            if ( has_post_thumbnail() ) { 
                $html .= '<div class="bcssel_img">';
                $html .= get_the_post_thumbnail(); 
                $html .= '</div>';
            }else{
                $html .= '<div class="bcssel_no_img"></div>';
            } 

            $html .= '</div>';
            $html .= '<div class="bcssel_col_content">';
            $html .= '<div class="bcssel_box_title">';
            $html .= '<h3 class="bcssel_title">'. get_the_title() .'</h3>';
            $html .= '</div>';
            //if (!isset($atts['content'])){ 
                $html .= '<div class="bcssel_meta_box">';

                if(isset($bcssel_date)){ $html .= $bcssel_date; }
                if(isset($bcssel_time)){ $html .= $bcssel_time; }
                if(isset($bcssel_loc)) { $html .= $bcssel_loc;  }

                $html .= '</div>';
            //}
            if (isset($atts['content'])){ 
                $html .= '<div class="bcssel_box_text bcssel_box_full_text">';
                $html .= get_the_content(); 
                $html .= '</div>';
            } 

        $html .= '</div>';
        if (!isset($atts['no_link'])){
            $html .= '</a>';
        } 

    $html .= '</div>';

    endwhile; 
    if(!isset($atts['disable_paginate'])){
        $html .= paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $query->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'prev_next'    => false,
                    'add_args'     => false,
                    'add_fragment' => '',
                ) );
    }
    
$html .= '</div>';
return $html;

}
add_shortcode('bcssel_upcoming_events', 'bcssel_upcoming_events');

// shortcode: past event list

function bcssel_past_events($atts, $content = null) {
global $wpdb;

$html = '<div id="bcssel" class="bcssel bcssel_past_events bcssel_list">';

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    
    if(isset($atts['items'])){
        $post_per_page = $atts['items'];  
    }else{
        $post_per_page = 10;    
    }

    if(isset($atts['disable_paginate'])){
        
    }

/* The custom post types query */
    $args = array(
        'post_type' => 'bcssel_events',
        'posts_per_page' => $post_per_page,
        'paged' => $paged,
        'meta_key' => '_a_date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
    
    'meta_query' => array(
      array(
        'key' => '_a_date',
        'value' => date('Y-m-d'),
        'compare' => '<',
      )
    )
        
    );
    $query = new WP_Query( $args );
    while($query -> have_posts()) : $query -> the_post();
    
    if(get_post_meta(get_the_ID(), '_a_date', true)!=''){
        $bcssel_date = '<span class="bcssel_meta_item bcssel_list_date">'.__('Date','bcssel').': <span class="bcssel_value">'.esc_html(date_i18n(get_option('date_format'), strtotime(get_post_meta(get_the_ID(), '_a_date', true)))).'</span></span>';
    }
    
    if(get_post_meta(get_the_ID(), '_a_time', true)!=''){
        $bcssel_time = '<span class="bcssel_meta_item bcssel_list_time">'.__('Time','bcssel').': <span class="bcssel_value">'.esc_html(date_i18n(get_option('time_format'), strtotime(get_post_meta(get_the_ID(), '_a_time', true)))).'</span></span>';
    }
    
    if(get_post_meta(get_the_ID(), '_a_loc', true)!=''){
        $bcssel_loc = '<span class="bcssel_meta_item bcssel_list_loc">'.__('Venue','bcssel').': <span class="bcssel_value">'.esc_html(get_post_meta(get_the_ID(), '_a_loc', true)).'</span></span>';
    }


    $html .= '<div class="bcssel_list_item">';
    
        if (!isset($atts['no_link'])){ 
            $html .= '<a href="'. get_the_permalink() .'" class="bcssel_list_link">';
        }
        $html .= '<div class="bcssel_col_img">';

            if ( has_post_thumbnail() ) { 
                $html .= '<div class="bcssel_img">';
                $html .= get_the_post_thumbnail(); 
                $html .= '</div>';
            }else{
                $html .= '<div class="bcssel_no_img"></div>';
            } 

            $html .= '</div>';
            $html .= '<div class="bcssel_col_content">';
            $html .= '<div class="bcssel_box_title">';
            $html .= '<h3 class="bcssel_title">'. get_the_title() .'</h3>';
            $html .= '</div>';
            //if (!isset($atts['content'])){ 
                $html .= '<div class="bcssel_meta_box">';

                if(isset($bcssel_date)){ $html .= $bcssel_date; }
                if(isset($bcssel_time)){ $html .= $bcssel_time; }
                if(isset($bcssel_loc)) { $html .= $bcssel_loc;  }

                $html .= '</div>';
            //}   
            if (isset($atts['content'])){ 
                $html .= '<div class="bcssel_box_text bcssel_box_full_text">';
                $html .= get_the_content(); 
                $html .= '</div>';
            } 

        $html .= '</div>';
        if (!isset($atts['no_link'])){
            $html .= '</a>';
        } 

    $html .= '</div>';

    endwhile; 
    if(!isset($atts['disable_paginate'])){
        $html .= paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $query->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'prev_next'    => false,
                    'add_args'     => false,
                    'add_fragment' => '',
                ) );
    }
    
$html .= '</div>';
return $html;

}
add_shortcode('bcssel_past_events', 'bcssel_past_events');


// pagination

