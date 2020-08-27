<?php
/**
 * WordPress filter hooks
 *
 * @package Remove_Uppercase_Accents
 * @since 1.0
 */

namespace RUA;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class App {
	/**
	 * @var false|mixed|void
	 */
	private $options;

	public function __construct() {
		$this->options = get_option( 'rua_options' );

		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );

		if ( ! $this->options || ! isset( $this->options['rua_field_mode'] ) || 'php' !== $this->options['rua_field_mode'] || ! isset( $this->options['rua_field_filters'] ) ) {
			return;
		}
		add_filter( 'the_content', [ $this, 'the_content' ], 1 );
		add_filter( 'wp_nav_menu_items', [ $this, 'wp_nav_menu_items' ], 10, 2 );
		add_filter( 'the_title', [ $this, 'the_title' ], 10, 2 );
		add_filter( 'get_the_excerpt', [ $this, 'get_the_excerpt' ] );
		add_filter( 'widget_title', [ $this, 'widget_title' ] );
		add_filter( 'the_tags', [ $this, 'the_tags' ] );
		add_filter( 'the_category', [ $this, 'the_category' ] );

	}

	function get_the_excerpt( $text ) {
		$output = $text;
		if ( in_array( 'rua_excerpt', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $text );
		}

		return $output;
	}

	function the_content( $content ) {
		$output = $content;
		if ( in_array( 'rua_content', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $content );
		}

		return $output;
	}

	function wp_nav_menu_items( $items, $args ) {
		$output = $items;
		if ( in_array( 'rua_menu', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $items );
		}

		return $output;
	}

	function the_title( $title, $id = null ) {
		$output = $title;
		if ( in_the_loop() && in_array( 'rua_title', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $title );
		}

		return $output;
	}

	function widget_title( $title ) {
		$output = $title;
		if ( in_array( 'rua_widget_title', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $title );
		}

		return $output;
	}

	function the_tags( $content ) {
		$output = $content;
		if ( in_array( 'rua_tags', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $content );
		}

		return $output;
	}

	function the_category( $content ) {
		$output = $content;
		if ( in_array( 'rua_category', $this->options['rua_field_filters'], true ) ) {
			$output = self::removeAccents( $content );
		}

		return $output;
	}

	public static function removeAccents( $string ) {
		$data = self::data();
		if ( $data && isset( $data->accents ) ) {
			foreach ( $data->accents as $match ) {
				if ( $match && isset( $match->original ) && isset( $match->convert ) ) {
					$string = str_replace( $match->original, $match->convert, $string );
				}
			}
		}

		return $string;
	}

	function scripts() {
		if ( isset( $this->options['rua_field_mode'] ) && in_array( $this->options['rua_field_mode'],
				[ 'php', 'manual' ],
				true ) ) {
			return;
		}
		$handle    = '';
		$prefix    = '';
		$deps      = [];
		$action    = isset( $this->options['rua_field_action'] ) ? $this->options['rua_field_action'] : '';
		$selectors = isset( $this->options['rua_field_selectors'] ) ? $this->options['rua_field_selectors'] : '';
		if ( ! isset( $this->options['rua_field_mode'] ) || 'jquery' === $this->options['rua_field_mode'] ) {
			$handle    = 'jquery-';
			$prefix    = 'jquery.';
			$deps      = [ 'jquery' ];
			$action    = '';
			$selectors = '';
		}
		$data = self::data();
		wp_enqueue_script(
			$handle . 'remove-uppercase-accents',
			plugins_url( '/js/' . $prefix . 'remove-uppercase-accents.js', dirname( __FILE__ ) ),
			$deps
		);
		wp_localize_script( $handle . 'remove-uppercase-accents',
			'rua',
			[
				'accents'   => $data->accents,
				'selectors' => isset( $selectors ) && $selectors && ! empty( $selectors ) ? $selectors : '',
				'selAction' => $action,
			] );
	}

	public static function data() {
		$json_file = trailingslashit( plugin_dir_path( dirname( __FILE__ ) ) ) . 'data/greek-accents.json';
		$request   = file_get_contents( $json_file );

		return json_decode( $request );
	}
}