<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webnique.de
 * @since      1.0.0
 *
 * @package    Usercentrics
 * @subpackage Usercentrics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Usercentrics
 * @subpackage Usercentrics/admin
 * @author     Webnique <darius@webnique.de>
 */
class Usercentrics_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @param $hook_suffix
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook_suffix ): void {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Usercentrics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Usercentrics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( $hook_suffix === 'toplevel_page_usercentrics' ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/usercentrics-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param $hook_suffix
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ): void {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Usercentrics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Usercentrics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( $hook_suffix === 'toplevel_page_usercentrics' ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/usercentrics-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Register a custom menu page.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu(): void {

		add_menu_page(
			__( 'Usercentrics CMP', $this->plugin_name ), // page_title
			__( 'Usercentrics CMP', $this->plugin_name ), // menu_title
			'manage_options', // capability
			$this->plugin_name, // menu_slug
			[ $this, 'admin_page' ], // function
			'data:image/svg+xml;base64,' . base64_encode( '<svg width="20px" height="19px" viewBox="0 0 20 19" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="favicon" transform="translate(-15.000000, -18.000000)" fill-rule="nonzero"><g id="Usercentrics" transform="translate(15.000000, 18.000000)"><circle id="Oval" fill="#0095FF" cx="10.4266546" cy="9.41956882" r="3.91979496"></circle><circle id="Oval" fill="#B8CEE1" cx="18.4652495" cy="1.50761345" r="1.50761345"></circle><circle id="Oval" fill="#0D47A1" cx="15.4530378" cy="15.8420021" r="2.71370421"></circle><circle id="Oval" fill="#F25900" cx="2.11065883" cy="12.7121966" r="2.11065883"></circle></g></g></g></svg>' ), // icon_url
			6 // position
		);

	}

	/**
	 * Admin Page
	 *
	 * @since    1.0.0
	 */
	public function admin_page(): void {
		require plugin_dir_path( __FILE__ ) . '/partials/usercentrics-admin-display.php';
	}


	/**
	 * Add some meta links to the plugin description.
	 *
	 * @param $links
	 * @param $file
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function admin_meta( $links, $file ): array {
		$plugin_file = $this->plugin_name . '/' . $this->plugin_name . '.php';
		if ( $file == $plugin_file ) {
			return array_merge(
				$links,
				array(
					'<a target="_blank" href="https://webnique.de/plugins/usercentrics">' . __( 'Get Support', $this->plugin_name ) . '</a>',
				)
			);
		}

		return $links;
	}

	/**
	 * Register settings.
	 *
	 * @since    1.0.0
	 */
	public function register_setting(): void {

		// Add Sections & Settings Fields. Please provide a callback function named as the settings key plus "_cb".
		$sections = array(
			array(
				'id'     => 'general',
				'label'  => __( 'General', $this->plugin_name ),
				'fields' => array(
					'settings_id' => __( 'Usercentrics Settings ID', $this->plugin_name ),
				)
			),
			array(
				'id'     => 'gtm',
				'label'  => __( 'Google Tag Manager', $this->plugin_name ),
				'fields' => array(
					'gtm_id' => __( 'Google Tag Manager Container ID', $this->plugin_name ),
				)
			),
			array(
				'id'    => 'shortcodes',
				'label' => __( 'Shortcodes', $this->plugin_name ),
			)
		);

		foreach ( $sections as $i => $section ) {

			if ( ! empty( $section['id'] ) && ! empty( $section['label'] ) && method_exists( $this, 'display_settings_' . $section['id'] . '_cb' ) ) {

				// Add section.
				add_settings_section(
					$this->plugin_name . '_' . $section['id'],
					$section['label'],
					[ $this, 'display_settings_' . $section['id'] . '_cb' ],
					$this->plugin_name
				);

				if ( ! empty( $section['fields'] ) ) {

					foreach ( $section['fields'] as $key => $label ) {

						$field_slug = $this->plugin_name . '_' . $key;

						// Add field.
						add_settings_field(
							$field_slug,
							$label,
							array( $this, $field_slug . '_cb' ),
							$this->plugin_name,
							$this->plugin_name . '_' . $section['id'],
							array( 'label_for' => $field_slug )
						);

						register_setting( $this->plugin_name, $field_slug );

					}
				}

			}

		}

	}

	/**
	 * Display general settings callback function.
	 *
	 * @param $arg
	 *
	 * @since    1.0.0
	 */
	public function display_settings_general_cb( $arg ): void {

		echo '<p>' . __( 'Please enter your personal Usercentrics Settings ID. You will find it in your <a href="https://admin.usercentrics.com/#/" target="_blank">Usercentrics Dashboard</a>.', $this->plugin_name ) . '</p>';

		echo '<p><strong>' . __( 'Please note:', $this->plugin_name ) . '</strong>' . ' ' . __( 'Make sure that in your settings the correct domain is stored (under “General” -> “Domain”). Only if this is ensured, the Usercentrics script can be executed on your website.', $this->plugin_name ) . '</p>';

		echo '<p><strong>' . __( 'Important:', $this->plugin_name ) . '</strong>' . ' ' . __( 'If you are using any kind of minification plugin (like WP Rocket or Autoptimize) please make sure to exclude <strong>app.usercentrics.eu/latest/main.js</strong> from being combined or compressed. Please just leave it untouched.', $this->plugin_name ) . '</p>';
	}

	/**
	 * Display gtm settings callback function.
	 *
	 * @param $arg
	 *
	 * @since    1.0.0
	 */
	public function display_settings_gtm_cb( $arg ): void {

		echo '<p>' . __( 'To be GDPR/CCPA compliant it is crucial to embed the Google Tag Manager in a specific manner. Therefore you will have to remove any existing Google Tag Manager inclusions before using this plugin.', $this->plugin_name ) . '</p>';

	}

	/**
	 * Display shortcodes callback function.
	 *
	 * @param $arg
	 *
	 * @since    1.0.0
	 */
	public function display_settings_shortcodes_cb( $arg ): void {

		echo '<p>' . __( 'If you want to list tags configured within Usercentrics for example on your privacy policy page you can just use our shortcode. Just copy and paste the shortcode below to your desired page.', $this->plugin_name ) . '</p>';
		echo '<p><span class="wbq-shortcode">' . __( '[uc-embed layout="1" data="all"]', $this->plugin_name ) . '</span></p>';
		echo '<p>' . __( 'For further information on which values to apply for the attributes layout and data please visit the', $this->plugin_name ) . ' ' . '<a href="https://docs.usercentrics.com/#/embeddings" target="_blank">' . __( 'Usercentrics Documentation', $this->plugin_name ) . '</a>.</p>';

	}

	/**
	 * Usercentrics settings ID input callback function.
	 *
	 * @param $arg
	 *
	 * @since    1.0.0
	 */
	public function usercentrics_settings_id_cb( $arg ): void {
		$this->print_input( 'text', $arg['label_for'] );
	}

	/**
	 * Print input fields
	 *
	 * @param $type
	 * @param $label
	 *
	 * @since    1.0.0
	 */
	public function print_input( $type, $label ): void {

		$option = get_option( $label ) ? get_option( $label ) : '';

		switch ( $type ) {
			case 'text':
				?>
                <input name="<?php echo $label; ?>" type="text" id="<?php echo $label ?>" value="<?php echo $option; ?>" class="regular-text">
				<?php
				break;

		}

	}

	/**
	 * Google Tag Manager input callback function.
	 *
	 * @param $arg
	 *
	 * @since    1.0.0
	 */
	public function usercentrics_gtm_id_cb( $arg ): void {
		$this->print_input( 'text', $arg['label_for'] );
	}


}
