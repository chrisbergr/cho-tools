<?php

namespace Cho\Core;

class Kernel {

	protected $greeting = 'Aloha world!';

	public function hello_world() {
		return $this->greeting;
	}

	public function hello_world_print() {
		print_r( $this->hello_world() );
	}

}
