<?php

namespace Cho\Core;

class inserter {

	protected $config   = null;
	protected $helper   = null;
	protected $defaults = array();
	protected $data     = array();
	protected $response = array();

	function __construct( $data = array() ) {
		$this->config = new \Cho\Config;
		$this->helper = new \Cho\Helper;
		$this->defaults = $this->set_defaults();
		$this->data = $this->helper->parse_args( $data, $this->defaults );
		return $this->process();
	}

	protected function set_defaults() {
		return array();
	}

	protected function process() {
		return true;
	}

	public function get_data() {
		return $this->response;
	}

	public function get_json_data() {
		return json_encode( $this->get_data(), JSON_PRETTY_PRINT );
	}

}
