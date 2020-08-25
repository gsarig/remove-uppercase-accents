<?php
/**
 * Enqueue scripts and styles
 *
 * @package Remove_Uppercase_Accents
 * @since 1.0
 */
function remove_uppercase_accents() {
	$options = get_option( 'rua_options' );
	if ( isset( $options['rua_field_mode'] ) && in_array( $options['rua_field_mode'], [ 'php', 'manual' ], true ) ) {
		return;
	}
	$handle    = '';
	$prefix    = '';
	$deps      = [];
	$selectors = isset( $options['rua_field_selectors'] ) ? $options['rua_field_selectors'] : '';
	if ( ! isset( $options['rua_field_mode'] ) || 'jquery' === $options['rua_field_mode'] ) {
		$handle    = 'jquery-';
		$prefix    = 'jquery.';
		$deps      = [ 'jquery' ];
		$selectors = '';
	}
	$data = \RUA\App::matches();
	wp_enqueue_script(
		$handle . 'remove-uppercase-accents',
		plugins_url( '/js/' . $prefix . 'remove-upcase-accents.js', dirname( __FILE__ ) ),
		$deps
	);
	wp_localize_script( $handle . 'remove-uppercase-accents',
		'rua',
		[
			'data'      => $data,
			'selectors' => isset( $selectors ) && $selectors && ! empty( $selectors ) ? $selectors : '',
		] );
}

add_action( 'wp_enqueue_scripts', 'remove_uppercase_accents' );