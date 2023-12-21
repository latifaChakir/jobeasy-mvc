<?php
namespace App\Controllers;
use App\Models\UserModel;

class CondidatController {
    private $userModel;

    public function __construct($conn) {
        $this->userModel = new UserModel($conn);
    }

    public function index() {
        session_start();

        if ($_SESSION['role'] !== 'admin') {
            header("Location:?route=home");
            exit();
        }

        $allUsers = $this->userModel->getAllUsers();

        require(__DIR__ .'../../../view/admin/candidat.php');
    }

   
}
