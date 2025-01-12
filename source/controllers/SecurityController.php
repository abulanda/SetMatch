<?php

require_once 'AppController.php';
require_once __DIR__ . '/../Database.php';

class SecurityController extends AppController {

    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('login');
        }

        $nickname = $_POST['login'];
        $password = $_POST['password'];

        try {

            $db = new Database();
            $pdo = $db->connect();


            $stmt = $pdo->prepare("SELECT * FROM users WHERE nickname = :nickname");
            $stmt->execute([':nickname' => $nickname]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                return $this->render('login', ['messages' => ['Invalid login or password.']]);
            }

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['nickname'] = $user['nickname'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['city'] = $user['city'];
            $_SESSION['skill_level'] = $user['skill_level'];
            $_SESSION['position'] = $user['position'];
            $_SESSION['profile_picture'] = $user['profile_picture'];

            header("Location: /home");
            exit();
        } catch (PDOException $e) {
            return $this->render('login', ['messages' => ['Database error: ' . $e->getMessage()]]);
        }
    }


    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /login");
        exit();
    }

}
