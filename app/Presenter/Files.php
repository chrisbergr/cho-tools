<?php

namespace App\Presenter;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Files extends \Cho\Core\Presenter {

	public function start() {
		$this->view = new \App\View\Files;
	}

	public function index( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		//$adapter = new \League\Flysystem\Ftp\FtpAdapter(
		//	// Connection options
		//	\League\Flysystem\Ftp\FtpConnectionOptions::fromArray([
		//		'host'     => $this->config->get_images_ftp_host(),
		//		'root'     => $this->config->get_images_ftp_root(),
		//		'username' => $this->config->get_images_ftp_username(),
		//		'password' => $this->config->get_images_ftp_password(),
		//	]),
		//	new \League\Flysystem\Ftp\FtpConnectionProvider(),
		//	new \League\Flysystem\Ftp\NoopCommandConnectivityChecker(),
		//	new \League\Flysystem\UnixVisibility\PortableVisibilityConverter()
		//);

		//// The FilesystemOperator
		//$filesystem = new \League\Flysystem\Filesystem($adapter);

		//print_r((array) $filesystem->listContents('/render')->toArray());

		$path = '/';
		if ( isset( $_GET['path'] ) ) {
			$path = $_GET['path'];
		}


		$files = new \App\Collection\Files( array( 'path' => $path ) );

		print_r( $files->get_json_data() );

		die();

		//$data = array(
		//	'new_pin_url' => $this->config->get_root() . '/website/new-pin/',
		//	'greeting'    => '<p>Hello hello! I am the Home Presenter</p><p><img src="' . $this->helper->get_image_url( 'render/cho-cover--10.png', ['w' => 500, 'fit' => 'crop', 'q' => 100, 'sharp' => 10, 'dpr' => 2] ) . '" width="500"></p>',
		//);

		//$response->getBody()->write( $this->view->index( $data ) );
		//return $response;

	}

	public function upload( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$response->getBody()->write( $this->view->upload() );
		return $response;

	}

	public function upload_receiver( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$notice = '';
		$path   = '/';
		$config = array(
			'visibility' => 'public',
		);

		if ( isset( $_POST['the_path'] ) ) {
			$path = $_POST['the_path'];
		}

		if ( isset( $_FILES['the_file'] ) ) {

			$the_file      = $_FILES['the_file'];
			$fileName      = $the_file['name'];
			$fileExtTmp    = explode( '.', $fileName );
			$fileExtension = strtolower( end( $fileExtTmp ) );
			$targetName    = time() . '.' . $fileExtension;
			$path          = $path . basename( $targetName );

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

			try {

				$contents = file_get_contents( $the_file['tmp_name'] );
				$filesystem->write( $path, $contents, $config );

				$notice = 'New File ' . $path . ' created';

			} catch ( \League\Flysystem\FilesystemException | \League\Flysystem\UnableToWriteFile $exception ) {
				$notice = $exception;
			}

		} else {
			$notice = 'No File submitted';
		}

		$data = array(
			'notice' => $notice,
		);

		$response->getBody()->write( $this->view->upload_receiver( $data ) );
		return $response;

	}

	public function screenshot( ServerRequestInterface $request, array $args ) {

		$response = new \Laminas\Diactoros\Response;

		$browser = (new \HeadlessChromium\BrowserFactory()) -> createBrowser();

		//$urlToCapture = "https://packagist.org/packages/chrome-php/chrome";
		$urlToCapture = "https://christian-hockenberger.com";

		try {

			$page = $browser -> createPage();
			$page -> setViewport(1280, 720);
			$page -> navigate($urlToCapture) -> waitForNavigation();

			//$screenshot = $page->screenshot([
			//	'captureBeyondViewport' => true,
			//	'clip' => $page->getFullPageClip(),
			//	'format' => 'jpeg', // default to 'png' - possible values: 'png', 'jpeg',
			//]);


			$screenshot = $page -> screenshot();

			$resp = $screenshot->getResponseReader()->waitForResponse(null);

			$screenshot = base64_decode( $resp->getResultData('data') );

			//print_r($screenshot);
			//$screenshot -> saveToFile("captureWIthChrome.png");

			$notice = '';
			$config = array(
				'visibility' => 'public',
			);
			$targetName    = time() . '.jpg';
			$path          = '/screenshots/' . basename( $targetName );

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

			try {

				$contents = $screenshot;
				$filesystem->write( $path, $contents, $config );

				$notice = 'New File ' . $path . ' created';

			} catch ( \League\Flysystem\FilesystemException | \League\Flysystem\UnableToWriteFile $exception ) {
				$notice = $exception;
			}

		}
		catch (\Exception $ex) {
			// Something went wrong
		}
		finally {
			$browser -> close();
		}

		//die();

		$data = array(
			'notice' => $notice,
		);

		$response->getBody()->write( $this->view->upload_receiver( $data ) );
		return $response;

	}

}
