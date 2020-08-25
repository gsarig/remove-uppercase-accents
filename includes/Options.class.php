<?php
/**
 * Plugin Options
 *
 * @package Remove_Uppercase_Accents
 * @since 1.0
 */

namespace RUA;


class Options {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'rua_options_page' ] );
		add_action( 'admin_init', [ $this, 'rua_settings_init' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueues' ] );
	}

	function rua_settings_init() {
		register_setting( 'rua',
			'rua_options',
			[
				'sanitize_callback' => [ $this, 'rua_options_validate' ],
			] );

		add_settings_section(
			'rua_section_settings',
			__( 'Settings', 'remove-uppercase-accents' ),
			[ $this, 'rua_section_settings_cb' ],
			'rua'
		);
		add_settings_field(
			'rua_field_mode',
			__( 'Plugin mode', 'remove-uppercase-accents' ),
			[ $this, 'rua_field_mode_cb' ],
			'rua',
			'rua_section_settings',
			[
				'label_for'       => 'rua_field_mode',
				'class'           => 'rua_row rua-mode',
				'rua_custom_data' => 'custom',
			]
		);
		add_settings_field(
			'rua_field_selectors',
			__( 'Selectors', 'remove-uppercase-accents' ),
			[ $this, 'rua_field_selectors_cb' ],
			'rua',
			'rua_section_settings',
			[
				'label_for'       => 'rua_field_selectors',
				'class'           => 'rua_row rua-js',
				'rua_custom_data' => 'custom',
			]
		);
		add_settings_field(
			'rua_field_filters',
			__( 'Places', 'remove-uppercase-accents' ),
			[ $this, 'rua_field_filters_cb' ],
			'rua',
			'rua_section_settings',
			[
				'label_for'       => 'rua_field_filters',
				'class'           => 'rua_row rua-php',
				'rua_custom_data' => 'custom',
			]
		);
	}

	function rua_section_settings_cb( $args ) {
		?>
		<div class="rua_info">
			<h3><?php _e( 'Instructions:', 'remove-uppercase-accents' ); ?></h3>
			<p id="<?php echo esc_attr( $args['id'] ); ?>">
				<?php esc_html_e( 'Select the mode that best fits your case:', 'remove-uppercase-accents' ); ?>
			</p>
			<ol>
				<li>
					<?php _e( 'The <strong>jQuery</strong> mode is the old version of the script, which is kept as default to avoid breaking existing installations. For better performance, you are encouraged to try any of the other options.',
						'remove-uppercase-accents' ); ?>
				</li>
				<li>
					<?php _e( '<strong>JavaScript</strong> mode is the same script, but with no jQuery dependency. Also, it allows you to target specific selectors.',
						'remove-uppercase-accents' ); ?>
				</li>
				<li>
					<?php _e( '<strong>PHP</strong> mode will not load any scripts at all and will do the replacement server-side. It should be faster that the previous options but can only be applied on specific parts of your website.',
						'remove-uppercase-accents' ); ?>
				</li>
				<li>
					<?php _e( '<strong>Manual</strong> mode is mostly for those who build their own themes or want to do things manually. It will practically deactivate all scripts and it will run no PHP filters. You will still have access to the <code>remove_greek_accents($text)</code> function, though, to apply the replacement on any string you want.',
						'remove-uppercase-accents' ); ?>
				</li>
			</ol>
			<p><?php _e( 'Options are ordered from the easiest to implement to the most advanced. You can keep the defaults and forget it or you can try them all until you find the one which works best for you.',
					'remove-uppercase-accents' ); ?></p>
			<h3><?php _e( 'Tips:', 'remove-uppercase-accents' ); ?></h3>
			<p><?php _e( 'If the content that needs to be transformed is on one of the places supported by the <code>PHP</code> option, you should always prefer it, as it takes care of the transform on the server\'s side, skipping entirely the loading of scripts.',
					'remove-uppercase-accents' ); ?></p>
			<p><?php _e( 'If that isn\'t the case and you use a ready-made theme where you don\'t want to mess with the child theme, you should choose the <code>JavaScript</code> option. If you know the selectors that you want to target, you are encouraged to do so, as this will highly improve the script\'s performance. ',
					'remove-uppercase-accents' ); ?></p>
			<p><?php _e( 'If this option doesn\'t work for you or if you need to support legacy browsers, you can always switch it to the good old <code>jQuery</code>.',
					'remove-uppercase-accents' ); ?></p>
			<p><?php _e( 'If you build a custom theme and you know your PHP, you should turn on the <code>Manual</code> mode and use the <code>remove_greek_accents($text)</code> function anywhere in your code.',
					'remove-uppercase-accents' ); ?></p>
			<p class="rua-colophon"><a href="https://wordpress.org/support/plugin/remove-uppercase-accents/"
									   target="_blank"><?php _e( 'Support forum', 'remove-uppercase-accents' ); ?></a>
				| <?php echo sprintf( wp_kses( __( 'Plugin created by <a href="%s" target="_blank">Giorgos Sarigiannidis</a>',
					'remove-uppercase-accents' ),
					array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
					esc_url( 'https://www.gsarigiannidis.gr/' ) ); ?></p>
		</div>

		<?php
	}

	function rua_field_mode_cb( $args ) {
		$options = get_option( 'rua_options' );
		?>
		<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
				data-custom="<?php echo esc_attr( $args['rua_custom_data'] ); ?>"
				name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
			<option value="jquery" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ],
				'jquery',
				false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'jQuery', 'remove-uppercase-accents' ); ?>
			</option>
			<option value="js" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ],
				'js',
				false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'JavaScript', 'remove-uppercase-accents' ); ?>
			</option>
			<option value="php" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ],
				'php',
				false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'PHP', 'remove-uppercase-accents' ); ?>
			</option>
			<option value="manual" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ],
				'manual',
				false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'Manual', 'remove-uppercase-accents' ); ?>
			</option>
		</select>
		<?php
	}

	function rua_field_selectors_cb( $args ) {
		$option = get_option( 'rua_options' );
		?>
		<textarea name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
				  data-custom="<?php echo esc_attr( $args['rua_custom_data'] ); ?>"
				  id="<?php echo esc_attr( $args['label_for'] ); ?>"><?php echo isset( $option[ $args['label_for'] ] ) ? $option[ $args['label_for'] ] : ''; ?></textarea>
		<?php
	}

	function rua_field_filters_cb( $args ) {
		$options    = get_option( 'rua_options' );
		$checkboxes = isset( $options[ $args['label_for'] ] ) ? (array) $options[ $args['label_for'] ] : [];
		?>
		<fieldset>
			<legend>
				<p>
					<?php esc_html_e( 'Select the parts of the website where the replacement should happen.',
						'remove-uppercase-accents' ); ?>
				</p>
			</legend>
			<div>
				<input type="checkbox" id="rua_menu" name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_menu" <?php echo checked( in_array( 'rua_menu', $checkboxes, true ), 1 ); ?>>
				<label for="rua_menu"><?php _e( 'Menu (hooks to <code>wp_nav_menu_items()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
			<div>
				<input type="checkbox" id="rua_title"
					   name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_title" <?php echo checked( in_array( 'rua_title', $checkboxes, true ), 1 ); ?>>
				<label for="rua_title"><?php _e( 'Title (hooks to <code>the_title()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
			<div>
				<input type="checkbox" id="rua_excerpt"
					   name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_excerpt" <?php echo checked( in_array( 'rua_excerpt', $checkboxes, true ), 1 ); ?>>
				<label for="rua_excerpt"><?php _e( 'Excerpt (hooks to <code>the_excerpt()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
			<div>
				<input type="checkbox" id="rua_widget_title"
					   name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_widget_title" <?php echo checked( in_array( 'rua_widget_title', $checkboxes, true ),
					1 ); ?>>
				<label for="rua_widget_title"><?php _e( 'Widget title (hooks to <code>widget_title()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
			<div>
				<input type="checkbox" id="rua_tags"
					   name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_tags" <?php echo checked( in_array( 'rua_tags', $checkboxes, true ),
					1 ); ?>>
				<label for="rua_tags"><?php _e( 'Tags (hooks to <code>the_tags()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
			<div>
				<input type="checkbox" id="rua_category"
					   name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_category" <?php echo checked( in_array( 'rua_category', $checkboxes, true ),
					1 ); ?>>
				<label for="rua_category"><?php _e( 'Categories (hooks to <code>the_category()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
			<div>
				<input type="checkbox" id="rua_content"
					   name="rua_options[<?php echo esc_attr( $args['label_for'] ); ?>][]"
					   value="rua_content" <?php echo checked( in_array( 'rua_content', $checkboxes, true ), 1 ); ?>>
				<label for="rua_content"><?php _e( 'Content (hooks to <code>the_content()</code>)',
						'remove-uppercase-accents' ); ?></label>
			</div>
		</fieldset>
		<?php
	}

	function rua_options_page() {
		add_menu_page(
			'Remove Uppercase Accents',
			'Remove Uppercase Accents',
			'manage_options',
			'remove-uppercase-accents',
			[ $this, 'rua_options_page_html' ]
		);
	}

	function rua_options_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'rua_messages',
				'rua_message',
				__( 'Settings Saved', 'remove-uppercase-accents' ),
				'updated' );
		}
		settings_errors( 'rua_messages' );
		$options = get_option( 'rua_options' );
		$current = isset( $options['rua_field_mode'] ) && $options['rua_field_mode'] ? $options['rua_field_mode'] : '';
		?>
		<div id="rua_form" class="wrap" data-current="<?php echo $current; ?>">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'rua' );
				do_settings_sections( 'rua' );
				submit_button( __( 'Save Settings', 'remove-uppercase-accents' ) );
				?>
			</form>
		</div>
		<?php
	}

	function rua_options_validate( $input ) {
		$input['rua_field_selectors'] = preg_replace( '/\s+/',
			' ',
			esc_attr( $input['rua_field_selectors'] ) );

		return $input;
	}

	function enqueues( $hook ) {
		if ( 'toplevel_page_remove-uppercase-accents' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'rua-styles',
			plugins_url( '/admin/css/styles.css', dirname( __FILE__ ) ),
			[],
			RUA_VERSION );
		wp_enqueue_script( 'rua-scripts',
			plugins_url( '/admin/js/scripts.js', dirname( __FILE__ ) ),
			[],
			RUA_VERSION,
			true );
	}
}