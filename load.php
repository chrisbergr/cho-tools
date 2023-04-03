<?php

header( 'Content-Type: text/html; charset=utf-8' );
mb_internal_encoding( 'UTF-8' );

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

date_default_timezone_set( 'Europe/Berlin' );

define( 'CHO_START', microtime( true ) );
define( 'CHO_ABSPATH', dirname( __FILE__ ) );

require_once( CHO_ABSPATH . '/vendor/autoload.php' );

use League\Config\Configuration;
use Nette\Schema\Expect;

$cfg = new Configuration([
	'app' => Expect::structure([
		'env'      => Expect::anyOf( 'dev', 'prod' )->default('dev'),
		'home_url' => Expect::string()->required(),
		'name'     => Expect::string()->required(),
	]),
	'images' => Expect::structure([
		'salt' => Expect::string()->required(),
		'base' => Expect::string()->required(),
	]),
	'website' => Expect::structure([
		'login'         => Expect::string()->required(),
		'password'      => Expect::string()->required(),
		'rest_root_url' => Expect::string()->required(),
		'receiver_url'  => Expect::string()->required(),
		'get_tags_url'  => Expect::string()->required(),
	]),
]);

require_once( CHO_ABSPATH . '/config.php' );
