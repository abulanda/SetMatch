<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('addmatch', 'DefaultController');
Routing::get('addteam1', 'DefaultController');
Routing::get('calendar', 'DefaultController');
Routing::get('home', 'DefaultController');
Routing::get('signup1', 'DefaultController');
Routing::get('signup2', 'DefaultController');
Routing::get('temp', 'DefaultController');
Routing::get('myteams', 'DefaultController');

Routing::run($path);