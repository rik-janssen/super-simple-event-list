<?php 
/**
* Plugin Name: Super Simple Events List
* Plugin URI: https://betacore.tech/plugins/super-simple-event-list-for-wordpress/
* Description: Create and customise a simple events (and past events) list. Display them on your page with a shortcode. In the WP admin it has the look and feel of Wordpress. Nothing fancy.
* Version: 0.9
* Author: Rik Janssen 
* Author URI: https://www.rikjanssen.info/
* Text Domain: bcssel
* Domain Path: /lang
**/

//betaanalytics

/* Includes */
include_once('includes/init.php'); // initialize the CPT
include_once('includes/wpadmin.php'); // build the WP-admin part
include_once('includes/shortcode.php'); // build the WP-admin part
include_once('includes/content.php'); // the block that is added to the content of the single page
include_once('includes/docs.php'); // the documentation page



/* make the plugin page row better */

function bcssel_plugin_list( $links ) {

	$links = array_merge( array(
		'<a href="' . esc_url( 'https://www.patreon.com/wpaudit' ) . '">' . __( 'Donate', 'bcssel' ) . '</a>'
    ), $links );

    $links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/edit.php?post_type=bcssel_events&page=bcssel_shortcodes' ) ) . '">' . __( 'Shortcodes', 'bcssel' ) . '</a>'
    ), $links );
    
	return $links;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bcssel_plugin_list' );

?>
