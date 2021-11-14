<?php
    namespace App;

    class DatabaseConnection{

        private $pdo;

        public function connect(){
            if(this->pdo == null){
                $this->pdo = new \PDO("sqlite" . Config::PATH_TO_DATABASE);

            }
            return $this->pdo;
        }
        //add functions
        public function addUsers($username, $password, $name, $email_address){
            $unique_id = creteUserID();
            $new_username = $username;
            $new_password = $password;
            $new_name = $name;
            $new_email_address = $email_address;

            try{
                insert_users($unique_id, $new_username, $new_password, $new_name, $new_email_address);
            }catch(exception $e){
                echo("Username aldready in use.")
            }
        }

        public function addReviewers($reviewer_name, $contractor, $stars, $comments){
            $reviewer = $reviewer_name;
            $current_data = date("Y/m/d");
            $query = 'SELECT user_id FROM users WHERE username =: reviewer'
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $contractor_name = $contractor;
            $star_rating = $stars;
            $comment = $comments;
            insertReview($uid, $reviewer, $current_data, $contractor_name, $comment);
        }

        public function addJobs(){

        }

        public function paymentInformation(){

        }

        public function addContractors(){

        }

        public function addBankInformation(){

        }

        //insert functions
        public function insertUsers($uid, $username, $password, $name, $email_address){
            $query = "INSERT INTO users(uid, username, password, name, email) VALUES(:uid, :username, :password, :name, :email)";

            $stmt -> $this->pdo->prepare($query);
            $stmt->execute([
                ':uid' = $uid,
                ':username' = $username,
                ':password' = $password,
                ':name' = $name,
                ':email_address' = $email_address,
            ]);
        }

        public function insertReview($uid, $reviewer, $date, $contractor, $stars, $comment){
            $query = "INSERT INTO reviews(uid, reviewer, date, contractor, stars, comment) VALUES(:uid, :reviewer, :date,:contractor, :stars, :comment)";
            $stmt -> $this->pdo->prepare($query);
            $stmt->execute([
                ':uid' = $uid,
                ':reviewer' = $reviewer,
                ':date' = $date,
                ':contractor' = $contractor,
                ':stars' = $stars,
                ':comment' = $comment,
            ]);
        }
        //remove functions

        //helper functions

        public function createID(){
            $id=""
            for($x=0; $x<10; $x++){
                $digit = mt_rand(0,9);
                $id .= (string)$id;
            }
            return $id;
        }

        public function isNewUsername($str){
            $is_new_username = true;
            $query = "SELECT username FROM users";
            $stmt = $this->pdo->prepare($query);
            $result -> $stmt->execute();
            if(var_dump(array_search($str, $result)) == 1){
                $is_new_username = false;
            }
            return $is_new_username;
        }
    }
?>