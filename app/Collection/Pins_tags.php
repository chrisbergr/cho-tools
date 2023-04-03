<?php

namespace App\Collection;

class Pins_tags extends \Cho\Core\Collection {

	protected function start() {
		$this->meta['name'] = 'Tags Collection';
	}

	protected function collect() {
		$raw_data = $this->helper->curl_get(
			$this->config->get_website_get_tags_url(),
			array(
				'headers' => array(
					'Authorization: Basic ' . base64_encode( $this->config->get_website_login() . ':' . $this->config->get_website_password() ),
					'Content-type: application/json',
				)
			)
		);
		$raw_data = json_decode( $raw_data, true );
		foreach( $raw_data as $data ) {
			$model = new \App\Model\Pins_tag();
			$model->fill( $data );
			$this->items[] = $model->get_data();
		}
	}

}
