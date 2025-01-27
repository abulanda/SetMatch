<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
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
Routing::post('login', 'SecurityController');
Routing::post('register', 'RegisterController');
Routing::get('logout', 'SecurityController');
Routing::post('createTeamTransaction', 'DefaultController');
Routing::post('createMatchTransaction', 'DefaultController');
Routing::get('joinMatch', 'DefaultController');
Routing::get('leaveMatch', 'DefaultController');
Routing::get('searchMatchesAjax', 'DefaultController');

Routing::get('admin', 'AdminController');
Routing::get('deleteUser', 'AdminController');
Routing::get('deleteTeam', 'AdminController');
Routing::get('deleteMatch', 'AdminController');

Routing::get('checkUserExistsAjax','DefaultController');



Routing::run($path);
