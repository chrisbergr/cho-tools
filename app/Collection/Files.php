<?php

namespace App\Collection;

class Files extends \Cho\Core\Collection {

	protected $defaults  = array(
		'path' => '/',
	);

	protected function start() {
		$this->meta['name'] = 'Files Collection';
	}

	protected function collect() {

		$ftp      = $this->helper->use_ftp();
		$raw_data = $ftp->listContents( $this->get_arg( 'path' ) )->toArray();

		foreach( $raw_data as $data ) {
			if( 'file' === $data['type'] ) {
				$model = new \App\Model\File();
			} else {
				$model = new \App\Model\Dir();
			}
			$model->fill( $data );
			$this->items[] = $model->get_data();
		}

	}

}
