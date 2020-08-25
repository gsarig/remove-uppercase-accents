<?php
/**
 * WordPress Filters
 *
 * @package Remove_Uppercase_Accents
 * @since 1.0
 */

namespace RUA;


class App {
	/**
	 * @var false|mixed|void
	 */
	private $options;

	public function __construct() {
		$this->options = get_option( 'rua_options' );
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
		$matches = self::matches();
		if ( $matches && isset( $matches->letters ) ) {
			foreach ( $matches->letters as $match ) {
				if ( $match && isset( $match->original ) && isset( $match->convert ) ) {
					$string = str_replace( $match->original, $match->convert, $string );
				}
			}
		}

		return $string;
	}

	public static function matches() {
		$data      = '';
		$json_file = trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'data/greek-accents.json';
		$request   = wp_safe_remote_get( $json_file );
		if ( ! is_wp_error( $request ) ) {
			$body = wp_remote_retrieve_body( $request );
			$data = json_decode( $body );
		}

		return $data;
	}
}