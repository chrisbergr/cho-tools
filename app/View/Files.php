<?php

namespace App\View;

class Files extends \Cho\Core\View {

	public function index( $data = null ) {
		//return $this->build( $this->tpl->make( 'pages/home/index' ), $data );
	}

	public function upload( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/files/upload' ), $data );
	}

	public function upload_receiver( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/files/upload-receiver' ), $data );
	}

	public function list( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/files/list' ), $data );
	}

	public function detail( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/files/detail' ), $data );
	}

}
