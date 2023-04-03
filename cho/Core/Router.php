<?php

namespace Cho\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router {

	protected $container  = null;
	protected $router     = null;

	function __construct() {

		$this->container = new \League\Container\Container;
		$this->container->add( 'response', \Zend\Diactoros\Response::class );
		$this->container->add( 'request', \Laminas\Diactoros\ServerRequestFactory::fromGlobals( $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES ) );
		$this->container->add( 'emitter', new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter );
		$this->router = new \League\Route\Router;

		$this->routes_collect();

	}

	private function routes_collect() {

		$this->router->map( 'GET', '/', [ new \App\Presenter\Home, 'index' ] );
		$this->router->map( 'GET', '/test/', [ new \App\Presenter\Home, 'test_rest' ] );

		$this->router->map( 'GET', '/website/new-pin/', [ new \App\Presenter\Website_new_pin, 'index' ] );
		$this->router->map( 'GET', '/website/new-pin/tags/', [ new \App\Presenter\Website_new_pin, 'tags' ] );
		$this->router->map( 'GET', '/website/new-pin/images/', [ new \App\Presenter\Website_new_pin, 'images' ] );
		$this->router->map( 'POST', '/website/new-pin/images/', [ new \App\Presenter\Website_new_pin, 'images' ] );
		$this->router->map( 'POST', '/website/new-pin/receiver/', [ new \App\Presenter\Website_new_pin, 'receiver' ] );

		//$this->routes->map( 'GET', '/receiver/', [ new \App\Presenter\Receiver, 'index' ] );
		//$this->routes->map( 'GET', '/receiver/overland/', [ new \App\Presenter\Receiver, 'overland' ] );
		//$this->routes->map( 'POST', '/receiver/overland/', [ new \App\Presenter\Receiver, 'overland_post' ] );
		//$this->routes->map( 'GET', '/receiver/overland/{page}/', [ new \App\Presenter\Receiver, 'overland' ] );
//
		//$this->routes->map( 'GET', '/history/', [ new \App\Presenter\History, 'index' ] );
		//$this->routes->map( 'GET', '/history/city/', [ new \App\Presenter\History, 'city' ] );
		//$this->routes->map( 'GET', '/history/city/{slug}/', [ new \App\Presenter\History, 'city_by_slug' ] );
//
		//$this->routes->map( 'GET', '/embed/current-location/', [ new \App\Presenter\Embed, 'current_location' ] );
//
		//$this->routes->map( 'GET', '/api/current-location/', [ new \App\Presenter\Api, 'current_location' ] );
		//$this->routes->map( 'GET', '/api/current-map/', [ new \App\Presenter\Api, 'current_map' ] );
//
		//$this->routes->map( 'GET', '/action/', [ new \App\Presenter\Action, 'index' ] );
		//$this->routes->map( 'GET', '/action/go-home/', [ new \App\Presenter\Action, 'go_home' ] );

	}

	public function process() {

		try {

			$response = $this->router->dispatch( $this->container->get( 'request' ) );
			$this->container->get( 'emitter' )->emit( $response );

		} catch ( \League\Route\Http\Exception\NotFoundException $e ) {
			$presenter = new \App\Presenter\Home;
			print_r( $presenter->not_found( $e ) );
		} catch ( \League\Route\Http\Exception\MethodNotAllowedException $e ) {
			$presenter = new \App\Presenter\Home;
			print_r( $presenter->not_allowed( $e ) );
		} catch ( \Laminas\HttpHandlerRunner\Exception\EmitterException $e ) {
			// DO NOTHING
		}

	}

}
