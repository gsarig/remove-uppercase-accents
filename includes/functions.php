<?php
/**
 * Plugin functions
 *
 * @package Remove_Uppercase_Accents
 * @since 1.0
 */

use RUA\App;

if ( ! function_exists( 'remove_greek_accents' ) ) :

	/**
	 * Function to remove greek accents
	 *
	 * @param $text
	 *
	 * @return string|string[]
	 */
	function remove_greek_accents( $text ) {
		return App::removeAccents( $text );
	}
endif;