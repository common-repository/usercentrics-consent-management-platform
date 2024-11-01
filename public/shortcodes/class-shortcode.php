<?php

class UC_Shortcode {

	/**
	 * The shortcode handle.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var string $handle The shortcode handle
	 */
	protected $handle;


	/**
	 * The shortcode file.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var string $partial The shortcode file
	 */
	protected $partial;


	/**
	 * @return array
	 */
	public function getDefaultAttributes() {
		return [
			'class' => ''
		];
	}

	/**
	 * @return array
	 */
	public function getStyles() {
		return [];
	}

	/**
	 * @return array
	 */
	public function getScripts() {
		return [];
	}

	/**
	 * @return false|string
	 */
	public function render($attributes) {
		ob_start();
		$attributes = shortcode_atts($this->getDefaultAttributes(), $attributes, $this->handle );
		$class = $this->handle . " " . $attributes['class'];
		include(  plugin_dir_path( __FILE__ ) . '../partials/shortcodes/'  . $this->partial ) ;
		return ob_get_clean();
	}

}