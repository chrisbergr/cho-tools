<?php

namespace Cho\Core;

class Collection {

	protected $config    = null;
	protected $helper    = null;
	protected $meta      = array();
	protected $items     = array();
	protected $defaults  = array();
	protected $args      = array();

	function __construct( $args = array() ) {
		$this->config = new \Cho\Config;
		$this->helper = new \Cho\Helper;
		$this->args = $this->helper->parse_args( $args, $this->defaults );
		$this->start();
		return $this->collect();
	}

	protected function start() {
		return true;
	}

	protected function collect() {
		return true;
	}

	protected function get_arg( $key) {
		if ( ! array_key_exists( $key, $this->args ) ) {
			return '';
		}
		return $this->args[$key];
	}

	protected function get_meta() {
		return $this->meta;
	}

	protected function get_items() {
		return $this->items;
	}
	protected function get_items_count() {
		return count( $this->items );
	}

	public function get_data() {
		$data = $this->get_meta();
		$data['size'] = $this->get_items_count();
		$data['items'] = $this->get_items();
		return $data;
	}

	public function get_json_data() {
		return json_encode( $this->get_data(), JSON_PRETTY_PRINT );
	}


}
