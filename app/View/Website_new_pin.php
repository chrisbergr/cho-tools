<?php

namespace App\View;

class Website_new_pin extends \Cho\Core\View {

	public function index( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/website/new-pin/index' ), $data );
	}

	public function tags( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/website/new-pin/tags' ), $data );
	}

	public function images( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/website/new-pin/images' ), $data );
	}

	public function receiver( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/website/new-pin/receiver' ), $data );
	}

}
