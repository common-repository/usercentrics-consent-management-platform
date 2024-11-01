<?php

class UC_Embed extends UC_Shortcode {

	/**
	 * @var string
	 *
	 * @since      1.0.0
	 */
	public $handle = 'uc-embed';

	/**
	 * @var string
	 *
	 * @since      1.0.0
	 */
	protected $partial = 'uc-embed.php';

	public function getDefaultAttributes() {
		return array_merge(
			parent::getDefaultAttributes(),
			[
				'layout' => 1,
				'data'   => 'all'
			]
		);
	}


}