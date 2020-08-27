<?php
/*
Plugin Name: Remove Uppercase Accents
Plugin URI: http://wordpress.org/plugins/remove-uppercase-accents/
Description: A Wordpress plugin that automatically removes accented characters (currently greek) from elements having their text content uppercase transformed through CSS (with "text-transform: uppercase;"). Currently the script transforms only greek text, but it can be easily extended to support other languages.
Version: 1.1.1
Author: Giorgos Sarigiannidis
Author URI: https://www.gsarigiannidis.gr/
Text Domain: remove-uppercase-accents
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RUA\App;
use RUA\Options;

define( 'RUA_PLUGIN_VERSION', '1.1.1' );

// Localize the plugin.
add_action( 'init', 'rua_load_textdomain' );
function rua_load_textdomain() {
	load_plugin_textdomain( 'remove-uppercase-accents', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'rua_settings_links' );
function rua_settings_links( $links ) {
	array_unshift( $links,
		'<a href="' . admin_url( 'options-general.php?page=remove-uppercase-accents' ) . '">' . __( 'Settings',
			'remove-uppercase-accents' ) . '</a>' );

	return $links;
}

include_once dirname( __FILE__ ) . '/admin/Options.class.php';
include_once dirname( __FILE__ ) . '/includes/App.class.php';
include_once dirname( __FILE__ ) . '/includes/functions.php';

new Options();
new App();