<?php

require_once __DIR__ . '/../Database.php';

class RegisterController
{
    public function register()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['signup_data'])) {

            $name = $_SESSION['signup_data']['name'];
            $surname = $_SESSION['signup_data']['surname'];
            $username = $_SESSION['signup_data']['username'];
            $email = $_SESSION['signup_data']['email'];
            $password = password_hash($_SESSION['signup_data']['password'], PASSWORD_BCRYPT);


            $city = $_POST['city'];
            $advancement = $_POST['advancement'];
            $position = $_POST['position'];
            $profilePicture = null;


            if (!empty($_FILES['profile-picture']['name'])) {
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($_FILES["profile-picture"]["name"]);
                if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $targetFile)) {
                    $profilePicture = $targetFile;
                } else {
                }
            }

            try {
                $db = new Database();
                $pdo = $db->connect();

                $stmt = $pdo->prepare("
                    INSERT INTO users 
                    (first_name, last_name, nickname, email, password, city, skill_level, position, profile_picture)
                    VALUES 
                    (:first_name, :last_name, :nickname, :email, :password, :city, :skill_level, :position, :profile_picture)
                ");

                $stmt->execute([
                    ':first_name'      => $name,
                    ':last_name'       => $surname,
                    ':nickname'        => $username,
                    ':email'           => $email,
                    ':password'        => $password,
                    ':city'            => $city,
                    ':skill_level'     => $advancement,
                    ':position'        => $position,
                    ':profile_picture' => $profilePicture
                ]);


                header("Location: /home");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Debug: Session data or POST data is missing.<br>";
        }
    }
}