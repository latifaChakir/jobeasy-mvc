<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $userModel = new UserModel($this->conn);
            $userModel->setUsername($username);
            $userModel->loginUser($password);
        } else {
            require(__DIR__ .'../../../view/login.php');
        }
    }
}
?>
