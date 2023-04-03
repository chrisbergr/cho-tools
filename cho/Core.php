<?php

namespace Cho;

class Core {

	protected $config  = null;
	protected $kernel  = null;
	protected $router  = null;
	protected $helper  = null;
	private static $instance = null;

	function __construct() {
		$this->config = new Config;
		$this->kernel = new Core\Kernel;
		$this->router = new Core\Router;
		$this->helper = new Helper;
	}

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function get_config() {
		return $this->config;
	}

	public function get_kernel() {
		return $this->kernel;
	}

	public function get_router() {
		return $this->router;
	}

	public function get_helper() {
		return $this->helper;
	}

}
