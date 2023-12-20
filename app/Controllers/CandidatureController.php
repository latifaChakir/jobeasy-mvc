<?php
namespace App\Controllers;

use App\Models\CandidatureModel;

class CandidatureController {
    private $jobModel;

    public function __construct($conn) {
        $this->jobModel = new CandidatureModel($conn);
    }

    public function index() {
        session_start();

        if ($_SESSION['role'] !== 'admin') {
            header("Location:?route=home");
            exit();
        }

        $allOffres = $this->jobModel->getOffresPostuler();

        require(__DIR__ .'../../../view/admin/offre.php');
    }

   
}
