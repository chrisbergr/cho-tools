<?php

namespace App\Presenter;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Website_new_pin extends \Cho\Core\Presenter {

	public function start() {
		$this->view = new \App\View\Website_new_pin;
	}

	public function index( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$response->getBody()->write( $this->view->index() );
		return $response;

	}

	public function tags( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$request = new \App\Collection\Pins_tags();

		$data = array(
			'request' => $request->get_data(),
		);

		$response->getBody()->write( $this->view->tags( $data ) );
		return $response;

	}

	public function images( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		if ( isset( $_POST['site_url'] ) ) {
			$url = $_POST['site_url'];
		} else {
			$url = $_GET['site_url'];
		}

		$request = new \App\Collection\Pins_images( array( 'url' => $url ) );

		$data = array(
			'request' => $request->get_data(),
		);

		$response->getBody()->write( $this->view->images( $data ) );
		return $response;

	}

	public function receiver( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$form_title       = htmlentities( $_POST['form_title'], ENT_QUOTES, 'UTF-8' );
		$form_image       = htmlentities( $_POST['form_image'], ENT_QUOTES, 'UTF-8' );
		$form_bookmark    = htmlentities( $_POST['form_bookmark'], ENT_QUOTES, 'UTF-8' );
		$form_description = htmlentities( $_POST['form_description'], ENT_QUOTES, 'UTF-8' );
		$form_tags        = '';

		if ( isset( $_POST['form_tags'] ) ) {
			$form_tags = $_POST['form_tags'];
			if ( ! is_array( $form_tags ) ) {
				$form_tags = explode( ',', $form_tags );
			}
		}

		$args = array(
			'title'            => $form_title,
			'pins-media'       => $form_image,
			'pins-bookmark'    => $form_bookmark,
			'pins-description' => $form_description,
			'pins-tags'        => $form_tags,
		);

		$request = new \App\Inserter\Website_pin( $args );

		$data = array(
			'request' => $request->get_data(),
		);

		$response->getBody()->write( $this->view->receiver( $data ) );
		return $response;

	}

}
