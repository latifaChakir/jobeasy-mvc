<?php
namespace App\Controllers;

use App\Models\JobModel;

class DashboardController {
    private $jobModel;

    public function __construct($conn) {
        $this->jobModel = new JobModel($conn);
    }

    public function index() {
        session_start();

        if ($_SESSION['role'] !== 'admin') {
            header("Location:?route=home");
            exit();
        }

        $allOffres = $this->jobModel->getOffres();

        require(__DIR__ .'../../../view/admin/index.php');
    }

   
}
