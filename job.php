<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //use Application\DatabaseConnectionObject as DBConnect;
    include 'app/DatabaseConnection.php';
    if (isset($_GET['userId'])){
        $userId = $_GET['userId'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->getCustomerJobs($userId);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }else if(isset($_GET['contractorId'])){

    }else if(isset($_GET['add'])){

    }
    
?>