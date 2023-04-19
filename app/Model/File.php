<?php

namespace App\Model;

class File extends \Cho\Core\Model {

	protected function start() {
		// nothing
	}

	public function fill( $raw_data ) {
		$data = array(
			'type'      => 'file',
			'name'      => basename( $raw_data['path'] ),
			'path'      => $raw_data['path'],
			'url'       => $this->config->get_images_base() . '/uploads/' . $raw_data['path'],
			'file_size' => $raw_data['file_size'],
		);
		$this->data = $data;
	}

}
