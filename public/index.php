<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/Models/Database.php';

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\NotificationController;
use App\Controllers\RegisterController;
use App\Controllers\DashboardController;
use App\Controllers\AddJobController;
use App\Controllers\DeleteJobController;
use App\Controllers\EditJobController;
use App\Controllers\CandidatureController;
use App\Controllers\ApprovedController;
use App\Controllers\RejectedStatusController;
use App\Controllers\OffreController;
use App\Controllers\SearchController;
use App\Controllers\StatistiqueController;
use App\Models\Database; 


$database = Database::getInstance();
$conn = $database->getConnection();

$route = isset($_GET['route']) ? $_GET['route'] : 'home';

switch ($route) {
    case 'home':
        $controller = new HomeController($conn);
        $controller->index();
        break;
    case 'login':
        $loginController = new LoginController($conn);
        $loginController->login();
        break;
     case 'logout':
            $logoutController = new LogoutController($conn);
            $logoutController->logout();
        break;

    case 'register':
            $registerController = new RegisterController($conn);
            $registerController->register();
        break;

    case 'dashboard':
        $DachboardController = new DashboardController($conn);
        $DachboardController->index();
    break;

    case 'add':
        $AddJobController = new AddJobController($conn);
        $AddJobController->addJob();
    break;

    case 'delete':
        $DeleteJobController = new DeleteJobController($conn);
        $DeleteJobController->deleteJob();
    break;
    case 'edit':
        $EditJobController = new EditJobController($conn);
        $EditJobController->editJob();
    break;

    case 'offre':
        $CandidatureController = new CandidatureController($conn);
        $CandidatureController->index();
    break;

    case 'approvedoffre':
        $ApprovedController = new ApprovedController($conn);
        $ApprovedController->approvedStatus();
    break;
    case 'rejectedoffre':
        $RejectedStatusController = new RejectedStatusController($conn);
        $RejectedStatusController->rejectedStatus();
    break;
    case 'postuleroffre':
        $OffreController = new OffreController($conn);
        $OffreController->postuleroffre();
    break;

    case 'search':
        $SearchController = new SearchController($conn);
        $SearchController->index();
    break;

    case 'notification':
        $NotificationController = new NotificationController($conn);
        $NotificationController->notificationForoffre();
    break;

    case 'statistique':
        $StatistiqueController = new StatistiqueController($conn);
        $StatistiqueController->index();
    break;
    default:
        header('HTTP/1.0 404 Not Found');
        exit('Page not found');
}
?>
