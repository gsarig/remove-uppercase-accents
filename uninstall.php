<?php
/**
 * Uninstall Remove Uppercase Accents
 *
 * @package Remove_Uppercase_Accents
 * @since 1.0
 */

// If uninstall is not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$option_name = 'rua_options';

delete_option( $option_name );