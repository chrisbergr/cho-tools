<?php

namespace App\Presenter;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Home extends \Cho\Core\Presenter {

	public function start() {
		$this->view = new \App\View\Home;
	}

	public function index( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$data = array(
			'new_pin_url' => $this->config->get_root() . '/website/new-pin/',
			'greeting'    => '<p>Hello hello! I am the Home Presenter</p><p><img src="' . $this->helper->get_image_url( 'render/cho-cover--10.png', ['w' => 500, 'fit' => 'crop', 'q' => 100, 'sharp' => 10, 'dpr' => 2] ) . '" width="500"></p>',
		);

		$response->getBody()->write( $this->view->index( $data ) );
		return $response;

	}

	public function not_found( $expression ) {

		header( 'HTTP/1.0 404 Not Found', true, 404 );

		$data = array(
			'greeting' => '<p>The requested URL was not found on this server.</p>',
		);

		return $this->view->not_found( $data );

	}

	public function not_allowed( $expression ) {

		header( 'HTTP/1.0 405 Method Not Allowed', true, 404 );

		$data = array(
			'greeting' => '<p>The requested URL is not allowed on this server.</p>',
		);

		return $this->view->not_allowed( $data );

	}

	public function test_rest( $expression ) {

		$raw_data = $this->helper->curl_get(
			$this->config->get_website_rest_root_url(),
			array(
				'headers' => array(
					'Authorization: Basic ' . base64_encode( $this->config->get_website_login() . ':' . $this->config->get_website_password() ),
					'Content-type: application/json',
				)
			)
		);
		$raw_data = json_decode( $raw_data, true );

		print_r( json_encode( $raw_data, JSON_PRETTY_PRINT ) );

		die();

		$data = array(
			'greeting' => '<p>The requested URL is not allowed on this server.</p>',
		);

		return $this->view->not_allowed( $data );

	}

}
