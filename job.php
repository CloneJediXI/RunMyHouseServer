<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //use Application\DatabaseConnectionObject as DBConnect;
    include 'app/DatabaseConnection.php';
    if (isset($_GET['userId']) && isset($_GET['viewAll'])){
        $userId = $_GET['userId'];
        $viewAll = $_GET['viewAll'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->getCustomerJobs($userId, $viewAll);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }else if(isset($_GET['contractorId']) && isset($_GET['viewAll'])){
        $contractorId = $_GET['contractorId'];
        $viewAll = $_GET['viewAll'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->getContractorJobs($contractorId, $viewAll);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }else if(isset($_GET['jobTitle']) && isset($_GET['jobDesc']) && isset($_GET['cost']) && isset($_GET['userId'])){
        $jobTitle = $_GET['jobTitle'];
        $jobDesc = $_GET['jobDesc'];
        $cost = $_GET['cost'];
        $userId = $_GET['userId'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $newJob = $connection->addJob($jobTitle, $jobDesc, $cost, $userId);
            if($newJob){
                $response = [];
                $response['data']=$newJob;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }
    
?>