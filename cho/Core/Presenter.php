<?php

namespace Cho\Core;

class Presenter {

	protected $config = null;
	protected $helper = null;
	protected $view   = null;

	function __construct() {
		$this->config = new \Cho\Config;
		$this->helper = new \Cho\Helper;
		return $this->start();
	}

	protected function getId( $slug ) {
		$slug_parts = explode( "--", $slug );
		$slug_parts_count = count( $slug_parts );
		$the_id = ( $slug_parts_count == 1 ? $slug_parts[0] : $slug_parts[$slug_parts_count - 1] );
		return $the_id;
	}

	protected function start() {
		return true;
	}

}
