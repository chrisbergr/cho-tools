<?php

namespace App\Model;

class Pins_image extends \Cho\Core\Model {

	protected function start() {
		// nothing
	}

	public function fill( $raw_data ) {
		$data = array(
			'url'    => $raw_data['url'],
			'width'  => $raw_data['width'],
			'height' => $raw_data['height'],
		);
		$this->data = $data;
	}

}
