<?php

namespace Cho;

class Config {

	protected $env  = null;
	protected $name = null;
	protected $root = null;

	protected $images_salt              = null;
	protected $images_base              = null;
	protected $images_base_ftp_host     = null;
	protected $images_base_ftp_root     = null;
	protected $images_base_ftp_username = null;
	protected $images_base_ftp_password = null;

	protected $website_login         = null;
	protected $website_password      = null;
	protected $website_rest_root_url = null;
	protected $website_receiver_url  = null;
	protected $website_get_tags_url  = null;

	/**/

	function __construct() {
		$cfg = CHO_CONFIG;

		$this->env                      = $cfg->get( 'app/env' );
		$this->name                     = $cfg->get( 'app/name' );
		$this->root                     = $cfg->get( 'app/home_url' );
		$this->images_salt              = $cfg->get( 'images/salt' );
		$this->images_base              = $cfg->get( 'images/base' );
		$this->images_base_ftp_host     = $cfg->get( 'images/ftp_host' );
		$this->images_base_ftp_root     = $cfg->get( 'images/ftp_root' );
		$this->images_base_ftp_username = $cfg->get( 'images/ftp_username' );
		$this->images_base_ftp_password = $cfg->get( 'images/ftp_password' );
		$this->website_login            = $cfg->get( 'website/login' );
		$this->website_password         = $cfg->get( 'website/password' );
		$this->website_rest_root_url    = $cfg->get( 'website/rest_root_url' );
		$this->website_receiver_url     = $cfg->get( 'website/receiver_url' );
		$this->website_get_tags_url     = $cfg->get( 'website/get_tags_url' );

	}

	/**/

	public function get_env() {
		return $this->env;
	}

	public function get_name() {
		return $this->name;
	}

	public function get_root() {
		return $this->root;
	}

	public function get_images_salt() {
		return $this->images_salt;
	}

	public function get_images_base() {
		return $this->images_base;
	}

	public function get_images_ftp_host() {
		return $this->images_base_ftp_host;
	}

	public function get_images_ftp_root() {
		return $this->images_base_ftp_root;
	}

	public function get_images_ftp_username() {
		return $this->images_base_ftp_username;
	}

	public function get_images_ftp_password() {
		return $this->images_base_ftp_password;
	}

	public function get_website_login() {
		return $this->website_login;
	}

	public function get_website_password() {
		return $this->website_password;
	}

	public function get_website_rest_root_url() {
		return $this->website_rest_root_url;
	}

	public function get_website_receiver_url() {
		return $this->website_receiver_url;
	}

	public function get_website_get_tags_url() {
		return $this->website_get_tags_url;
	}

}
