<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../config/database.php";
require_once "../controllers/AuthController.php";
require_once "../controllers/CourseController.php";
require_once "../middleware/AuthMiddleware.php";

$database = new Database();
$db = $database->getConnection();
$auth = new AuthController($db);
$courseController = new CourseController($db);
$authMiddleware = new AuthMiddleware();

$request_method = $_SERVER["REQUEST_METHOD"];
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($request_method) {
    case 'POST':
        if($action == 'register') {
            $data = json_decode(file_get_contents("php://input"));
            echo $auth->register($data->name, $data->email, $data->password);
        }
        elseif($action == 'login') {
            $data = json_decode(file_get_contents("php://input"));
            echo $auth->login($data->email, $data->password);
        }
        break;
        
    case 'GET':
        if($action == 'getCourses') {
            echo $courseController->getAllCourses();
        }
        break;
}
?>
