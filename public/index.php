<?php

require_once( '../load.php' );

//$cho = new Cho\Core;
$cho = Cho\Core::get_instance();
$cho->get_router()->process();
