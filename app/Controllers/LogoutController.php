<?php

namespace App\Controllers;

class LogoutController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ../../?route=home');
        exit();
    }
}
?>
