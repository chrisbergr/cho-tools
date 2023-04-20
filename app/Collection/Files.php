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

		$path        = $this->get_arg( 'path' );
		$ftp         = $this->helper->use_ftp();
		$raw_data    = $ftp->listContents( $path )->toArray();
		$items_dir   = array();
		$items_files = array();

		if( '/' !== $path ) {
			$up_path = str_replace( basename( $path ), '', $path );
			$up_path = str_replace( '//', '/', $up_path );
			$this->meta['dir_up'] = $up_path;
		}

		foreach( $raw_data as $data ) {
			if( 'file' === $data['type'] ) {
				$model = new \App\Model\File();
				$model->fill( $data );
				$items_files[] = $model->get_data();
			} else {
				$model = new \App\Model\Dir();
				$model->fill( $data );
				$items_dir[] = $model->get_data();
			}
		}

		$this->items = array_merge( $items_dir, $items_files );

	}

}
