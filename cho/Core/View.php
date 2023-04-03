<?php

namespace Cho\Core;

class View {

	protected $tpl = null;
	protected $config = null;
	protected $helper = null;

	function __construct() {
		$this->config = new \Cho\Config;
		$this->helper = new \Cho\Helper;
		$this->tpl = new \League\Plates\Engine( CHO_ABSPATH . '/templates' );
		$this->add_helper();
		$this->add_variables();
	}

	protected function build( $template, $data = null ) {
		$template->data( $data );
		return $template->render();
	}

	private function add_helper() {

		$this->tpl->registerFunction( 'nothing', function( $string ) {
			return $string;
		});

		$this->tpl->registerFunction( 'utf8_encode', function( $string ) {
			return utf8_encode( $string );
		} );

		$this->tpl->registerFunction( 'shorten', function( $string ) {
			return substr( $string, 0, 50 ) . '...';
		});

		$this->tpl->registerFunction( 'strip', function( $string ) {
			return strip_tags( $string, '<b><i><strong><em><a>' );
		});

		$this->tpl->registerFunction( 'hostname', function( $string ) {
			return hostname_of_uri( $string );
		});

		$this->tpl->registerFunction( 'nl2p', function( $string ) {
			$paragraphs = '';
			$string = nl2br( $string, false );
			foreach ( explode( '<br>', $string ) as $line ) {
				if ( trim( $line ) ) {
					$paragraphs .= '<p>' . trim( $line ) . '</p>';
				}
			}
			return $paragraphs;
		});

		$this->tpl->registerFunction( 'nl2br', function( $string ) {
			return preg_replace( '#(\s*<br\s*/?>)*\s*$#i', '', nl2br( $string ) );
		});

		$this->tpl->registerFunction( 'time_ago', function( $string ) {
			return $this->helper->get_timeago( $string );
		});

		$this->tpl->registerFunction( 'build_url', function( $string ) {
			return $this->helper->build_url( $string );
		});

	}

	private function add_variables() {

		$this->tpl->addData( [ 'title' => $this->config->get_name() ] );
		$this->tpl->addData( [ 'root_url' => $this->config->get_root() ] );

	}

}
