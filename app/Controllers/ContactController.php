<?php
namespace App\Controllers;

class ContactController {
    private $userModel;

    public function __construct() {
    }

    public function index() {
        session_start();

        if ($_SESSION['role'] !== 'admin') {
            header("Location:?route=home");
            exit();
        }

        require(__DIR__ .'../../../view/admin/contact.php');
    }

   
}
