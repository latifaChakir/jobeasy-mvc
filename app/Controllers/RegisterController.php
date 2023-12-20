<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegisterController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            $userModel = new UserModel($this->conn);
            $userModel->setUsername($username);
            $userModel->setEmail($email);
            $userModel->setPassword($password);
            $userModel->setRoleName('candidat');
            if ($userModel->isUsernameTaken()) {
                echo 'Username already exists';
            } else {
                if ($userModel->insertUser()) {
                    header('Location: ../../?route=login');
                    exit();
                } else {
                    echo 'User insertion failed';
                }
            }
        }
        require(__DIR__ .'../../../view/register.php');
    }
}
?>
