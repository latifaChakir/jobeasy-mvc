<?php

namespace App\Controllers;
use App\Models\JobModel; 

class StatistiqueController {
    public $conn;
    private $model;


    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new JobModel($this->conn);
    }

    public function index() {
        $totalOffres = $this->model->getTotalJobs();
        $totalOffresApproved = $this->model->getTotalOffresApproved();
        $totalOffresRejected = $this->model->getTotalOffresRejected();
        $totalOffresPending = $this->model->getTotalOffresAttentes();

        require(__DIR__ .'../../../view/admin/dashboard.php');
    }
}
