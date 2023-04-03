<?php

namespace App\Inserter;

class Website_pin extends \Cho\Core\Inserter {

	protected function set_defaults() {
		return array(
			'title'            => 'Pin ' . time(),
			'status'           => 'publish',
			'pins-media'       => null,
			'pins-bookmark'    => null,
			'pins-description' => '',
			'pins-tags'        => array(),
		);
	}

	protected function process() {

		$request = $this->helper->curl_post(
			$this->config->get_website_receiver_url(),
			array(
				'headers' => array(
					'Authorization: Basic ' . base64_encode( $this->config->get_website_login() . ':' . $this->config->get_website_password() ),
					'Content-type: application/json',
				),
				'body' => $this->data,
			)
		);

		$this->response = json_decode( $request, true );

	}

}
