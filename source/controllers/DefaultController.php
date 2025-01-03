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
        $this->render('addmatch');
    }

    public function addteam1()
    {
        $this->render('addteam1');
    }

    public function calendar()
    {
        $this->render('calendar');
    }

    public function home()
    {
        $this->render('home');
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
        $this->render('temp');
    }

    public function myteams()
    {
        $this->render('myteams');
    }
}