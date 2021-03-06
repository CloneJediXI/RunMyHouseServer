<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // This file contains all the methods relating to viewing and posting jobs
    include 'app/DatabaseConnection.php';
    if (isset($_GET['userId']) && isset($_GET['viewAll'])){
        // Get Jobs for a specific user
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
        // Get Jobs for a specific contractor
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
        // Create a new Job posting
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
                $response['data']=false;
            }
        }
        echo json_encode($response);
    }else if(isset($_GET['status']) && isset($_GET['userId'])){
        // Get all jobs with a specified status for a specified user
        $status = $_GET['status'];
        $userId = $_GET['userId'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->getCustomerJobsForBids($userId, $status);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }else if(isset($_GET['status'])){
        // Get all jobs with a specified status
        $status = $_GET['status'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->getJobs($status);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }else if(isset($_GET['ticketId']) && isset($_GET['biddingComplete'])){
        // Close bidding for a job
        $ticketId = $_GET['ticketId'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->closeJobBidding($ticketId);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        echo json_encode($response);
    }
    else if(isset($_GET['ticketId']) && isset($_GET['bid']) && isset($_GET['contractorId'])){
        // Update the current bid on a job
        $ticketId = $_GET['ticketId'];
        $bid = $_GET['bid'];
        $contractorId = $_GET['contractorId'];
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $jobs = $connection->addBid($ticketId, $bid, $contractorId);
            if($jobs){
                $response = [];
                $response['data']=$jobs;
            }else{
                $response = [];
                $response['data']=false;
            }
        }
        echo json_encode($response);
    }else if ( isset($_GET['ticketId']) && isset($_GET['completeFlag']) ){
        //echo("Here");
        /*
        * Make an endpoint in the job.php file
        * that will take a ticket ID and a complete flag, that will mark jobs as complete
        */
        $ticket_id = $_GET['ticketId'];
        $completeFlag = $_GET['completeFlag'];


        //call a function to update the job's ticket status to closed
        
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if ($pdo != null){
            $completeJob = $connection->completeJob($ticket_id);
            if($completeJob){
                $response = [];
                $response['err'] = "true";
            }else{
                $response = [];
                $response['err'] = [];
            }
        }

        echo json_encode($response);

    }
    
?>