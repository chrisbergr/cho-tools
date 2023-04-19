<?php

namespace App\Model;

class Dir extends \Cho\Core\Model {

	protected function start() {
		// nothing
	}

	public function fill( $raw_data ) {
		$data = array(
			'type'      => 'dir',
			'name'      => basename( $raw_data['path'] ),
			'path'      => $raw_data['path'],
		);
		$this->data = $data;
	}

}
