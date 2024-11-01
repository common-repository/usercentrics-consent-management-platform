<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webnique.de
 * @since      1.0.0
 *
 * @package    Usercentrics
 * @subpackage Usercentrics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Usercentrics
 * @subpackage Usercentrics/public
 * @author     Webnique <darius@webnique.de>
 */
class Usercentrics_Public {

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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/usercentrics-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		$uc_settings = get_option( $this->plugin_name . '_settings_id' );

		if ( ! empty( $uc_settings ) && $uc_settings !== '' ) {
			wp_enqueue_script( $this->plugin_name . '_ext_main', 'https://app.usercentrics.eu/latest/main.js', array(), null );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/usercentrics-public.js', array( $this->plugin_name . '_ext_main' ), $this->version, true );
		}

	}

	/**
	 * Filter the Usercentrics Script Tag and add Attributes.
	 *
	 * @param $tag
	 * @param $handle
	 * @param $src
	 *
	 * @return string
	 *
	 * @since    1.0.0
	 */
	public function filter_scripts( $tag, $handle, $src ): string {

		$uc_settings = get_option( $this->plugin_name . '_settings_id' );

		if ( ! empty( $uc_settings ) && $uc_settings !== '' && $this->plugin_name . '_ext_main' === $handle ) {
			$tag = '<!-- Usercentrics CMP --><script type="text/javascript" src="' . esc_url( $src ) . '" id="' . esc_attr( $uc_settings ) . '"></script>';
		}

		return $tag;

	}

	/**
	 * Add meta tags to HTML <head>.
	 *
	 * @since    1.0.0
	 */
	public function add_meta(): void {

		$uc_settings = get_option( $this->plugin_name . '_settings_id' );

		if ( ! empty( $uc_settings ) && $uc_settings !== '' ) {
			$locale = substr( get_locale(), 0, 2 );
			echo "<meta http-equiv='language' content='" . $locale . "'>";
		}

	}

	/**
	 * Embed the Google Tag Manager in the Head section.
	 *
	 * @since      1.0.0
	 */
	public function embed_gtm_head(): void {

		$uc_settings = get_option( $this->plugin_name . '_settings_id' );
		$gtm         = get_option( $this->plugin_name . '_gtm_id' );

		if ( ! empty( $gtm ) && ! empty( $uc_settings ) ) {
			?>
            <!-- Google Tag Manager -->
            <script type="text/plain" data-usercentrics="Google Tag Manager">(function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                  'gtm.start':
                      new Date().getTime(), event: 'gtm.js',
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
              })(window, document, 'script', 'dataLayer', '<?php echo $gtm; ?>');
            </script>
            <!-- End Google Tag Manager -->
			<?php
		}
	}

	/**
	 * Embed the Google Tag Manager in the Body section.
	 *
	 * @since      1.0.0
	 */
	public function embed_gtm_body(): void {
		$uc_settings = get_option( $this->plugin_name . '_settings_id' );
		$gtm         = get_option( $this->plugin_name . '_gtm_id' );

		if ( ! empty( $gtm ) && ! empty( $uc_settings ) ) {
			?>
            <!-- Google Tag Manager (noscript) -->
            <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm; ?>"
                        height="0" width="0" style="display:none;visibility:hidden"></iframe>
            </noscript>
            <!-- End Google Tag Manager (noscript) -->
			<?php
		}
	}

	/**
	 * Add Shortcodes.
	 *
	 * @since      1.0.0
	 */
	public function add_shortcodes(): void {

		$uc_settings = get_option( $this->plugin_name . '_settings_id' );

		if ( empty( $uc_settings ) || $uc_settings === '' ) {
			return;
		}

		require_once plugin_dir_path( __FILE__ ) . 'shortcodes/class-shortcode.php';
		require_once plugin_dir_path( __FILE__ ) . 'shortcodes/class-uc-embed.php';

		$uc_embed = new UC_Embed();

		add_shortcode( $uc_embed->handle, function ( $attributes ) use ( $uc_embed ) {
			return $uc_embed->render( $attributes );
		} );
	}

	/**
	 * Add DNS preconnects.
	 *
	 * @param array $urls
	 * @param string $relation_type
	 *
	 * @return array
	 *
	 * @since 1.0.7
	 */
	public function add_dns_preconnects( array $urls, string $relation_type ): array {

		$uc_settings = get_option( $this->plugin_name . '_settings_id' );

		if ( ! empty( $uc_settings ) ) {

			$uc_urls = [
				'//app.usercentrics.eu',
				'//api.usercentrics.eu',
				'//aggregator.service.usercentrics.eu'
			];

			if ( $relation_type === 'preconnect' ) {
				$urls = array_merge( $urls, $uc_urls );
			}

			if ( $relation_type === 'dns-prefetch' ) {
				foreach ( $urls as $i => $url ) {
					if ( in_array( '//' . $url, $uc_urls ) ) {
						unset( $urls[ $i ] );
					}
				}
			}

		}

		return $urls;

	}
}
