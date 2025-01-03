<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';

class SecurityController extends AppController {

    public function login()
    {
        $user = new \models\User('jsnow', 'admin', 'Johnny', 'Snow');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('login');
        }

        $login = $_POST['login'];
        $password = $_POST['password'];

        if ($user->getLogin() !== $login) {
            return $this->render('login', ['messages' => ['User with this login does not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $url = "http://{$_SERVER['HTTP_HOST']}";
        header("Location: {$url}/home");
    }
}