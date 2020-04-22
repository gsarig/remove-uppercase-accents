<?php
	/*
	Plugin Name: Remove Uppercase Accents
	Plugin URI: http://wordpress.org/plugins/remove-uppercase-accents/
	Description: A Wordpress plugin that automatically removes accented characters (currently greek) from elements having their text content uppercase transformed through CSS (with "text-transform: uppercase;"). Currently the script transforms only greek text, but it can be easily extended to support other languages.
	Version: 0.5
	Author: Giorgos Sarigiannidis
	Author URI: http://www.gsarigiannidis.gr/
	*/

	load_plugin_textdomain('remove-uppercase-accents', false, basename( dirname( __FILE__ ) ) . '/languages' ); // Localize it

	function remove_uppercase_accents() {
		wp_enqueue_script(
			'remove-uppercase-accents',
			plugins_url( '/js/jquery.remove-upcase-accents.js' , __FILE__ ), array( 'jquery' )
		);
	}

	add_action( 'wp_enqueue_scripts', 'remove_uppercase_accents' );
