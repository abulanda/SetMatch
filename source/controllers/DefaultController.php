<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index()
    {
        $this->render('login');
    }

    public function login()
    {

        $this->render('login');
    }

    public function addMatch()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
        ];
        $this->render('addmatch', $userData);
    }

    public function addteam1()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
        ];
        $this->render('addteam1', $userData);
    }

    public function calendar()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
        ];
        $this->render('calendar', $userData);
    }

    public function home()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
        ];

        $this->render('home', $userData);
    }



    public function signup1()
    {
        $this->render('signup1');
    }

    public function signup2()
    {
        $this->render('signup2');
    }

    public function temp()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userData = [
            'user_id' => $_SESSION['user_id'],
            'nickname' => $_SESSION['nickname'] ?? 'Guest',
            'city' => $_SESSION['city'] ?? 'Unknown',
            'skill_level' => $_SESSION['skill_level'] ?? 'N/A',
            'position' => $_SESSION['position'] ?? 'N/A',
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
        ];

        $this->render('temp', $userData);
    }

}