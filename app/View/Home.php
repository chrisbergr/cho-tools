<?php

namespace App\View;

class Home extends \Cho\Core\View {

	public function index( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/home/index' ), $data );
	}

	public function not_found( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/home/404' ), $data );
	}

	public function not_allowed( $data = null ) {
		return $this->build( $this->tpl->make( 'pages/home/405' ), $data );
	}

}
