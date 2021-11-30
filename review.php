<?php 

    /*
    * This file will be used for and endpoint that is for adding contractor reviews
    * 
    * It will take 
        userID
        ContractorID
        review text
        review rating
    *
    * It will then pass through a database method that will probably return true if it works
    * 
    *
    */  


    session_start();
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    include 'app/DatabaseConnection.php';

    $reviewData = [];

    if( isset($_GET['userId']) && isset($_GET['reviewText']) && isset($_GET['reviewRating']) && isset($_GET['ticketId']) ) {
        $userId = $_GET['userId'];
        $ticketId = $_GET['ticketId'];
        $reviewText = $_GET['reviewText'];
        $reviewRating = $_GET['reviewRating'];
        
        $connection = new DatabaseConnectionObject();
        $pdo = $connection->connect();
        if($pdo != null) {
            $reviewer = $connection->addReview($userId, $ticketId, $reviewText, $reviewRating);
            if($reviewer){
                $response = [];
                $response['data']=$reviewer;
            }else{
                $response = [];
                $response['data']=[];
            }
        }
        
    }else{
        $response = [];
        $response['data']="false";
    }
            
    echo json_encode($response);

?>