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
       <!-- -->
	<div style="background-color: #142949; border-radius: 5px; border: 1px solid #162034; color: #fff; padding: 10px 15px; margin-top: 20px; margin-bottom: 10px;">
		<a href="https://wordpress.org/plugins/site-auditor/" target="_blank" class="button" style="float: right;">Check it out now</a>
		<p style="margin: 0; padding: 0; font-size: 1.4em"><span class="dashicons dashicons-megaphone" style="color: #7ab6a2;"></span> I've released a new plugin: <strong><a href="https://wordpress.org/plugins/site-auditor/" target="_blank" style="color: #7ab6a2;">WP Audit</a>!</strong></p>
		<p style="margin: 0; padding: 0; font-size: 1.1em; color: #7ab6a2;">A super simple way to keep track of your <strong>Google Pagespeed</strong> and <strong>404 Error hits</strong>.</p>
	</div>
	<!-- -->
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
