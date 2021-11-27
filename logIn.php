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
        }else if(isset($_GET['service']) && isset($_GET['routing']) && isset($_GET['account'])){
            //This is a contractor trying to create a new account
            //echo("Add a new Contractor");
            $username = $_GET['username'];
            $password = $_GET['password'];
            $service = $_GET['service'];
            $routing = $_GET['routing'];
            $account = $_GET['account'];
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
        }else if(isset($_GET['contractor'])){
            // This is a contractor trying to log in
            //echo("Contractor logging in");
            $username = $_GET['username'];
            $password = $_GET['password'];
            $connection = new DatabaseConnectionObject();
            $pdo = $connection->connect();
            if ($pdo != null){
                $login = $connection->checkContractorLogin($username, $password);
                if($login){
                    $response = [];
                    $response['auth']="true";
                    $response['id']=$login;
                }else{
                    $response = [];
                    $response['auth']="false";
                    $response['id']=(-1);
                }
            }else{
                $response = [];
                $response['auth']="false";
                $response['id']=(-1);
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
                if($login){
                    $response = [];
                    $response['auth']="true";
                    $response['id']=$login;
                }else{
                    $response = [];
                    $response['auth']="false";
                    $response['id']=(-1);
                }
            }else{
                $response = [];
                $response['auth']="false";
                $response['id']=(-1);
            }
        }
        
        //$query = "SELECT * FROM `staff_reg` WHERE username='$username' and password='$password'";

        //$result = mysql_query($query) or die(mysql_error());
        //$count = mysql_num_rows($result);
        /*if ($count == 1)
        {
            $response="Success";
        }
        else
        {
            $response="Failure";
        }*/
        
    //now echo it as an json object
        echo json_encode($response);
    }
?>