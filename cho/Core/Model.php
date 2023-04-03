<?php

namespace Cho\Core;

class Model {

	protected $config = null;
	protected $helper = null;
	protected $data   = array();
	protected $defaults  = array();
	protected $args      = array();

	function __construct( $args = array() ) {
		$this->config = new \Cho\Config;
		$this->helper = new \Cho\Helper;
		$this->args = $this->helper->parse_args( $args, $this->defaults );
		return $this->start();
	}

	protected function start() {
		return true;
	}

	public function fill( $raw_data ) {
		return true;
	}

	public function get_data() {
		return $this->data;
	}

	public function get_json_data() {
		return json_encode( $this->get_data(), JSON_PRETTY_PRINT );
	}

}
