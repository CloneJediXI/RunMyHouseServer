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
        
        public function addUsers($userData){
            $uid = creteUserID();

            //insert script
            $query = "INSERT INTO users(user_, username, password, full_name, email_address) VALUES(:user_id, :username, :password, :full_name, :email_address)";
            $stmt -> $this->pdo->prepare($query);
            $stmt->execute([
                ':user_id' => $uid,
                ':username' => $userData[0],
                ':password' => $userData[1],
                ':full_name' => $userData[2],
                ':email_address' => $userData[3],
            ]);
            
        }

        public function addReviewers($reviewData){
            $query = "SELECT user_id FROM users WHERE username = :$reviewData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $current_date = date("Y/m/d");
            
            //insert script
            $query = "INSERT INTO reviews(user_id, reviewer, date, contractor_name, star_rating, comments) VALUES(:user_id, :reviewer, :date, :contractor_name, :star_rating, :comments)";
            $stmt -> $this->pdo->prepare($query);
            $stmt->execute([
                ':user_id' => $uid,
                ':reviewer' => $reviewData[0],
                ':date' => $date,
                ':contractor_name' => $reviewData[1],
                ':star_rating' => $reviewData[2],
                ':comments' => $reviewData[3],
            ]);
        }

        public function addJobs($jobData){
            $query = "SELECT user_id FROM users WHERE username = :$jobData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $ticketId = createID();
            $ticketStatus = "B";
            $leadingBidder = "";
            $date_posted = date("Y/m/d");

            //insert script

            $query = "INSERT INTO jobs(user_id, poster, job_title, job_description, ticket_id, ticket_status, current_cost, leading_bidder, date) VALUES(:user_id, :poster, :job_title, :job_description, :ticket_id, :ticket_status, :current_cost, :leading_bidder, :date)";
            $stmt->$this->pdo->prepare($query);
            $stmt->execute([
                ':user_id' => $uid,
                ':poster' => $jobData[0],
                ':job_title' => $jobData[1],
                ':job_description' => $jobData[2],
                ':ticket_id' => $ticket_id,
                ':ticket_status' => $ticket_status,
                ':current_cost' => $jobData[3],
                ':leading_bidder' => $leading_bidder,
                ':date' => $date_posted,
            ]);
        }

        public function addPaymentInformation($cardData){
            $query = "SELECT full_name FROM users WHERE username = :$cardData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();

            $query = "INSERT INTO paymentInfo(user_id, card_holder, card_number, month, year, csv) VALUES(:user_id, :card_holder, :card_number, :month, :year, :csv)";
            $stmt->$this->prepare($query);
            $stmt->execute([
                ':user_id' => $uid,
                ':card_holder' => $cardData[0],
                ':card_number' => $cardData[1],
                ':month' => $cardData[2],
                ':year' => $cardData[3],
                ':csv' => $cardData[4],
            ]);        
        }

        public function addContractors($contractorData){
            $uid = createID();

            $query = "INSERT INTO contractors(company_name, contractor_id, type_of_service, password, overall_stars) VALUES(:company_name, :contractor_id, :type_of_service, :password, :overall_stars)";
            $stmt->this->pdo->prepare($query);
            $stmt->execute([
                ':company_name' => $contractorData[0],
                ':contractor_id' => $uid,
                ':type_of_service' => $contractorData[1],
                ':password' => $contractorData[2],
                ':overall_stars' => $contractorData[3],
            ]);
        }

        public function addBankInformation($bankData){
            $query = "SELECT contractor_id FROM contractors where company_name = :$bankData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt -> execute();

            $query = "INSERT INTO bank_info(contractor_id, routing_number, account_number) VALUES(:contractor_id, :routing_number, :account_number)";
            $stmt->this->pdo->prepare($query);
            $stmt->execute([
                ':contractor_id' => $bankData[1],
                ':routing_number' => $bankData[2],
                ':accounting_number' => $bankData[3],
            ]);
        }

        //remove functions

        //update functions

        public function updateUserInfo($updateData){
            $query = "SELECT user_id FROM users where username =: $updateData[0]"; //this username is the old one
            $stmt->this->pdo->prepare($query);
            $uid->stmt->execute();
            //Update
            $query = "UPDATE users SET username = :newUsername, password = :newPassword, full_name = :newFullName, email_address = :newEmailAddress WHERE user_id = :$uid";
            $stmt->this->pdo->prepare($query);
            $stmt->execute([
                ':newUsername' => $updateData[1],
                ':newPassword' => $updateData[2],
                ':newFullName' => $updateData[3],
                'newEmailAddress' => $updateData[4],
            ]);
        }

        //"Print" functions
            //Sends back information for the client side to print out.
        
        


        //helper functions
        public function createID(){
            $id="";
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