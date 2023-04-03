<?php

namespace App\Collection;

class Pins_images extends \Cho\Core\Collection {

	protected function start() {
		$this->meta['name'] = 'Images Collection';
	}

	protected function collect() {
		$raw_data = $this->helper->curl_get(
			$this->get_arg( 'url' ),
			array(
				'headers' => array(
					'Content-type: application/json',
				)
			)
		);

		preg_match_all( "{<img\\s*(.*?)src=('.*?'|\".*?\"|[^\\s]+)(.*?)\\s*/?>}ims", $raw_data, $matches, PREG_SET_ORDER );
		$images = array();
		$image_i = 0;

		foreach ( $matches as $val ) {
			$link = str_replace( '..', '', $val[2] );
			$pos  = strpos( $link, "/" );
			$link = substr( $link, 1, -1 );
			$link = str_replace( '?compress=1&amp;resize=752x', '', $link );
			if ( $pos === 1 ) {
				if( '/' === substr( $link, 0, 1 ) ) {
					$images[]['url'] = 'https:' . $link;
				} else {
					$images[]['url'] = $this->helper->get_base_url( $this->get_arg( 'url' ) ) . $link;
				}
			} else {
				if( 'http' !== substr( $link, 0, 4 ) && 'data' !== substr( $link, 0, 4 ) ) {
					$images[]['url'] = $this->helper->get_base_url( $this->get_arg( 'url' ) ) . '/' . $link;
				} else {
					$images[]['url'] = $link;
				}
			}
		}

		$images = array_unique( $images, SORT_REGULAR );
		$images = array_values( $images );

		foreach ( $images as $image ) {
			list( $images[$image_i]['width'], $images[$image_i]['height'] ) = @getimagesize( $image['url'] );
			$image_i++;
		}

		usort(
			$images,
			function( $a, $b ) {
				return $b['width'] <=> $a['width'];
			}
		);

		foreach( $images as $data ) {
			$model = new \App\Model\Pins_image();
			$model->fill( $data );
			$this->items[] = $model->get_data();
		}
	}

}
