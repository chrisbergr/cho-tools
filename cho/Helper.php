<?php

namespace Cho;

use \League\Glide\Urls\UrlBuilderFactory;

class Helper {

	protected $config = null;

	function __construct() {
		$this->config = new \Cho\Config;
	}

	public function convert_utf8( &$item ) {
		if ( !$this->is_utf8( $item ) ) {
			$item = utf8_decode( $item );
		}
	}

	public function force_utf8( $str, $inputEnc = 'WINDOWS-1252' ) {

		if ( $this->is_utf8( $str ) )
			return $str;

		if ( strtoupper( $inputEnc ) === 'ISO-8859-1' )
			return utf8_encode( $str );

		if ( function_exists( 'mb_convert_encoding' ) )
			return mb_convert_encoding( $str, 'UTF-8', $inputEnc );

		if ( function_exists( 'iconv' ) )
			return iconv( $inputEnc, 'UTF-8', $str );

		trigger_error(
			'Cannot convert string to UTF-8 in file '
				. __FILE__ . ', line ' . __LINE__ . '!',
			E_USER_ERROR
		);

	}

	function is_utf8( $str ) {
		return preg_match( "/^(
			 [\x09\x0A\x0D\x20-\x7E]            # ASCII
		   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
		   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
		   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
		   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
		  )*$/x",
		  $str
		);
	}

	public function buildPermalink( $type = false, $id = false, $slug = false ) {
		$params = "";
		if ( $type ) {
			$params .= $type . "/";
		}
		if ( $slug ) {
			$params .= $slug;
			if ( $id ) {
				$params .= "--" . $id;
			}
			$params .= "/";
		} else {
			if ( $id ) {
				$params .= $id . "/";
			}
		}
		return $this->config->get_root() . $params;
	}

	public function sop( $amount, $singular, $plural ) {
		return ( abs( $amount ) >= 2 ? $amount . " " . $plural : $amount . " " . $singular );
	}

	public function utf8ify( $string ) {
		return utf8_decode( $string );
	}

	public function time_ago( $date, $granularity = 2 ) {
		$date = strtotime( $date );
		$difference = time() - $date;
		$periods = array(
			'decade' => 315360000,
			'year' => 31536000,
			'month' => 2628000,
			'week' => 604800,
			'day' => 86400,
			'hour' => 3600,
			'minute' => 60,
			'second' => 1
		);
		$retval = '';
		foreach ( $periods as $key => $value ) {
			if ( $difference >= $value ) {
				$time = floor( $difference / $value );
				$difference %= $value;
				$retval .= ( $retval ? ' ' : '' ) . $time . ' ';
				$retval .= ( ( $time > 1 ) ? $key . 's' : $key );
				$granularity--;
			}
			if ( $granularity == '0' ) {
				break;
			}
		}
		if ( $retval === '' ) {
			$retval = 'Seconds';
		}
		return $retval;
	}

	public function get_timeago( $ptime ) {
		$ptime = strtotime($ptime);
		$estimate_time = time() - $ptime;
		if ( $estimate_time < 1 ) {
			return 'seconds';
		}
		$condition = array(
					12 * 30 * 24 * 60 * 60  =>  'year',
					30 * 24 * 60 * 60       =>  'month',
					24 * 60 * 60            =>  'day',
					60 * 60                 =>  'hour',
					60                      =>  'minute',
					1                       =>  'second'
		);
		foreach ( $condition as $secs => $str ) {
			$d = $estimate_time / $secs;
			if ( $d >= 1 ) {
				$r = round( $d );
				return $r . ' ' . $str . ( $r > 1 ? 's' : '' );
			}
		}
	}

	public function build_url( $slug ) {
		return $this->config->get_root() . $slug;
	}

	public function check_url( $url ) {
		$headers = @get_headers( $url );
		$headers = ( is_array( $headers ) ) ? implode( "\n ", $headers ) : $headers;

		return (bool)preg_match( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
	}

	public function check_url_has_target( $url, $target ) {
		ob_start();
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		$ok = curl_exec( $ch );
		curl_close( $ch );
		$source = ob_get_contents();
		ob_end_clean();
		return ( stristr( $source, $target ) );
	}

	public function copy_image( $image, $path = '' ) {
		$uploads_dir = CHO_ABSPATH . '/public/uploads/' . $path;
		$type = "jpg";
		if ( strpos( $image, '.gif' ) !== false ) {
			$type = "gif";
		}
		if ( strpos( $image, '.png' ) !== false ) {
			$type = "png";
		}
		$filename = md5( $image ) . "." . $type;
		if ( ! file_exists( $uploads_dir . $filename ) ) {
			copy( $image, $uploads_dir . $filename );
		}
		$image = $this->config->get_root() . 'uploads/' . $path . $filename;
		return $image;
	}

	public function get_image_url( $file, $args = array() ) {
		$urlBuilder = UrlBuilderFactory::create( '/uploads/', $this->config->get_images_salt() );
		return $this->config->get_images_base() . $urlBuilder->getUrl( $file, $args );
	}

	//public function get_model_by_type( $id, $model = null ) {
	//	switch( $model ) {
	//		case 'location':
	//			return new \App\Model\Location( $id );
	//		break;
	//		case 'city':
	//			return new \App\Model\City( $id );
	//		break;
	//		default:
	//			return false;
	//		break;
	//	}
	//}

	//public function get_model_filled_by_type( $data, $model = null ) {
	//	switch( $model ) {
	//		case 'location':
	//			return new \App\Model\Location( null, $data );
	//		break;
	//		case 'city':
	//			return new \App\Model\City( null, $data );
	//		break;
	//		default:
	//			return false;
	//		break;
	//	}
	//}

	public function parse_args( $args, $defaults = array() ) {
		if ( is_object( $args ) ) {
			$parsed_args = get_object_vars( $args );
		} elseif ( is_array( $args ) ) {
			$parsed_args =& $args;
		} else {
			parse_str( (string) $args, $parsed_args );
		}

		if ( is_array( $defaults ) && $defaults ) {
			$parsed_args = array_merge( $defaults, $parsed_args );
			$empty_args = array_keys( $parsed_args, '', true );
			foreach ( $empty_args as $empty ) {
				$parsed_args[$empty] = $defaults[$empty];
			}
			return $parsed_args;
		}
		return $parsed_args;
	}

	public function get_base_url( $url ) {
		$url = parse_url( $url, PHP_URL_SCHEME ) . '://' . parse_url( $url, PHP_URL_HOST );
		return trim( $url, '/' );
	}

	public function curl_get( $url, $args = array() ) {
		$agent = 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31';
		if( false !== strpos( $url, 'instagram.com' ) ) {
			$agent = 'Instagram 76.0.0.15.395 Android (24/7.0; 640dpi; 1440x2560; samsung; SM-G930F; herolte; samsungexynos8890; en_US; 138226743)';
		}
		$curl = curl_init( $url );
		curl_setopt( $curl, CURLOPT_USERAGENT, $agent );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $args['headers'] );
		curl_setopt( $curl, CURLOPT_HEADER, false );
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl, CURLOPT_MAXREDIRS, 10 );
		$response = curl_exec( $curl );
		if ( $response === false ) {
			print_r( 'Curl error: ' . curl_error( $curl ) );
		}
		curl_close( $curl );
		return $response;
	}

	public function curl_post( $url, $args = array() ) {
		$agent = 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31';
		$curl = curl_init($url);
		curl_setopt( $curl, CURLOPT_USERAGENT, $agent );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $args['headers'] );
		curl_setopt( $curl, CURLOPT_HEADER, false );
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $args['body'] ) );
		$response = curl_exec( $curl );
		if ( $response === false ) {
			print_r( 'Curl error: ' . curl_error( $curl ) );
		}
		curl_close( $curl );
		//return json_decode( $response, true );
		return $response;
	}

	public function use_ftp() {
		$adapter = new \League\Flysystem\Ftp\FtpAdapter(
			\League\Flysystem\Ftp\FtpConnectionOptions::fromArray( [
				'host'     => $this->config->get_images_ftp_host(),
				'root'     => $this->config->get_images_ftp_root(),
				'username' => $this->config->get_images_ftp_username(),
				'password' => $this->config->get_images_ftp_password(),
			] ),
			new \League\Flysystem\Ftp\FtpConnectionProvider(),
			new \League\Flysystem\Ftp\NoopCommandConnectivityChecker(),
			new \League\Flysystem\UnixVisibility\PortableVisibilityConverter()
		);
		$filesystem = new \League\Flysystem\Filesystem( $adapter );
		return $filesystem;
	}

}
