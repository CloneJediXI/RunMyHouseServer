<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //use Application\DatabaseConnectionObject as DBConnect;
    include 'app/DatabaseConnection.php';
    if(isset($_GET['add'])){
        // Add a new type of service
        $service = $_GET['add'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        $connection->addService($service);
        $response = [];
        $response['message']="Added new service '$service'";
    }else{
        // Get all the existing types of services
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        $response = [];
        $response['services']=$connection->getServices();
    }
    echo json_encode($response);

?>