<?php



add_filter( 'the_content', 'bcssel_the_content_meta', 1 );
 
function bcssel_the_content_meta( $content ) {
 
    // Check if we're inside the main loop in a single Post.
    if ( is_singular() && in_the_loop() && is_main_query() && get_post_type()=='bcssel_events') {
        

        
        
        $html = '<div id="bcssel" class="bcssel_meta_box">';
        if(get_post_meta(get_the_ID(), '_a_date', true)!=''){
            $html .= '<span class="bcssel_meta_item bcssel_meta_date">'.__('Date','bcssel').': <span class="bcssel_value">'.esc_html(date_i18n(get_option('date_format'), strtotime(get_post_meta(get_the_ID(), '_a_date', true)))).'</span></span>';
        }
        if(get_post_meta(get_the_ID(), '_a_time', true)!=''){
            $html .= '<span class="bcssel_meta_item bcssel_meta_time">'.__('Time','bcssel').': <span class="bcssel_value">'.esc_html(date_i18n(get_option('time_format'), strtotime(get_post_meta(get_the_ID(), '_a_time', true)))).'</span></span>';
        }
        if(get_post_meta(get_the_ID(), '_a_loc', true)!=''){
            $html .= '<span class="bcssel_meta_item bcssel_meta_venue">'.__('Venue','bcssel').': <span class="bcssel_value">'.esc_html(get_post_meta(get_the_ID(), '_a_loc', true)).'</span></span>';
        }
        if(get_post_meta(get_the_ID(), '_a_addr', true)!=''){
            $html .= '<span class="bcssel_meta_item bcssel_meta_city">'.__('City','bcssel').': <span class="bcssel_value">'.esc_html(get_post_meta(get_the_ID(), '_a_addr', true)).'</span></span>';        
        }
        
        
        if(get_post_meta(get_the_ID(),'_a_date', true)==date('Y-m-d')){
                $html .= '<span class="bcssel_today_event_notice">'.__('This event is today!','bcssel').'</span>';
            }elseif(get_post_meta(get_the_ID(),'_a_date', true)<date('Y-m-d')){
                $html .= '<span class="bcssel_past_event_notice">'.__('This event has already happened.','bcssel').'</span>';
            }
        
        
        $html .= '</div>';
        
        

        
        return  $html.$content;
    }
 
    return $content;
}

