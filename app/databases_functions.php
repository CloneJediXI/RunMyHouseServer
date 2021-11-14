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
        public function addUsers($postData){
            $uniqueID = creteUserID();
            $newUsername = $postData[0];
            $newPassword = $password;
            $newName = $name;
            $newEmailAddress = $email_address;

            try{
                insert_users($unique_id, $new_username, $new_password, $new_name, $new_email_address);
            }catch(exception $e){
                echo("Username aldready in use.")
            }
        }

        public function addReviewers($reviewer_name, $contractor, $stars, $comments){
            $reviewer = $reviewer_name;
            $current_date = date("Y/m/d");
            $query = 'SELECT user_id FROM users WHERE username =: reviewer'
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $contractor_name = $contractor;
            $star_rating = $stars;
            $comment = $comments;
            insertReview($uid, $reviewer, $current_date, $contractor_name, $comment);
        }

        public function addJobs($poster_name, $job_title, $job_description, $starting_bid){
            $query = 'SELECT user_id FROM users WHERE username =: reviewer'
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $poster = $poster_name;
            $job = $job_title;
            $description = $job_description;
            $ticket_id = createID();
            $ticket_status = "B";
            $start_bid = $starting_bid;
            $leading_bidder = "";
            $date_posted = date("Y/m/d");
            insertJob($uid, $poster, $job, $job_description, $ticket_id, $ticket_status, $start_bid, $leading_bidder, $date_posted);

        }

        public function addPaymentInformation($card_holder< $number_on_card){
            $query = 'SELECT user_id FROM users WHERE username =: reviewer'
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $card_owner = $card_holder;
            $card_number = $number_on_card;
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

        public function insertJob($uid, $poster, $job, $job_description, $ticket_id, $ticket_status, $start_bid, $leading_bidder, $date_posted){
            $query = "INSERT INTO jobs($uid, $poster, $job, $job_description, $ticket_id, $ticket_status, $start_bid, $leading_bidder, $date_posted) VALUES(:uid, :poster, :job, :job_description, :ticket_id, :ticket_status, :start_bid, :leading_bidder, $date_posted)";
            $stmt->$this->pdo->prepare($query);
            $stmt->execute([
                ':uid' = $uid,
                ':poster' = $poster,
                ':job' = $job,
                ':job_description' = $job_description,
                ':ticket_id' = $ticket_id,
                ':ticket_status' = $ticket_status,
                ':start_bid' = $start_bid,
                ':leading_bidder' = $leading_bidder,
                ':date_posted' = $date_posted,
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