<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //use Application\DatabaseConnectionObject as DBConnect;
    include 'app/DatabaseConnection.php';
    if (isset($_GET['username']) && isset($_GET['password']))
    {
        if(isset($_GET['email']) && isset($_GET['name'])){
            //User wants to make a new login
            //echo("Add a new User");
            $username = $_GET['username'];
            $password = $_GET['password'];
            $email = $_GET['email'];
            $name = $_GET['name'];
            $connection = new DatabaseConnectionObject();
            $pdo = $connection->connect();
            if ($pdo != null){
                $addUser = $connection->addUsers($username, $password, $name, $email);
                if($addUser){
                    $response = [];
                    $response['err']="false";
                }else{
                    $response = [];
                    $response['err']="true";
                }
            }
        }else if(isset($_GET['service'])){
            //This is a contractor trying to create a new account
            //echo("Add a new Contractor");
            $username = $_GET['username'];
            $password = $_GET['password'];
            $service = $_GET['service'];
            $connection = new DatabaseConnectionObject();
            $pdo = $connection->connect();
            if ($pdo != null){
                $addUser = $connection->addContractors($username, $password, $service);
                if($addUser){
                    $response = [];
                    $response['err']="false";
                }else{
                    $response = [];
                    $response['err']="true";
                }
            }
        }else{
            //User wants to do a standard login
            //echo("User logging in");
            $username = $_GET['username'];
            $password = $_GET['password'];
            $connection = new DatabaseConnectionObject();
            $pdo = $connection->connect();
            if ($pdo != null){
                $login = $connection->checkLogin($username, $password);
                // The log in is not in the user table
                if($login){
                    $response = [];
                    $response['auth']="true";
                    $response['id']=$login;
                    $response['contractor']=false;
                }else{
                    // Check the contractor table
                    $login = $connection->checkContractorLogin($username, $password);
                    if($login){
                        $response = [];
                        $response['auth']="true";
                        $response['id']=$login;
                        $response['contractor']=true;
                    }else{
                        $response = [];
                        $response['auth']="false";
                        $response['id']=(-1);
                    }
                }
            }else{
                $response = [];
                $response['auth']="false";
                $response['id']=(-1);
            }
        }
        //now echo it as an json object
        echo json_encode($response);
    }
?>