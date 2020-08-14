<?php 
/**
* Plugin Name: Super Simple Event List
* Plugin URI: https://betacore.tech/plugins/super-simple-event-list-for-wordpress/
* Description: Need a list of events ordered by date? Then this is the plugin for you! Create a list of events using the trusty old WP post types and display them as a list using a shortcode. Use the shortcode [upcoming_events] on a page and you are all set!
* Version: 0.1
* Author: Rik Janssen 
* Author URI: https://www.rikjanssen.inf/
* Text Domain: bcssel
* Domain Path: /lang
**/

//betaanalytics

/* Includes */
include_once('includes/init.php'); // the wp-admin navigation



/* make the plugin page row better */

function bcssel_plugin_list( $links ) {

	$links = array_merge( array(
		'<a href="' . esc_url( 'https://www.patreon.com/betadev' ) . '">' . __( 'Donate', 'bcssel' ) . '</a>'
    ), $links );

    $links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/options-general.php?page=bcssel_plugin_list' ) ) . '">' . __( 'Setup', 'bcssel' ) . '</a>'
    ), $links );
    
	return $links;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bcssel_plugin_list' );

?>
