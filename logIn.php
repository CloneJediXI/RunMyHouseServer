<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    if (isset($_GET['username']) and isset($_GET['password']))
    {
        $username = $_GET['username'];
        $password = $_GET['password'];
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
        $response = [];
        $response['message']="Hello!";
        
    //now echo it as an json object
        echo json_encode($response);
    }
?>