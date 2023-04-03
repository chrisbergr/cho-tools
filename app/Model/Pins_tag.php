<?php

namespace App\Model;

class Pins_tag extends \Cho\Core\Model {

	protected function start() {
		// nothing
	}

	public function fill( $raw_data ) {
		$data = array(
			'id'          => $raw_data['id'],
			'name'        => $raw_data['name'],
			'description' => $raw_data['description'],
			'count'       => $raw_data['count'],
			'slug'        => $raw_data['slug'],
			'link'        => $raw_data['link'],
			'taxonomy'    => $raw_data['taxonomy'],
		);
		$this->data = $data;
	}

}
