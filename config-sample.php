<?php //config.php

$cfg->merge([
	'app' => [
		'env' => 'dev',
		'name' => 'Tools',
		'home_url' => 'https://tools.example.com',
	],
	'images' => [
		'base' => 'https://images.example.com',
		'salt' => 'xoxoxo',
	],
	'website' => [
		'login' => 'chrisbergr',
		'password' => 'xxxx xxxx xxxx xxxx xxxx xxxx',
		'rest_root_url' => 'https://example.com/wp-json/wp/v2',
		'receiver_url' => 'https://example.com/wp-json/wp/v2/pins',
		'get_tags_url' => 'https://example.com/wp-json/wp/v2/pins-tags?per_page=100',
	],
]);

define( 'CHO_CONFIG', $cfg );
