<?php

add_action('admin_menu', 'bcssel_cpt_subnav');

function bcssel_cpt_subnav() {
    add_submenu_page(
        'edit.php?post_type=bcssel_events',
        __( 'Shortcodes', 'bcssel' ),
        __( 'Shortcodes', 'bcssel' ),
        'manage_options',
        'bcssel_shortcodes',
        'bcssel_shortcodes_cb'
    );
}
 
/**
 * Display callback for the submenu page.
 */
function bcssel_shortcodes_cb() { 
    ?>
    <div class="wrap bcssel_docs">
        <h1><?php _e( 'Event List Shortcode Reference', 'textdomain' ); ?></h1>

    <h3>Shortcodes</h3>
    <p>To show the upcoming event list add this shortcode to your page:</p>
    <input type="text" value="[bcssel_upcoming_events]">
    <p>To show the past event list add this shortcode to your page:</p>
    <input type="text" value="[bcssel_past_events]">


    <h3>Parameters</h3>
    <p>Use these parameters to customize your events list. They work on both the upcoming and past event lists.</p>

    <p>Override the standard item amount of 10 by adding your own value:</p>
    <input type="text" value='[bcssel_upcoming_events items="25"]'>
    <p>Disable the link to the single page:</p>
    <input type="text" value='[bcssel_upcoming_events no_link="true"]'>
    <p>Disable pagination:</p>
    <input type="text" value='[bcssel_upcoming_events disable_paginate="true"]'>
    <p>Show the full content:</p>
    <input type="text" value='[bcssel_upcoming_events content="true"]'>


    <h3>Combine parameters</h3>

    <p>And you can combine these to only show the next event with the full text and no link:</p>
    <input type="text" value='[bcssel_upcoming_events items="1" disable_paginate="true" content="true" no_link="true"]'>

    </div>
    <?php
}